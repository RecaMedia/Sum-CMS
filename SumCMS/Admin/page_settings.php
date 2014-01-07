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
$uploadpath = $GLB_UploadPath;
$uploadpath = ltrim($uploadpath, '/');

/* ---------- Page Script ---------- */
// Submit Form ----------------------------------------------------------------------
if(isset($_POST['s_Submit']) && $_POST['s_Submit']==$GLBLang['btn2']){
	function alphaNumSpe($str){
		return preg_replace("/[^A-Za-z0-9_,.?!@:\&\-_\='\"\/ ]/","", $str);
	}
	
	function checkSize($Mem){
		if(preg_match("/(^\d+[M{1}|G{1}]$)/", $Mem)){
			return true;
		}else{
			return false;
		}
	}
	
	$s_SiteName = $_POST['s_SiteName'];
	$s_LogoURL = $_POST['s_LogoURL'];
	$s_MaxFileSize = $_POST['s_MaxFileSize'];
	$s_BlogRollCount = $_POST['s_BlogRollCount'];
	$s_ApproveComments = $_POST['s_ApproveComments'];
	$s_ContactEmail = $_POST['s_ContactEmail'];
	$s_LangSet = $_POST['s_LangSet'];
	$s_IndexURL = $_POST['s_IndexURL'];
	$s_GATracking = $_POST['s_GATracking'];
	
	if($s_SiteName == "" || $s_MaxFileSize == "" || $s_ContactEmail == ""){
		$GLB_PG_Error = true;
		$GLB_PG_ErrorMsg .= $GLBLang['msg1'].'<br />';
	}
	
	if(!preg_match("/^[0-1]+$/", $s_ApproveComments)) {
		$s_ApproveComments = 0;
	}
	
	if($s_BlogRollCount==0) {
		$s_BlogRollCount = 1;
	}
	
	if(!checkSize($s_MaxFileSize)){
		$GLB_PG_Error = true;
		$GLB_PG_ErrorMsg .= $GLBLang['msg2'].'<br />';
	}
	
	if (!array_key_exists($s_LangSet,$GLBLanguage)){
		$GLB_PG_Error = true;
		$GLB_PG_ErrorMsg .= $GLBLang['msg3'].'<br />';
	}
	
	// Update Information
	if(!$GLB_PG_Error){
		$DBLink = MySqlConnect();
		$s_SiteName = mysql_real_escape_string(alphaNumSpe($s_SiteName));
		$s_LogoURL = mysql_real_escape_string($s_LogoURL);
		$s_MaxFileSize = mysql_real_escape_string($s_MaxFileSize);
		$s_BlogRollCount = mysql_real_escape_string($s_BlogRollCount);
		$s_ApproveComments = mysql_real_escape_string($s_ApproveComments);
		$s_ContactEmail = mysql_real_escape_string($s_ContactEmail);
		$s_LangSet = mysql_real_escape_string($s_LangSet);
		$s_IndexURL = mysql_real_escape_string($s_IndexURL);
		$s_GATracking = mysql_real_escape_string($s_GATracking);
		
		if(mysql_query("UPDATE IDCMS_Settings SET IndexURL='$s_IndexURL', LogoURL='$s_LogoURL', SiteName='$s_SiteName', MaxFileSize='$s_MaxFileSize', BlogRollCount='$s_BlogRollCount', ApproveComments='$s_ApproveComments', ContactEmail='$s_ContactEmail', LangSet='$s_LangSet', GATracking='$s_GATracking'")){	
			mysql_close($DBLink);
			$GLB_PG_Success = true;
			$GLB_PG_SuccessMsg = $GLBLang['msg4'];
		}else{
			mysql_close($DBLink);
			$GLB_PG_Error = true;
			$GLB_PG_ErrorMsg = $GLBLang['msg5'];
		}
	}
}

$DBLink = MySqlConnect();
$S_SettingsQuery = mysql_query("SELECT * FROM IDCMS_Settings",$DBLink);
$S_Settings = mysql_fetch_array($S_SettingsQuery);
mysql_close($DBLink);

$s_Domain = $S_Settings['Domain'];
$s_UploadPath = $S_Settings['UploadPath'];
$s_SiteName = $S_Settings['SiteName'];
$s_LogoURL = $S_Settings['LogoURL'];
$s_MaxFileSize = $S_Settings['MaxFileSize'];
$s_BlogRollCount = $S_Settings['BlogRollCount'];
$s_ApproveComments = $S_Settings['ApproveComments'];
$s_ThemeIndex = $S_Settings['ThemeIndex'];
$s_ThemeFolder = $S_Settings['ThemeFolder'];
$s_ContactEmail = $S_Settings['ContactEmail'];
$s_LangSet = $S_Settings['LangSet'];
$s_IndexURL = $S_Settings['IndexURL'];
$s_GATracking = $S_Settings['GATracking'];

// Gets available languages
foreach ($GLBLanguage as $key => $value){
	if($s_LangSet==$key){
		$selectedLang = 'selected="selected"';
	}else{
		$selectedLang = '';
	}
    $LangList .= '<option '.$selectedLang.' value="'.$key.'">'.$key.'</option>';
}
$GLB_LangSet = $s_LangSet;
$GLBLang = $GLBLanguage[$GLB_LangSet][$Page];

/* ---------- Page Header Setup ---------- */
$PageTitle = $GLBLang['PT'];
$PageRel = 'settings';
$AdditionalScripts = '';
require("inc_header.php");
?>

<form method="post" action="page_settings.php">
<div class="ad_col_half">
	<div class="padRight10">
        <!--Left Column Content Start-->
        <div class="ad_mod_wrap">
            <div class="ad_mod_header">
                <?php echo $GLBLang['sub1'];?>
            </div>
            <div class="ad_mod_content">
            	<div class="ad_mod_row_full">
            		<p><strong><?php echo $GLBLang['sub2'];?>:</strong> <?php echo $GLB_Domain;?></p>
                    <p><strong><?php echo $GLBLang['sub3'];?>:</strong> <?php echo $GLB_Domain.'/'.$uploadpath;?></p>
                </div>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub4'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <input type="text" id="s_SiteName" name="s_SiteName" value="<?php echo $s_SiteName;?>"/>
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub5'];?>:</strong> <a href="javascript:void(0);" onclick="BrowseServer('s_LogoURL');"><?php echo $GLBLang['btn1'];?></a>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <input type="text" id="s_LogoURL" name="s_LogoURL" value="<?php echo $s_LogoURL;?>"/>
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub6'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <input type="text" id="s_ContactEmail" name="s_ContactEmail" value="<?php echo $s_ContactEmail;?>"/>
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub7'];?>:</strong> <em>(EX: 10M or 10G | M=Megabyte, G=Gigabyte)</em>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <input type="text" id="s_MaxFileSize" name="s_MaxFileSize" value="<?php echo $s_MaxFileSize;?>"/>
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub8'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <input type="text" id="s_BlogRollCount" name="s_BlogRollCount" value="<?php echo $s_BlogRollCount;?>"/>
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub9'];?>:</strong> <em>(Optional)</em>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <input type="text" id="s_IndexURL" name="s_IndexURL" value="<?php echo $s_IndexURL;?>"/>
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
                <?php echo $GLBLang['sub10'];?>
            </div>
            <div class="ad_mod_content">
            	<div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub11'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <textarea id="s_GATracking" name="s_GATracking"><?php echo stripslashes($s_GATracking);?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="ad_mod_wrap">
            <div class="ad_mod_header">
                <?php echo $GLBLang['sub12'];?>
            </div>
            <div class="ad_mod_content">
            	<div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub13'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                	<div class="ad_mod_whiteWrap">
                    	<select id="s_LangSet" name="s_LangSet"><?php echo $LangList;?></select>
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <strong><?php echo $GLBLang['sub14'];?>:</strong>
                </div>
                <div class="ad_mod_row_full">
                    <input id="s_ApproveComments" name="s_ApproveComments" type="checkbox" <?php if($s_ApproveComments==1){echo 'checked="checked"';}?> value="1" /> <?php echo $GLBLang['sub15'];?>
                </div>
            </div>
        </div>
        <!--Right Column Content End-->
    </div>
</div>

<div class="clear"></div>

<div class="ad_col_full">
    <div class="ad_mod_row_full">
        <input class="form_submit FloatRight" id="s_Submit" name="s_Submit" type="submit" value="<?php echo $GLBLang['btn2'];?>" />
        <div class="clear"></div>
    </div>
</div>
</form>

<?php require("inc_footer.php");?>