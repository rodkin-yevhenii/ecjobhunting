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
define( 'DB_NAME', 'ecjobhunting' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         'lIU/tbVtinSNs;qi=5X<$Z{qh/C&g(X, Ii6`alIga)W-d#gtYJ[wpxq+v]N[zLc' );
define( 'SECURE_AUTH_KEY',  'lI%&$aWv7jxD[dF9,-u$[fWAS(:)#TvR?QLc-sKt)OBOXkZY>D>&z.IKgEcaa8X~' );
define( 'LOGGED_IN_KEY',    '4s{i|PF+I/{6((iMK+; V:5ro8J8M]/@Gm(FAzAMrA| [7N[+FzE?}xpg(3]I8fy' );
define( 'NONCE_KEY',        'Q>{aZ_<Qke -QGDe@UX@],&H)FFrz.9(RF~7CwZHh@+Vi/&0{YJt&:61%}n]Q<iF' );
define( 'AUTH_SALT',        'WEN7;>ZmN?hs8t|8B7vwY|rsrYPuhgOsX=yR7kMNtzP-ePxM62M2QXWw@#J>8Knw' );
define( 'SECURE_AUTH_SALT', 'N8Bdb5eu}=_|KaC|yWodV^-N!q 7|u9.I0H{PP`8u?p:fRJqU#}iuW%BJ:b8douh' );
define( 'LOGGED_IN_SALT',   'UK/TvR&1<,*b#@_-j@,oa~y{]F_wWTvzR`p*06e;Z}=*flCdGy4*s8qq,oam$.!h' );
define( 'NONCE_SALT',       'MmLT|4_WdqEa%981NAd,u4{6D84V<ZSZG7+?D7@3B~g^jl-O84 @gch+i.{iGhg7' );

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
