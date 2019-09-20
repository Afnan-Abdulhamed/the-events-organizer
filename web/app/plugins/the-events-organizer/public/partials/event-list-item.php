<?php

/**
 * partial template for single event div in the events listing
 *
 * @package    the events organizer
 */
?>

<div class="single-event col-md-9">
<a href="<?php echo get_permalink() ?>">
    <div class="row">
    <div class="col-md-3 br">
        <div class="img-container">
            <img src="<?php echo wp_get_attachment_image_src($event->event_cover_image,0)[0] ?>" alt="">
        </div>
    </div>

    
    <div class="col-md-9 ">
        
        <div class="text-container">
            <h4 class="event-title">
                <?php echo $event->event_title ?>
            </h4>
            
            <div class="event-time">
                <p><?php echo date( "H:i A", strtotime($event->event_start_time)) . " - " . date( "H:i A", strtotime( $event->event_end_time)) ?></p>
            </div>

            <p class="single-item-desc">
              <?php echo substr($event->event_description, 0, 150) .'...'  ?>
            </p>
    </div>
      </div>
    </div>
    </a>
</div>