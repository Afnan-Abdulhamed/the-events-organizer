<?php

/**
 * partial template for single event div in the events listing
 *
 * @package    the events organizer
 */
?>

<div class="single-event">
  
    <div class="img-container">
        <img src="<?php echo wp_get_attachment_image_src($event->event_cover_image,0)[0] ?>" alt="">
    </div>

    <div class="text-container">
        <h4 class="event-title">
            <?php echo $event->event_title ?>
        </h4>
    
        <div class="event-time">
            <p><?php echo $event->event_start_time . " - " . $event->event_end_time ?></p>
        </div>
    </div>


</div>