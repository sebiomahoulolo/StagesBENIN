<?php
define( 'WP_CACHE', true );

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u493769229_gqDRV' );

/** Database username */
define( 'DB_USER', 'u493769229_ZuBHB' );

/** Database password */
define( 'DB_PASSWORD', 'p8kbI0nNSn' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          '6t)|kwz-)qyfu>vQNFv$#X?ghiJB!`2YCMPab?-r&CLP@G_l_&,NBZII!.SivZ=l' );
define( 'SECURE_AUTH_KEY',   'Oc=^y*i4U#]lDBPC# (.:zkjHWXSn,]`pu@c^Rm;J.~I5Mmt`9M:8k-6xSGs#OGr' );
define( 'LOGGED_IN_KEY',     '.kvgFt9^Atby-&wr)wle67q4FQTB0qm;^@t}Q;b)YL+wa-tw6IS8JxL16kym_lv(' );
define( 'NONCE_KEY',         'xA=-kMTd+FY%]_bQOVA?yzj`U9h}m:k4#ju2wxhQJj0q!*s-3dVChxXZj8hy6!|&' );
define( 'AUTH_SALT',         'B^LWZ]P#[T?fozC.2/P44TCT1J5cIfI_rX`vYH<Yrrpy)1M!C`ZrmL~Z-}Oh^m=c' );
define( 'SECURE_AUTH_SALT',  'MRkxzn.|j.rJi}.HKsBND6YE^eac:wZ@$ds6=J8#,sD+%#nLY_lhk-=D)$aRhED7' );
define( 'LOGGED_IN_SALT',    'P0HSoxWgThMOeNUznIG}(+IsT+ hFK}b_9{OJc5Nj]l&Z3:~JDwXT0~1V;.kSJ#s' );
define( 'NONCE_SALT',        '`nz%r,lWLZ>IF|XmKsv1]}G-$uuL%=cacwf88H8pOlt<R&Z0<4:$Pl}+JE}ME3Se' );
define( 'WP_CACHE_KEY_SALT', 'yxl1$]S>Nbr^wzB_W/Sg-aR0^J!oZ~T-|E!!KA4JKD,d}1.uLIj;(Mul}Ck:8e9;' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', '9f11906e0d5044d4ae298a82055841e7' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
