param(
    [ValidateSet("ftp", "sftp")]
    [string]$Protocol = $env:DEPLOY_PROTOCOL,
    [string]$HostName = $env:DEPLOY_HOST,
    [int]$Port = $(if ($env:DEPLOY_PORT) { [int]$env:DEPLOY_PORT } else { 0 }),
    [string]$Username = $env:DEPLOY_USERNAME,
    [string]$Password = $env:DEPLOY_PASSWORD,
    [string]$RemotePath = $env:DEPLOY_REMOTE_PATH,
    [string]$OutputRoot = ".deploy",
    [string]$WinScpPath = $env:DEPLOY_WINSCP_PATH,
    [string]$SshHostKeyFingerprint = $env:DEPLOY_SSH_HOST_KEY,
    [switch]$AllowAnySshHostKey,
    [switch]$SkipBuild,
    [int]$FtpTimeoutSeconds = 30,
    [bool]$FtpUsePassive = $true,
    [bool]$FtpUseSsl = $false
)

$ErrorActionPreference = "Stop"

function Write-Step {
    param([string]$Message)
    Write-Host "==> $Message"
}

function Test-Blank {
    param([string]$Value)

    return [string]::IsNullOrWhiteSpace($Value)
}

function Get-ThemeFolderName {
    param([string]$ProjectRoot)

    $viteConfigPath = Join-Path $ProjectRoot "vite.config.js"
    $defaultName = Split-Path -Leaf $ProjectRoot

    if (-not (Test-Path -LiteralPath $viteConfigPath)) {
        return $defaultName
    }

    $viteConfig = Get-Content -LiteralPath $viteConfigPath -Raw
    $match = [regex]::Match($viteConfig, "base:\s*'/app/themes/([^/]+)/public/build/'")

    if ($match.Success) {
        return $match.Groups[1].Value
    }

    return $defaultName
}

function Get-PortOrDefault {
    param(
        [string]$SelectedProtocol,
        [int]$SelectedPort
    )

    if ($SelectedPort -gt 0) {
        return $SelectedPort
    }

    if ($SelectedProtocol -eq "ftp") {
        return 21
    }

    return 22
}

function Normalize-RemotePath {
    param([string]$PathValue)

    if (Test-Blank $PathValue) {
        throw "Missing remote path. Set -RemotePath or DEPLOY_REMOTE_PATH."
    }

    $normalized = $PathValue.Replace("\", "/").Trim()

    if (-not $normalized.StartsWith("/")) {
        $normalized = "/$normalized"
    }

    if ($normalized.Length -gt 1) {
        $normalized = $normalized.TrimEnd("/")
    }

    return $normalized
}

function Get-RemoteRelativePath {
    param(
        [string]$BasePath,
        [string]$FullPath
    )

    $relativePath = $FullPath.Substring($BasePath.Length).TrimStart("\")
    return $relativePath.Replace("\", "/")
}

function New-FtpUri {
    param(
        [string]$HostName,
        [int]$HostPort,
        [string]$PathValue
    )

    return "ftp://{0}:{1}{2}" -f $HostName, $HostPort, $PathValue
}

function Invoke-FtpRequest {
    param(
        [string]$Method,
        [string]$RequestPath,
        [string]$HostName,
        [int]$HostPort,
        [System.Management.Automation.PSCredential]$Credential,
        [byte[]]$Body = $null,
        [int]$TimeoutSeconds,
        [bool]$UsePassive,
        [bool]$UseSsl
    )

    Write-Host ("[FTP] {0} {1}" -f $Method, $RequestPath)

    $request = [System.Net.FtpWebRequest]::Create((New-FtpUri -HostName $HostName -HostPort $HostPort -PathValue $RequestPath))
    $request.Method = $Method
    $request.Credentials = $Credential
    $request.UseBinary = $true
    $request.UsePassive = $UsePassive
    $request.EnableSsl = $UseSsl
    $request.KeepAlive = $false
    $request.Timeout = $TimeoutSeconds * 1000
    $request.ReadWriteTimeout = $TimeoutSeconds * 1000

    if ($Body) {
        $request.ContentLength = $Body.Length
        $requestStream = $request.GetRequestStream()
        $requestStream.Write($Body, 0, $Body.Length)
        $requestStream.Dispose()
    }

    $response = $request.GetResponse()
    $response.Dispose()
}

function Ensure-FtpDirectory {
    param(
        [string]$TargetPath,
        [string]$HostName,
        [int]$HostPort,
        [System.Management.Automation.PSCredential]$Credential,
        [int]$TimeoutSeconds,
        [bool]$UsePassive,
        [bool]$UseSsl
    )

    $segments = $TargetPath.Trim("/").Split("/", [System.StringSplitOptions]::RemoveEmptyEntries)
    $currentPath = ""

    foreach ($segment in $segments) {
        $currentPath += "/$segment"

        try {
            Invoke-FtpRequest -Method ([System.Net.WebRequestMethods+Ftp]::MakeDirectory) -RequestPath $currentPath -HostName $HostName -HostPort $HostPort -Credential $Credential -TimeoutSeconds $TimeoutSeconds -UsePassive $UsePassive -UseSsl $UseSsl
        }
        catch [System.Net.WebException] {
            $response = $_.Exception.Response

            if ($null -eq $response) {
                throw
            }

            $statusCode = [int]$response.StatusCode
            $response.Dispose()

            if ($statusCode -notin 550, 553) {
                throw
            }
        }
    }
}

function Publish-FtpDirectory {
    param(
        [string]$LocalPath,
        [string]$TargetPath,
        [string]$HostName,
        [int]$HostPort,
        [System.Management.Automation.PSCredential]$Credential,
        [int]$TimeoutSeconds,
        [bool]$UsePassive,
        [bool]$UseSsl
    )

    Write-Step ("FTP connection settings: passive={0}, ssl={1}, timeout={2}s" -f $UsePassive, $UseSsl, $TimeoutSeconds)
    Ensure-FtpDirectory -TargetPath $TargetPath -HostName $HostName -HostPort $HostPort -Credential $Credential -TimeoutSeconds $TimeoutSeconds -UsePassive $UsePassive -UseSsl $UseSsl

    $directories = Get-ChildItem -LiteralPath $LocalPath -Directory -Recurse | Sort-Object FullName
    foreach ($directory in $directories) {
        $relativePath = Get-RemoteRelativePath -BasePath $LocalPath -FullPath $directory.FullName
        $remoteDirectory = "{0}/{1}" -f $TargetPath, $relativePath
        Ensure-FtpDirectory -TargetPath $remoteDirectory -HostName $HostName -HostPort $HostPort -Credential $Credential -TimeoutSeconds $TimeoutSeconds -UsePassive $UsePassive -UseSsl $UseSsl
    }

    $files = Get-ChildItem -LiteralPath $LocalPath -File -Recurse | Sort-Object FullName
    foreach ($file in $files) {
        $relativePath = Get-RemoteRelativePath -BasePath $LocalPath -FullPath $file.FullName
        $remoteFilePath = "{0}/{1}" -f $TargetPath, $relativePath
        $remoteParentPath = Split-Path -Path $remoteFilePath -Parent

        if ($remoteParentPath) {
            $remoteParentPath = $remoteParentPath.Replace("\", "/")
            Ensure-FtpDirectory -TargetPath $remoteParentPath -HostName $HostName -HostPort $HostPort -Credential $Credential -TimeoutSeconds $TimeoutSeconds -UsePassive $UsePassive -UseSsl $UseSsl
        }

        Write-Host ("--> {0}" -f $relativePath)
        $fileBytes = [System.IO.File]::ReadAllBytes($file.FullName)
        Invoke-FtpRequest -Method ([System.Net.WebRequestMethods+Ftp]::UploadFile) -RequestPath $remoteFilePath -HostName $HostName -HostPort $HostPort -Credential $Credential -Body $fileBytes -TimeoutSeconds $TimeoutSeconds -UsePassive $UsePassive -UseSsl $UseSsl
    }
}

function Get-WinScpPath {
    param([string]$ConfiguredPath)

    $candidates = @()

    if (-not (Test-Blank $ConfiguredPath)) {
        $candidates += $ConfiguredPath
    }

    $candidates += @(
        "C:\Program Files (x86)\WinSCP\WinSCP.com",
        "C:\Program Files\WinSCP\WinSCP.com"
    )

    foreach ($candidate in $candidates) {
        if (-not (Test-Blank $candidate) -and (Test-Path -LiteralPath $candidate)) {
            return $candidate
        }
    }

    throw "WinSCP.com not found. Install WinSCP or pass -WinScpPath."
}

function Publish-SftpDirectory {
    param(
        [string]$LocalPath,
        [string]$TargetPath,
        [string]$HostName,
        [int]$HostPort,
        [string]$UserNameValue,
        [string]$PasswordValue,
        [string]$ConfiguredWinScpPath,
        [string]$HostKeyFingerprint,
        [bool]$UseAnyHostKey
    )

    $winScp = Get-WinScpPath -ConfiguredPath $ConfiguredWinScpPath
    $encodedUser = [Uri]::EscapeDataString($UserNameValue)
    $encodedPassword = [Uri]::EscapeDataString($PasswordValue)
    $sessionUrl = "sftp://{0}:{1}@{2}:{3}/" -f $encodedUser, $encodedPassword, $HostName, $HostPort
    $targetDirectory = $TargetPath.Replace("\", "/")
    $openCommand = "open `"$sessionUrl`""

    if ($UseAnyHostKey) {
        $openCommand += " -hostkey=*"
    }
    elseif (-not (Test-Blank $HostKeyFingerprint)) {
        $openCommand += " -hostkey=`"$HostKeyFingerprint`""
    }
    else {
        throw "SFTP requires -SshHostKeyFingerprint or -AllowAnySshHostKey."
    }

    $scriptLines = @(
        "option batch continue",
        "option confirm off",
        $openCommand,
        "mkdir `"$targetDirectory`""
    )

    $directories = Get-ChildItem -LiteralPath $LocalPath -Directory -Recurse | Sort-Object FullName
    foreach ($directory in $directories) {
        $relativePath = Get-RemoteRelativePath -BasePath $LocalPath -FullPath $directory.FullName
        $remoteDirectory = "{0}/{1}" -f $targetDirectory, $relativePath
        $scriptLines += "mkdir `"$remoteDirectory`""
    }

    $scriptLines += "option batch abort"

    $files = Get-ChildItem -LiteralPath $LocalPath -File -Recurse | Sort-Object FullName
    foreach ($file in $files) {
        $relativePath = Get-RemoteRelativePath -BasePath $LocalPath -FullPath $file.FullName
        $remoteFilePath = "{0}/{1}" -f $targetDirectory, $relativePath

        Write-Host ("--> {0}" -f $relativePath)
        $scriptLines += "put `"$($file.FullName)`" `"$remoteFilePath`""
    }

    $scriptLines += "exit"

    $tempScriptPath = Join-Path ([System.IO.Path]::GetTempPath()) ("winscp-{0}.txt" -f ([guid]::NewGuid().ToString("N")))
    $tempLogPath = Join-Path ([System.IO.Path]::GetTempPath()) ("winscp-{0}.log" -f ([guid]::NewGuid().ToString("N")))

    try {
        [System.IO.File]::WriteAllLines($tempScriptPath, $scriptLines)
        & $winScp "/ini=nul" "/log=$tempLogPath" "/script=$tempScriptPath"

        if ($LASTEXITCODE -ne 0) {
            if (Test-Path -LiteralPath $tempLogPath) {
                Write-Host "--- WinSCP log tail ---"
                Get-Content -LiteralPath $tempLogPath -Tail 40
                Write-Host "--- end log tail ---"
            }

            throw "WinSCP upload failed with exit code $LASTEXITCODE."
        }
    }
    finally {
        if (Test-Path -LiteralPath $tempScriptPath) {
            Remove-Item -LiteralPath $tempScriptPath -Force
        }

        if (Test-Path -LiteralPath $tempLogPath) {
            Remove-Item -LiteralPath $tempLogPath -Force
        }
    }
}

if (Test-Blank $Protocol) {
    throw "Missing protocol. Use -Protocol ftp or -Protocol sftp."
}

if (Test-Blank $HostName) {
    throw "Missing host. Set -HostName or DEPLOY_HOST."
}

if (Test-Blank $Username) {
    throw "Missing username. Set -Username or DEPLOY_USERNAME."
}

if (Test-Blank $Password) {
    throw "Missing password. Set -Password or DEPLOY_PASSWORD."
}

$normalizedRemotePath = Normalize-RemotePath -PathValue $RemotePath
$selectedPort = Get-PortOrDefault -SelectedProtocol $Protocol -SelectedPort $Port

$scriptRoot = Split-Path -Parent $MyInvocation.MyCommand.Path
$projectRoot = Split-Path -Parent $scriptRoot
$themeFolderName = Get-ThemeFolderName -ProjectRoot $projectRoot
$localDeployPath = Join-Path (Join-Path $projectRoot $OutputRoot) $themeFolderName
$localDeployScript = Join-Path $scriptRoot "deploy-theme.ps1"

Write-Step "Preparing local deploy package"
& $localDeployScript -OutputRoot $OutputRoot -SkipZip -SkipBuild:$SkipBuild

if ($LASTEXITCODE -ne 0) {
    throw "Local deploy package creation failed."
}

if (-not (Test-Path -LiteralPath $localDeployPath)) {
    throw "Local deploy path not found: $localDeployPath"
}

Write-Step ("Uploading theme '{0}' to {1}://{2}:{3}{4}" -f $themeFolderName, $Protocol, $HostName, $selectedPort, $normalizedRemotePath)

if ($Protocol -eq "ftp") {
    $securePassword = ConvertTo-SecureString $Password -AsPlainText -Force
    $credential = New-Object System.Management.Automation.PSCredential ($Username, $securePassword)

    Publish-FtpDirectory -LocalPath $localDeployPath -TargetPath $normalizedRemotePath -HostName $HostName -HostPort $selectedPort -Credential $credential -TimeoutSeconds $FtpTimeoutSeconds -UsePassive $FtpUsePassive -UseSsl $FtpUseSsl
}
else {
    Publish-SftpDirectory -LocalPath $localDeployPath -TargetPath $normalizedRemotePath -HostName $HostName -HostPort $selectedPort -UserNameValue $Username -PasswordValue $Password -ConfiguredWinScpPath $WinScpPath -HostKeyFingerprint $SshHostKeyFingerprint -UseAnyHostKey $AllowAnySshHostKey.IsPresent
}

Write-Step "Remote deploy finished"
