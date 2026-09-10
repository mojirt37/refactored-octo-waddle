<?php
/**
 * The base configuration for WordPress
 *
 * This file contains the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link https://codex.wordpress.org/Editing_wp-config.php}.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'bambroo_db');

/** MySQL database username */
define('DB_USER', 'bambroo_user');

/** MySQL database password */
define('DB_PASSWORD', 'secure_password_here');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 */
define('AUTH_KEY',         'unique_auth_key_here');
define('SECURE_AUTH_KEY',  'unique_secure_auth_key_here');
define('LOGGED_IN_KEY',    'unique_logged_in_key_here');
define('NONCE_KEY',        'unique_nonce_key_here');
define('AUTH_SALT',        'unique_auth_salt_here');
define('SECURE_AUTH_SALT', 'unique_secure_auth_salt_here');
define('LOGGED_IN_SALT',   'unique_logged_in_salt_here');
define('NONCE_SALT',       'unique_nonce_salt_here');

/**#@-*/

/**
 * WordPress database table prefix.
 */
$table_prefix = 'wp_bambroo_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 */
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);
define('WP_DEBUG_LOG', true);

/**
 * Security settings
 */
define('DISALLOW_FILE_EDIT', true);
define('DISALLOW_FILE_MODS', true);
define('FORCE_SSL', true);

/**
 * Hide WordPress version
 */
remove_action('wp_head', 'wp_generator');

/**
 * Absolute path to the WordPress directory.
 */
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');