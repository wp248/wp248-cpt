<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wp248.com
 * @since             1.0.0
 * @package           wp248_cpt
 *
 * @wordpress-plugin
 * Plugin Name:       WP248 CPT
 * Plugin URI:        https://github.com/wp248/wp248-cpt
 * Description:       WordPress plugin, Custom Type Posts for: Customers Speak, Jobs, Partners, Portfolios, Services, Tech Terms, Technology, and much more.
 * Version:           1.0.0
 * Author:            wp248.com
 * Author URI:        https://wp248.com
 * License:           GPL-3.0++
 * License URI:       http://www.gnu.org/licenses/GPL-3.0+.txt
 * Text Domain:       wp248-cpt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP248_CPT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp248-cpt-activator.php
 */
function activate_wp248_cpt() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp248-cpt-activator.php';
	wp248_cpt_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp248-cpt-deactivator.php
 */
function deactivate_wp248_cpt() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp248-cpt-deactivator.php';
	wp248_cpt_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp248_cpt' );
register_deactivation_hook( __FILE__, 'deactivate_wp248_cpt' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp248-cpt.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp248_cpt() {

	$plugin = new wp248_cpt();
	$plugin->run();

}
run_wp248_cpt();
