<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/Adapt-AB/wprule
 * @since      1.0.0
 *
 * @package    Wprule
 * @subpackage Wprule/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wprule
 * @subpackage Wprule/includes
 *
 */
class Wprule_Shortcode {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function wprule_shortcode_init() {

		function wprule_shortcode_output( $atts ) {

			ob_start();

			$apikey = get_option( "wprule_setting_apikey", false );
			$button = get_option( "wprule_setting_submit_button_text", false );


			if (!$button || !$apikey) {

				echo "<div>Make sure to set your API-key and button text in the plugin settings first.</div>";

			}else{


				?>

				<div id="wprule">
					<div class="wprule_response"></div>
					<input type="email" value="" placeholder="Your Email" name="wprule_email"><a href="#"><?php echo $button ?></a>
					<div class="wprule_tags">
						<?php foreach (array_filter(explode(",", get_option( "wprule_setting_external_tags", false ))) as $tag) {
							echo "<span>" . $tag . "</span> ";
						} ?>
					</div>
				</div>

				<?php
			}
			return ob_get_clean();
		}

		add_shortcode( 'wprule', 'wprule_shortcode_output' );
	}

}
