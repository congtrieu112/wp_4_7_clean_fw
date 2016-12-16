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
define('DB_NAME', 'wp_clear_4_7');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'bsRDt6o`Eup<&pl4qkiPQFTrWa<wG#=OzXvivD=QX -0:/!g~4Ehc-$@U*MqBJrU');
define('SECURE_AUTH_KEY',  ':2,XA[N0&A#P> n?;$4rJ^,906j8roW6>cAB]HX#`9#Gj7mWqaCR#y83AL5Wx wa');
define('LOGGED_IN_KEY',    '~>Dl)!};ltb={{sAmOsnxyZjg?p{h+a.=+b%^u1 }duPyQZ(5/(H4+ZivlW6yP}E');
define('NONCE_KEY',        'Dir@mDXy.L(fTGV70&;?NX/ew}DK;ma;3j:SJE;LTVEIVv|L()a9Opb-jbZEKc1$');
define('AUTH_SALT',        'KGyF7_`f1>XHd7%A[attk=*eOu!_9zT3lN: m%<}gZCI]sVjp3VSd /L+l^n!sd@');
define('SECURE_AUTH_SALT', '{`2e bX.>Jn+?$@MrO_j6?%IuAJ^=lES.m }|j_/+h^*H2Y8eLGzyCpuO93KO9Z_');
define('LOGGED_IN_SALT',   'g1OGE/Cv3J?Y*mc%gt@h9?zSV)|wEt{4&<S-*|dolr+f.Gd9pVFhB+A_bpLHOYm]');
define('NONCE_SALT',       'nM|S^gEoer0U1wl+db;U<5}O^-8VVr!&-tU!@dPijNy=,QB7t<}k4~Q8iJ=_`v}P');

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
