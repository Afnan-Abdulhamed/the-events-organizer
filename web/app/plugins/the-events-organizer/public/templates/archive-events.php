
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
$events_per_page =  5;
$page            =  isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
$offset          =  ( $page * $events_per_page ) - $events_per_page;
$latest_events   =  $wpdb->get_results( "SELECT * FROM (${query}) AS lates LIMIT ${offset}, ${events_per_page}" );
 ?>
 <div class="container">
<section class="event_list">

    <div class="row">
        <div class="col-md-6">
            <h2 class="title">Upcoming Events</h2>
            <hr class="title-line">
        </div>

        <div class="col-md-6">
            <?php if( get_option('wpeo_enable_past_events') ){ ?>
                <span> <a class="past-link" href="<?php echo get_home_url() ?>/?post_type=events&past=1">Past Events</a> </span>
            <?php } ?>
        </div>
    </div>
    
    
    
    <!-- if the showing past event option  enabled add past event button -->
     
    <?php if( ! $latest_events){ ?>
        <h5 class="date-title"> No Events </h5>
    <?php }else{ ?> 
        

    <!-- Events List  -->
    <div class="upcomming-events-sec row">
        <?php $first_date = $latest_events[0]->event_date ;?>
        
        <div class=" col-md-9">
            <h5 class="date-title"> <?php echo date( "M d, Y", strtotime($first_date)) ?></h5>
        </div>
        
        <?php foreach ($latest_events as $event) { 
            // $date = $event->event->date;
            if( $event->event_date != $first_date ){?>
            <div class=" col-md-9">
                <h5 class="date-title"> <?php echo date( "d M, Y", strtotime($event->event_date)) ?></h5>
            </div>    
            <?php }
            // include partial template 
            include plugin_dir_path( dirname( __FILE__ ) ) . 'partials\event-list-item.php';
            }
        }
        ?>
    </div>


</section>


<!-- pagination section -->
<div class="pagenation">

<?php
echo paginate_links( array(
    'base' => add_query_arg( 'cpage', '%#%' ),
    'format' => '',
    'prev_text' => __('&laquo;'),
    'next_text' => __('&raquo;'),
    'total' => ceil($total_events / $events_per_page),
    'current' => $page
));
?>
</div>
</div>

<?php get_footer(); ?>
 