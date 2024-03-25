(function( $ ) {
	'use strict';

	jQuery(document).ready(function($) {
		//console.log(ajax_object);
		$('#wprule a').click(function(event) {
			event.preventDefault();

			var email = $(this).siblings('input').val();
			console.log(email);
			var message = $(this).siblings('div')
			message.removeClass('good bad')

			if (isEmail(email)) {
				var data = {
					'action': 'wprule_add_subscriber',
					'email' : email
				};

		    	$.post(ajax_object.ajax_url, data, function(response) {
					//console.log(jQuery.parseJSON(response));
					message.addClass('good').fadeIn('50').html(response);
				});
			}else{
				//console.log("Not an email");
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
