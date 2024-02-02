<?php
/*
 * Plugin Name:       Grants
 * Plugin URI:        #
 * Description:       Grants listings.
 * Version:           0.1.0
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author:            Ahamed Arshad
 * Author URI:        https://upwork.com/fl/achchu93
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       grants
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define plugin constants.
define( 'GRANTS_PLUGIN_FILE', __FILE__ );
define( 'GRANTS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include the main plugin class.
require_once __DIR__ . '/includes/class-grants.php';

// Initialize the plugin.
$plugin = new \Grants\Grants();
$plugin->init();
