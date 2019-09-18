<?php
/**
 * settings page for the plugin
 *
 * @package the events organizer
 */
?>
<h1>The Events Organizer Settings</h1>
    
<form method="post" action="">

	<?php settings_fields('wpeo-settings-group'); ?>
	<?php do_settings_sections('wpeo-settings-group'); ?>
	
    <table class="form-table">
		<tr valign="top">
            <th scope="row">Show Past Events</th>
            <td><input type="checkbox" name="wpeo_enable_past_events" <?php echo (get_option('wpeo_enable_past_events'))? "checked": "" ?>></td>
		</tr>
			 
		<tr valign="top">
			<th scope="row">Number of Listing Events</th>
			<td><input type="number" name="wpeo_events_listing_no" value="<?php echo esc_attr(get_option('wpeo_events_listing_no')); ?>" /></td>
		</tr>
	</table>
		
	<?php submit_button(); ?>
	
</form>