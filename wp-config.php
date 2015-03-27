<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
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
define('DB_NAME', 'clay_hardcell');

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
define('AUTH_KEY',         'gd38D }`doo.)#n:[j[!zqz[KSF>;Tk[/}O^k>8>cYYa<F;GM`2dDX1p^Q3.ZN2r');
define('SECURE_AUTH_KEY',  'gmlR`Qq`p0n:A,w0B)~8Tn)9Fg=%#aKd;_GZh2Mv&c!n]o/ZWcX1hh3!;N4eOEEV');
define('LOGGED_IN_KEY',    'fq;7c~|kmX )`w)1YPgy*&`R!H4Y~C~JAAW}vv (A!8 ?iJ>:9P(3?uh={@T3Yqd');
define('NONCE_KEY',        'zi<G79]Zm46r):3[%zFV4;&?)h(0s^O;:Y-o<fqq{@GpG*C2=^1aB.^8]W+:=f}/');
define('AUTH_SALT',        '?^*~Uq>OH|5#yZ|d^7sR%MOE/&+$U!};s5ZBV.O,z}>Y0O57I/JnM@N! u=dHjCh');
define('SECURE_AUTH_SALT', 'i:S]T>DaMP2|] Sa=4Kk.dR^wG5j@*9?gl!@^*!d}NIIQSYtJxx-geP8+KZ#*Kwl');
define('LOGGED_IN_SALT',   'qC&I04M:|)WWe{j2+8V@9}IduCW{-$REXK@.EKH:H7LgaG6x/mpW$!KOqg2.pi?h');
define('NONCE_SALT',       'eeA-Li:lp,:#@_7-2I,wEJaZ57Ge|#v:$J ptk9[7XD|Bw5~D/Bdf$!zN4s<Y@RB');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
