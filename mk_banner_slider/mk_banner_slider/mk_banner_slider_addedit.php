<?php
if(isset($_GET[$strPrimaryKey]))
{
	$strAction = "edit";
	$sqlSelectQuery = "SELECT * FROM mk_banner_slider WHERE banner_id = ".$_GET[$strPrimaryKey];
	$arrResults = $wpdb->get_results($sqlSelectQuery);
	$intBannerId = $arrResults[0]->banner_id;
	$strPageurl = $arrResults[0]->page_url;
	$strTitle = $arrResults[0]->title;
	$strDescription = $arrResults[0]->description;
	$strUrl = $arrResults[0]->url;
	$strBannerFile = $arrResults[0]->banner_file;
	$strSortorder = $arrResults[0]->sortorder;
	$strStatus = $arrResults[0]->status;
}
?>
<form name="frm" method="post" action="admin.php?page=<?php echo $strRedirectPagename;?>" id="createuser" enctype="multipart/form-data">
<input type="hidden" name="postaction" id="postaction" value="<?php echo $strAction;?>" />
<input type="hidden" name="banner_id" id="banner_id" value="<?php echo $intBannerId;?>" />
	<table class="form-table">
    	<tr class="form-field form-required">
        	<th scope="row">Title</th>
            <td><input type="text" name="title" id="title" required="required" value="<?php echo $strTitle;?>" /></td>
        </tr>
        <tr>
        	<th scope="row">Description</th>
            <td><textarea name="description" id="description"><?php echo $strDescription;?></textarea></td>
        </tr>
        <tr class="form-field form-required">
        	<th scope="row">Banner URL</th>
            <td><input type="url" name="url" id="url" required="required" value="<?php echo $strUrl;?>" /></td>
        </tr>
        <tr>
        	<th scope="row">Banner File</th>
            <td><input type="file" name="banner_file" id="banner_file" value="<?php echo $strBannerFile;?>" /></td>
        </tr>
        <tr class="form-field form-required">
        	<th scope="row">Sortorder</th>
            <td><input type="number" name="sortorder" id="sortorder" required="required" value="<?php echo $strSortorder;?>" /></td>
        </tr>
        <tr class="form-field form-required">
        	<th scope="row">Status</th>
            <td>
            <select name="status" id="status">
            	<option value="Active" <?php if($strStatus == 'Active'){echo "selected='selected'";}?>>Active</option>
                <option value="Inactive" <?php if($strStatus == 'Inactive'){echo "selected='selected'";}?>>Inactive</option>
            </select>
            </td>
        </tr>
        <tr>
        	<td colspan="2"><input type="submit" id="createusersub" class="button button-primary" name="submitform" value="Save" /><a class="button button-primary" href="admin.php?page=<?php echo $strRedirectPagename;?>" style="margin-left:10px;">Cancel</a></td>
        </tr>
    </table>
</form>