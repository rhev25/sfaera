<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'sfaera');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         ',$<1T=&>aB |EsQQR$qtAk@FWTnZkvh{Y&5rctG[r:rE0#Nd^Y]/,:cRL!n[Rt-5');
define('SECURE_AUTH_KEY',  ';+Y(R#2MNH~n$}l1WBN8aG%F[d?Xo,BR7yR~KySi<n7Gx?pdAm:g~^_!(M~WEg/%');
define('LOGGED_IN_KEY',    'X7?afBo(6_gGdf+W1}n^e{]cKAzl0l;=Z$2k]FhA@ib<zwzxAq[/$Lo4r(D7ykOL');
define('NONCE_KEY',        'N~eLUDhP2P2o,$}]aSGLb&y4Dmf%!S>3$ ?)2)Fmnfc0b@PnYW495/c1QF+JtE#W');
define('AUTH_SALT',        '8=X~yg4nD(bAh(zNE)m},F9.j(zhs(Wham0&o)qU~A28~gR;{?^OGG:^x/[3?M3{');
define('SECURE_AUTH_SALT', '9Mg1c9y;*MVZnMwlZSbRHJ_?Yp?r7VU#?)1)xQR^g17oESor=ZVZ5gM]RDK1Jh$f');
define('LOGGED_IN_SALT',   'wcYp@EaGL nC$TvYQcArDi4RZ7U@REE;@S;]SyZPSOR?f3J}xT/jrx4CylQ3t0Bf');
define('NONCE_SALT',       'kO}2.gL-g3#@[jN{@DBAjU|eS[o<3oUgB&Aqmb2X(,{h/3l_KTHr6%i]-M`dIt6Z');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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
