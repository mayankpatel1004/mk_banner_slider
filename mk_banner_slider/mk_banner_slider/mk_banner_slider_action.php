<?php
$strSearchRequrest = "";
if(isset($_REQUEST["s"]) && $_REQUEST["s"] != "")
{
	$strSearchRequrest = $_REQUEST["s"];
}

if(isset($_REQUEST["search-submit"]))
{
	if($strSearchRequrest != "")
	{
		$strWhere .= " AND $strSearchColumnname LIKE '%".$strSearchRequrest."%' ";
	}
	
	$sqlQueryTotalRecords = "SELECT * FROM $strTablename WHERE 1=1 $strWhere ORDER BY `$strPrimaryKey DESC";
	$arrTotalRecords = $wpdb->get_results($sqlQueryTotalRecords);
	
	$sqlQuery = "SELECT * FROM $strTablename WHERE 1=1 $strWhere ORDER BY $strPrimaryKey DESC  LIMIT $intStart, $intLimit";
	$arrResults = $wpdb->get_results($sqlQuery);
	
}
else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == 'delete')
{
	if(isset($_REQUEST["delete"]) && sizeof($_REQUEST["delete"]) > 0)
	{
		$path = $path."/uploads/";
		foreach($_REQUEST["delete"] as $key => $id)
		{
			if(isset($id) && $id != "")
			{
				$sqlQuery = "SELECT banner_file FROM $strTablename WHERE $strPrimaryKey = $id";
				$arrResults = $wpdb->get_results($sqlQuery);
				if(isset($arrResults[0]->banner_file) && $arrResults[0]->banner_file != "")
				{
					$strBannerFile = $arrResults[0]->banner_file;
					@unlink($path.$strBannerFile);
					@unlink($path."thumb/".$strBannerFile);
					@unlink($path."medium/".$strBannerFile);
					@unlink($path."large/".$strBannerFile);
				}
			}
			
			$sqlDelete = "DELETE FROM $strTablename WHERE $strPrimaryKey = ".$id;
			$wpdb->get_results($sqlDelete);
			
			header("Location:admin.php?page=$strRedirectPagename&msg=1");
		}
	}
}
else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == 'resize_thumb')
{
	if(isset($_REQUEST["delete"]) && sizeof($_REQUEST["delete"]) > 0)
	{
		$path = $path."/uploads/";
		foreach($_REQUEST["delete"] as $key => $id)
		{	
			if(isset($id) && $id != "")
			{
				$sqlQuery = "SELECT banner_file FROM $strTablename WHERE $strPrimaryKey = $id";
				$arrResults = $wpdb->get_results($sqlQuery);
				if(isset($arrResults[0]->banner_file) && $arrResults[0]->banner_file != "")
				{
					$strBannerFile = $arrResults[0]->banner_file;
					@unlink($path."thumb/".$strBannerFile);
					fnCreatThumbnail($path.$arrResults[0]->banner_file,$arrResults[0]->banner_file,$path."thumb/".$arrResults[0]->banner_file,get_option('mk_banner_thumb_width'),get_option('mk_banner_thumb_height'));
				}
			}
		}
		header("Location:admin.php?page=$strRedirectPagename&msg=4");
	}
}
else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == 'resize_medium')
{
	if(isset($_REQUEST["delete"]) && sizeof($_REQUEST["delete"]) > 0)
	{
		$path = $path."/uploads/";
		foreach($_REQUEST["delete"] as $key => $id)
		{	
			if(isset($id) && $id != "")
			{
				$sqlQuery = "SELECT banner_file FROM $strTablename WHERE $strPrimaryKey = $id";
				$arrResults = $wpdb->get_results($sqlQuery);
				if(isset($arrResults[0]->banner_file) && $arrResults[0]->banner_file != "")
				{
					$strBannerFile = $arrResults[0]->banner_file;
					//echo $path."medium/".$strBannerFile;exit;
					@unlink($path."medium/".$strBannerFile);
					
					fnCreatThumbnail($path.$arrResults[0]->banner_file,$arrResults[0]->banner_file,$path."medium/".$arrResults[0]->banner_file,get_option('mk_banner_medium_width'),get_option('mk_banner_medium_height'));
				}
			}
		}
		header("Location:admin.php?page=$strRedirectPagename&msg=4");
	}
}
else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == 'resize_large')
{
	if(isset($_REQUEST["delete"]) && sizeof($_REQUEST["delete"]) > 0)
	{
		$path = $path."/uploads/";
		foreach($_REQUEST["delete"] as $key => $id)
		{	
			if(isset($id) && $id != "")
			{
				$sqlQuery = "SELECT banner_file FROM $strTablename WHERE $strPrimaryKey = $id";
				$arrResults = $wpdb->get_results($sqlQuery);
				if(isset($arrResults[0]->banner_file) && $arrResults[0]->banner_file != "")
				{
					$strBannerFile = $arrResults[0]->banner_file;
					@unlink($path."large/".$strBannerFile);
					fnCreatThumbnail($path.$arrResults[0]->banner_file,$arrResults[0]->banner_file,$path."large/".$arrResults[0]->banner_file,get_option('mk_banner_large_width'),get_option('mk_banner_large_height'));
				}
			}
		}
		header("Location:admin.php?page=$strRedirectPagename&msg=4");
	}
}
else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == 'resize_all')
{
	if(isset($_REQUEST["delete"]) && sizeof($_REQUEST["delete"]) > 0)
	{
		$path = $path."/uploads/";
		foreach($_REQUEST["delete"] as $key => $id)
		{	
			if(isset($id) && $id != "")
			{
				$sqlQuery = "SELECT banner_file FROM $strTablename WHERE $strPrimaryKey = $id";
				$arrResults = $wpdb->get_results($sqlQuery);
				if(isset($arrResults[0]->banner_file) && $arrResults[0]->banner_file != "")
				{
					$strBannerFile = $arrResults[0]->banner_file;
					@unlink($path."thumb/".$strBannerFile);
					@unlink($path."medium/".$strBannerFile);
					@unlink($path."large/".$strBannerFile);
					fnCreatThumbnail($path.$arrResults[0]->banner_file,$arrResults[0]->banner_file,$path."thumb/".$arrResults[0]->banner_file,get_option('mk_banner_thumb_width'),get_option('mk_banner_thumb_height'));
					fnCreatThumbnail($path.$arrResults[0]->banner_file,$arrResults[0]->banner_file,$path."medium/".$arrResults[0]->banner_file,get_option('mk_banner_medium_width'),get_option('mk_banner_medium_height'));
					fnCreatThumbnail($path.$arrResults[0]->banner_file,$arrResults[0]->banner_file,$path."large/".$arrResults[0]->banner_file,get_option('mk_banner_large_width'),get_option('mk_banner_large_height'));
				}
			}
		}
		header("Location:admin.php?page=$strRedirectPagename&msg=4");
	}
}
else
{
	$strWhere = "";
	if($strSearchRequrest != "")
	{
		$strWhere .= " AND $strSearchColumnname LIKE '%".$strSearchRequrest."%' ";
	}
	
	$sqlQueryTotalRecords = "SELECT * FROM $strTablename WHERE 1=1 $strWhere ORDER BY $strPrimaryKey DESC";
	$arrTotalRecords = $wpdb->get_results($sqlQueryTotalRecords);
	
	$sqlQuery = "SELECT * FROM $strTablename WHERE 1=1 $strWhere ORDER BY $strPrimaryKey DESC  LIMIT $intStart, $intLimit";
	$arrResults = $wpdb->get_results($sqlQuery);
}

if(isset($_POST["submitform"]))
{
	
	if(isset($_FILES["banner_file"]["name"]) && $_FILES["banner_file"]["name"] != "")
	{
		$path = $path."/uploads/";
		$strFilename = uniqid()."_".$_FILES["banner_file"]["name"];
		move_uploaded_file($_FILES["banner_file"]["tmp_name"],$path.$strFilename);
		
		if(get_file_extension($strFilename) == 1)
		{
			fnCreatThumbnail($path.$strFilename,$strFilename,$path."thumb/".$strFilename,get_option('mk_banner_thumb_width'),get_option('mk_banner_thumb_height'));
			fnCreatThumbnail($path.$strFilename,$strFilename,$path."medium/".$strFilename,get_option('mk_banner_medium_width'),get_option('mk_banner_medium_height'));
			fnCreatThumbnail($path.$strFilename,$strFilename,$path."large/".$strFilename,get_option('mk_banner_large_width'),get_option('mk_banner_large_height'));
		}
		$sqlArr["banner_file"] = $strFilename;
	}
	
	$sqlArr["url"] = $_POST["url"];
	$sqlArr["status"] = $_POST["status"];
	$sqlArr["title"] = $_POST["title"];
	$sqlArr["description"] = $_POST["description"];
	$sqlArr["sortorder"] = $_POST["sortorder"];
	
	if(isset($_POST["submitform"]) && $_POST["postaction"] == "add")
	{
		$sqlArr["created_at"] = date("Y-m-d h:i:s");
		fnInsertData($sqlArr,$strTablename);
		header("Location:admin.php?page=$strRedirectPagename&msg=2");
	}
	else if(isset($_POST["submitform"]) && $_POST["postaction"] == "edit")
	{
		if(isset($_FILES["banner_file"]["name"]) && $_FILES["banner_file"]["name"] != "")
		{
			$path = $path."";
			fnDeleteOldFile($strTablename,'banner_file',$strPrimaryKey,$_POST["banner_id"],$path);
			fnDeleteOldFile($strTablename,'banner_file',$strPrimaryKey,$_POST["banner_id"],$path."thumb/");
			fnDeleteOldFile($strTablename,'banner_file',$strPrimaryKey,$_POST["banner_id"],$path."medium/");
			fnDeleteOldFile($strTablename,'banner_file',$strPrimaryKey,$_POST["banner_id"],$path."large/");
		}
		
		$sqlArr["updated_at"] = date("Y-m-d h:i:s");
		fnUpdateData($sqlArr,$strTablename,$strPrimaryKey,$_POST["banner_id"]);
		header("Location:admin.php?page=$strRedirectPagename&msg=3");
	}
}
?>