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

// Setup general vars ----------------------------------------------------------------------
$SubmitTypes = array('Save','Update','Publish','Unpublish');
$FormType = 'new';
$FormButtons = '
<input class="form_submit FloatRight MarginLeft10" id="SubmitType" name="SubmitType" type="submit" value="'.$GLBLang['btn7'].'" />
<input class="form_submit FloatRight" id="SubmitType" name="SubmitType" type="submit" value="'.$GLBLang['btn8'].'"/>';
$ReloadData = false;
$entryType = $_POST['entryType'];

// Submit Form ----------------------------------------------------------------------
// Here the entry will be inserted into mysql.
if(isset($_POST['SubmitType']) && in_array($_POST['SubmitType'],$SubmitTypes)){
	// Some verification functions
	function strip_html_tags($text){
		// Function provided by:
		// http://nadeausoftware.com/articles/2007/09/php_tip_how_strip_html_tags_web_page
		$text = preg_replace(
			array(
				'@<head[^>]*?>.*?</head>@siu',
				'@<style[^>]*?>.*?</style>@siu',
				'@<script[^>]*?.*?</script>@siu',
				'@<object[^>]*?.*?</object>@siu',
				'@<embed[^>]*?.*?</embed>@siu',
				'@<applet[^>]*?.*?</applet>@siu',
				'@<noframes[^>]*?.*?</noframes>@siu',
				'@<noscript[^>]*?.*?</noscript>@siu',
				'@<noembed[^>]*?.*?</noembed>@siu',
				'@</?((address)|(blockquote)|(center)|(del))@iu',
				'@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
				'@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
				'@</?((table)|(th)|(td)|(caption))@iu',
				'@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
				'@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
				'@</?((frameset)|(frame)|(iframe))@iu',
			),
			array(
				' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
				"\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
				"\n\$0", "\n\$0",
			),
			$text );
		return strip_tags($text);
	}
	function alphaNumSpe($str){
		return preg_replace("/[^A-Za-z0-9_,.?!@:\&\-_\='\"\/ ]/","", $str);
	}
	function keywords($str){
		return preg_replace("/[^A-Za-z0-9,\- ]/","", $str);
	}
	function webSafeTitle($str){
		return str_replace(" ","_",preg_replace("/[^A-Za-z0-9\- ]/","", $str));
	}
	function removeSquareBrackets($str){
		return preg_replace('/\[.*?\]/', '', $str);
	}
	
	// Connect to MySql
	$DLINK = MySqlConnect();
	
	// Get post items
	$entryID = $_POST['entryID'];
	$entryTitle = removeSquareBrackets($_POST['entryTitle']);
	$entryWebSafeTitle = webSafeTitle($entryTitle);
	$entryEditor = str_ireplace('\r\n', '', $_POST['entryEditor']);
	$entrySplashImg = removeSquareBrackets($_POST['entrySplashImg']);
	$entryCate = $_POST['entryCate'];
	$entryKeywords = keywords(removeSquareBrackets($_POST['entryKeywords']));
	$entryDescription = removeSquareBrackets($_POST['entryDescription']);
	$entryComments = $_POST['entryComments'];
	
	if($_POST['MakeHome']==1){
		$entryMakeHome = $_POST['MakeHome'];
	}else{
		$entryMakeHome = 0;
	}
	// Check if content and title are set
	if($entryTitle == "" || $entryEditor == ""){
		$GLB_PG_Error = true;
		$GLB_PG_ErrorMsg .= $GLBLang['msg1'].'<br />';
	}
	
	$entryWebSafeTitle = mysql_real_escape_string($entryWebSafeTitle);
	$TitleQuery = mysql_query("SELECT * FROM IDCMS_Entries WHERE WebsafeTitle='$entryWebSafeTitle' AND Active='1' AND ID!='$entryID' LIMIT 1");
	$TitleExist = mysql_num_rows($TitleQuery);
	if($TitleExist>0){
		$GLB_PG_Error = true;
		$GLB_PG_ErrorMsg .= $GLBLang['msg2'].'<br />';
	}
	
	// Insert or Update Information
	if(!$GLB_PG_Error){
		
		if(strlen($entryEditor)>300){
			$entryExcerpt = substr(strip_html_tags($_POST['entryEditor']),0,300).'...';
		}else{
			$entryExcerpt = strip_html_tags($_POST['entryEditor']);
		}
		if($_POST['AuGenDes']==1){
			// Generate description from content
			if(strlen($entryExcerpt)>150){
				$entryDescription = substr($entryExcerpt,0,150).'...';
			}else{
				$entryDescription = $entryExcerpt;
			}
		}
		if(!preg_match("/^[0-1]+$/", $entryComments)||$entryType=="page") {
			$entryComments = 0;
		}
		
		// Escape strings
		$entryID = mysql_real_escape_string($entryID);
		$entryTitle = mysql_real_escape_string($entryTitle);
		//$entryWebSafeTitle = mysql_real_escape_string($entryWebSafeTitle);
		$entrySplashImg = mysql_real_escape_string($entrySplashImg);
		$entryKeywords = mysql_real_escape_string($entryKeywords);
		$entryDescription = mysql_real_escape_string($entryDescription);
		$entryDateStamp = date("Y-m-d H:i:s");
		$FinishType = $_POST['SubmitType'];
		
		// Prepare for mysql
		switch($_POST['SubmitType']){
			case 'Save':
				$SQL = "INSERT INTO IDCMS_Entries
			(AuthorID,Type,Home,SplashImgURL,WebsafeTitle,Title,Content,Excerpt,Keywords,Description,Date,RemoveComments)
				VALUES
				('$log_ID','$entryType','$entryMakeHome','$entrySplashImg','$entryWebSafeTitle','$entryTitle','$entryEditor',
				 '$entryExcerpt','$entryKeywords','$entryDescription','$entryDateStamp','$entryComments')";
				$SucTxt = $GLBLang['msg3'];
			break;
			case 'Update':
				$SQL = "UPDATE IDCMS_Entries
				SET Home='$entryMakeHome', SplashImgURL='$entrySplashImg', WebsafeTitle='$entryWebSafeTitle', Title='$entryTitle',
				Content='$entryEditor', Excerpt='$entryExcerpt', Keywords='$entryKeywords', Description='$entryDescription', UpdateDate='$entryDateStamp',
				RemoveComments='$entryComments'
				WHERE ID='$entryID' AND Type='$entryType'";
				$SucTxt = $GLBLang['msg4'];
			break;
			case 'Publish':
				$EntryQuery = mysql_query("SELECT * FROM IDCMS_Entries WHERE ID='$entryID' LIMIT 1");
				$Exist = mysql_num_rows($EntryQuery);
				if($Exist>0){
					$SQL = "UPDATE IDCMS_Entries
					SET Publish='1' WHERE ID='$entryID' AND Type='$entryType'";
					$SucTxt = $GLBLang['msg5'];
					$FinishType = 'Publish';
				}else{
					$SQL = "INSERT INTO IDCMS_Entries
					(AuthorID,Type,Home,SplashImgURL,WebsafeTitle,Title,Content,Excerpt,Keywords,Description,Date,RemoveComments,Publish)
					VALUES
					('$log_ID','$entryType','$entryMakeHome','$entrySplashImg','$entryWebSafeTitle','$entryTitle','$entryEditor',
					 '$entryExcerpt','$entryKeywords','$entryDescription','$entryDateStamp','$entryComments','1')";
					$SucTxt = $GLBLang['msg6'];
					$FinishType = 'SavePublish';
				}
			break;
			case 'Unpublish':
				$SQL = "UPDATE IDCMS_Entries
				SET Publish='0' WHERE ID='$entryID' AND Type='$entryType'";
				$SucTxt = $GLBLang['msg7'];
			break;
		}
		
		// Run MySql command
		if($entryMakeHome==1 && $entryType=="page"){
			mysql_query("UPDATE IDCMS_Entries SET Home='0' WHERE Home='1'");
		}
		
		if(mysql_query($SQL)){
			if(isset($entryCate)){
				if(is_array($entryCate)){
					mysql_query("DELETE FROM IDCMS_CateLinks WHERE PostID='$entryID'");
					foreach($entryCate as $value){
						if($value!=0&&$value!=''){
							mysql_query("INSERT INTO IDCMS_CateLinks (PostID,CateID) VALUES ('$entryID','$value')");
						}
					}
				}
			}
			
			$GLB_PG_Success = true;
			$GLB_PG_SuccessMsg = $SucTxt;
			
			if($FinishType == 'SavePublish' || $FinishType == 'Save'){
				$entryID = mysql_insert_id($DLINK);
			}
		}else{
			$mysqlError = mysql_error();
			$GLB_PG_Error = true;
			$GLB_PG_ErrorMsg = $GLBLang['msg8'];
		}
	}
	mysql_close($DLINK);
	
	$ReloadData = true;
}


// Load Existing Entry ----------------------------------------------------------------------
if(isset($_POST['formType']) && $_POST['formType']=='update' && isset($_POST['entryID']) && $_POST['entryID']!='' ||
$ReloadData){
	
	// Connect to MySql and get data
	$DLINK = MySqlConnect();
	
	$FormType = 'update';
	
	if(isset($_POST['entryID']) && $_POST['entryID']!='' && preg_match("/^[0-9]+$/", $_POST['entryID'])){
		$entryID = mysql_escape_string($_POST['entryID']);
	}
	
	$EntryQuery = mysql_query("SELECT p.ID, p.AuthorID, p.Home, p.SplashImgURL, p.WebsafeTitle, p.Title, p.Content, p.Excerpt, p.Description, p.Keywords, p.Date, p.UpdateDate, p.Trashed, p.RemoveComments, p.Publish, a.Fname, a.Lname FROM IDCMS_Entries p
		INNER JOIN IDCMS_Authors a
	ON p.AuthorID=a.ID
		WHERE p.ID='$entryID' AND p.Active='1' LIMIT 1");
	$CateQuery = mysql_query("SELECT * FROM IDCMS_Categories ORDER BY Name ASC");
	$Exist = mysql_num_rows($EntryQuery);
	
	// If data exist, continue
	if($Exist>0){
		$E = mysql_fetch_array($EntryQuery);
		$entryID = $E['ID'];
		$entryAuthorID = $E['AuthorID'];
		$entryMakeHome = $E['Home'];
		$entrySplashImg = $E['SplashImgURL'];
		$entryWebSafeTitle = $E['WebsafeTitle'];
		$entryTitle = $E['Title'];
		$entryEditor = $E['Content'];
		$entryDescription = stripslashes($E['Description']);
		$entryKeywords = stripslashes($E['Keywords']);
		$entryDate = $E['Date'];
		$entryComments = $E['RemoveComments'];
		$entryPublish = $E['Publish'];
		$userFname = $E['Fname'];
		$userLname = $E['Lname'];
		
		// Prepare all linked categories with this entry
		$CateCount = mysql_num_rows($CateQuery);
		if($CateCount>0){
			while($C = mysql_fetch_array($CateQuery)){
				$CateID = $C['ID'];
				
				$CateEntryLink = mysql_num_rows(mysql_query("SELECT * FROM IDCMS_CateLinks
				WHERE PostID='$entryID' AND CateID='$CateID' LIMIT 1"));
				$CateChecked = '';
				
				if($CateEntryLink>0){
					$CateChecked = ' checked="checked" ';
				}
				
				$CateList .= '<div class="FloatLeft padding5">
					<input id="entryCate[]" name="entryCate[]" type="checkbox"'.$CateChecked.'value="'.$CateID.'" /> '.ucwords(strtolower(stripslashes($C['Name']))).'
				</div>';
			}
		}else{
			$CateList = '<strong>'.$GLBLang['msg9'].'</strong>';
		}

		// Get all comments for this entry
		$CommenteQuery = mysql_query("SELECT * FROM IDCMS_Comments WHERE EntryID='$entryID' AND Active='1' ORDER BY ID DESC",$DLINK);
		$CommentExist = mysql_num_rows($CommenteQuery);
		if($CommentExist>0){
			while($Com = mysql_fetch_array($CommenteQuery)){
				$com_ID = $Com['ID'];
				$com_Avatar = $GLBFunc->getGravatar($Com['Email'],40,'identicon','pg',array('class'=>'comment_avatar'));
				$com_Username = stripslashes($Com['Username']);
				$com_Email = $Com['Email'];
				$com_Comment = nl2br(stripslashes($Com['Comment']));
				$com_Date = $GLBFunc->formatDate($Com['Date'])." at ".$GLBFunc->formatTime($Com['Date']);
				
				if($Com['WebURL']==''){
					$com_AvUser = ''.$com_Avatar.'<br /><br />
					'.$com_Username.'<br />';
				}else{
					$com_AvUser = '<a href="'.$Com['WebURL'].'" target="_blank">'.$com_Avatar.'<br /><br />
					'.$com_Username.'</a><br />';
				}
				
				if($log_Role=='admin'||$log_Role=='manager' || $log_ID==$entryAuthorID){
					if($Com['Approved']==0){
						$com_Btns = '<div id="Combtn'.$com_ID.'" class="FloatRight" style="text-align:right;">
						<a href="javascript:void(0);" onclick="updatedComment(\''.$com_ID.'\')">'.$GLBLang['btn1'].'</a><br />
						<a href="javascript:void(0);" onclick="deleteComment(\''.$com_ID.'\')">'.$GLBLang['btn2'].'</a>
						</div>';
					}else{
						$com_Btns = '<div id="Combtn'.$com_ID.'" class="FloatRight" style="text-align:right;">
						<a href="javascript:void(0);" onclick="updatedComment(\''.$com_ID.'\')">'.$GLBLang['btn3'].'</a><br />
						<a href="javascript:void(0);" onclick="deleteComment(\''.$com_ID.'\')">'.$GLBLang['btn2'].'</a>
						</div>';
					}
				}else{
					$com_Btns = '';
				}
				
				$Comments .= '<div id="Combox'.$com_ID.'" class="padTop10">
					<div class="FloatLeft marRight10 marBot10 padLeft10 padBot10 padRight10 roundedCornersBR5 BGGradient" style="font-size:11px;">
						'.$com_Btns.'
						<input id="CID[]" name="CID[]" type="checkbox" value="'.$com_ID.'" /><br /><br />
						'.$com_AvUser.'
						<a href="mailto:'.$com_Email.'">'.$com_Email.'</a><br />
						'.$com_Date.'
					</div>
					<div>
						'.$com_Comment.'
					</div>
					<div class="clear"></div>
					<hr/>
				</div>';
			}
		}else{
			$Comments = $GLBLang['msg10'];
		}
		
		// Check if user has access
		$DoesUserHaveAccess = false;
		$RoleCheck = array('admin','manager');
		if($log_ID==$entryAuthorID || in_array($log_Role,$RoleCheck)){
			$DoesUserHaveAccess = true;
		}
		
		if(!$DoesUserHaveAccess){
			$GLB_PG_Error = true;
			$GLB_PG_ErrorMsg .= $GLBLang['msg11'];
			
			unset($entryID, $entryAuthorID, $entrySplashImg, $entryTitle, $entryEditor, $entryDescription, $entryKeywords, $entryDate, $entryComments, $entryPublish, $entryActive, $userFname, $userLname);
		}
		
		// Finish preparing menu
		if($entryPublish>0){
			$btnPublish = $GLBLang['btn4'];
		}else{
			$btnPublish = $GLBLang['btn7'];
		}
		
		$FormButtons = '
		<input class="form_submit FloatRight MarginLeft10" id="SubmitType" name="SubmitType" type="submit" value="'.$btnPublish.'"/>
    	<input class="form_submit FloatRight" id="SubmitType" name="SubmitType" type="submit" value="'.$GLBLang['btn5'].'"/>
		<a class="btnLink FloatLeft" onclick="newEntry(\''.$entryType.'\')">'.$GLBLang['btn6'].'</a>';
		
		mysql_close($DLINK);
	}else{
		$GLB_PG_Error = true;
		$GLB_PG_ErrorMsg .= $GLBLang['msg12'];
		
		$FormType = 'new';
		$FormButtons = '
		<input class="form_submit FloatRight MarginLeft10" id="SubmitType" name="SubmitType" type="submit" value="'.$GLBLang['btn7'].'" />
		<input class="form_submit FloatRight" id="SubmitType" name="SubmitType" type="submit" value="'.$GLBLang['btn8'].'"/>';
	}
}else{
	// Setup Categories ----------------------------------------------------------------------
	$DLINK = MySqlConnect();
	$CateQuery = mysql_query("SELECT * FROM IDCMS_Categories ORDER BY Name ASC");
	$CateCount = mysql_num_rows($CateQuery);
	mysql_close($DLINK);
	if($CateCount>0){
		while($C = mysql_fetch_array($CateQuery)){			
			$CateList .= '<div class="FloatLeft padding5">
				<input id="entryCate[]" name="entryCate[]" type="checkbox" value="'.$C['ID'].'" /> '.ucwords(strtolower(stripslashes($C['Name']))).'
			</div>';
		}
	}else{
		$CateList = '<strong>'.$GLBLang['msg13'].'</strong>';
	}
}


/* ---------- Page Header Setup ---------- */
if(isset($entryTitle)&&$entryTitle!=""){
	$PageTitle = $entryTitle;
	
}else{
	$PageTitle = $GLBLang['PT1'].' '.($entryType=="blog"?$GLBLang['PT2']:$GLBLang['PT3']);
}
$PageRel = ($entryType=="blog"?'blogentry':'page');

$AdditionalScripts = '
<script type="text/javascript" src="_ckeditor/ckeditor.js"></script>
';

require("inc_header.php");
?>

<?php if($FormType=='update' && $log_ID!=$entryAuthorID){?>
<div class="ad_row_full">
	<?php echo $GLBLang['sub1'];?>: <?php echo ucwords(strtolower($userFname.' '.$userLname));?>
</div>
<?php }?>

<form action="page_newEntry.php" method="post">
<input id="entryID" name="entryID" type="hidden" value="<?php echo $entryID;?>" />
<input id="entryType" name="entryType" type="hidden" value="<?php echo $entryType;?>" />

<div class="ad_row_full">
	<?php if($entryType=="page"){?>
    <input id="MakeHome" name="MakeHome" type="checkbox" <?php if($entryMakeHome=="1"){echo'checked="checked"';}?> value="1" /> <?php echo $GLBLang['sub2'];?> | 
	<?php }?>
    <strong><?php echo $GLBLang['sub3'];?>:</strong> <em style="color:#999;"><?php
    if($entryID>0){
		if($entryMakeHome){
			$DirectEntryURL = "http://".$GLB_Domain;
		}else{
			$DirectEntryURL = "http://".$GLB_Domain."/".($entryType=="blog"?'blog':'page')."/".$entryWebSafeTitle;
		}
		echo '<a href="'.$DirectEntryURL.'" target="_blank">'.$DirectEntryURL.'</a>';
	}else{
		echo $GLBLang['sub4'];
	}
	?></em>
</div>

<div class="ad_col_left">
	<!--Main Content Start-->
    <div class="ad_row_full">
    	<?php echo $FormButtons;?>
        <div class="clear"></div>
    </div>
    <div class="ad_row_full">
        <div class="ad_mod_whiteWrap">
            <input id="entryTitle" name="entryTitle" type="text" value="<?php echo stripslashes($entryTitle);?>" />
        </div>
    </div>
    <div class="ad_row_full">
    	<?php if($Platform=='mobile'){?>
        <div class="ad_mod_whiteWrap">
            <textarea id="entryEditor" name="entryEditor"><?php echo $entryEditor;?></textarea>
        </div>
        <?php }else{?>
        <textarea id="entryEditor" name="entryEditor"><?php echo $entryEditor;?></textarea>
        <?php }?>
    </div>
    <div class="ad_row_full">
    	<?php echo $FormButtons;?>
        <div class="clear"></div>
    </div>
    <?php if($entryType=="blog"){?>
    <div class="ad_mod_wrap">
        <div class="ad_mod_header">
            <?php echo $GLBLang['sub5'];?>
        </div>
        <div class="ad_mod_content">
            <div class="ad_mod_row_full">
                <input class="form_submit" onclick="deleteSelectedComments()" type="button" value="<?php echo $GLBLang['btn9'];?>"/>
            	<div class="FloatRight">
                	<input id="entryComments" name="entryComments" type="checkbox" value="1" <?php if($entryComments){echo 'checked="checked"';}?> /> <?php echo $GLBLang['sub6'];?>.
                </div>
            </div>
            <hr/>
            <div class="ad_mod_row_full">
            	<?php echo $Comments;?>
            </div>
        </div>
    </div>
    <?php }?>
    <!--Main Content End-->
</div>

<div class="ad_col_right">
	<div class="padLeft10 padBot10" id="RightBar">
    	<!--Right Column Content Start-->
        <div class="ad_mod_wrap">
        	<div class="ad_mod_header">
            	<?php echo $GLBLang['sub7'];?>
            </div>
            <div class="ad_mod_content">
            	<div class="ad_mod_row_full">
                	<?php echo $GLBLang['sub8'];?>:<br /><br />
                	<div class="ad_mod_whiteWrap">
                        <input id="entrySplashImg" name="entrySplashImg" type="text" value="<?php echo $entrySplashImg;?>" />
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <input class="form_submit FloatRight" type="button" value="<?php echo $GLBLang['btn10'];?>" onclick="BrowseServer('entrySplashImg');"/>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <?php if($entryType=="blog"){?>
        <div class="ad_mod_wrap">
        	<div class="ad_mod_header">
            	<?php echo $GLBLang['sub9'];?>
            </div>
            <div class="ad_mod_content">
            	<div class="ad_mod_row_full">
                	<?php echo $CateList;?>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <?php }?>
    	<div class="ad_mod_wrap">
        	<div class="ad_mod_header">
            	<?php echo $GLBLang['sub10'];?>
            </div>
            <div class="ad_mod_content">
            	<div class="ad_mod_row_full">
                	<div class="ad_mod_whiteWrap">
                		<textarea id="entryKeywords" name="entryKeywords"><?php echo $entryKeywords;?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="ad_mod_wrap">
        	<div class="ad_mod_header">
            	<?php echo $GLBLang['sub11'];?>
            </div>
            <div class="ad_mod_content">
            	<div class="ad_mod_row_full">
                	<input id="AuGenDes" name="AuGenDes" type="checkbox" value="1" /> <?php echo $GLBLang['sub12'];?><br /><br />
                	<div class="ad_mod_whiteWrap">
                		<textarea id="entryDescription" name="entryDescription"><?php echo $entryDescription;?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <!--Right Column Content End-->
    </div>
</div>

<div class="clear"></div>
</form>

<?php require("inc_footer.php");?>