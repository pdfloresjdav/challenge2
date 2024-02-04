<?php
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
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'Neumann12.' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

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
define( 'AUTH_KEY',         '#`7H<wms*|GY_LHUn^_I+W%qF]$G qrR:pC5^h.#~_}06eY~39dH)=,;i*Pm?~}~' );
define( 'SECURE_AUTH_KEY',  'gH0m0e=#tenhv#X0j8bzj_([<HT@mm0RhHwzt. W+R!IhjX,pf/ylyK^<=KH.SoB' );
define( 'LOGGED_IN_KEY',    '*{)-r<Z$5:o$Cip&h[Kn5][n/X-,vLdRxqL]YCZssvqqwcv.>Ef:0E`&z6n^Qp,|' );
define( 'NONCE_KEY',        ';RLLGQ/kA0(e76Fy#v[f|-9R)*((;7vAc:5H<ntdR0SGB +1Ja?!abBsv_S(9o/~' );
define( 'AUTH_SALT',        'wl{g>7ad<5cn$k:?hg/9ZAtM=)$U?Gns@/DqULJ7PVu|Jm@hOY/|%6k5deoI<8vp' );
define( 'SECURE_AUTH_SALT', 'Kx5-quWgboOqq#v+Ry7>~e,#+l1ToC/)d)Re/jk(|w?cOtV3CR)y{VjJimI2SL<[' );
define( 'LOGGED_IN_SALT',   '88Mx#A]Npw6Re,mk*.V27P>,MeS|h`C(pr}FDkvx().LjT/SCi4(&Vh/gzO-Ta&l' );
define( 'NONCE_SALT',       't1Qh7lN#(KcH~8]#O.iL|mKKQxgzy9+NV3*k!TzXB*ks0`g*5~HzAh*|EfZ}g;-4' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
