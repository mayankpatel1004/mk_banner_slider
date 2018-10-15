<?php require_once("global/global.php");
if(isset($_POST["submit_settings"]))
{
	$wpdb->get_results("UPDATE $strOptionTable SET option_value = '".$_POST["mk_banner_thumb_width"]."' WHERE option_name = 'mk_banner_thumb_width'");
	$wpdb->get_results("UPDATE $strOptionTable SET option_value = '".$_POST["mk_banner_thumb_height"]."' WHERE option_name = 'mk_banner_thumb_height'");
	$wpdb->get_results("UPDATE $strOptionTable SET option_value = '".$_POST["mk_banner_medium_width"]."' WHERE option_name = 'mk_banner_medium_width'");
	$wpdb->get_results("UPDATE $strOptionTable SET option_value = '".$_POST["mk_banner_medium_height"]."' WHERE option_name = 'mk_banner_medium_height'");
	$wpdb->get_results("UPDATE $strOptionTable SET option_value = '".$_POST["mk_banner_large_width"]."' WHERE option_name = 'mk_banner_large_width'");
	$wpdb->get_results("UPDATE $strOptionTable SET option_value = '".$_POST["mk_banner_large_height"]."' WHERE option_name = 'mk_banner_large_height'");
	$wpdb->get_results("UPDATE $strOptionTable SET option_value = '".$_POST["mk_banner_default_bg_color"]."' WHERE option_name = 'mk_banner_default_bg_color'");
	$wpdb->get_results("UPDATE $strOptionTable SET option_value = '".$_POST["slider_timeout"]."' WHERE option_name = 'slider_timeout'");
	$wpdb->get_results("UPDATE $strOptionTable SET option_value = '".$_POST["slider_effect"]."' WHERE option_name = 'slider_effect'");
	header("Location:admin.php?page=$strSettingsRedirectPagename&msg=3");
}

$url = plugins_url();
$path = plugin_dir_path( __FILE__ );
$strPluginname = basename($path); 
?>
<div class="wrap">
<div class="icon32 icon32-posts-xtn_slide_conten" id="icon-edit"><br /></div>
<h2><?php echo $strPluginTitle;?></h2>
<link href="<?php echo $url."/".$strPluginname;?>/css/styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">var imageUrl="<?php echo $url."/".$strPluginname;?>/images/color.png";</script>
<script src="<?php echo $url."/".$strPluginname;?>/js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $url."/".$strPluginname;?>/js/color.js"></script>
<form name="frm" method="post" action="admin.php?page=<?php echo $strSettingsRedirectPagename;?>">
    <div class="wrapper-action wp-core-ui">
      <div class="bulkactionsdiv1 fl">
        <div class="actions bulkactions">
        	<table cellpadding="1" cellspacing="1" border="0" width="100%">
            	 <?php
				if($strMsg != "")
				{
				?>
					<tr>
						<td colspan="10"><div class="delete-record"><?php echo $strMsg;?></div></td>
					</tr>
				<?php
				}
				?>
            	<tr>
                	<td>Thumb Width</td>
                    <td><input type="number" name="mk_banner_thumb_width" maxlength="5" value="<?php echo get_option('mk_banner_thumb_width');?>" style="width:60px !important;" /></td>
                    <td>Thumb Height</td>
                    <td><input type="number" name="mk_banner_thumb_height" maxlength="5" value="<?php echo get_option('mk_banner_thumb_height');?>" style="width:60px !important;" /></td>
                </tr>
                <tr>
                	<td>Medium Width</td>
                    <td><input type="number" name="mk_banner_medium_width" maxlength="5" value="<?php echo get_option('mk_banner_medium_width');?>" style="width:60px !important;"  /></td>
                	<td>Medium Height</td>
                    <td><input type="number" name="mk_banner_medium_height" maxlength="5" value="<?php echo get_option('mk_banner_medium_height');?>" style="width:60px !important;"  /></td> 
                </tr>
                <tr>
                	<td>Large Width</td>
                    <td><input type="number" name="mk_banner_large_width" maxlength="6" value="<?php echo get_option('mk_banner_large_width');?>" style="width:60px !important;"  /></td>
                	<td>Large Height</td>
                    <td><input type="number" name="mk_banner_large_height" maxlength="6" value="<?php echo get_option('mk_banner_large_height');?>" style="width:60px !important;"  /></td>
                    </tr>
                <tr>
                	<td colspan="2">Default Background Color</td>
                    <td colspan="2"><input type="text" name="mk_banner_default_bg_color" value="<?php echo get_option('mk_banner_default_bg_color');?>" style="width:60px !important;"  class="izzyColor" id="color1" /></td>
                    </tr>    
               
                <tr>
			<td class="label" colspan="2"><label>Banner Slider Time Out</label></td>
			<td class="content" colspan="2"><input type="text" name="slider_timeout"  value="<?php echo get_option('slider_timeout');?>"  /></td>
            </tr>
                <tr>
			<td class="label" colspan="2"><label>Banner Slider Effect</label></td>
			<td class="content" colspan="2">
			<select class="slider_effect" name="slider_effect">
            <option value="fade"<?php if(get_option('slider_effect')=='fade'){echo "selected='selected'";} ?>>Fade</option>
            <option value="blindX"<?php if(get_option('slider_effect')=='blindX'){echo "selected='selected'"; }?>>BlindX</option>
            <option value="blindY"<?php if(get_option('slider_effect')=='blindY'){echo "selected='selected'"; }?>>BlindY</option>
            <option value="blindZ"<?php if(get_option('slider_effect')=='blindZ'){echo "selected='selected'"; }?>>BlindZ</option>
            <option value="cover"<?php if(get_option('slider_effect')=='cover'){echo "selected='selected'"; }?>>cover</option>
            <option value="curtainX"<?php if(get_option('slider_effect')=='curtainX'){echo "selected='selected'"; }?>>CurtainX</option>
            <option value="curtainY"<?php if(get_option('slider_effect')=='curtainY'){echo "selected='selected'"; }?>>CurtainY</option>
            <option value="fadeZoom"<?php if(get_option('slider_effect')=='fadeZoom'){echo "selected='selected'"; }?>>FadeZoom</option>
            <option value="growX"<?php if(get_option('slider_effect')=='growX'){echo "selected='selected'"; }?>>GrowX</option>
            <option value="growY"<?php if(get_option('slider_effect')=='growY'){echo "selected='selected'"; }?>>growY</option>
            <option value="none"<?php if(get_option('slider_effect')=='none'){echo "selected='selected'"; }?>>None</option>
            <option value="scrollUp"<?php if(get_option('slider_effect')=='scrollUp'){echo "selected='selected'"; }?>>ScrollUp</option>
            <option value="scrollDown"<?php if(get_option('slider_effect')=='scrollDown'){echo "selected='selected'"; }?>>ScrollDown</option>
            <option value="scrollLeft"<?php if(get_option('slider_effect')=='scrollLeft'){echo "selected='selected'"; }?>>ScrollLeft</option>
            <option value="scrollRight"<?php if(get_option('slider_effect')=='scrollRight'){echo "selected='selected'"; }?>>ScrollRight</option>
            <option value="scrollHorz"<?php if(get_option('slider_effect')=='scrollHorz'){echo "selected='selected'"; }?>>ScrollHorz</option>
            <option value="scrollVert"<?php if(get_option('slider_effect')=='scrollVert'){echo "selected='selected'"; }?>>ScrollVert</option>
            <option value="shuffle"<?php if(get_option('slider_effect')=='shuffle'){echo "selected='selected'"; }?>>Shuffle</option>
            <option value="slideX"<?php if(get_option('slider_effect')=='slideX'){echo "selected='selected'"; }?>>SlideX</option>
            <option value="slideY"<?php if(get_option('slider_effect')=='slideY'){echo "selected='selected'"; }?>>SlideY</option>
            <option value="toss"<?php if(get_option('slider_effect')=='toss'){echo "selected='selected'"; }?>>Toss</option>
            <option value="turnUp"<?php if(get_option('slider_effect')=='turnUp'){echo "selected='selected'"; }?>>TurnUp</option>
            <option value="turnDown"<?php if(get_option('slider_effect')=='turnDown'){echo "selected='selected'"; }?>>TurnDown</option>
            <option value="turnLeft"<?php if(get_option('slider_effect')=='turnLeft'){echo "selected='selected'"; }?>>TurnLeft</option>
            <option value="turnRight"<?php if(get_option('slider_effect')=='turnRight'){echo "selected='selected'"; }?>>TurnRight</option>
            <option value="wipe"<?php if(get_option('slider_effect')=='wipe'){echo "selected='selected'"; }?>>Wipe</option>
            <option value="zoom"<?php if(get_option('slider_effect')=='zoom'){echo "selected='selected'"; }?>>Zoom</option>
			</select>
			</td>
		</tr>
         <tr>
                	<td colspan="2"><input type="submit" name="submit_settings" value="Save" class="add-new-h2 button-primary fr" /></td>
                </tr>
            </table>
        </div>
      </div>
    </div>
  </form>  
</div>