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
 * @since             0.0.1
 * @package           wp248_cpt
 *
 * @wordpress-plugin
 * Plugin Name:       WP248 CPT
 * Plugin URI:        https://github.com/wp248/wp248-cpt
 * Description:       WordPress plugin, Custom Type Posts for: Customers Speak, Jobs, Partners, Portfolios, Services, Tech Terms, Technology, and much more.
 * Version:           0.0.1
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
 * Start at version 0.0.1 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */

define( 'WP248_CPT_VERSION', '0.0.1' );
define( 'WP248_CPT_PLUGIN', plugin_basename( __FILE__ ) );  // value: p248-cpt/wp248-cpt.php
define( 'WP248_CPT_ID', dirname( WP248_CPT_PLUGIN ) ); // value: wp248-cpt

defined( 'WP248_CPT_DIR' ) || define( 'WP248_CPT_DIR', plugin_dir_path( __FILE__ ) );	//<filesystem>/wp-content/plugins/wp248-cpt/
defined( 'WP248_CPT_URL' ) || define( 'WP248_CPT_URL', plugin_dir_url( __FILE__ ) );	//http(s)://domain-name/wp-content/plugins/wp248-cpt/

defined( 'WP248_CPT_INC' ) || define( 'WP248_CPT_INC', WP248_CPT_DIR . 'includes/' );
defined( 'WP248_CPT_INC_ASSETS' ) || define( 'WP248_CPT_INC_ASSETS', WP248_CPT_DIR . 'assets/' );

defined( 'WP248_CPT_INC_MOD' ) || define( 'WP248_CPT_INC_MOD', WP248_CPT_INC . 'modules/' ); // includes/modules/

defined( 'WP248_CPT_ADMIN' ) || define( 'WP248_CPT_ADMIN', WP248_CPT_DIR . 'admin/' );
defined( 'WP248_CPT_ADMIN_URL' ) || define( 'WP248_CPT_ADMIN_URL', WP248_CPT_URL . 'admin/' );

defined( 'WP248_CPT_PUBLIC' ) || define( 'WP248_CPT_PUBLIC', WP248_CPT_DIR . 'public/' );
defined( 'WP248_CPT_PUBLIC_URL' ) || define( 'WP248_CPT_PUBLIC_URL', WP248_CPT_URL . 'public/' );

defined( 'WP248_CPT_ASSETS_CSS' ) || define( 'WP248_CPT_ASSETS_CSS', WP248_CPT_URL . 'assets/css/' );
defined( 'WP248_CPT_ASSETS_JS' ) || define( 'WP248_CPT_ASSETS_JS', WP248_CPT_URL . 'assets/js/' );
defined( 'WP248_CPT_ASSETS_SRC' ) || define( 'WP248_CPT_ASSETS_SRC', WP248_CPT_URL . 'assets/src/' );
defined( 'WP248_CPT_ASSETS_IMG' ) || define( 'WP248_CPT_ASSETS_IMG', WP248_CPT_URL . 'assets/images/' );
defined( 'WP248_CPT_ASSETS_PARTIALS' ) || define( 'WP248_CPT_ASSETS_PARTIALS', WP248_CPT_URL . 'assets/partials/' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp248-cpt-activator.php
 */

function activate_wp248_cpt() {
	require_once WP248_CPT_INC . 'class-wp248-cpt-activator.php';
	wp248_cpt_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp248-cpt-deactivator.php
 */
function deactivate_wp248_cpt() {
	require_once WP248_CPT_INC . 'class-wp248-cpt-deactivator.php';
	wp248_cpt_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp248_cpt' );
register_deactivation_hook( __FILE__, 'deactivate_wp248_cpt' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require_once WP248_CPT_INC . 'class-wp248-cpt.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.0.1
 */
function run_wp248_cpt() {

	$plugin = new wp248_cpt();
	$plugin->run();

}
run_wp248_cpt();
