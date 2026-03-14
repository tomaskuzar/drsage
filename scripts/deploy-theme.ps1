param(
    [string]$TargetPath,
    [string]$OutputRoot = ".deploy",
    [switch]$SkipBuild,
    [switch]$SkipZip
)

$ErrorActionPreference = "Stop"

function Write-Step {
    param([string]$Message)
    Write-Host "==> $Message"
}

function Ensure-Directory {
    param([string]$Path)

    if (-not (Test-Path -LiteralPath $Path)) {
        New-Item -ItemType Directory -Path $Path | Out-Null
    }
}

function Copy-DeployItem {
    param(
        [string]$ProjectRoot,
        [string]$DeployRoot,
        [string]$RelativePath
    )

    $sourcePath = Join-Path $ProjectRoot $RelativePath

    if (-not (Test-Path -LiteralPath $sourcePath)) {
        return
    }

    $destinationPath = Join-Path $DeployRoot $RelativePath
    $destinationParent = Split-Path -Parent $destinationPath

    if ($destinationParent) {
        Ensure-Directory -Path $destinationParent
    }

    Copy-Item -LiteralPath $sourcePath -Destination $destinationPath -Recurse -Force
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

$scriptRoot = Split-Path -Parent $MyInvocation.MyCommand.Path
$projectRoot = Split-Path -Parent $scriptRoot
$themeFolderName = Get-ThemeFolderName -ProjectRoot $projectRoot
$deployBasePath = Join-Path $projectRoot $OutputRoot
$deployThemePath = Join-Path $deployBasePath $themeFolderName
$zipPath = Join-Path $deployBasePath ("{0}.zip" -f $themeFolderName)

$directoriesToCopy = @(
    "app",
    "bootstrap",
    "config",
    "patterns",
    "public",
    "resources\views",
    "resources\lang",
    "vendor"
)

$filesToCopy = @(
    "composer.json",
    "composer.lock",
    "functions.php",
    "index.php",
    "LICENSE.md",
    "screenshot.png",
    "style.css",
    "theme.json"
)

Set-Location -LiteralPath $projectRoot

if (-not $SkipBuild) {
    Write-Step "Running npm build"
    & npm.cmd run build

    if ($LASTEXITCODE -ne 0) {
        throw "npm run build failed."
    }
}

$vendorPath = Join-Path $projectRoot "vendor"
if (-not (Test-Path -LiteralPath $vendorPath)) {
    throw "Missing vendor directory. Run composer install before deploy."
}

$buildPath = Join-Path $projectRoot "public\\build"
if (-not (Test-Path -LiteralPath $buildPath)) {
    throw "Missing public/build directory. Run npm run build before deploy."
}

Write-Step ("Preparing deploy directory for theme '{0}'" -f $themeFolderName)
Ensure-Directory -Path $deployBasePath

if (Test-Path -LiteralPath $deployThemePath) {
    Remove-Item -LiteralPath $deployThemePath -Recurse -Force
}

Ensure-Directory -Path $deployThemePath

foreach ($relativePath in $directoriesToCopy) {
    Copy-DeployItem -ProjectRoot $projectRoot -DeployRoot $deployThemePath -RelativePath $relativePath
}

foreach ($relativePath in $filesToCopy) {
    Copy-DeployItem -ProjectRoot $projectRoot -DeployRoot $deployThemePath -RelativePath $relativePath
}

if (-not $SkipZip) {
    Write-Step "Creating zip archive"

    if (Test-Path -LiteralPath $zipPath) {
        Remove-Item -LiteralPath $zipPath -Force
    }

    Compress-Archive -Path (Join-Path $deployThemePath "*") -DestinationPath $zipPath -CompressionLevel Optimal
}

if ($TargetPath) {
    $resolvedTargetPath = $ExecutionContext.SessionState.Path.GetUnresolvedProviderPathFromPSPath($TargetPath)

    Write-Step ("Copying deploy package to {0}" -f $resolvedTargetPath)
    Ensure-Directory -Path $resolvedTargetPath
    Copy-Item -Path (Join-Path $deployThemePath "*") -Destination $resolvedTargetPath -Recurse -Force
}

Write-Step ("Deploy package ready: {0}" -f $deployThemePath)

if (-not $SkipZip) {
    Write-Step ("Zip archive ready: {0}" -f $zipPath)
}
