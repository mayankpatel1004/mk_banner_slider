<?php
global $wpdb;
$wpdb->get_results("CREATE TABLE IF NOT EXISTS `mk_banner_slider`(
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `url` varchar(1024) NOT NULL,
  `banner_file` varchar(1024) NOT NULL,
  `sortorder` int(11) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");

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
	$wpdb->get_results("INSERT INTO $strOptionTable SET option_name = 'mk_banner_thumb_width',option_value = '100px',autoload = 'yes'");
	$wpdb->get_results("INSERT INTO $strOptionTable SET option_name = 'mk_banner_thumb_height',option_value = '100px',autoload = 'yes'");
	$wpdb->get_results("INSERT INTO $strOptionTable SET option_name = 'mk_banner_medium_width',option_value = '500px',autoload = 'yes'");
	$wpdb->get_results("INSERT INTO $strOptionTable SET option_name = 'mk_banner_medium_height',option_value = '250px',autoload = 'yes'");
	$wpdb->get_results("INSERT INTO $strOptionTable SET option_name = 'mk_banner_large_width',option_value = '900px',autoload = 'yes'");
	$wpdb->get_results("INSERT INTO $strOptionTable SET option_name = 'mk_banner_large_height',option_value = '250px',autoload = 'yes'");
	$wpdb->get_results("INSERT INTO $strOptionTable SET option_name = 'slider_timeout',option_value = '3000',autoload = 'yes'");
	$wpdb->get_results("INSERT INTO $strOptionTable SET option_name = 'slider_effect',option_value = 'fade',autoload = 'yes'");
	$wpdb->get_results("INSERT INTO $strOptionTable SET option_name = 'mk_banner_default_bg_color',option_value = '#FFFFFF',autoload = 'yes'");
}

$intPage = 1;//Default page
$intLimit = 10;//Records per page
$intStart = 0;//starts displaying records from 0
$strTablename = "mk_banner_slider";
$strSearchColumnname = "title";
$strPrimaryKey = "banner_id";
$strRedirectPagename = "mk_banner_slider";
$strSettingsRedirectPagename = "mk_banner_slider_settings";
$strTitle = "";
$strDescription = "";
$strUrl = "";
$strBannerFile = "";
$strSortorder = "";
$strCreatedAt = "";
$strUpdatedAt = "";
$strAction = "add";
$intBannerId = 0;
$strPluginTitle = "Banner Slider";
$strActionFilename = "mk_banner_slider_action.php";
$strActionFileaddedit = "mk_banner_slider_addedit";


$strMsg = "";	
if(isset($_GET["msg"]) && $_GET["msg"] == 1)
{
	$strMsg = "Records Deleted Successfully";
}
else if(isset($_GET["msg"]) && $_GET["msg"] == 2)
{
	$strMsg = "Records Inserted Successfully";
}
else if(isset($_GET["msg"]) && $_GET["msg"] == 3)
{
	$strMsg = "Records Updated Successfully";
}
else if(isset($_GET["msg"]) && $_GET["msg"] == 4)
{
	$strMsg = "Banner Resized Successfully";
}

if(isset($_GET['pg']) && $_GET['pg']!='')
{
	$intPage = $_GET['pg'];
	$intStart=($intPage - 1)*$intLimit;
}

function fnInsertData($arrData,$strTablename)
{
	global $wpdb;
	$strName='';
	$strValue='';
	$strNames = "";
	$strValues = "";
	
	foreach($arrData as $strName => $strValue)
	{
		$strNames .= "`$strName`,";
		$strValues .= "'".addslashes($strValue)."',";
	}
	$strNames = substr($strNames,0,strlen($strNames)-1);
	$strValues = substr($strValues,0,strlen($strValues)-1);
	
	$sqlInsert = "INSERT INTO `$strTablename` ($strNames) values ($strValues) ";
	if($wpdb->query($sqlInsert))
	{
		return  $lastid = $wpdb->insert_id;
	}
	else
	{
		echo "<div class='sqlqueryerror'>There is a problem with insert</div>";
		exit;
	}
}

function fnUpdateData($arrData,$strTablename,$intPrimaryKeyColumn,$intPrimaryKeyValue)
{
	global $wpdb;
	$sqlQuery = " UPDATE $strTablename SET ";
	foreach($arrData as $strName => $strValue)
	{
		if(strtoupper($strValue)!="NULL")
		{
			$sqlQuery .= "`$strName` = '".addslashes($strValue)."' , ";
		}
		else
		{
			$sqlQuery .= "`$strName` =  ".addslashes($strValue)." , ";
		}
	}
	$sqlQuery = substr($sqlQuery,0,strlen($sqlQuery)-2);
	$sqlQuery .= " WHERE $intPrimaryKeyColumn = $intPrimaryKeyValue " ;
	$wpdb->get_results($sqlQuery);
	return 1;
}

function fnDeleteOldFile($strTablename,$strColumnname,$intPrimarykey,$intPrimaryvalue,$strFilepath)
{
	global $wpdb;
	$sqlQuery = "SELECT $strColumnname FROM $strTablename WHERE $intPrimarykey = $intPrimaryvalue";
	$arrResults = $wpdb->get_results($sqlQuery);
	if(isset($arrResults[0]->banner_file) && $arrResults[0]->banner_file != "")
	{
		$strBannerFile = $arrResults[0]->banner_file;
		unlink($strFilepath.$strBannerFile);
	}
}

function get_file_extension($file_name)
{
	$intReturn = 0;
	$strExtension = strtolower(substr(strrchr($file_name,'.'),1));
	if($strExtension == 'jpg' || $strExtension == "png" || $strExtension == 'gif' || $strExtension == 'jpeg')
	{
		$intReturn = 1;
	}
	return $intReturn;
}

function fnCheckImageFile($strFilename)
{
	$strReturn = "false";
	$arrImageExtensions = array("jpg","jpeg","png","gif");
	$strFileExtension = strtolower(substr(strrchr($strFilename,'.'),1));
	if(in_array($strFileExtension,$arrImageExtensions))
	{
		$strReturn = "true";
	}
	return $strReturn;
}

function fnCreatThumbnail($strSourcePath,$strFilename,$strDestinationPath,$intGetWidth,$intGetHeight)
{	
	$info = pathinfo($strSourcePath);
	if (strtolower($info['extension']) == 'jpg') {$img = imagecreatefromjpeg( "{$strSourcePath}");}
	elseif(strtolower($info['extension']) == 'jpeg'){$img = imagecreatefromjpeg( "{$strSourcePath}");}
	elseif(strtolower($info['extension']) == 'gif'){$img = imagecreatefromgif( "{$strSourcePath}");}
	elseif(strtolower($info['extension']) == 'png'){$img = imagecreatefrompng( "{$strSourcePath}");}
	
	@$intNewWidth = $intOrigionalWidth = imagesx( $img ); 
	@$intNewHeight = $intOrigionalHeight = imagesy( $img );
	$color = "#FFFFFF";
	if(get_option('mk_banner_large_height') != "")
	{
		$color = get_option('mk_banner_default_bg_color');
	}
	$strTrueColor = fnHtml2rgb($color);
	$intFirstColor = $strTrueColor[0];
	$intSecondColor = $strTrueColor[1];
	$intThirdColor = $strTrueColor[2];
	
	if($intOrigionalWidth > $intGetWidth)
	{
		@$intNewWidth = $intGetWidth;
		@$intNewHeight = (($intOrigionalHeight * $intGetWidth)/$intOrigionalWidth);
	}
	if($intNewHeight > $intGetHeight)
	{
		@$intNewHeight = $intGetHeight;
		@$intNewWidth = (($intOrigionalWidth * $intGetHeight)/$intOrigionalHeight);
	}
	
	@$tmp_img = imagecreatetruecolor($intGetWidth,$intGetHeight);
	
	$strWhiteBackground = imagecolorallocate($tmp_img, $intFirstColor, $intSecondColor, $intThirdColor);
	imagefill($tmp_img, 0, 0, $strWhiteBackground);
	
	@$floatWhiteWidth = (($intGetWidth - $intNewWidth)/2);
	@$floatWhiteHeight = (($intGetHeight - $intNewHeight)/2);
	
	@imagecopyresized( $tmp_img, $img, $floatWhiteWidth, $floatWhiteHeight, 0, 0, $intNewWidth, $intNewHeight, $intOrigionalWidth, $intOrigionalHeight );
	$strDestinationFilename = basename($strDestinationPath);
	$strDestinationPath = str_replace($strDestinationFilename,"",$strDestinationPath);
	
	if(strtolower($info['extension']) == 'jpg'){imagejpeg($tmp_img,"{$strDestinationPath}{$strFilename}");}
	elseif(strtolower($info['extension']) == 'jpeg'){imagegif( $tmp_img, "{$strDestinationPath}{$strFilename}");}
	elseif(strtolower($info['extension']) == 'gif'){imagegif( $tmp_img, "{$strDestinationPath}{$strFilename}");}
	elseif(strtolower($info['extension']) == 'png'){imagepng( $tmp_img, "{$strDestinationPath}{$strFilename}");}
}
function fnHtml2rgb($color='')
{
	if ($color[0] == '#')
	{
		$color = substr($color, 1);
	}
	if (strlen($color) == 6)
	{
		list($r, $g, $b) = array($color[0].$color[1],$color[2].$color[3],$color[4].$color[5]);
	}							 
	elseif (strlen($color) == 3)
	{
		list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
	}	
	else
	{
		return false;
	}
	$r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
	return array($r, $g, $b);
}

function pagination($per_page = 10, $page = 1, $url = '', $total)
{   
	$adjacents = "2";
	
	$page = ($page == 0 ? 1 : $page); 
	$start = ($page - 1) * $per_page;                              
	 
	$prev = $page - 1;                         
	$next = $page + 1;
	$lastpage = ceil($total/$per_page);
	$lpm1 = $lastpage - 1;
	 
	$pagination = "";
	if($lastpage > 1)
	{  
		$pagination .= "<ul class='pagination'>";
				$pagination .= "<li class='details'>Page $page of $lastpage</li>";
		if ($lastpage < 7 + ($adjacents * 2))
		{  
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li><a class='current'>$counter</a></li>";
				else
					$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";                   
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))
		{
			if($page < 1 + ($adjacents * 2))    
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li><a class='current'>$counter</a></li>";
					else
						$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";                   
				}
				$pagination.= "<li class='dot'>...</li>";
				$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
				$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>";     
			}
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<li><a href='{$url}1'>1</a></li>";
				$pagination.= "<li><a href='{$url}2'>2</a></li>";
				$pagination.= "<li class='dot'>...</li>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li><a class='current'>$counter</a></li>";
					else
						$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";                   
				}
				$pagination.= "<li class='dot'>..</li>";
				$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
				$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>";     
			}
			else
			{
				$pagination.= "<li><a href='{$url}1'>1</a></li>";
				$pagination.= "<li><a href='{$url}2'>2</a></li>";
				$pagination.= "<li class='dot'>..</li>";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li><a class='current'>$counter</a></li>";
					else
						$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";                   
				}
			}
		}
		 
		if ($page < $counter - 1){
			$pagination.= "<li><a href='{$url}$next'>Next</a></li>";
			$pagination.= "<li><a href='{$url}$lastpage'>Last</a></li>";
		}else{
			$pagination.= "<li><a class='current'>Next</a></li>";
			$pagination.= "<li><a class='current'>Last</a></li>";
		}
		$pagination.= "</ul>\n";     
	}          
	return $pagination;
} 
?>