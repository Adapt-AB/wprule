(function( $ ) {
	'use strict';

	jQuery(document).ready(function($) {

		// Subscribe button is clicked
		$('#wprule a').click(function(event) {
			event.preventDefault();

			var email = $(this).siblings('input').val();
			var selected_tags = $('.wprule_tags span.tag-selected');
			var tags = [];
			selected_tags.each(function(index, val) {
				tags.push($(this).text());
			});

			var message = $(this).siblings('.wprule_response')
			message.removeClass('good bad')

			if (isEmail(email)) {
				var data = {
					'action': 'wprule_request',
					'email' : email,
					'tags'	: tags,
					'type'	: 'subscribe'
				};

		    	$.post(ajax_object.ajax_url, data, function(response) {
					response = jQuery.parseJSON(response);
					if (response.message == "Success") {
						message.addClass('good').fadeIn(200).html("Thank you for signing up");
					}else{
						message.addClass('bad').fadeIn(200).html("Something went wrong");
					}
				});
			}else{
				message.addClass('bad').fadeIn(200).html("Not an email");
			}
		});

		$('.wprule_response').click(function(event) {
			$(this).fadeOut('50');
		});

		$('#wprule .wprule_tags').on('click', 'span', function(event) {
    		$(this).toggleClass('tag-selected');
    	});

		function isEmail(email) {
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(email);
		}

	});

})( jQuery );
