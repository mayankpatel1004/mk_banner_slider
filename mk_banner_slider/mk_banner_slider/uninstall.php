<?php
if(!defined('WP_UNINSTALL_PLUGIN'))
{
	exit();
}
else
{
	global $wpdb;
	$wpdb->get_results("DROP TABLE mk_banner_slider");
	
	$strOptionTable = "";
	if(sizeof($wpdb->get_results("SHOW TABLES")) > 0)
	{
		foreach($wpdb->get_results("SHOW TABLES") as $key => $value)
		{
			$subject = $value->Tables_in_customwordpress;
			$pattern = '/options/';
			if(preg_match($pattern, $subject, $matches))
			{
				$strOptionTable = $value->Tables_in_customwordpress;
			}
		}
	}
	if($strOptionTable != "")
	{
		$wpdb->get_results("DELETE FROM $strOptionTable WHERE option_name = 'mk_banner_thumb_width'");
		$wpdb->get_results("DELETE FROM $strOptionTable WHERE option_name = 'mk_banner_thumb_height'");
		$wpdb->get_results("DELETE FROM $strOptionTable WHERE option_name = 'mk_banner_medium_width'");
		$wpdb->get_results("DELETE FROM $strOptionTable WHERE option_name = 'mk_banner_medium_height'");
		$wpdb->get_results("DELETE FROM $strOptionTable WHERE option_name = 'mk_banner_large_width'");
		$wpdb->get_results("DELETE FROM $strOptionTable WHERE option_name = 'mk_banner_large_height'");
		$wpdb->get_results("DELETE FROM $strOptionTable WHERE option_name = 'mk_banner_default_bg_color'");
		$wpdb->get_results("DELETE FROM $strOptionTable WHERE option_name = 'slider_effect'");
		$wpdb->get_results("DELETE FROM $strOptionTable WHERE option_name = 'slider_timeout'");
	}
	
}




?>