<?php
/*
Plugin Name: bbPress Support Forum Checked by Default
Plugin URI: http://thepluginfactory.co
Description: Checks the checkbox for support forums by default on specified forums.
Version: 1.0
Author: The Plugin Factory
Author URI: http://thepluginfactory.co
*/

if(!class_exists('bbpress_support_checked_options')) {
	define('BBPRESS_SUPPORT_CHECKED_OPTIONS_ID', 'bbpress_support_checked_nick');
	define('BBPRESS_SUPPORT_CHECKED_NICK', 'bbPress Support Forum Checked by Default');
    class bbpress_support_checked_options{

		public static function file_path($file){
			return ABSPATH.'wp-content/plugins/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).$file;
		}

		public static function register(){
			$forums = get_pages( array( 'post_type' => bbp_get_forum_post_type(), 'numberposts' => 99, 'post_status' => array('publish', 'private')) );
			foreach($forums as $key => $value) {
				register_setting(BBPRESS_SUPPORT_CHECKED_OPTIONS_ID.'_options', "bb_support_check_".$value->ID);
			}

			register_setting(BBPRESS_SUPPORT_CHECKED_OPTIONS_ID.'_options', "bb_support_check_hide_support_hide");

		}

		public static function menu(){
			// Create menu tab
			add_options_page(BBPRESS_SUPPORT_CHECKED_NICK.' Plugin Options', BBPRESS_SUPPORT_CHECKED_NICK, 'manage_options', BBPRESS_SUPPORT_CHECKED_OPTIONS_ID.'_options', array('bbpress_support_checked_options', 'options_page'));
		}

		public static function options_page(){
			if (!current_user_can('manage_options'))
			{
				wp_die( __('You do not have sufficient permissions to access this page.') );
			}

			$plugin_id = BBPRESS_SUPPORT_CHECKED_OPTIONS_ID;
			// display options page
			include(self::file_path('options.php'));
		}

		public static function content_with_quote($content)
		{
			$quote = '<p><blockquote>' . get_option('kkpo_quote') . '</blockquote></p>';
			return $content . $quote;
		}

		public static function checked() {
			if ( function_exists('is_bbpress') && is_bbpress() ) {
				$forum = bbp_get_forum_id();
				$thisforum = get_option( "bb_support_check_".$forum );
				$hide_support = '';
				
				if( get_option( "bb_support_check_hide_support_hide" ) == 1 ) {
					$hide_support = "document.getElementById('bp_bbp_st_is_support').style.display = 'none';";
				}


				if ( $thisforum == 1 ) {

					echo '
					<script type="text/javascript">
						function init() {
							document.getElementById("bp_bbp_st_is_support").checked = true;
							'.$hide_support.'
						}
						window.onload = init;
					</script>';
				}
			}
		}

    }
}


if ( !is_admin() ) {

	add_action('bbp_theme_after_topic_form_subscriptions', array('bbpress_support_checked_options', 'checked'), 99);
	add_action('bbp_theme_after_reply_form_subscription',  array('bbpress_support_checked_options', 'checked'), 99);

} elseif( is_admin() ) {
	
	add_action('admin_init', array('bbpress_support_checked_options', 'register'), 99);
	add_action('admin_menu', array('bbpress_support_checked_options', 'menu'), 99);

}




?>