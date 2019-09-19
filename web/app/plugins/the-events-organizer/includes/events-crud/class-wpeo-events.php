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
     * Inistantiate the WPEO_Schema class
     *
     * @return object
     */
	public function __construct()
    {
        // save DB tables actions
		add_action('save', array($this, 'save'));
		// delete DB table action
		add_action('delete', array($this, 'delete'));
		// status transitions
		add_action('on_all_status_transitions', array($this, 'on_all_status_transitions'));
		// get single event data
		add_action('sing_event', array($this, 'sing_event'));
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
	 * @param int $post_id
	 * @param object $post
	 * @return void
	 */
	function save($post_id, $post)
	{ 
		global $wpdb;
		// check request and post type
		if(! $_POST || $post->post_type != 'events'){
			return $post_id;
		}
		// check existance 
		$record_exists = $wpdb->get_var( 
			"SELECT COUNT(*) 
			 FROM $wpdb->prefix".'wpeo_events'." WHERE post_id = $post_id");
		// data to be saved
		$event_details = [
			'post_id'            => $post_id, 
			'event_date'         => $_POST['event_date'],
			'event_title'        => $post->post_title,
			'event_status'		 => ($post->post_status == 'publish') ? 1 : 0,
			'event_author'       => $post->post_author,
			'event_end_time'     => $_POST['evnt_end_time'],
			'event_start_time'   => $_POST['evnt_start_time'],
			'event_cover_image'  => $_POST['_thumbnail_id'],
			'event_description'  => $post->post_content
		];

		$table_name = $wpdb->prefix . 'wpeo_events';
		// update the record if exists or create new one
		( $record_exists ) ? 
		$wpdb->update( $table_name, $event_details, ['post_id' => $post_id] ) :
		$wpdb->insert( $table_name, $event_details );
	}


	/**
	 * delete event permanently
	 *
	 * @param int $post_id
	 * @return void
	 */
	function delete($post_id)
	{ 
		global $wpdb;

		$table_name = $wpdb->prefix . 'wpeo_events';

		if ( $wpdb->get_var( 
				$wpdb->prepare( 
					"SELECT post_id 
					FROM $table_name 
					WHERE post_id = %d", $post_id 
				) 
			)) 
		{
			$wpdb->query( $wpdb->prepare( "DELETE FROM $table_name WHERE post_id = %d", $post_id ));
		}
	}


	/**
	 * handle event status transitions
	 * update event status when post status changes 
	 * ex from publish to trash , trash to draft ...
	 *
	 * @param string $new_status
	 * @param string $old_status
	 * @param int $post
	 * @return void
	 */
	function on_all_status_transitions( $new_status, $old_status, $post )
	{ 
		// if the post not event dont do anything
		if( $post->post_type != 'events' ){
			return $post->ID;
		}

		global $wpdb;
		$table_name = $wpdb->prefix . 'wpeo_events';

		// update if the status changed 
		if ( $new_status != $old_status) {
				$status = ( $new_status == 'publish') ? 1 : 0 ;
				$wpdb->update( $table_name, ['event_status' => $status], ['post_id' => $post->ID] );
			}
	}


	/**
	 * get data for single event
	 *
	 * @param int $post_id
	 * @return void
	 */
	function single_event( $post_id )
	{ 
		global $wpdb;
		$table_name = $wpdb->prefix . 'wpeo_events';

		$post_data = $wpdb->get_row( "SELECT * FROM $table_name WHERE post_id = $post_id" );
		
		if($post_data){
			return $post_data;
		}

	}


}
