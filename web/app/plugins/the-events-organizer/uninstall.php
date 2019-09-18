<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @since      1.0.0
 * @package link-task
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

function wplt_delete_plugin() {
	global $wpdb;

	delete_option( 'wplt_plugin_test' );

// 	$posts = get_posts(
// 		array(
// 			'numberposts' => -1,
// 			'post_type' => 'wpcf7_contact_form',
// 			'post_status' => 'any',
// 		)
// 	);

// 	foreach ( $posts as $post ) {
// 		wp_delete_post( $post->ID, true );
// 	}

	$wpdb->query( sprintf( "DROP TABLE IF EXISTS %s",
		$wpdb->prefix . 'wplt_test' ) );
}

wplt_delete_plugin();
