<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @since      1.0.0
 * @package the-events-organizer
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

function wpeo_delete_plugin() {
	global $wpdb;
	// delete the setting added to the options table
	delete_option( 'wpeo_enable_past_events' );
	delete_option( 'wpeo_events_listing_no' );

	// delete the plugin custom tables
	$wpdb->query( sprintf( "DROP TABLE IF EXISTS %s",
		$wpdb->prefix . 'wp_wpeo_settings' ) );
	
	$wpdb->query( sprintf( "DROP TABLE IF EXISTS %s",
		$wpdb->prefix . 'wp_wpeo_events' ) );
}

wpeo_delete_plugin();
