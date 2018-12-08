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
define('DB_NAME', 'twobirdssalon_database');

/** MySQL database username bryan_salon*/
define('DB_USER', 'root');

/** MySQL database password 9uCVKHeC+z.(*/
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'R}iZkbn8cNuw$MWrKS|SZ`{[D9duI0eitgvU,0LV2r/7*Kg0A8tZY.M>dsNNoEIF');
define('SECURE_AUTH_KEY',  'V{1kTYb4<0fik0%ugQce0(Jw*/1VFV=@|Ymi|neUsr!u+;?nM.()l6{-B?XwdY,O');
define('LOGGED_IN_KEY',    '.@u;7K)idqx:_lNWdN$ZThRYWXqH@JL~~ unjPlx8@TJ&=d!:hx[OH9rYeT:X67g');
define('NONCE_KEY',        'Tx&7K!ksk0K8PI@$pF7eA Qg,Z@;L70y03A@V)AG>c#l$)}cw<w)biRr{5Ic}ww.');
define('AUTH_SALT',        'IXBTKBPVL]j2z~WUMVE oAk8t{l0:9{Em`pgGSu/%hb-A<O&6Ny:~rZ[;vQ9+u9a');
define('SECURE_AUTH_SALT', '(I CF4RF8~RN8{h9GN/SD=BSq38l3)h&-aA{aAY w{F}W .M^WH=9^!Y0lo8SaNG');
define('LOGGED_IN_SALT',   '~W1vUF[046s7rde/0DAw0VLj7%a+g%s^$is^03P1]SJOE,.|Bieo`A-#Q$Asca&[');
define('NONCE_SALT',       'h@e5_s<#x&ty.n|4zJ%(P/PLJR]/!Snp=pTR4B%<m$Ed:;w^f JA%MJU:~RS>9kB');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
