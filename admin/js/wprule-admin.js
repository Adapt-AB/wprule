(function( $ ) {
	'use strict';

	jQuery(document).ready(function($) {

		// UI for selecting tags
		$('#wprule_setting_tags').after('<div id="wprule_list_tags"></div>')

		var current_tags = $('#wprule_setting_tags');

		$('#wprule_list_tags').on('click', 'span', function(event) {

    		if(current_tags.val().indexOf($(this).text()) != -1){
    			current_tags.val(current_tags.val().replace($(this).text() + ",", ""));
			}else{
				current_tags.val(current_tags.val() + $(this).text() + ",");
			}
    		$(this).toggleClass('tag-selected');
    	});

		// Get the tags
		var data = {
			'action': 'wprule_get_tags',
		};
    	$.post(ajax_object.ajax_url, data, function(response) {
			response = jQuery.parseJSON(response);
			var tags = "";
			$.each(response.tags, function(index, val) {
				tags = tags + "<span>" + val.name + "</span>";
			});
			$('#wprule_list_tags').html(tags);

			$('#wprule_list_tags span').each(function(index, el) {
				if($('#wprule_setting_tags').val().indexOf($(this).text()) != -1){
	    			$(this).addClass('tag-selected');
				}
			});
		});
	});

})( jQuery );
