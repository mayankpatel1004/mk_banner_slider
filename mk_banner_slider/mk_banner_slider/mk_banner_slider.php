<?php
/**
 * Plugin Name: Mk Banner Slider
 * Plugin URI: http://www.mayankpatel104.blogspot.in/
 * Description: Place this code to view anywhere on file <?php if(function_exists('fnDisplayMKBannerSlider')){ fnDisplayMKBannerSlider();} ?
 * Version: The Plugin's Version Number, e.g.: 1.0
 * Author: Mayank Patel
 * Author URI: http://www.mayankpatel104.blogspot.in/
 * License: A "mk-banners" license name e.g. GPL2
 */
define( 'BANNER_HTTP_PATH' , WP_PLUGIN_URL . '/' . str_replace(basename( __FILE__) , "" , plugin_basename(__FILE__) ) );
define( 'BANNER_ABSPATH' , WP_PLUGIN_DIR . '/' . str_replace(basename( __FILE__) , "" , plugin_basename(__FILE__) ) );
add_action('admin_menu', 'fnBannerPlugin');
function fnBannerPlugin() 
{
	add_menu_page('Banner Slider','Banner Slider',7,'mk_banner_slider','fnBannerSlider');
	add_submenu_page('mk_banner_slider','Banner Slider','Banner Slider',7,'mk_banner_slider','fnBannerSlider');
	add_submenu_page('mk_banner_slider','Slider Settings','Slider Settings',7,'mk_banner_slider_settings','fnBannerSliderSettings');
}
function fnBannerSlider()
{
	include_once "mk_banner_slider_listing.php";
} 
function fnBannerSliderSettings()
{
	include_once "mk_banner_slider_settings.php";
} 

add_action('wp_head','custom_slider');
function custom_slider()
{
	/*echo "<script type='text/javascript' src='http://malsup.github.com/jquery.cycle.all.js'></script>";*/
	echo '<meta property="og:site_name" content="'.get_bloginfo('name').'"/>';		
	echo '<meta property="og:url" content="http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'"/>';
	echo '<meta property="og:title" content="'.$post->post_title.'" />';
	
	if (is_home())
	{
		echo '<meta property="og:type" content="Blog"/>';
		return;	
	} 
	
	if (is_single())
	{
		echo '<meta property="og:title" content="'.$post->post_title.'" />';
		if (function_exists('has_post_thumbnail') && has_post_thumbnail($post->ID))
		{
			if ($thumb_id = get_post_meta($post->ID, '_thumbnail_id', true))
			{
				$thumb_meta = wp_get_attachment_image_src($thumb_id);
				echo '<meta property="og:image" content="'.$thumb_meta[0].'"/>';			
			}
		}	
	}
}

function fnDisplayMKBannerSlider()
{
	global $wpdb;
	
	$strHtml = "";
	
	$strBannerJS = BANNER_HTTP_PATH."js";
	$strBannerCSS = BANNER_HTTP_PATH."css";
	$strBannerImages = BANNER_HTTP_PATH."images";
	$strJqueryJs = $strBannerJS.'/jquery.js';
	$strJqueryCycle = $strBannerJS.'/cycle.js';
	$strCyclecss = $strBannerCSS.'/cycle.css';
	$strHtml .= "<script src='".$strJqueryJs."'></script>";
	$strHtml .= "<script src='".$strJqueryCycle."'></script>";
	$strHtml .= "<link rel='stylesheet' href='".$strCyclecss."' type='text/css' />";
	$sqlQueryTotalRecords = "SELECT * FROM mk_banner_slider WHERE status = 'Active' ORDER BY banner_id DESC";
	$arrTotalRecords = $wpdb->get_results($sqlQueryTotalRecords);
	$strEffect = get_option("slider_effect");
	$strTimeout = get_option("slider_timeout");
	
	$strHtml .= '<style>
	#banner-slider li{float:left;margin-right:10px;list-style:none;}
#banner-slider li a{background-image:url("'.$strBannerImages.'/banner-slider.png");height:19px;width:19px;display:block;border:1px solid;}
#banner-slider li.activeSlide a, #banner-slider li a:hover{background-image:url("'.$strBannerImages.'/banner-slider-hover.png");}
.banner-image img{border:1px solid #CCC;}
.banner-slider{width:40%;margin:auto;clear:both;float:right;}
.clear{clear:both;}
.wrapper-banner{margin:auto !important;}
	</style>';
	$strHtml .= '<script type="text/javascript">			
					jQuery(document).ready(function()
					{
						jQuery(".banner-image").cycle({
							fx: "'.$strEffect.'",
							timeout:3000,
							pager:  "#banner-slider",
							pagerAnchorBuilder: function(idx, slide)
							{ 
								return "<li><a></a></li>"; 
							} 																		
						});
					});
				</script>';
	
	if(count($arrTotalRecords) > 0)
	{
		$strHtml .= "<div class='wrapper-banner banner-image'>";
		foreach($arrTotalRecords as $key => $value)
		{	
			$strHtml .= '<a><img src='.BANNER_HTTP_PATH.'uploads/large/'.$value->banner_file.' /></a>';
		}
		$strHtml .= "</div>";
		$strHtml .= "<div class='clear'></div>";
		$strHtml .= '<ul id="banner-slider" class="banner-slider"></ul>';
    
	}
	echo $strHtml;
}
//add_action('wp_head','fnDisplayMKBannerSlider');
//if(function_exists('fnDisplayMKBannerSlider')){ fnDisplayMKBannerSlider();} ?>