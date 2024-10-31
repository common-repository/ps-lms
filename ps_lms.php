<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.perceptionsystem.com
 * @since             1.0.0
 * @package           Ps_lms
 *
 * @wordpress-plugin
 * Plugin Name:       PS LMS
 * Plugin URI:        http://www.perceptionsystem.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Perception System Pvt. Ltd.
 * Author URI:        http://www.perceptionsystem.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ps_lms
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
 
define( 'PS_LMS_VERSION', '1.0.0' );
define( 'PS_LMS_PREMIUM', '1' );
define( 'PS_LMS_INIT', plugin_basename( __FILE__ ) );
define( 'PS_LMS_FILE', __FILE__ );
define( 'PS_LMS_DIR', plugin_dir_path( __FILE__ ) );
define( 'PS_LMS_URL', plugins_url( '/', __FILE__ ) );
define( 'PS_LMS_ASSETS_URL', PS_LMS_URL . 'assets/' );
define( 'PS_LMS_ASSETS_PATH', PS_LMS_DIR . 'assets/' );
define( 'PS_LMS_TEMPLATE_PATH', PS_LMS_DIR . 'templates/' );
define( 'PS_LMS_INC', PS_LMS_DIR . 'includes/' );
define( 'PS_LMS_SLUG', 'ps-lms' );
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ps_lms-activator.php
 */
function activate_ps_lms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ps_lms-activator.php';
	Ps_lms_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ps_lms-deactivator.php
 */
function deactivate_ps_lms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ps_lms-deactivator.php';
	Ps_lms_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ps_lms' );
register_deactivation_hook( __FILE__, 'deactivate_ps_lms' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ps_lms.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ps_lms() {

	$plugin = new Ps_lms();
	$plugin->run();

}
run_ps_lms();
