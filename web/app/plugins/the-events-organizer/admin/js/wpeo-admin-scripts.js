(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$(function() {
		$( ".calendar" ).datepicker({
			dateFormat: 'dd/mm/yy',
			firstDay: 1
		});
		
		$(document).on('click', '.date-picker .input', function(e){
			var $me = $(this),
					$parent = $me.parents('.date-picker');
			$parent.toggleClass('open');
		});
		
		
		$(".calendar").on("change",function(){
			var $me = $(this),
					$selected = $me.val(),
					$parent = $me.parents('.date-picker');
			$parent.find('.result').children('span').html($selected);
			$("#event_date").val($selected);
		});
	});

})( jQuery );
