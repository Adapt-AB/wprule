<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       plugin_name.com/team
 * @since      1.0.0
 *
 * @package    PluginName
 * @subpackage PluginName/admin/partials
 */
?>

<div class="wrap">
    <div id="icon-themes" class="icon32"></div>
    <h2>WPRule Settings</h2>

	<?php settings_errors(); ?>

    <form method="POST" action="options.php">
        <?php
            settings_fields( 'wprule_general_settings' );
            do_settings_sections( 'wprule_general_settings' );
        ?>
        <?php submit_button(); ?>
    </form>
</div>