<?php

/**
 * The file that defines the core plugin class
 *
 * @package the-events-organizer
 */


 
/**
 *
 * A class to handlepublic-facing side of the site and the admin area
 *
 * @since      1.0.0
 * @package   the-events-oranizer
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
		if ( defined( 'WPEO_VERSION' ) ) {
			$this->version = WPEO_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'the-events-generator';

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_events_hooks();
		$this->define_events_shortcodes();
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

		/**
		 * The class responsible for defining plugin shortcodes
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpeo-shortcodes.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wpeo-public.php';

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
		
		// add settings page as submenu for events cpt
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'register_settings_submenu' );

		// add metaboxes to events post type
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'register_events_metaboxes' );

		// save event meta data
		$this->loader->add_action( 'save_post', $plugin_admin, 'save_events_metadat', 1, 2);

	}


	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new WPEO_Public( $this->get_plugin_name(), $this->get_version() );
		
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}


	/**
	 * Register all events crud related hooks
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_events_hooks() {

		$plugin_admin = new WPEO_Events();

		// save event hooks
		$this->loader->add_action( 'save_post', $plugin_admin, 'save', 1, 2);

		// delete event hooks
		$this->loader->add_action( 'delete_post', $plugin_admin, 'delete', 1, 1);

		// event status transitions
		$this->loader->add_action( 'transition_post_status', $plugin_admin, 'on_all_status_transitions',2,3);

	}


	/**
	 * Register all events crud related hooks
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_events_shortcodes() {

		$shortcodes = new WPEO_Shortcodes();
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
