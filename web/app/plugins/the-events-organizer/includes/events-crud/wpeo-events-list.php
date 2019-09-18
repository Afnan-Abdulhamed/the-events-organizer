<?php

/**
 * CRUD class file
 *
 * @package the-events-organizer
 */



/**
 * class to get all events from db
 *
 * @since      1.0.0
 * @package   The Events Organizer Plugin
 * @author     Afnan Abdelhameed <afnanabdulhameed@gmail.com>
 */
class WPEO_List_Events {

    public function __construct()
    {
        add_action('wpeo_list', array($this, 'wpeo_list'));
    }

    /**
     * Inistantiate the WPEO_List_Events class
     *
     * @return object
     */
    public static function init()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new WPEO_List_Events();
        }
        return $instance;
    }

    function wpeo_list(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'wpeo_events';

        return $wpdb->get_results(
            "SELECT * 
            FROM $table_name"
        );
    }

}
