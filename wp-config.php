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
define( 'DB_NAME', 'woo_com' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '6uFamu>%VhT,4aQ{U0*!zPU+<v+9RgUeUCT?;jyrQ~`3M{NOW+uI|L.*ayz+O5<y' );
define( 'SECURE_AUTH_KEY',  '=ps<=`tm=n~Gq|p}W@n7m_zOWj3M.}P ]L^h~Ng9Wa-cQ#4h|&iej=RMNj:Y~4)h' );
define( 'LOGGED_IN_KEY',    '1{Nx5;Eh->92FB# +?L >GFufk/W:Q{3+.pD}5?0x}#|3-+H9hT0EY{t TUZ|>?D' );
define( 'NONCE_KEY',        '<~7m8!UeCRlXgr:E{+BKR-6=e!n{?G*J3Y|l`9<pq>LYW+YFV;@m:<YHl,XHpr4/' );
define( 'AUTH_SALT',        'DLef-^$`[iJKo6|*i|-#D|h!^_fTM]HlQZ4FW4>Avn;Qs{DQCU5)S{7Qz}7+_x!d' );
define( 'SECURE_AUTH_SALT', ',e%m)F&/U9T;qE(QzWFHb{TDi(@08bm8< <,>5LGaBx2)hK e/[ZXjd8xB8fx?TH' );
define( 'LOGGED_IN_SALT',   'cuep3-12/Kv`*uIbnAK$O}~^y365VGZ:#Zf3>z[Qs5RYhY}*ep6,sx)2Doa`;#<>' );
define( 'NONCE_SALT',       'S%I^I~Zv4Un{O*qLLU.KPiz#O`<982Uz%H+tc?h{&iM{u>Q7:v r`rJgAwHy 7GD' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_avocado_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
