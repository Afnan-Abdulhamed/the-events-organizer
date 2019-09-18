<?php

/**
 *
 * the DB structure for the plugin
 *
 * @package the events organizer
 */




class WPEO_Schema {
	private $wpdb;
	private  $charset_collate;

	public function __construct()
    {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		/*
		* Indexes have a maximum size of 767 bytes. Historically, we haven't need to be concerned about that.
		* As of 4.2, however, we moved to utf8mb4, which uses 4 bytes per character. This means that an index which
		* used to have room for floor(767/3) = 255 characters, now only has room for floor(767/4) = 191 characters.
		*/
		/**
		 * Declare these as global
		 *
		 * @global wpdb   $wpdb
		 * @global string $charset_collate
		 */
		global $wpdb, $charset_collate;
		$this->wpdb = $wpdb;

		/**
		 * The database character collate.
		 */	
		$this->charset_collate = $wpdb->get_charset_collate();
   
        // Photo Gallery
		add_action('create_settings_table', array($this, 'create_settings_table'));
        add_action('create_event_meta_table', array($this, 'create_event_meta_table'));
        add_action('create_events_table', array($this, 'create_events_table'));
		
    }

    /**
     * Inistantiate the CgTunes class
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
	

	function create_settings_table(){
		
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


	function create_event_meta_table(){
        $table_name = $this->wpdb->prefix . 'wpeo_event_meta';
        $sql = "CREATE TABLE $table_name (
			meta_id bigint(20) unsigned NOT NULL auto_increment,
			event_id bigint(20) unsigned NOT NULL default '0',
			meta_key varchar(255) default NULL,
			meta_value longtext,
			PRIMARY KEY  (meta_id),
			KEY event_id (event_id),
			KEY meta_key (meta_key(191))
		) $this->charset_collate;";
        dbDelta($sql);
	}
	
	
	function create_events_table(){
        $table_name = $this->wpdb->prefix . 'wpeo_events';
        $sql = "CREATE TABLE $table_name (
			ID bigint(20) unsigned NOT NULL auto_increment,
			event_author bigint(20) unsigned NOT NULL default '0',
			event_content longtext NOT NULL,
			event_title text NOT NULL,
			event_date datetime NOT NULL default '0000-00-00 00:00:00',
			event_modified datetime NOT NULL default '0000-00-00 00:00:00',
			guid varchar(255) NOT NULL default '',
			PRIMARY KEY  (ID),
			KEY event_author (event_author)
		) $this->charset_collate;";
        dbDelta($sql);
    }
	
		
}
