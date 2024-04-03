<?php

/**
 * The admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/Adapt-AB/wprule
 * @since      1.0.0
 *
 * @package    Wprule
 * @subpackage Wprule/admin/partials
 */
?>

<div class="wrap">

	<h2>WPRule</h2>

	<div class="card" >
		<h2 class="title">Integrates WordPress with rule.io.</h2>
		<p>This plugin requires a <a href="https://rule.io">rule.io</a> subscription. </p>
		<p>You can generate an API-key under <a href="https://app.rule.io/v5/#/app/settings/developer">developer settings</a> in your rule.io account.</p>
		<img class="api_screenshot" src="<?php echo plugin_dir_url( __FILE__ ) . "../img/rule_api_key.png" ?>" alt="">
		<p>Enter you domain and generate an API-key. Then go to <a href="./admin.php?page=wprule-settings">settings</a> and paste the key.</p>
	</div>

</div>
