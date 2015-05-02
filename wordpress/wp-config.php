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
define('DB_NAME', 'ricci');

/** MySQL database username */
define('DB_USER', 'ricci');

/** MySQL database password */
define('DB_PASSWORD', 'champ120');

/** MySQL hostname */
define('DB_HOST', 'http://www.ricci.hku.hk');

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
define('AUTH_KEY',         '[b|sl.%6vQ-+`vbMUUM.O*;O#OnJ5AJT#>HMSI>}s[-78B[L%2nd+zo` dw+l=fz');
define('SECURE_AUTH_KEY',  'Sd-).fQ]c,v+$6QeudF+%$f<wJ3C-%QR$Am[XDU%LYsC!B&=U|[=JWM!)1YTT7h7');
define('LOGGED_IN_KEY',    'w$Vdy2k@Y^NSU[AYvtaB/*qIw}WxiuS D>U4iu5cGjHL)>%K]rK,5gvzZ2#D+dIg');
define('NONCE_KEY',        ']8M,{s99RLQJ<o+3AAV;P$[:W^e_ $_14,r+mPF{D>ZM0?r[(Q>QEu3@U+#X|-K/');
define('AUTH_SALT',        '!^9Im}e N9WRKU#kCV7OJi|E5)-4& A9-6#5/fg~ZTC4:AW@l#MxH:ln_E/MO#*3');
define('SECURE_AUTH_SALT', 't[}r=#)v)eECw#8SLzLMza|)pC%m1CN6D|h5gxCR)L<kJCjLv/pfCWpdf!UxhZC_');
define('LOGGED_IN_SALT',   'O50z`/JtDS9|aT7:yJpgYP5h%NU+-^Z%pFg`]1~@ale}l-yYU=VV!|7n(J(sI2|S');
define('NONCE_SALT',       '2kFG4iix3)BDt@[+W/aSKkv!_9s?(<[G#gb.h*C/gD=:It7N6`p)eoebA@mo)i =');

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
