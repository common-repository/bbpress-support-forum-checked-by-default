<h2><?php echo BBPRESS_SUPPORT_CHECKED_NICK ?> &raquo; Settings</h2>

<form method="post" action="options.php" id="<?php echo $plugin_id; ?>_options_form" name="<?php echo $plugin_id; ?>_options_form">
	This plugin extends the <a href="http://wordpress.org/plugins/buddy-bbpress-support-topic/" target="_blank" title="Buddy-bbPress Support Topic">Buddy-bbPress Support Topic</a> plugin to allow the automatic checking of the "This is a support topic" checkbox on forums that you specify.<br>
	The <a href="http://wordpress.org/plugins/buddy-bbpress-support-topic/" target="_blank" title="Buddy-bbPress Support Topic">Buddy-bbPress Support Topic</a> plugin is required for this to function properly.<br>
	<br>
	<b>Please select the forums below that you would like to have the "This is a support topic" checkbox checked for by default.</b><br><br>

	<?php 

	settings_fields($plugin_id.'_options'); 

	$forums = get_pages( array( 'post_type' => bbp_get_forum_post_type(), 'numberposts' => 99, 'post_status' => array('publish', 'private')) );

	foreach($forums as $key => $value) {
		if( get_option( "bb_support_check_".$value->ID ) == 1 ) {$checked = "checked='checked'";} else { $checked = ''; }
		echo "<span style='margin-bottom: 5px;display: inline-block;'><input type='checkbox' name='bb_support_check_".$value->ID."' id='bb_support_check_".$value->ID."' value='1' ".$checked."/> ".$value->post_title."</span><br>";
	}
	
	if( get_option( "bb_support_check_hide_support_hide" ) == 1 ) {$bb_support_check_hide_support_hide = "checked='checked'";} else { $bb_support_check_hide_support_hide = ''; }

	?><br>
	Would you like to disable unchecking of the checkbox on support forums?<br>
		<span style='margin-bottom: 5px;display: inline-block;'>
			<input type='checkbox' name='bb_support_check_hide_support_hide' id='bb_support_check_hide_support_hide' value='1' <?php echo $bb_support_check_hide_support_hide ?> /> 
			Yes, disable unchecking of the checkbox on support forums.
		</span><br><br>
	<br>
	<input id="submit" type="submit" name="submit" value="Save Settings" class="button-primary" />
</form>
<br><br>
This plugin was created by <a href="http://thepluginfactory.co/" target="_blank" title="The Plugin Factory">The Plugin Factory</a>.<br>
For support of this plugin, please visit our support forums at <a href="http://thepluginfactory.co/community/forum/plugin-specific/" title="The Plugin Factory - Plugin Support Forums" target="_blank">http://thepluginfactory.co/community/forum/plugin-specific/</a>
