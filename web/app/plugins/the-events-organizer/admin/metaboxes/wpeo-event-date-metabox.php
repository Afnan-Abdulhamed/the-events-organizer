<?php
/**
 * Register metabox for event date and time
 *
 * @package the events organizer
 */
?>
<?php global $post; ?>
<div class="date-picker">
    <div class="input">
        <div class="result">Event Date: 
            <input name="event_date" type="text" value="" id="event_date"></div>
        <div><i class="fa fa-calendar"></i></div>
    </div>
    
    <div class="calendar"></div>
</div>

<label class="meta-label">Start Time: </label>
<input type="time" name="evnt_start_time"  value="" class="widefat meta-input">
<div class="">
<label class="meta-label">End Time: </label>
<input type="time" name="evnt_end_time"  value="" class="widefat meta-input">

<?php ?>
