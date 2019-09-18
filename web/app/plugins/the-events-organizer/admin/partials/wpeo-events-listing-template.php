<?php
/**
 * Listing table for events
 * 
 * @package the-events-organizer
 */


require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

/**
 * class to build listing table for events
 * this class extends wp core class wp-list-table
 *
 * @since     1.0.0
 * @package   The Events Organizer Plugin
 * @see       wp-admin/includes/class-wp-list-table.php
 * @author    Afnan Abdelhameed <afnanabdulhameed@gmail.com>
 */
class WPEO_Events_Listing_Table extends WP_List_Table  {
    
    /**
     * function to handle other data-manipulation required
     *
     * @since  1.0.0
     * @return void
     */
    function prepare_items()
    {
        $columns = $this->get_columns();
        $sortable = $this->get_sortable_columns();
        $events = $this->get_events_data();
        
        usort( $events, array( &$this, 'sort_events_list' ) );
        
        $per_page = 2;
        $current_page = $this->get_pagenum();
        $total_events_count = count($events);
        
        $this->set_pagination_args( array(
            'total_items' => $total_events_count,
            'per_page'    => $per_page
        ) );
        
        $events = array_slice($events,(($current_page-1)*$per_page),$per_page);
        $this->_column_headers = array($columns,  $sortable);
        $this->items = $events;
    }


    /**
     * return an associative array of events columns
     *
     * @since 1.0.0
     * @return array
     */
    function get_columns()
    {
        $columns = array(
            'checkbox'      => '<input type="checkbox" />',
            'event_title'   => 'Title',
            'event_author'  => 'Author',
            'event_date'    => 'Date',
        );
        return $columns;
    }
   
    /**
     * the columns need to be sortable 
     * 
     * @since 1.0.0
     * @return array
     */
    function get_sortable_columns()
    {
        return array('event_title' => array('event_title', false));
    }


    /**
     * get the events data
     * 
     * @since 1.0.0
     * @return array
     */
    private function get_events_data()
    {
        $events_list = array();
        $events_list[] = array(
                    'id'          => 1,
                    'event_title'       => 'The Shawshank Redemption',
                    'event_author' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
                    'event_date'        => '1994',
                    );
        $events_list[] = array(
                    'id'          => 2,
                    'event_title'       => 'The Godfather',
                    'event_author' => 'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.',
                    'event_date'        => '1972',
                    );
        $events_list[] = array(
                    'id'          => 3,
                    'event_title'       => 'The Godfather: Part II',
                    'event_author' => 'The early life and career of Vito Corleone in 1920s New York is portrayed while his son, Michael, expands and tightens his grip on his crime syndicate stretching from Lake Tahoe, Nevada to pre-revolution 1958 Cuba.',
                    'event_date'        => '1974',
                    );
        return $events_list;
    }


    /**
     * render a column when no other specific method exists for that column
     * 
     * @since 1.0.0
     * @param  array $item
     * @param  string $column_name
     * @return mix
     */
    function column_default( $item, $column_name )
    {
        switch( $column_name ) {
            case 'event_title':
            case 'event_author':
            case 'event_date':
                return $item[ $column_name ];
            default:
                return print_r( $item, true ) ;
        }
    }


    /**
     * handles the events order 
     * 
     * @since 1.0.0
     * @param array $first
     * @param array $second 
     * @return mix
     */
    private function sort_events_list( $first, $second )
    {
        // order by the created date (by default)
        $orderby = 'event_date';
        $order   = 'desc';

        // If orderby is set, use this as the sort column
        if(!empty($_GET['orderby']))
        {
            $orderby = $_GET['orderby'];
        }
        // If order is set use this as the order
        if(!empty($_GET['order']))
        {
            $order = $_GET['order'];
        }
        $result = strcmp( $first[$orderby], $second[$orderby] );
        if($order === 'asc')
        {
            return $result;
        }
        return -$result;
    }


    /**
     * add edit and delete buttons to the event title column
     *
     * @since 1.0.0
     * @param array $item
     * @return void
     */
    function column_event_title($item) {
        $actions = array(
                  'edit'      => sprintf('<a href="?page=%s&action=%s&book=%s">Edit</a>',$_REQUEST['page'],'edit',$item['id']),
                  'delete'    => sprintf('<a href="?page=%s&action=%s&book=%s">Delete</a>',$_REQUEST['page'],'delete',$item['id']),
              );
      
        return sprintf('%1$s %2$s', $item['event_title'], $this->row_actions($actions) );
      }


    /**
     * add the bulk actions drop down
     *
     * @since 1.0.0
     * @return void
     */
    function get_bulk_actions() {
        $actions = array(
          'delete'    => 'Delete'
        );
        return $actions;
    }



    /**
     * handle check box 
     *
     * @since 1.0.0
     * @param array $item
     * @return void
     */
    function column_checkbox($item) {
        return sprintf(
            '<input type="checkbox" name="event[]" value="%s" />', $item['id']
        );    
    }
 }