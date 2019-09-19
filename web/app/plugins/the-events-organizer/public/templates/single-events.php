<?php
/**
 * The template for displaying all single posts
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
			<h3><?php echo $event_data->event_title ?></h3>
			<div class="img-container">
				<img src="<?php echo wp_get_attachment_image_src($event_data->event_cover_image,0)[0] ?>" alt="">
			</div>

			<div class="info-boxes">
			<?php echo $event_data->event_date ?>
			<?php echo $event_data->event_start_time ?>
			<?php echo $event_data->event_end_time ?>
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
