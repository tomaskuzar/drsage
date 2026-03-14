<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'QSnyORdT' );

/** Database username */
define( 'DB_USER', 'xNqjPfXe' );

/** Database password */
define( 'DB_PASSWORD', '79f|nYaj.B1+8ORuOUwb' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'uiNN6GQ<lnj{C]gMD-;s/lY AvlmXYv//wM24o4%vJ/<WRGDv+:DI4u=AN:m`DhY' );
define( 'SECURE_AUTH_KEY',  'WeLfjX,/zTF64E)f}WtcG&ePTnMGTA*{yNxdgIY1Gl_=-Y<M7qL8ZSN}(67V4}S5' );
define( 'LOGGED_IN_KEY',    'rFR(cgT:_7+ C9q{Df:ZLA=uynNLc,H9uI,)^yxq9nNcjqb>RUbBM&n@M&ZL?/Vs' );
define( 'NONCE_KEY',        'hbvaQ=#K]`4m@te;#fvJu.Bm{YY<Z>6-*|L6qJLmr#EKm:X1/3SiiE)37*|ZIx8K' );
define( 'AUTH_SALT',        'RcEe(F&ANIbm!Uw>z5-T[LTy;h8V(.5X=`x)-jzj}uqn)SAed8NX9o<k2*s9<f/!' );
define( 'SECURE_AUTH_SALT', 'G4NoHFt#jh4WUoV KFt6>gl&O%VsYsR9s$bXK`cNwlcau|NJi^,p<;,B/9F6+xPT' );
define( 'LOGGED_IN_SALT',   '~w-5rIKXjTFi7zDFZHRx3,C;C5#R>o6d4+}Ku&K}Z`W!Jo+qBEpaeYwXJ?=U.Tf;' );
define( 'NONCE_SALT',       '9|]H>.5(`%~aiaa|PM;:.sy|Kd(NE@74C6Z3V^6nC}p(~QVrYK9{95a7`(:pDB:$' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
