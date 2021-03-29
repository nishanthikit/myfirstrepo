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
define( 'DB_NAME', 'wordpresstest' );

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
define( 'AUTH_KEY',         'biC;SD4EJ.xtT:K+UqMy *a@f$|EH0AyRvr3{pGHu&iHMAV`}3,~ZMDGJPT%Ifl$' );
define( 'SECURE_AUTH_KEY',  ';A234#$r?tzyJ[<,:LcK846oNHfX}z?fY;X-=oZmA}vp3|?,s1Mid!>}c]rt9*2p' );
define( 'LOGGED_IN_KEY',    'Rg5M^8gCFfV.0ODhHMlp2z`|ZQDDf5gtumEW$&%kany w@(mAqI[<%Qlj<qz:ZBA' );
define( 'NONCE_KEY',        'n@YP@qQq!>.2A[s$<~`W%6UKgj@CvzofQd:Z,%C1&E=)6KRZ#T46Yx*|U-^9x*R0' );
define( 'AUTH_SALT',        '!Ay~xB);#AT`8Y1vXh}]D,v&fC0KJ;Eg7L04v^{&6^:$u1RQU{jQ=m[5kLjmx!pZ' );
define( 'SECURE_AUTH_SALT', '6<-P[K5b];uyi=P-!b2 roS1&=X^%5WOj%ad[)lf{/!}ma+CK(u,q|1q[x3Qr5qN' );
define( 'LOGGED_IN_SALT',   '=ncDRR7OICHc5B&cix(^ <klLVzVZG[|)~$fsv27gi?l9VzZ+3pjM.sLT7}i35<9' );
define( 'NONCE_SALT',       '<HoRG}S[k|@;/#Jd[3<ma:eO!}n^u]U*S:[qVq60[ Sn*8Ewr/R+z-:xeC?Gdu8$' );

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
define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
