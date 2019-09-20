<?php
/**
 * The template for displaying all single events
 *
 * @package events-theme
 */

get_header();
?>

<?php 
	// get post data
	global $post;
	$event = new WPEO_Events();
	$event_tags = get_the_tags($post->ID); 
	$event_data = $event->single_event($post->ID);
	$event_category = get_the_category($post->ID);
?>
	<div class="container">
		<div class="col-md-9">
			<h3 class="single-title"><?php echo $event_data->event_title ?></h3>
			<div class="single-img-container">
				<img src="<?php echo wp_get_attachment_image_src($event_data->event_cover_image,0)[0] ?>" alt="">
			</div>

			<div >
				<ul class="info-boxes">
					<li> <?php echo date( "M d, Y", strtotime($event_data->event_date))  ?> </li>
					<li>From: <?php echo date( "H:i A", strtotime($event_data->event_start_time)) ?> </li>
					<li>To: <?php echo date( "H:i A", strtotime($event_data->event_end_time)) ?> </li>

				</ul>
			
			</div>

			<div class="desc-text">
			<?php echo $event_data->event_description ?>
			</div>
		</div>
		<col-md-3>
	</col-md-3>
	</div>

<?php
get_footer();
