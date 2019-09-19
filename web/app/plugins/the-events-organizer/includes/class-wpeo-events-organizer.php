<?php

/**
 * The file that defines the core plugin class
 *
 * @package the-events-organizer
 */


 
/**
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area
 *
 * @since      1.0.0
 * @package   The Events Organizer Plugin
 * @subpackage the-events-organizer/includes
 * @author     Afnan Abdelhameed <afnanabdulhameed@gmail.com>
 */
class WPEO_Events_Organizer {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WPEO_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'the-events-generator';

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_events_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WPEO_Loader. Orchestrates the hooks of the plugin.
	 * - WPEO_Admin. Defines all hooks for the admin area.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpeo-loader.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 * like registering cpt, metaboxes, menu pages ... 
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpeo-admin.php';

		/**
		 * The class responsible for defining all crud actions for the events.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/events-crud/class-wpeo-events.php';

		$this->loader = new WPEO_Loader();

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new WPEO_Admin( $this->get_plugin_name(), $this->get_version() );
		
		// assets
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// plugin settings page
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'register_options_page' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_options_fields' );

		// registering custom post types
		$this->loader->add_action( 'init', $plugin_admin, 'register_wpeo_cpt' );
		// add metaboxes to events post type
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'register_events_metaboxes' );

		// save event meta data
		$this->loader->add_action( 'save_post', $plugin_admin, 'save_events_metadat', 1, 2);

	}


	/**
	 * Register all events crud related hooks
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_events_hooks() {

		$plugin_admin = new WPEO_Events( $this->get_plugin_name(), $this->get_version(), 1, 2);

		// save event hooks
		$this->loader->add_action( 'save_post', $plugin_admin, 'save', 1, 2);

		// delete event hooks
		$this->loader->add_action( 'delete_post', $plugin_admin, 'delete', 1, 1);

		// event status transitions
		$this->loader->add_action( 'transition_post_status', $plugin_admin, 'on_all_status_transitions',2,3);


	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WPEO_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
