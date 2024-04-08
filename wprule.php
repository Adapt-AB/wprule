<?php

/**
 *
 * @link              https://github.com/Adapt-AB/wprule
 * @since             1.0.0
 * @package           Wprule
 *
 * @wordpress-plugin
 * Plugin Name:       WPRule
 * Plugin URI:        https://github.com/Adapt-AB/wprule
 * Description:       Integrates WordPress with rule.io
 * Version:           1.1.3
 * Author:            Adam Rehal @ Adapt AB
 * Author URI:        https://www.adapt.se
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wprule
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Update it as you release new versions.
 */
define( 'SETTINGS_PAGE_VERSION', '1.1.3' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wprule-activator.php
 */
function activate_wprule() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wprule-activator.php';
	Wprule_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wprule-deactivator.php
 */
function deactivate_wprule() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wprule-deactivator.php';
	Wprule_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wprule' );
register_deactivation_hook( __FILE__, 'deactivate_wprule' );

/**
 * The code for the shortcode
 * This action is documented in includes/class-wprule-shortcode.php
 */
function wprule_shortcode() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wprule-shortcode.php';
	Wprule_Shortcode::wprule_shortcode_init();
}
add_action( 'init', 'wprule_shortcode' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wprule.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 *
 */

/**
 * cURL request
 *
 * This functions handles all API-requests
 *
 */
add_action( 'wp_ajax_wprule_request', 'wprule_request' );
function wprule_request() {

	// Set basic options
	$apikey = get_option( "wprule_setting_apikey", false );
	$curl = curl_init();
	$curl_options = array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $apikey
		),
	);

	switch ($_POST["type"]) {

		// Subscribe user
		case 'subscribe':
			$email = $_POST["email"];
			$external_tags = $_POST["tags"];
			$apikey = get_option( "wprule_setting_apikey", false );
			$optin = (get_option( "wprule_setting_require_optin", false )) ? "true" : "false";

			// Tags
			$tags = "";
			$internal_tags = array_filter(explode(",", get_option( "wprule_setting_tags", false )));
			if ($external_tags) {
				$all_tags = array_merge($internal_tags, $external_tags);
			}else{
				$all_tags = $internal_tags;
			}
			foreach ($all_tags as $tag) {
				$tags .= '"' . $tag . '",';
			}
			$tags = rtrim($tags, ',');

			$curl_options[CURLOPT_URL] = 'https://app.rule.io/api/v2/subscribers';
			$curl_options[CURLOPT_CUSTOMREQUEST] = 'POST';
			$curl_options[CURLOPT_POSTFIELDS] = '"update_on_duplicate": true,
				"require_opt_in": "' . $require_optin . '",
				"tags": [
				    ' . $tags . '
				],
				"subscribers": {
				    "email": "' . $email . '",
				    "fields": []
			    }
			}';
			curl_setopt_array($curl, $curl_options);
			$response = curl_exec($curl);
			break;

		// Get all tags
		case 'tags':
			// code...
			$curl_options[CURLOPT_URL] = 'https://app.rule.io/api/v2/tags?limit=100';
			$curl_options[CURLOPT_CUSTOMREQUEST] = 'GET';
			curl_setopt_array($curl, $curl_options);
			$response = curl_exec($curl);
			break;

		// Validate API-key
		case 'validate':
			// code...
			$curl_options[CURLOPT_URL] = 'https://app.rule.io/api/v2/';
			$curl_options[CURLOPT_CUSTOMREQUEST] = 'GET';
			curl_setopt_array($curl, $curl_options);
			$response = curl_exec($curl);
			if (!$response) {
				$response = array("valid" => true);

			}else{
				$response = array("valid" => false);
			}
			$response = json_encode($response);
			break;
	}

	curl_close($curl);
	echo $response;

    // Die allready you f*cker!
    wp_die();
}

function run_wprule() {

	$plugin = new Wprule();
	$plugin->run();

}
run_wprule();
