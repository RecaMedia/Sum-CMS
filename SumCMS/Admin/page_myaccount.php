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

$DBLink = MySqlConnect();

if(isset($_POST['u_Submit']) && $_POST['u_Submit']==$GLBLang['btn1']){
	// Setup Vars	
	$u_Fname = $_POST['u_Fname'];
	$u_Lname = $_POST['u_Lname'];
	$u_NickName = $_POST['u_NickName'];
	$u_DisplayName = $_POST['u_DisplayName'];
	$u_Email = $_POST['u_Email'];
	$u_Password = $_POST['u_Password'];
	$u_PersonalURL = $_POST['u_PersonalURL'];
	$u_Bio = $_POST['u_Bio'];
	$u_FacebookURL = $_POST['u_FacebookURL'];
	$u_TwitterURL = $_POST['u_TwitterURL'];
	$u_LinkedInURL = $_POST['u_LinkedInURL'];
	
	// Validation process
	function isValidEmail($emailcheck){
		return preg_match("/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)*\.([a-zA-Z]{2,6})$/", $emailcheck);
	}
	function doesEmailExist($emailcheck){
		global $log_ID;
		$emailcheck = mysql_real_escape_string($emailcheck);
		$sql = mysql_query("SELECT * FROM IDCMS_Authors WHERE Email='$emailcheck' AND ID!='$log_ID' LIMIT 1");
		$U = mysql_fetch_array($sql);
		$Num = mysql_num_rows($sql); 
		if($Num > 0){
			return true;
		}
	}
	
	// Start Process
	if($u_Fname == "" || $u_Lname == "" || $u_DisplayName == "" || $u_Email == "" || $u_Password == ""){
		$GLB_PG_Error = true;
		$GLB_PG_ErrorMsg .= $GLBLang['msg1'].'<br />';
	}
	if(!isValidEmail($u_Email)){
		$GLB_PG_Error = true;
		$GLB_PG_ErrorMsg .= $GLBLang['msg2'].'<br />';
	}
	if(doesEmailExist($u_Email)){
		$GLB_PG_Error = true;
		$GLB_PG_ErrorMsg .= $GLBLang['msg3'].'<br />';
	}
	
	// Insert or Update Information
	if (!$GLB_PG_Error){
		$u_Fname = mysql_real_escape_string(ucfirst(strtolower(preg_replace("/[^A-Za-z ]/","", $u_Fname))));
		$u_Lname = mysql_real_escape_string(ucfirst(strtolower(preg_replace("/[^A-Za-z ]/","", $u_Lname))));
		$u_NickName = mysql_real_escape_string(preg_replace("/[^A-Za-z0-9 ]/","", $u_NickName));
		$u_DisplayName = mysql_real_escape_string($u_DisplayName);
		$u_Email = mysql_real_escape_string($u_Email);
		$u_Password = mysql_real_escape_string($u_Password);
		$u_PersonalURL = mysql_real_escape_string($u_PersonalURL);
		$u_Bio = mysql_real_escape_string($u_Bio);
		$u_FacebookURL = mysql_real_escape_string($u_FacebookURL);
		$u_TwitterURL = mysql_real_escape_string($u_TwitterURL);
		$u_LinkedInURL = mysql_real_escape_string($u_LinkedInURL);
		
		$SQL = "UPDATE IDCMS_Authors
		SET Fname='$u_Fname', Lname='$u_Lname', NickName='$u_NickName', DisplayName='$u_DisplayName', Email='$u_Email', 
		Password='$u_Password', PersonalURL='$u_PersonalURL', Bio='$u_Bio', FacebookURL='$u_FacebookURL',
		TwitterURL='$u_TwitterURL', LinkedInURL='$u_LinkedInURL'
		WHERE ID='$log_ID' LIMIT 1";
		
		if(mysql_query($SQL)){
			$_SESSION['IDCMS_Fname'] = $u_Fname;
			$_SESSION['IDCMS_Lname'] = $u_Lname;
			$_SESSION['IDCMS_Email'] = $u_Email;
			$_SESSION['IDCMS_PersonalURL'] = $u_PersonalURL;
			
			$GLB_PG_Success = true;
			$GLB_PG_SuccessMsg = $GLBLang['msg4'];
		}else{
			$GLB_PG_Error = true;
			$GLB_PG_ErrorMsg = $GLBLang['msg5'];
		}							
	}
}

$Account = mysql_fetch_array(mysql_query("SELECT * FROM IDCMS_Authors WHERE ID='$log_ID' LIMIT 1",$DBLink));
$u_Fname = $Account['Fname'];
$u_Lname = $Account['Lname'];
$u_NickName = $Account['NickName'];
$u_DisplayName = $Account['DisplayName'];
$u_Email = $Account['Email'];
$u_Password = $Account['Password'];
$u_PersonalURL = $Account['PersonalURL'];
$u_Bio = $Account['Bio'];
$u_FacebookURL = $Account['FacebookURL'];
$u_TwitterURL = $Account['TwitterURL'];
$u_LinkedInURL = $Account['LinkedInURL'];

$Option1_DN = $u_Fname.' '.$u_Lname;
$Option2_DN = $u_Lname.', '.$u_Fname;
$Option3_DN = $u_NickName;
$Option4_DN = $u_Fname;
$Option5_DN = $u_Lname;

mysql_close($DBLink);

/* ---------- Page Header Setup ---------- */
$PageTitle = $GLBLang['PT'];
$AdditionalScripts = '';
require("inc_header.php");
?>

<form method="post" action="page_myaccount.php">
<div class="ad_col_half">
	<div class="padRight10">
        <!--Left Column Content Start-->
        <div class="ad_mod_wrap">
            <div class="ad_mod_header">
                <?php echo $GLBLang['sub1'];?>
            </div>
            <div class="ad_mod_content">
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub2'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <input type="text" id="u_Fname" name="u_Fname" value="<?php echo $u_Fname;?>"/>
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub3'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <input type="text" id="u_Lname" name="u_Lname" value="<?php echo $u_Lname;?>"/>
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub4'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <input type="text" id="u_NickName" name="u_NickName" value="<?php echo $u_NickName;?>"/>
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub5'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <select id="u_DisplayName" name="u_DisplayName">
                            <option <?php if($Option1_DN==$u_DisplayName||$u_DisplayName==""){echo 'selected="selected"';}?> value="<?php echo $Option1_DN;?>"><?php echo $Option1_DN;?></option>
                            <option <?php if($Option2_DN==$u_DisplayName){echo 'selected="selected"';}?> value="<?php echo $Option2_DN;?>"><?php echo $Option2_DN;?></option>
                            <option <?php if($Option3_DN==$u_DisplayName){echo 'selected="selected"';}?> value="<?php echo $Option3_DN;?>"><?php echo $Option3_DN;?></option>
                            <option <?php if($Option4_DN==$u_DisplayName){echo 'selected="selected"';}?> value="<?php echo $Option4_DN;?>"><?php echo $Option4_DN;?></option>
                            <option <?php if($Option5_DN==$u_DisplayName){echo 'selected="selected"';}?> value="<?php echo $Option5_DN;?>"><?php echo $Option5_DN;?></option>
                        </select>
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub6'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <input type="text" id="u_Email" name="u_Email" value="<?php echo $u_Email;?>"/>
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub7'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <input type="password" id="u_Password" name="u_Password" value="<?php echo $u_Password;?>"/>
                    </div>
                </div>
            </div>
        </div>
        <!--Left Column Content End-->
    </div>
</div>

<div class="ad_col_half">
	<div class="padLeft10">
        <!--Right Column Content Start-->
        <div class="ad_mod_wrap">
            <div class="ad_mod_header">
                <?php echo $GLBLang['sub8'];?>
            </div>
            <div class="ad_mod_content">
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub9'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <input type="text" id="u_PersonalURL" name="u_PersonalURL" value="<?php echo $u_PersonalURL;?>"/>
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub10'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <input type="text" id="u_FacebookURL" name="u_FacebookURL" value="<?php echo $u_FacebookURL;?>"/>
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub11'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <input type="text" id="u_TwitterURL" name="u_TwitterURL" value="<?php echo $u_TwitterURL;?>"/>
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub12'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <input type="text" id="u_LinkedInURL" name="u_LinkedInURL" value="<?php echo $u_LinkedInURL;?>"/>
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub13'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <textarea id="u_Bio" name="u_Bio"><?php echo $u_Bio;?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <!--Right Column Content End-->
    </div>
</div>

<div class="clear"></div>

<div class="ad_mod_row_full">
    <input class="form_submit FloatRight" id="u_Submit" name="u_Submit" type="submit" value="<?php echo $GLBLang['btn1'];?>" />
    <div class="clear"></div>
</div>
</form>

<?php require("inc_footer.php");?>