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

require_once("inc.php");
require_once("inc_dda.php");

/* ---------- Page Script ---------- */
$ActivateTxt = 'Pre-activate this account.';
if(isset($_POST['formType']) && $_POST['formType']=='update' && preg_match("/^[0-9]+$/", $_POST['u_User'])){
	$FormType = 'update';
	$FormBtnTitle = $GLBLang['btn1'];
	$FormUserID = mysql_escape_string($_POST['u_User']);
	
	MySqlConnect();
	$UserQuery = mysql_query("SELECT * FROM IDCMS_Authors WHERE ID='$FormUserID' LIMIT 1");
	mysql_close(MySqlConnect());
	$Exist = mysql_num_rows($UserQuery);
	
	if($Exist>0){
		$U = mysql_fetch_array($UserQuery);
		if($_POST['u_Submit']!=$FormBtnTitle){
			$u_Fname = $U['Fname'];
			$u_Lname = $U['Lname'];
			$u_Email = $U['Email'];
			$u_Role = $U['Role'];
			$u_Confirm = $U['Confirm'];
			
			$ActivateTxt = $GLBLang['msg1'];
		}
	}else{
		$GLB_PG_Error = true;
		$GLB_PG_ErrorMsg .= $GLBLang['msg2'];
	}
}else{
	$FormType = 'add';
	$FormBtnTitle = $GLBLang['btn2'];
}

// Submit Form ----------------------------------------------------------------------
if($_POST['u_Submit']==$FormBtnTitle && $log_Role=='admin'){
	MySqlConnect();
	
	// Setup Vars
	$u_Fname = $_POST['u_Fname'];
	$u_Lname = $_POST['u_Lname'];
	$u_Email = $_POST['u_Email'];
	$u_Role = $_POST['u_Role'];
	$u_Confirm = $_POST['u_Confirm'];
	$FinalTypeCheck = $_POST['formType'];
	
	// Validation process
	function isValidEmail($emailcheck){
		return preg_match("/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)*\.([a-zA-Z]{2,6})$/", $emailcheck);
	}
	function doesEmailExist($emailcheck){
		$emailcheck = mysql_real_escape_string($emailcheck);
		$sql = mysql_query("SELECT * FROM IDCMS_Authors WHERE Email='$emailcheck' LIMIT 1");
		$U = mysql_fetch_array($sql);
		$Num = mysql_num_rows($sql); 
		if($Num > 0){
			if($U['Active']==1){
				return array('error');
			}else if($U['Active']==0){
				return array('reinstate',$U['ID']);
			}
		}else{
			return false;
		}
	}
	
	// Start Process
	if($u_Fname == "" || $u_Lname == "" || $u_Email == "" || $u_Role == ""){
		$GLB_PG_Error = true;
		$GLB_PG_ErrorMsg .= $GLBLang['msg3'].'<br />';
	}
	if(!isValidEmail($u_Email)){
		$GLB_PG_Error = true;
		$GLB_PG_ErrorMsg .= $GLBLang['msg4'].'<br />';
	}
	if($_POST['formType']=='add'){
		$AccountChk = doesEmailExist($u_Email);
		if($AccountChk){
			if($AccountChk[0]=='error'){
				$GLB_PG_Error = true;
				$GLB_PG_ErrorMsg .= $GLBLang['msg5'].'<br />';
			}else if($AccountChk[0]=='reinstate'){
				$FinalTypeCheck = $AccountChk[0];
				$FormUserID = $AccountChk[1];
			}
		}
	}
	
	// Insert or Update Information
	if (!$GLB_PG_Error){
		$FormUserID = mysql_real_escape_string($FormUserID);
		$u_Fname = mysql_real_escape_string(ucfirst(strtolower(preg_replace("/[^A-Za-z ]/","", $u_Fname))));
		$u_Lname = mysql_real_escape_string(ucfirst(strtolower(preg_replace("/[^A-Za-z ]/","", $u_Lname))));
		$u_Email = mysql_real_escape_string($u_Email);
		$u_Role = mysql_real_escape_string($u_Role);
		$u_Confirm = mysql_real_escape_string($u_Confirm);
		$u_Password = trim(substr(hash('sha256', rand(1, 256).$u_Email), 0, 16));
		$u_DateStamp = date("Y-m-d H:i:s");
		
		switch($FinalTypeCheck){
			case 'reinstate':
				$SQL = "UPDATE IDCMS_Authors
				SET Fname='$u_Fname', Lname='$u_Lname', DisplayName='$u_Fname $u_Lname', Email='$u_Email', 
				Password='$u_Password', Role='$u_Role', Confirm='$u_Confirm', Active='1'
				WHERE ID='$FormUserID'";
				$SucTxt = $GLBLang['msg6'];
				$ErrTxt = $GLBLang['msg7'];
			break;
			case 'update':
				$SQL = "UPDATE IDCMS_Authors
				SET Fname='$u_Fname', Lname='$u_Lname', DisplayName='$u_Fname $u_Lname', Email='$u_Email',
				Role='$u_Role', Confirm='$u_Confirm'
				WHERE ID='$FormUserID'";
				$SucTxt = $GLBLang['msg8'];
				$ErrTxt = $GLBLang['msg7'];
			break;
			case 'add':
				$SQL = "INSERT INTO IDCMS_Authors
				(Fname, Lname, DisplayName, Email, Password, RegDate, Role, Confirm)
				VALUES ('$u_Fname','$u_Lname','$u_Fname $u_Lname','$u_Email','$u_Password','$u_DateStamp','$u_Role','$u_Confirm')";
				$SucTxt = $GLBLang['msg9'];
				$ErrTxt = $GLBLang['msg10'];
			break;
		}
			
		if(mysql_query($SQL)){
			$GLB_PG_Success = true;
			$GLB_PG_SuccessMsg = 'You have successfully '.$SucTxt.' '.$u_Fname.'.';
			if($FinalTypeCheck=='add' || $FinalTypeCheck=='reinstate'){
				include 'func_mail.php';
				addedUser($log_Email,$u_Fname,$u_Email,$u_Password,$u_Confirm,$GLB_Domain);
				$GLB_PG_SuccessMsg .= ' '.$GLBLang['msg11'];
				
				$u_Fname = '';
				$u_Lname = '';
				$u_Email = '';
				$u_Role = '';
				$u_Confirm = 0;
			}
		}else{
			$GLB_PG_Error = true;
			$GLB_PG_ErrorMsg = $GLBLang['msg12'];
		}							
	}
	mysql_close(MySqlConnect());
}

/* ---------- Page Header Setup ---------- */
$PageTitle = $GLBLang['PT'];
$PageRel = 'users';
$AdditionalScripts = '';
require("inc_header.php");
?>

<div class="ad_col_half">
	<div class="padRight10">
        <!--Left Column Content Start-->
        <div class="ad_mod_wrap">
            <div class="ad_mod_header">
                <?php echo $FormBtnTitle;?>
            </div>
            <div class="ad_mod_content">
                <form method="post" action="page_manageUsers.php">
                <input type="hidden" value="<?php echo $FormType;?>"  id="formType" name="formType"/>
                <?php if($FormType=='update'){?>
                <input type="hidden" value="<?php echo $FormUserID;?>"  id="u_User" name="u_User"/>
                <?php }?>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub1'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <input type="text" id="u_Fname" name="u_Fname" value="<?php echo $u_Fname;?>"/>
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub2'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <input type="text" id="u_Lname" name="u_Lname" value="<?php echo $u_Lname;?>"/>
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub3'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <input type="text" id="u_Email" name="u_Email" value="<?php echo $u_Email;?>"/>
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub4'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <input id="u_Role" name="u_Role" type="radio" value="admin" <?php if($u_Role=='admin'){echo'checked="checked"';}?>/> <?php echo $GLBLang['sub5'];?> 
                    <input id="u_Role" name="u_Role" type="radio" value="manager" <?php if($u_Role=='manager'){echo'checked="checked"';}?>/> <?php echo $GLBLang['sub6'];?>
                    <input id="u_Role" name="u_Role" type="radio" value="user" <?php if($u_Role=='user'){echo'checked="checked"';}?>/> <?php echo $GLBLang['sub7'];?>
                </div>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub8'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <input id="u_Confirm" name="u_Confirm" type="checkbox" value="1" <?php if($u_Confirm=='1'){echo'checked="checked"';}?>/> <?php echo $ActivateTxt;?>
                </div>
                <div class="ad_mod_row_full">
                    <input class="form_submit FloatRight" id="u_Submit" name="u_Submit" type="submit" value="<?php echo $FormBtnTitle;?>" />
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
        <div id="UsersList"></div>
        <?php if($FormType=='update'){?>
        <div class="padTop10">
        	<a class="btnLink FloatRight" href="page_manageUsers.php"><?php echo $GLBLang['btn3'];?></a>
        </div>
        <?php }?>
        <!--Right Column Content End-->
    </div>
</div>

<div class="clear"></div>

<?php require("inc_footer.php");?>