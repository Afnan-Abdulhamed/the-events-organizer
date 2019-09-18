<?php

/**
 * Plugin Name:       The Events Organizer
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Afnan Abdelhameed
 * Author URI:        https://github.com/Afnan-Abdulhamed
 */



// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}



/**
 * Currently plugin version.
 */
define('THE_EVENT_ORGANIZER_VERSION', '1.0.0');



/**
 * The code that runs during plugin activation.
 *
 * @since 1.0.0
 * @see includes/class-wpeo-activator.php
 * @return void
 */
function wpeo_activate_plugin() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpeo-activator.php';
    WPEO_Activator::activate();
}



/**
 * The code that runs during plugin deactivation.
 *
 * @since 1.0.0
 * @see includes/class-wpeo-deactivator.php
 * @return void
 */
function wpeo_deactivate_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpeo-deactivator.php';
	WPEO_Deactivator::deactivate();
}


// register plugin activation and deactivation hooks
register_activation_hook( __FILE__, 'wpeo_activate_plugin' );
register_deactivation_hook( __FILE__, 'wpeo_deactivate_plugin' );




/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpeo-events-organizer.php';

/**
 * Begins execution of the plugin.
 *
 * @see includes/class-wpeo-events-organizer.php
 * @since 1.0.0
 * @return void
 */
function run_the_event_organizer() {

	$plugin = new WPEO_Events_Organizer();
	$plugin->run();

}
run_the_event_organizer();
