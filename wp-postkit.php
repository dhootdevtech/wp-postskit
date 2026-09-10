<?php
/**
 * Plugin Name: WP PostKit
 * Plugin URI: https://example.com/wp-postkit
 * Description: Essential tools for WordPress posts including reading time, word count, table of contents, views, and likes.
 * Version: 1.0.0
 * Author: Rashpal Bhardwaj
 * Author URI: https://example.com
 * Text Domain: wp-postkit
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP PostKit version.
 */
define( 'POSTKIT_VERSION', '1.0.0' );

/**
 * WP PostKit file path.
 */
define( 'POSTKIT_FILE', __FILE__ );

/**
 * WP PostKit directory.
 */
define( 'POSTKIT_DIR', plugin_dir_path( __FILE__ ) );

/**
 * WP PostKit URL.
 */
define( 'POSTKIT_URL', plugin_dir_url( __FILE__ ) );

/**
 * Load plugin files.
 */
require_once POSTKIT_DIR . 'includes/class-postkit.php';

/**
 * Initialize WP PostKit.
 */
function postkit_init() {
	$postkit = new PostKit();
	$postkit->init();
}

postkit_init();