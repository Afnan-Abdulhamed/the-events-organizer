
<?php
/**
 * archive page template for events.
 * You can override the single event page and the events archive in any theme
 * by creating single-events.php and archive-events.php
 */
 get_header();

 global $post;

$events = new WPEO_Events();
$query  = $events->upcoming_events();

// pagination handling section
$total_events    =  $wpdb->get_var( "SELECT COUNT(1) FROM (${query}) AS combined_table" );
$events_per_page =  1;
$page            =  isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
$offset          =  ( $page * $events_per_page ) - $events_per_page;
$latest_events   =  $wpdb->get_results( "SELECT * FROM (${query}) AS events LIMIT ${offset}, ${events_per_page}" );
 ?>
<section class="event_list">

    <h2 class="title">Upcoming Events</h2>
        
    <!-- if the showing past event option  enabled add past event button -->
    <?php if( get_option('wpeo_enable_past_events') ){ ?>
        <!-- past events -->
        <div>
            <a href="<?php echo get_home_url() ?>/?post_type=events&past=1">Past Events</a>
        </div>
        
    <?php } ?>

    <!-- Events List  -->
    <div class="upcomming-events-sec">

        <?php foreach ($latest_events as $event) { 
            // include partial template 
            include plugin_dir_path( dirname( __FILE__ ) ) . 'partials\event-list-item.php';
            }
        ?>
    </div>


</section>


<!-- pagination section -->
<?php
echo paginate_links( array(
    'base' => add_query_arg( 'cpage', '%#%' ),
    'format' => '',
    'prev_text' => __('&laquo;'),
    'next_text' => __('&raquo;'),
    'total' => ceil($total_events / $events_per_page),
    'current' => $page
));


get_footer();
 