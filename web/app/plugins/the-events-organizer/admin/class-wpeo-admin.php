<?php

/**
 * functions related to the event organizer backend
 *
 * @package the events organizer
 */


/**
 * The admin-specific functionalityn.
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
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/plugin-name-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript
     *
     * @since  1.0.0
     */
    public function enqueue_scripts()
    {   
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wpeo-admin-scripts.js', array( 'jquery' ), $this->version, false);
        wp_enqueue_script( 'jqueryUI', "//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js" );
    }


    /**
     * settings page to handle plugin configs
     *
     * @since  1.0.0
     * @return void
     */
    public function register_options_page()
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
     * events listing page
     *
     * @since  1.0.0
     * @return void
     */
    public function register_events_listing_page()
    {
        add_menu_page( 
            'Events', 
            'Events', 
            'manage_options', 
            'events-list',
            array($this,'events_list_page'),
            'dashicons-calendar-alt',
            5
        );
    }

    function events_list_page(){
        require_once plugin_dir_path(__FILE__) . 'partials\wpeo-events-listing-template.php';
        $eventsList = new WPEO_Events_Listing_Table();
        echo '<div class="wrap">
              <h2>All Events</h2>'; 
        $eventsList->prepare_items(); 
        $eventsList->display(); 
        
        echo '</div>'; 
      }
	/**
     * settings page fields registering
     * @since  1.0.0
     * @return void
     */
    public function register_options_fields()
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
    public function register_wpeo_cpt()
    {
		require_once plugin_dir_path(__FILE__) . '/post-types/wpeo-events-cpt.php';
    }
    
    /**
     * register meteaboxes
	 * 
     * @since  1.0.0
     * @return void
     */
    public function register_events_metaboxes()
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

    function wpeo_event_date_metabox() {
        require_once plugin_dir_path(__FILE__) . '/metaboxes/wpeo-event-date-metabox.php';
    }
    
}