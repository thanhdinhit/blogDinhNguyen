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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'blogntd' );

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
define( 'AUTH_KEY',         'd_</rfk2Fck#ps9~e;fW?p~RPtOf[oc12HgUXcH.W`ec7#37KT=.W!h*iB~0yNJx' );
define( 'SECURE_AUTH_KEY',  'o X#;%00@Rk1Q]q^,.L87Av[~fhOS=Z10?Mf<WBr({tn!zODw>r.f&NmTV`Ur?W5' );
define( 'LOGGED_IN_KEY',    '= .9@Z6K~;HbMCP/fvYy7D^VWQAd=ORzU/%yA:!q^*ngBCiqKJ:CBZ{<!hA}^W[[' );
define( 'NONCE_KEY',        '0}vXt d48~ven87HVKHItB`O.fBXAa7hgL<7H*8?k@BmefAjG/JRKQlfJErWAp^|' );
define( 'AUTH_SALT',        '5<dgl%kZ~|:[ajA@RI4`N?_xzJ/B=BD)sON|T@LS89huQUq2N%$YWzrrd N_L~hK' );
define( 'SECURE_AUTH_SALT', '4XV(u;RL&7F2bv7Ad~x<A`a2kEtNr^D6CtfaAjGglkluxGK^J,dkkgydI8@~:)qb' );
define( 'LOGGED_IN_SALT',   'N~{~zVUZbty_eo*7LAW1;y]}S:~uv&|E8vY>fiAnS%2R0+19l7+fS3]g.2PUL}@D' );
define( 'NONCE_SALT',       '4#vZXAru%Ei3/Lv*J15Y77SfuT>tAYSmLe`lC%AJeXFf~yfoZw>Z+tDU]ii}vi#-' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
