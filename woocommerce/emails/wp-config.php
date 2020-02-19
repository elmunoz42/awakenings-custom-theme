<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

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
/** The name of the database for WordPress */
define( 'DB_NAME', 'fatherin_wp957' );
/** MySQL database username */
define( 'DB_USER', 'fatherin_wp957' );
/** MySQL database password */
define( 'DB_PASSWORD', ')8)C3pSQ3b' );
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
define('AUTH_KEY',         'Y|;x1[8||vW=DLN^?,&z5+Vb -@.]--JOg<jI d}5X<br~IiNG3c^kt2F09)wp/=');
define('SECURE_AUTH_KEY',  'C%h6,h`+@u+d/S@>v#wv{Z /8%UJ#/&&c--sL<+KTqpA?B55{j9R4oM}Uh+d@rM ');
define('LOGGED_IN_KEY',    '0MvPeUZ+[m2n6#1yQY1+3J1U32SN}bBm#4d_y8]G3z+T{hr<05@h;-l|-|dszbfy');
define('NONCE_KEY',        'ubYy9$BO3j eiNOxfB@,#Q*4#gi<,BR1K[sp]J_)TOVX0g>+5--Z59-;R2@Ytd><');
define('AUTH_SALT',        '.`o3Z;<vRdX%@XFNf#?q-HBabb#=zU<*tV;*?UkypY{4j-mA8Upk9@a0=yEb/Bih');
define('SECURE_AUTH_SALT', 'm>X<vOA&   @v^G<xh~:lCx}LZ?JHw%|<bpKW7e<d/f+%+++m%lFDKvKyT$SrOTv');
define('LOGGED_IN_SALT',   '7+z*DdGT@6.g>ke+>5Gnu1G(5krZXG--]jB&O.SRlNY#v0[c)/OeV|KIEdU<JGM]');
define('NONCE_SALT',       'c5oUqT-EIwOLrEJ/}6U?yfg+%`g|v^^=pP~fUDE1E$0ziEw|n,}N 2C|jnj.&+2(');
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
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_DISPLAY', true );
define( 'WP_DEBUG_LOG', true );


/* That's all, stop editing! Happy blogging. */
/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
# Disables all core updates:
# Disables all core updates. Added by SiteGround Autoupdate:
define( 'WP_AUTO_UPDATE_CORE', false );
@include_once('/var/lib/sec/wp-settings.php'); // Added by SiteGround WordPress management system
