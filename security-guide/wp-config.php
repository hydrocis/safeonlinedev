<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'WPCACHEHOME', '/var/www/html/wordpress/security-guide/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('WP_CACHE', true); //Added by WP-Cache Manager
define('DB_NAME', 'ds-guide');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'CcHUB2014');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'A;|{~@Kezn+USh@*Q1>oC9ALbhS^A%9K}B+>RFHV:]Sq_3D:1?;+o[MwtqaX?q)m');
define('SECURE_AUTH_KEY',  'Nq`4[hKbX5l4F:OA =S9|#Q9ZcGI;B]O(D_D9P|Q/=V`@+&Q[a+fz$!l<JEqyIJ4');
define('LOGGED_IN_KEY',    '8Y}=nn3W=k5j*9D0l2L5^%jC?FxY=PBc5Q;}fy7PtAAiph*ax<5|f7Shm^Ra>AxH');
define('NONCE_KEY',        'Qq?,,Lr;LGui}0hx~wC]10$d6kGmXifMa[+DGB+C-M5jPAT[8v)x6&2+$-dk`wYm');
define('AUTH_SALT',        'qQrJ05mdM)hRfd=<cZ8~C-H3?;<;~sml^)W-g6qngY/b?eFF]eLjmhNI $Rgh;Cw');
define('SECURE_AUTH_SALT', ';FC)y:;p*?WCtH0d ~eD/BX(UMyJb-F#0Bk^|}Os`XoDCE^FiDZ|f#btpW-?]=cT');
define('LOGGED_IN_SALT',   '+#d[-Db^y$J+V)Rh;ZX2u T.L@QK^!=[lRBW/*!OX-a@c.W[n9c{Wn]PYN_.fX]n');
define('NONCE_SALT',       'ZxO:Z;Y.WrE-mpM&Eeqff56twU2AL*4f@ys1h+@64&H+EEi0|=Ap$x~G+,|/OU!c');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'fund_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

/** Set Header  **/
// header('X-Frame-Options: SAMEORIGIN');
