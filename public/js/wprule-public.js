(function( $ ) {
	'use strict';

	jQuery(document).ready(function($) {

		// Subscribe button is clicked
		$('#wprule a').click(function(event) {
			event.preventDefault();

			var email = $(this).siblings('input').val();

			var message = $(this).siblings('div')
			message.removeClass('good bad')

			if (isEmail(email)) {
				var data = {
					'action': 'wprule_add_subscriber',
					'email' : email
				};

		    	$.post(ajax_object.ajax_url, data, function(response) {
					response = jQuery.parseJSON(response);
					if (response.message == "Success") {
						message.addClass('good').fadeIn('50').html("Thanks you for signing up");
					}else{
						message.addClass('bad').fadeIn('50').html("Something went wrong");
					}
				});
			}else{
				message.addClass('bad').fadeIn('50').html("Not an email");
			}
		});

		$('.wprule_response').click(function(event) {
			$(this).fadeOut('50');
		});

		function isEmail(email) {
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(email);
		}

	});

})( jQuery );
