<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/Adapt-AB/wprule
 * @since      1.0.0
 *
 * @package    Wprule
 * @subpackage Wprule/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name and version, and enqueues
 * the admin-specific stylesheet and JavaScript.
 *
 * @package    Wprule
 * @subpackage Wprule/admin
 *
 */
class Wprule_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action('admin_menu', array( $this, 'addPluginAdminMenu' ), 9);   
		add_action('admin_init', array( $this, 'registerAndBuildFields' )); 

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wprule-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area and acces to the admin ajax url.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wprule-admin.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->plugin_name, 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	}

	// Plugin menu in admin area
	public function addPluginAdminMenu() {
		//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
		add_menu_page(  $this->plugin_name, 'WPRule', 'administrator', $this->plugin_name, array( $this, 'displayPluginAdminDashboard' ), 'dashicons-email-alt', 26 );
		
		//add_submenu_page( '$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		add_submenu_page( $this->plugin_name, 'WPRule Settings', 'Settings', 'administrator', $this->plugin_name.'-settings', array( $this, 'displayPluginAdminSettings' ));
	}
	public function displayPluginAdminDashboard() {
		require_once 'partials/'.$this->plugin_name.'-admin-display.php';
	}

	public function displayPluginAdminSettings() {
		// set this var to be used in the settings-display view
		$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';
		if(isset($_GET['error_message'])){
				add_action('admin_notices', array($this,'settingsPageSettingsMessages'));
				do_action( 'admin_notices', $_GET['error_message'] );
		}
		require_once 'partials/'.$this->plugin_name.'-admin-settings-display.php';
	}

	public function settingsPageSettingsMessages($error_message){
		switch ($error_message) {
			case '1':
				$message = __( 'There was an error adding this setting. Please try again.  If this persists, shoot us an email.', 'wprule-text-domain' );
				$err_code = esc_attr( 'wprule_setting' );
				$setting_field = 'wprule_setting';
				break;
		}
		$type = 'error';
		add_settings_error(
			$setting_field,
			$err_code,
			$message,
			$type
		);
	}

	public function registerAndBuildFields() {
		/**
		 * First, we add_settings_section. This is necessary since all future settings must belong to one.
		 * Second, add_settings_field
		 * Third, register_setting
		 */     
		add_settings_section(

			// ID used to identify this section and with which to register options
			'wprule_general_section',

			// Title to be displayed on the administration page
			'',  

			// Callback used to render the description of the section
			array( $this, 'wprule_display_general_account' ),

			// Page on which to add this section of options
			'wprule_general_settings'
		);


		// API-key settings field
		unset($args);
		$args = array (
			'type'      => 'input',
			'subtype'   => 'text',
			'id'    => 'wprule_setting_apikey',
			'name'      => 'wprule_setting_apikey',
			'required' => 'true',
			'get_options_list' => '',
			'value_type'=>'normal',
			'wp_data' => 'option'
		);

		add_settings_field(
			'wprule_setting_apikey',
			'API-key',
			array( $this, 'wprule_render_settings_field' ),
			'wprule_general_settings',
			'wprule_general_section',
			$args
		);
		register_setting(
			'wprule_general_settings',
			'wprule_setting_apikey'
		);

		// Submit button test settings field
		$args = array (
			'type'      => 'input',
			'subtype'   => 'text',
			'id'    => 'wprule_setting_submit_button_text',
			'name'      => 'wprule_setting_submit_button_text',
			'required' => 'true',
			'get_options_list' => '',
			'value_type'=>'normal',
			'wp_data' => 'option'
		);

		add_settings_field(
			'wprule_setting_submit_button_text',
			'Submit button text',
			array( $this, 'wprule_render_settings_field' ),
			'wprule_general_settings',
			'wprule_general_section',
			$args
		);
		register_setting(
			'wprule_general_settings',
			'wprule_setting_submit_button_text'
		);

		// Select internal tags
		$args = array (
			'type'      => 'input',
			'subtype'   => 'text',
			'id'    => 'wprule_setting_tags',
			'name'      => 'wprule_setting_tags',
			'required' => 'true',
			'get_options_list' => '',
			'value_type'=>'normal',
			'wp_data' => 'option'
		);

		add_settings_field(
			'wprule_setting_tags',
			'Internal tags',
			array( $this, 'wprule_render_settings_field' ),
			'wprule_general_settings',
			'wprule_general_section',
			$args
		);
		register_setting(
			'wprule_general_settings',
			'wprule_setting_tags'
		);

		// Select external tags
		$args = array (
			'type'      => 'input',
			'subtype'   => 'text',
			'id'    => 'wprule_setting_external_tags',
			'name'      => 'wprule_setting_external_tags',
			'required' => 'true',
			'get_options_list' => '',
			'value_type'=>'normal',
			'wp_data' => 'option'
		);

		add_settings_field(
			'wprule_setting_external_tags',
			'User facing tags',
			array( $this, 'wprule_render_settings_field' ),
			'wprule_general_settings',
			'wprule_general_section',
			$args
		);
		register_setting(
			'wprule_general_settings',
			'wprule_setting_external_tags'
		);

	}

	//Check if php-curl ins installed
	public function wprule_display_general_account() {
		if (!WP_Http_Curl::test()) {
			echo '<div id="setting-error-settings_updated" class="notice settings-error is-dismissible notice-error"><p><strong>You do not have <a href="https://www.php.net/manual/en/book.curl.php">php-curl</a> installed on your server.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div><p>cURL is required for WPRule to post and fetch data. Install it on your server or ask your host provider for help</p>';
			wp_die();
		}

	} 

	public function wprule_render_settings_field($args) {

		/* EXAMPLE INPUT
		'type'      => 'input',
		'subtype'   => '',
		'id'    => $this->plugin_name.'_example_setting',
		'name'      => $this->plugin_name.'_example_setting',
		'required' => 'required="required"',
		'get_option_list' => "",
		'value_type' = serialized OR normal,
		'wp_data'=>(option or post_meta),
		'post_id' =>
		*/

		if($args['wp_data'] == 'option'){
			$wp_data_value = get_option($args['name']);
		} elseif($args['wp_data'] == 'post_meta'){
			$wp_data_value = get_post_meta($args['post_id'], $args['name'], true );
		}

		switch ($args['type']) {

			case 'input':
					$value = ($args['value_type'] == 'serialized') ? serialize($wp_data_value) : $wp_data_value;
					if($args['subtype'] != 'checkbox'){
							$prependStart = (isset($args['prepend_value'])) ? '<div class="input-prepend"> <span class="add-on">'.$args['prepend_value'].'</span>' : '';
							$prependEnd = (isset($args['prepend_value'])) ? '</div>' : '';
							$step = (isset($args['step'])) ? 'step="'.$args['step'].'"' : '';
							$min = (isset($args['min'])) ? 'min="'.$args['min'].'"' : '';
							$max = (isset($args['max'])) ? 'max="'.$args['max'].'"' : '';
							if(isset($args['disabled'])){
									// hide the actual input bc if it was just a disabled input the info saved in the database would be wrong - bc it would pass empty values and wipe the actual information
									echo $prependStart.'<input type="'.$args['subtype'].'" id="'.$args['id'].'_disabled" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'_disabled" size="40" disabled value="' . esc_attr($value) . '" /><input type="hidden" id="'.$args['id'].'" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'" size="40" value="' . esc_attr($value) . '" />'.$prependEnd;
							} else {
									echo $prependStart.'<input type="'.$args['subtype'].'" id="'.$args['id'].'" "'.$args['required'].'" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'" size="40" value="' . esc_attr($value) . '" />'.$prependEnd;
							}
							/*<input required="required" '.$disabled.' type="number" step="any" id="'.$this->plugin_name.'_cost2" name="'.$this->plugin_name.'_cost2" value="' . esc_attr( $cost ) . '" size="25" /><input type="hidden" id="'.$this->plugin_name.'_cost" step="any" name="'.$this->plugin_name.'_cost" value="' . esc_attr( $cost ) . '" />*/

					} else {
							$checked = ($value) ? 'checked' : '';
							echo '<input type="'.$args['subtype'].'" id="'.$args['id'].'" "'.$args['required'].'" name="'.$args['name'].'" size="40" value="1" '.$checked.' />';
					}
					break;
			default:

					break;
		}
	}
}
