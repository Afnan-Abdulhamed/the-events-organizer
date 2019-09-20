<?php

/**
 * The public-facing functionality of the plugin.
 * You can override the single event page and the events archive in any theme
 * by creating single-events.php and archive-events.php
 *
 *  @package the-events-organizer
 */


/**
 * The public-facing functionality of the plugin.
 *
 *
 * @package    the-events-organizer
 * @author     Afnan Abdelhameed <afnanabdulhamed@gmail.com>
 */
class WPEO_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->version     = $version;
		$this->plugin_name = $plugin_name;
		
		// public interface hooks
		add_filter( 'template_include', array( $this, 'include_events_archive_template'), 99 );
		add_filter( 'single_template', array( $this, 'include_events_single_template'), 99 );
	}


	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wpeo-styles-public.css', array(), $this->version, 'all' );
	}


	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wpeo-scripts-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(  $this->plugin_name, 'my_ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}


	/**
	 * events archive page template
	 * this template include if the theme dose not have archive-events.php
	 *
	 * @since 
	 * @param object $archive_template
	 * @return void
	 */
	public function include_events_archive_template( $archive_template ) {
		if ( is_post_type_archive('events') ) {

			$theme_events_archive = locate_template(['archive-events.php'], false);
			
			if ( $theme_events_archive ) {
			  return $theme_events_archive;
			} else {
			  return plugin_dir_path(__FILE__) . 'templates/archive-events.php';
			}
		  }
		return $archive_template;
	}


	/**
	 * events single page template
	 * this template include if the theme dose not have single-events.php
	 * 
	 * @since    1.0.0
	 */
	public function include_events_single_template( $single_template ) 
	{
		global $post;
		
		if ( 'events' == $post->post_type ) {
			$theme_single_event = locate_template(['single-events.php'], false);

			// check if theme already have single file for events if not include the plugin`s template
			if ( $theme_single_event ) {
				return $theme_single_event;
			} else {
				return plugin_dir_path(__FILE__) . 'templates/single-events.php';
			}
		}
		return $single_template;
	}
}