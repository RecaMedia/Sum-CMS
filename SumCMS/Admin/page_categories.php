<?php
/*
Sum CMS was developed to help manage a single website.
To install, please visit http://dev.sumcms.com/page/Getting_Started for further detailed instructions.
The index.php file in the root directory of the website must be properly set up to take full advantage of Sum CMS features.
To properly set up your index file, visit http://dev.sumcms.com/page/Documentation.
 *
 *
 * Sum CMS - A Content Management System
 *
 * @category   Content Management System
 * @software   Sum CMS
 * @author     Shannon Reca <sreca@recamedia.com>
 * @copyright  2013 Shannon Reca, RecaMedia
 * @license   See License.txt
 * @version    v1.3
 * @link       http://dev.sumcms.com
 * @since      File available since Release 1.0
 * @support    https://github.com/sorec007/Sum-CMS/issues
*/

include 'inc.php';
/* ---------- Page Script ---------- */
if(isset($_POST['formType']) && $_POST['formType']=='update' && preg_match("/^[0-9]+$/", $_POST['c_ID'])){
	$FormType = 'update';
	$FormBtnTitle = $GLBLang['sub1'];
	$FormCateID = mysql_escape_string($_POST['c_ID']);
	
	MySqlConnect();
	$CateQuery = mysql_query("SELECT * FROM IDCMS_Categories WHERE ID='$FormCateID' LIMIT 1");
	mysql_close(MySqlConnect());
	$Exist = mysql_num_rows($CateQuery);
	
	if($Exist>0){
		$C = mysql_fetch_array($CateQuery);
		if($_POST['c_Submit']!=$FormBtnTitle){
			$c_Name = $C['Name'];
			$c_Description = $C['Description'];
		}
	}else{
		$GLB_PG_Error = true;
		$GLB_PG_ErrorMsg .= $GLBLang['msg1'];
	}
}else{
	$FormType = 'add';
	$FormBtnTitle = $GLBLang['sub2'];
}


// Submit Form ----------------------------------------------------------------------
if($_POST['c_Submit']==$FormBtnTitle && $log_Role=='admin' || $log_Role=='manager'){
	MySqlConnect();
	
	function webSafeTitle($str){
		return str_replace(" ","_",preg_replace("/[^A-Za-z0-9\- ]/","", $str));
	}
	
	// Setup Vars
	$c_Name = $_POST['c_Name'];
	$c_Description = $_POST['c_Description'];
	$FinalTypeCheck = $_POST['formType'];
	
	// Validation process
	if($c_Name == "" || $c_Description == ""){
		$GLB_PG_Error = true;
		$GLB_PG_ErrorMsg .= $GLBLang['msg2'].'<br />';
	}
	
	// Insert or Update Information
	if (!$GLB_PG_Error){
		$c_Name = mysql_real_escape_string(ucwords(strtolower(preg_replace("/[^A-Za-z0-9 ]/","", $c_Name))));
		$c_WebsafeName = webSafeTitle($c_Name);
		$c_Description = mysql_real_escape_string($c_Description);
		
		switch($FinalTypeCheck){
			case 'update':
				$SQL = "UPDATE IDCMS_Categories SET Name='$c_Name', WebsafeName='$c_WebsafeName', Description='$c_Description' WHERE ID='$FormCateID'";
				$SucTxt = $GLBLang['msg3'];
				$ErrTxt = $GLBLang['msg4'];
			break;
			case 'add':
				$SQL = "INSERT INTO IDCMS_Categories (Name,WebsafeName,Description) VALUES ('$c_Name','$c_WebsafeName','$c_Description')";
				$SucTxt = $GLBLang['msg5'];
				$ErrTxt = $GLBLang['msg6'];
			break;
		}
			
		if(mysql_query($SQL)){
			$GLB_PG_Success = true;
			$GLB_PG_SuccessMsg .= $GLBLang['msg7'];
			
			$c_Name = '';
			$c_Description = '';
		}else{
			$GLB_PG_Error = true;
			$GLB_PG_ErrorMsg = $GLBLang['msg8'];
		}							
	}
	mysql_close(MySqlConnect());
}

/* ---------- Page Header Setup ---------- */
$PageTitle = $GLBLang['PT'];
$PageRel = 'categories';
$AdditionalScripts = '';
require("inc_header.php");
?>

<div class="ad_col_half">
	<div class="padRight10">
        <!--Left Column Content Start-->
        <div class="ad_mod_wrap">
            <div class="ad_mod_header">
                <?php echo $GLBLang['sub3'];?>
            </div>
            <div class="ad_mod_content">
                <form method="post" action="page_categories.php">
                <input type="hidden" value="<?php echo $FormType;?>"  id="formType" name="formType"/>
                <?php if($FormType=='update'){?>
                <input type="hidden" value="<?php echo $FormCateID;?>"  id="c_ID" name="c_ID"/>
                <?php }?>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub4'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <input type="text" id="c_Name" name="c_Name" value="<?php echo $c_Name;?>"/>
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub5'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                	<div class="ad_mod_whiteWrap">
                		<textarea id="c_Description" name="c_Description"><?php echo $c_Description;?></textarea>
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <input class="form_submit FloatRight" id="c_Submit" name="c_Submit" type="submit" value="<?php echo $FormBtnTitle;?>" />
                    <div class="clear"></div>
                </div>
                </form>
            </div>
        </div>
        <!--Left Column Content End-->
    </div>
</div>

<div class="ad_col_half">
	<div class="padLeft10">
        <!--Right Column Content Start-->
        <div id="CategoryList"></div>
        <!--Right Column Content End-->
    </div>
</div>

<div class="clear"></div>

<?php require("inc_footer.php");?>