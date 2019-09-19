<?php
/**
 * WPEO_Events class for handling CRUD 
 * 
 * @package the events organizer
 */


/**
 * handling Events CRUD 
 *
 * @since      1.0.0
 * @package   the events organizer
 * @author     Afnan Abdelhameed <afnanabdulhamed@gmail.com>
 */ 
class WPEO_Events{

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
		global $wpdb, $charset_collate;

		$this->wpdb = $wpdb;
		$this->charset_collate = $wpdb->get_charset_collate();
   
        // save DB tables actions
        add_action('save', array($this, 'save'));
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
            $instance = new WPEO_Events();
        }
        return $instance;
	}
	
	/**
	 * save event (create/edit)
	 *
	 * @return void
	 */
	function save($post_id, $post)
	{
		if(! $_POST){
			return $post_id;
		}

		$event_details = [
			'post_id'            => $post_id, 
			'event_date'         => $_POST['event_date'],
			'event_title'        => $post->post_title,
			'event_author'       => $post->post_author,
			'event_end_time'     => $_POST['evnt_end_time'],
			'event_start_time'   => $_POST['evnt_start_time'],
			'event_cover_image'  => $_POST['_thumbnail_id'],
			'event_description'  => $post->post_content
		];

		$table_name = $this->wpdb->prefix . 'wpeo_events';
		$this->wpdb->insert( $table_name, $event_details );
	}

	
}
