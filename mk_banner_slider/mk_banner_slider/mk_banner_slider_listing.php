<?php require_once("global/global.php");?>
<?php
$url = plugins_url();
$path = plugin_dir_path( __FILE__ );
$strPluginname = basename($path); 
?>
<div class="wrap">
<div class="icon32 icon32-posts-xtn_slide_conten" id="icon-edit"><br></div>
<h2><?php echo $strPluginTitle;?></h2>
<link href="<?php echo $url."/".$strPluginname;?>/css/styles.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $url."/".$strPluginname;?>/js/jquery.min.js" type="text/javascript"></script>
<?php 
require_once($strActionFilename);
if(isset($_GET['action']) && trim($_GET['action']) == $strActionFileaddedit)
{
	include_once "$strActionFileaddedit.php";
}
else if(isset($_GET['action']) && trim($_GET['action']) == $strActionFileaddedit)
{
	include_once "$strActionFileaddedit.php";
}
else
{
?>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#checkall-id').toggle(function(){
	jQuery('.dynmic-checkbox').attr('checked','checked');
	jQuery(this).val('None');
},function(){
	jQuery('.dynmic-checkbox').removeAttr('checked');
	jQuery(this).val('All');
});
});
function fnConfirmAction()
{
	if(confirm("Are you sure you want to apply action?"))
	{
		return true;
	}
	else
	{
		return false;
	}
}
</script>
  <form name="frm" method="post" action="admin.php?page=<?php echo $strRedirectPagename;?>">
    <div class="wrapper-action wp-core-ui">
      <div class="search-box fl">
        <label for="post-search-input" class="screen-reader-text">Search Posts:</label>
        <input type="search"  placeholder="Enter Title" value="<?php if(isset($_REQUEST["s"]) && $_REQUEST["s"] != ""){echo $_REQUEST["s"];}?>" name="s" id="post-search-input">
        &nbsp;&nbsp;<input type="submit" value="Search" class="button button-primary fl" id="search-submit" name="search-submit">
        &nbsp;&nbsp;<a class="button button-primary fl" href="admin.php?page=<?php echo $strRedirectPagename;?>" style="margin-left:10px;">Reset</a>
      </div>
      <div class="center-add"><a class="add-new-h2 button-primary fr" href="admin.php?page=<?php echo $strRedirectPagename;?>&action=<?php echo $strActionFileaddedit;?>">Add New</a></div>
      <div class="bulkactionsdiv fr">
      <span class="fr">&nbsp;&nbsp;Total <?php echo sizeof($arrTotalRecords);?> Records Found</span>
        <div class="actions bulkactions">
          <select name="action">
            <option value="0">Bulk Actions</option>
            <option value="delete">Delete</option>
            <option value="resize_thumb">Resize Thumb</option>
            <option value="resize_medium">Resize Medium</option>
            <option value="resize_large">Resize Large</option>
            <option value="resize_all">Resize All Banners</option>
          </select>
          <input type="submit" value="Apply" class="button action" id="doaction" onclick="return fnConfirmAction();">
        </div>
        <br class="clear">
      </div>
    </div>
    <table cellspacing="0" class="wp-list-table widefat fixed posts">
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
      	<th class="manage-columm check-column" scope="col">Sr</th>
        <th class="manage-column column-cb check-column" scope="col"><input name="mycheckbox" id="checkall-id" value="All" type="button" class="checkall-button w50" /></th>
        <th class="manage-column column-author" scope="col">Title</th>
        <th class="manage-column" scope="col">URL</th>
        <th class="manage-column" scope="col">File</th>
        <th class="manage-column" scope="col">Sort Order</th>
        <th class="manage-column" scope="col">Created At</th>
        <th class="manage-column" scope="col">Updated At</th>
        <th class="manage-column" scope="col">Action</th>
        <th class="manage-column check-column" scope="col">ID</th>
      </tr>
      <?php
	  	$intSrNo = 1;
		if(count($arrResults) > 0)
		{
		foreach($arrResults as $key => $val)
		{
		?>
      <tr>
      	<th class="manage-column column-author" scope="col"><?php echo $intSrNo;?></th>
        <td><label for="cb-select-<?php echo $val->banner_id;?>" class="screen-reader-text">Select test</label><input type="checkbox" value="<?php echo $val->banner_id;?>" name="delete[]" id="cb-select-<?php echo $val->banner_id;?>" class="dynmic-checkbox"><div class="locked-indicator"></div></td>
        <td><?php echo $val->title;?></td>
        <td><a href="<?php echo $val->url;?>" target="_blank"><?php echo $val->url;?></a></td>
        <td><?php echo $val->banner_file;?></td>
        <td><?php echo $val->sortorder;?></td>
        <td><?php echo $val->created_at;?></td>
        <td><?php echo $val->updated_at;?></td>
        <td><a href="admin.php?page=<?php echo $strRedirectPagename;?>&action=<?php echo $strActionFileaddedit;?>&<?php echo $strPrimaryKey;?>=<?php echo $val->banner_id;?>">Edit</a></td>
        <td><?php echo $val->banner_id;?></td>
      </tr>
      	<?php
	  	$intSrNo++;
		}
		}
		else
		{
			?>
            <tr><td colspan="10" align="center"><hr /></td></tr>
			<tr><td colspan="10" align="center">No Records Found</td></tr>
			<?php
		}
		?>
    </table>
    <table width="100%" align="right" style="float:right;">
      <tr>
        <?php
		$strUrl = "admin.php?page=".$strRedirectPagename;
		if(isset($_REQUEST["s"]))
		{
			$strUrl .= "&s=".$_REQUEST["s"];	
		}
		$strUrl .= "&pg=";
		?>
        <th colspan="5" align="center"><?php echo pagination($intLimit,$intPage,$strUrl,count($arrTotalRecords));?></th>
      </tr>
    </table>
  </form>
</div>
<?php
}
?>