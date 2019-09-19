<?php

/**
 * functions related to the event organizer admin side
 *
 * @package the events organizer
 */


/**
 * The admin-specific functionality.
 *
 * @since      1.0.0
 * @package   The Events Organizer Plugin
 * @author     Afnan Abdelhameed <afnanabdulhameed@gmail.com>
 */
class WPEO_Admin
{

    /**
     * The name of this plugin.
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
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     * @return void
     */
    function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }


    /**
     * Register the stylesheets
     *
     * @since    1.0.0
     */
    function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wpeo-admin-styles.css', array(), $this->version, 'all');
    }

    
    /**
     * Register the JavaScript
     *
     * @since  1.0.0
     * @return void
     */
    function enqueue_scripts()
    {   
        wp_enqueue_script( 'jqueryUI', "//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js" );
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wpeo-admin-scripts.js', array( 'jquery' ), $this->version, false);
    }


    /**
     * register page to handle plugin configs
     *
     * @since  1.0.0
     * @return void
     */
    function register_options_page()
    {
        add_menu_page(
            'Theme Options',
            'Events Organizer Settings',
            'manage_options',
            plugin_dir_path(__FILE__) . '/partials/wpeo_settings_page_template.php',
            null,
            'dashicons-admin-generic',
            75
        );
    }
    

	/**
     * register config. fields for the settings page
     * 
     * @since  1.0.0
     * @return void
     */
    function register_options_fields()
    {
        register_setting('wpeo-settings-group', 'wpeo_enable_past_events');
        register_setting('wpeo-settings-group', 'wpeo_events_listing_no');
	}


	/**
     * register plugin custom post types
	 * 
     * @since  1.0.0
     * @return void
     */
    function register_wpeo_cpt()
    {
		require_once plugin_dir_path(__FILE__) . '/post-types/wpeo-events-cpt.php';
    }


    /**
     * register settings submenu for events cpt menu item
     * 
     * @since 1.0.0
     * @return void
     */
    function register_settings_submenu()
    {
        add_submenu_page(
            'edit.php?post_type=events',
            'Event Organizer Settings',
            'Event Organizer Settings',
            'manage_options',
            'event_organizer_settings_submenu',
            array($this,'setting_page')
        );
    }
    

    /**
     * include settings page template
     *
     * @since 1.0.0
     * @return void
     */
    function setting_page(){
        require_once plugin_dir_path(__FILE__) . '/partials/wpeo_settings_page_template.php';
    }



    /**
     * register events posts meteaboxes
	 * 
     * @since  1.0.0
     * @return void
     */
    function register_events_metaboxes()
    {
        add_meta_box(
            'wpeo_event_date',
            'Event Date',
            array($this,'wpeo_event_date_metabox'),
            'events',
            'advanced',
            'default'
        );
    }


    /**
     * include event metaboxe template
     *
     * @since 1.0.0
     * @return void
     */
    function wpeo_event_date_metabox() {
        require_once plugin_dir_path(__FILE__) . '/metaboxes/wpeo-event-date-metabox.php';
    }

    
    /**
     * store event meta data
     *
     * @param id $post_id
     * @param object $post
     * @return void
     */
    function save_events_metadat( $post_id, $post ) {
        // Return if the user doesn't have edit permissions.
        if ( ! current_user_can( 'edit_post', $post_id ) || ! $_POST) {
            return $post_id;
        }
        
        $meta_data['event_date']      = esc_textarea( $_POST['event_date'] );
        $meta_data['evnt_end_time']   = esc_textarea( $_POST['evnt_end_time'] );
        $meta_data['evnt_start_time'] = esc_textarea( $_POST['evnt_start_time'] );

        foreach ( $meta_data as $key => $value ){
            // Don't store custom data twice
            if ( 'revision' === $post->post_type ) {
                return;
            }
            if ( get_post_meta( $post_id, $key, false ) ) {
                // If the custom field already has a value, update it.
                update_post_meta( $post_id, $key, $value );
            } else {
                // If the custom field doesn't have a value, add it.
                add_post_meta( $post_id, $key, $value);
            }
            if ( ! $value ) {
                // Delete the meta key if there's no value
                delete_post_meta( $post_id, $key );
            }
        }
    }
   
}