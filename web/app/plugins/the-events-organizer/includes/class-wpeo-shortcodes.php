<?php

/**
 * This file is use to create a sortcode of the event organizer plugin
 *
 * @package the-events-organizer
 */



/**
 * class to handle the plugin shortcodes
 *
 * @since      1.0.0
 * @package   The Events Organizer Plugin
 * @author     Afnan Abdelhameed <afnanabdulhameed@gmail.com>
 */
class WPEO_Shortcodes {

    /**
     * event object (crud)
     *
     * @var object
     */
    private $events;


	/**
     * Inistantiate the class
     *
     * @return object
     */
	public function __construct()
    {
        $this->events = new WPEO_Events();

        add_shortcode( 'wpeo_events', array( $this, 'list_events' ) );
    }


	/**
	 * list events shortcode
	 *
	 * @param int $post_id
	 * @param object $post
	 * @return void
	 */
	function list_events($post_id, $post)
	{ 
    }
}
