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
define('DB_NAME', 'guangjian');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** 默认语言包 */
define('WPLANG', 'zh_CN');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '1%)[4nU].w?4aruyX</ia#%@.eF8xD2jBM04pY~qUm^FxvI}Vf_W(<QZ>z]P!^s#');
define('SECURE_AUTH_KEY',  '$}Zu`:)gR85/U9SI<NX,-_xL_CsT0oD1wntp9#v5m!O3!<D=t]$8<^py5sW)*G-g');
define('LOGGED_IN_KEY',    'HOJ0rRl%&miC+[2mDi>U4Rl+>@-]k{uzm]T_Y=U]{wSIfw@jvjbjXJ+-)42$T@Sq');
define('NONCE_KEY',        '|Ylw_k%:,L<?$,?ZtdX|NcZot0^^CzW1ING&F,TC(S- Bl3G1*%b~RZ`X}eV]r&X');
define('AUTH_SALT',        'cke-pcC9L_uNLhJI1/IVrUTj~1fG[Q(_ e(PF.89!zPF}p]+55fPW/JzA={P#BuV');
define('SECURE_AUTH_SALT', 'AowQPE1?~/kV4[?6Wt&m}5~l_//T]UiOu|{sP?y39D*S|X|pf&3k&QEr@sFXOVRS');
define('LOGGED_IN_SALT',   'M2*tZQwsGA-gE)N(U!P5u$?/0,cBMhY-aMMw2LGPC;P!/MaNl__N0{zr._f3<Ks*');
define('NONCE_SALT',       'Rqn{TQGZqi xB5!O{G+tEyfda,ExetN3493N3139r|~8GYxn4;He:?ySxDybqGn[');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'gj_';

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
