<?php

/**
 *The Events Organizer plugin file for plugin activation
 *
 * @package the-events-organizer
 */



/**
 * class to defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package   The Events Organizer Plugin
 * @author     Afnan Abdelhameed <afnanabdulhameed@gmail.com>
 */
class WPEO_Activator {

	/**
	 * The code that runs during plugin activation.
	 *
	* @since 1.0.0
	* @see class-wpeo-schema.php
	* @return void
	 */
	public static function activate() {

		// add plugin related tables to DB
		require plugin_dir_path( __FILE__ ) . 'class-wpeo-schema.php';
		
		WPEO_Schema::init();

		do_action('create_settings_table');
		do_action('create_events_table');
	}
}
