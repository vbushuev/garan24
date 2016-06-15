<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'u0173919_GRN01');

/** MySQL database username */
define('DB_USER', 'u0173919_dva01');

/** MySQL database password */
define('DB_PASSWORD', 'GNde34$76');

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
define('AUTH_KEY',         'l<Zg8%lMFuH[oU!z0{`3=?&ms{/-`Tm`v9Z#^Hz%L:B-,{3d~~azT7!jO]2kggP?');
define('SECURE_AUTH_KEY',  'j7pP!K;z<Ca+yBXLyC~F {a|As@[p{nydTLB/ln0;;z| g!@+x6-/M0b{Y#OjPH`');
define('LOGGED_IN_KEY',    'FX0f1_nH16:j?h6Xj*5{,ArXgdMIwo;lA|@9Z|>!D=P>Huy7d[%$1_D^<R#c2x/c');
define('NONCE_KEY',        'q#bh>{Tzya]pdGeEEnfb0fwA/8K~?bC}bqF>43&w*Ao5nI`*e+,J8Wq;r,+B9v3Z');
define('AUTH_SALT',        ' (lo Vg/X.1riyr?|7,jK:e1k&ol}r^n27c5kk%G1 fpZ9?@uL[;Tz!?%,_RgC~U');
define('SECURE_AUTH_SALT', 'q|qiNJMkYH A=-,P><MFai`n.V<UJeLzQ*0<E#eo[z`Vd_X@i2OVYVh}|b5lgk!1');
define('LOGGED_IN_SALT',   ' c>gb6k!Qyq1rn]^x7C~y3YeHIuOxJ6Yxu6d0J<{n8?8G @2QXJE)Q+>J2AJ$.&%');
define('NONCE_SALT',       'F?u9GO`S#?em8nx~t1_K!upDj+P`%M&(DpU*ZF=c/0mA{.kbw+Lo:o#^aV`S#v*`');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'gr1_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
