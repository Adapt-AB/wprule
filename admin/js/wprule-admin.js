(function( $ ) {
	'use strict';

	jQuery(document).ready(function($) {

		//Validate API-key
		if ($('#wprule_setting_apikey').val()) {
			var data = {
				'action': 'wprule_request',
				'type': 'validate'
			};
	    	$.post(ajax_object.ajax_url, data, function(api_key) {
				api_key = jQuery.parseJSON(api_key);

				if (!api_key.valid) {
					$('.wrap h2').after('<div id="setting-error-settings_updated" class="notice settings-error is-dismissible notice-error"><p><strong>Your api key is not valid</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>');
					$('#wprule_setting_apikey').css('background', '#f8d7da');
				}
			});
		}

		// UI for selecting tags
		$('#wprule_setting_tags').after('<div class="tags-info">Tags are created in <a href="https://app.rule.io/v5/#/app/subscribers/tags/list">rule.io</a></div><div id="wprule_list_tags"></div>')
		$('#wprule_setting_external_tags').after('<div class="tags-info">Tags selectable by user (optional)</div><div id="wprule_list_external_tags"></div>')

		// Internal tags
		var current_tags = $('#wprule_setting_tags');
		$('#wprule_list_tags').on('click', 'span', function(event) {

    		if(current_tags.val().indexOf($(this).text()) != -1){
    			current_tags.val(current_tags.val().replace($(this).text() + ",", ""));
			}else{
				current_tags.val(current_tags.val() + $(this).text() + ",");
			}
    		$(this).toggleClass('tag-selected');
    	});

    	// External tags
		var current_external_tags = $('#wprule_setting_external_tags');
		$('#wprule_list_external_tags').on('click', 'span', function(event) {

    		if(current_external_tags.val().indexOf($(this).text()) != -1){
    			current_external_tags.val(current_external_tags.val().replace($(this).text() + ",", ""));
			}else{
				current_external_tags.val(current_external_tags.val() + $(this).text() + ",");
			}
    		$(this).toggleClass('tag-selected');
    	});

		// Get the tags
		var data = {
			'action': 'wprule_request',
			'type': 'tags'
		};
    	$.post(ajax_object.ajax_url, data, function(response) {
			response = jQuery.parseJSON(response);
			var tags = "";
			$.each(response.tags, function(index, val) {
				tags = tags + "<span>" + val.name + "</span>";
			});

			$('#wprule_list_tags, #wprule_list_external_tags').html(tags);

			$('#wprule_list_tags span').each(function(index, el) {
				if($('#wprule_setting_tags').val().indexOf($(this).text()) != -1){
	    			$(this).addClass('tag-selected');
				}
			});

			$('#wprule_list_external_tags span').each(function(index, el) {
				if($('#wprule_setting_external_tags').val().indexOf($(this).text()) != -1){
	    			$(this).addClass('tag-selected');
				}
			});

		});

    	$('#wprule_setting_apikey').on('focus', function(event) {
    		$(this).css('background', '#fff');
    	});


	});

})( jQuery );
