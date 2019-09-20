<?php
/**
 * the DB structure for the plugin
 *
 * @package the events organizer
 */


/**
 * class to create events database tables during the activation process
 *
 * @since      1.0.0
 * @package   the events organizer
 * @author     Afnan Abdelhameed <afnanabdulhamed@gmail.com>
 */ 
class WPEO_Schema {

	/**
	 * wordpress object to interact with the database
	 *
	 * @var private
	 */
	private $wpdb;


	/**
	 * The database character collate.
	 *
	 * @var private
	 */
	private  $charset_collate;


	/**
     * Inistantiate the WPEO_Schema class
     *
     * @return object
     */
	public function __construct()
    {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$this->wpdb = $wpdb;
		global $wpdb, $charset_collate;
		$this->charset_collate = $wpdb->get_charset_collate();
   
        // create DB tables actions
		add_action('create_settings_table', array($this, 'create_settings_table'));
        add_action('create_events_table', array($this, 'create_events_table'));
    }


    /**
     * Inistantiate the class
     *
     * @return object
     */
    public static function init()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new WPEO_Schema();
        }
        return $instance;
	}
	
	/**
	 * create plugin settings table, (can be replaced by wordpress options)
	 *
	 * @return void
	 */
	function create_settings_table()
	{
		$table_name = $this->wpdb->prefix . 'wpeo_settings';
		
		$sql = "CREATE TABLE $table_name (
			option_id bigint(20) unsigned NOT NULL auto_increment,
			option_name varchar(191) NOT NULL default '',
			option_value longtext NOT NULL,
			PRIMARY KEY  (option_id),
			UNIQUE KEY option_name (option_name)
		) $this->charset_collate;";
		dbDelta( $sql );
	}

	
	/**
	 * create the events table
	 *
	 * @return void
	 */
	function create_events_table()
	{
        $table_name = $this->wpdb->prefix . 'wpeo_events';
	   
	   	$sql = "CREATE TABLE $table_name (
			ID bigint(20) unsigned NOT NULL auto_increment,
			event_title text NOT NULL,
			post_id bigint(20) unsigned NOT NULL,
			event_description longtext NOT NULL,
			event_date date NULL DEFAULT NULL,
			event_start_time time NULL DEFAULT NULL,
			event_end_time time NULL DEFAULT NULL,
			event_cover_image bigint(20) unsigned NOT NULL,
			event_author bigint(20) unsigned NOT NULL default '0',
			event_status tinyint(1) NOT NULL default '1',
			deleted_at datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY  (ID),
			KEY event_author (event_author),
			KEY post_id (post_id)
		) $this->charset_collate;";
        dbDelta($sql);
	}
	
}
