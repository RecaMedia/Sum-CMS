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
/*
CUSTOMIZABLE CODE:
Look for [Editable Block]
-------------------
1. Custom Contact Form
2. Social Icons

****YOU MAY EDIT THIS FILE AS YOU LIKE AT YOUR OWN RISK.****
For additional information please visit dev.sumcms.com

*/
/* Setup Essentials -------------------- */
require_once("Admin/inc_MySQL.php");
require("Admin/class_global.php");
$GLBFunc = new GlobeFunc($GLB_DB_SET);
$BLD_General = $GLBFunc->getSettings();
$BLD_Content = array();

$BLD_Content['Ready'] = false;
$BLD_Content['Type'] = '';
$BLD_Content['EntryID'] = '';
$BLD_Content['PageURL'] = '';
$BLD_Content['Author'] = '';
$BLD_Content['AuthorEmail'] = '';
$BLD_Content['AuthorURL'] = '';
$BLD_Content['AuthorFacebook'] = '';
$BLD_Content['AuthorTwitter'] = '';
$BLD_Content['AuthorLinkedIn'] = '';
$BLD_Content['AuthorBio'] = '';
$BLD_Content['SplashImgURL'] = '';
$BLD_Content['WebsafeTitle'] = '';
$BLD_Content['Title'] = '';
$BLD_Content['Content'] = '';
$BLD_Content['Excerpt'] = '';
$BLD_Content['Keywords'] = '';
$BLD_Content['Description'] = '';
$BLD_Content['Date'] = '';
$BLD_Content['Paging'] = '';
$BLD_Content['Comments'] = '';
$BLD_Content['RemoveComments'] = '';
$BLD_Content['CommentForm'] = '';
$BLD_Content['CommentWrap'] = $Templates['CommentWrap'];
$BLD_Content['ContactForm'] = '';

$Is_Index = false;
$Is_Page = false;
$Is_Blog = false;
$Is_BlogEntry = false;
$Is_Contact = false;

$BLD_Captcha = '
<table style="width:166px; margin-left:auto; margin-right:auto;" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
    		<img id="captchaIMG" style="width:100%; height:auto;" border="0" src="captcha/securimage_show.php?sid='.md5(time()).'" alt="Image Code" />
		</td>
		<td style="width:22px;">
			<script type="text/javascript" src="captcha/swfobject_orig.js"></script>
			<div id="playword"></div>
			<script type="text/javascript">
				// <![CDATA[
				var so = new SWFObject("captcha/securimage_play.swf?audio=captcha/securimage_play.php&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5", "captcha", "19", "19", "9", "");
				so.addParam("quality", "high");
				so.addParam("menu", "false");
				so.addParam("allowScriptAccess", "sameDomain");
				so.addParam("allowFullScreen", "false");
				so.addParam("bgcolor", "#ffffff");
				so.write("playword");
				// ]]>
			</script>
			<a tabindex="-1" style="border-style: none" href="#" title="Refresh Image" onClick="document.getElementById(\'captchaIMG\').src = \'captcha/securimage_show.php?sid=\' + Math.random(); return false"><img src="captcha/images/refresh.gif" alt="Reload Image" border="0" onClick="this.blur()" align="bottom" /></a>
		</td>
    </tr>
</table>';

/* Fill Functions -------------------- */
function runCommentFill($ID){
	global $GLBFunc;
	global $BLD_Content;
	global $Templates;
	
	$DBLink = MySqlConnect();
	
	$CommenteQuery = mysql_query("SELECT * FROM IDCMS_Comments WHERE EntryID='$ID' AND Approved='1' AND Active='1' ORDER BY ID ASC",$DBLink);
	$CommentExist = mysql_num_rows($CommenteQuery);
	
	$BLD_Content['Comments'] = '';
	if($CommentExist>0){
		while($c = mysql_fetch_array($CommenteQuery)){
			if($c['WebURL']==''){
				$cWeb = '#';
			}else{
				$cWeb = $c['WebURL'];
			}
			$Temp = $Templates['CommentTemplate'];
			$Temp = str_replace("[[Avatar]]",$GLBFunc->getGravatar($c['Email'],250,'identicon','pg',array('class'=>'IDCMS_css_avatar')),$Temp);
			$Temp = str_replace("[[Username]]",stripslashes($c['Username']),$Temp);
			$Temp = str_replace("[[Email]]",$c['Email'],$Temp);
			$Temp = str_replace("[[WebURL]]",$cWeb,$Temp);
			$Temp = str_replace("[[Comment]]",nl2br(stripslashes($c['Comment'])),$Temp);
			$Temp = str_replace("[[Date]]",$GLBFunc->formatDate($c['Date'])." at ".$GLBFunc->formatTime($c['Date']),$Temp);
			
			$BLD_Content['Comments'] .= $Temp;
		}
	}else{
		$BLD_Content['Comments'] = "Be the first one to comment!";
	}
	
	mysql_close($DBLink);
}

function runContentFill($Item){
	global $GLBFunc;
	global $BLD_General;
	global $BLD_Content;
	global $BLD_Captcha;
	global $PagingBuild;
	global $Templates;
	
	if($Item=="Blog" || $Item=="BlogCategory"){
		$DBLink = MySqlConnect();
		
		if($Item=="Blog"){
			global $Is_Blog;
			$Is_Blog = true;
			
			$pg = preg_replace("/[^0-9]/","",$_GET['b']);
			
			$SetSQL = "SELECT * FROM IDCMS_Entries
			WHERE Type='blog' AND Publish='1'
				ORDER BY Date DESC";
		}else if($Item=="BlogCategory"){
			global $Is_BlogEntry;
			$Is_BlogEntry = true;
			
			$pg = preg_replace("/[^0-9]/","",$_GET['b']);
			$WebsafeCate = mysql_escape_string($_GET['c']);
			
			$SetSQL = "SELECT e.ID, e.AuthorID, e.Type, e.SplashImgURL, e.WebsafeTitle, e.Title, e.Content, e.Excerpt, e.Keywords, e.Description, e.Date FROM IDCMS_Categories c
			JOIN IDCMS_CateLinks l 
				ON c.ID=l.CateID
			LEFT JOIN IDCMS_Entries e
				ON l.PostID=e.ID
			WHERE c.WebsafeName='$WebsafeCate' AND e.Type='blog' AND e.Publish='1'
				ORDER BY Date DESC";
		}
		
		$rowsPerPage = $BLD_General['BlogRollCount'];
		if (isset($pg) && $pg!= '' && preg_match("/^[0-9]+$/",$pg)){
			$pageNum = $pg;
		}else{
			$pageNum = 1;
		}
		$offset = ($pageNum - 1) * $rowsPerPage;
			
		$CateTotal = mysql_num_rows(mysql_query($SetSQL,$DBLink));
		$CateQuery = mysql_query($SetSQL." LIMIT $offset, $rowsPerPage",$DBLink);
		$CateExist = mysql_num_rows($CateQuery);
		
		// Setup Paging
		$maxPage = ceil($CateTotal/$rowsPerPage);
		$nav = '';
		$pageNav = '';
		$PreURL = $Item=="Blog"?'http://'.$BLD_General['Domain'].'/blog':'http://'.$BLD_General['Domain'].'/blog-category/'.$WebsafeCate;
		for($page = 1; $page <= $maxPage; $page++){
			$URL = $PreURL.'/pg/'.$page;
			if ($page == $pageNum){
				$nav .= str_replace('[[URL]]',$URL,$PagingBuild['beforeLink']).'<strong>'.$page.'</strong>'.$PagingBuild['afterLink'];
			}else{
				$nav .= str_replace('[[URL]]',$URL,$PagingBuild['beforeLink']).$page.$PagingBuild['afterLink'];
			} 
		}
		if($pageNum > 1){
		   $page  = $pageNum - 1;
		   $URL = $PreURL.'/pg/'.$page;
		   $prev  = str_replace('[[URL]]',$URL,$PagingBuild['beforePrev']).$PagingBuild['titlePrev'].$PagingBuild['afterPrev'];
		}else{
		   $prev  = '';
		}
		if ($pageNum < $maxPage){
		   $page = $pageNum + 1;
		   $URL = $PreURL.'/pg/'.$page;
		   $next  = str_replace('[[URL]]',$URL,$PagingBuild['beforeNext']).$PagingBuild['titleNext'].$PagingBuild['afterNext'];
		}else{
		   $next = '';
		}
		if($CateTotal>$rowsPerPage){
			$pageNav = $PagingBuild['startWrap'].$prev.$nav.$next.$PagingBuild['endWrap'];
		}
		$BLD_Content['Paging'] = $pageNav;

		if($CateExist>0){
			$BLD_Content['Ready'] = true;
			$BC_ID = array();
			$BC_PageURL = array();
			$BC_Author = array();
			$BC_AuthorEmail = array();
			$BC_AuthorURL = array();
			$BC_AuthorFacebook = array();
			$BC_AuthorTwitter = array();
			$BC_AuthorLinkedIn = array();
			$BC_AuthorBio = array();
			$BC_SplashImgURL = array();
			$BC_SplashImage = array();
			$BC_WebsafeTitle= array();
			$BC_Title = array();
			$BC_Content = array();
			$BC_Excerpt = array();
			$BC_Date = array();
			while($c = mysql_fetch_array($CateQuery)){
				$AuthorQuery = mysql_query("SELECT * FROM IDCMS_Authors WHERE ID='$c[AuthorID]' LIMIT 1",$DBLink);
				$a = mysql_fetch_array($AuthorQuery);
				
				if($c['SplashImgURL']!=''){
					$imageTag = '<img src="'.$c['SplashImgURL'].'" border="0"/>';
				}else{
					$imageTag = '';
				}
				
				$BLD_Content['Type'] = $c['Type'];
				$BC_ID[] = $c['ID'];
				$BC_PageURL[] = 'http://'.$BLD_General['Domain'].'/blog/'.$c['WebsafeTitle'];
				$BC_Author[] = $a['DisplayName'];
				$BC_AuthorEmail[] = $a['Email'];
				
				$BC_AuthorURL[] = ($a['PersonalURL']==''?'#':$a['PersonalURL']);
				$BC_AuthorFacebook[] = ($a['FacebookURL']==''?'#':$a['FacebookURL']);
				$BC_AuthorTwitter[] = ($a['TwitterURL']==''?'#':$a['TwitterURL']);
				$BC_AuthorLinkedIn[] = ($a['LinkedInURL']==''?'#':$a['LinkedInURL']);
				
				$BC_AuthorBio[] = nl2br(stripslashes($a['Bio']));
				$BC_SplashImgURL[] = $c['SplashImgURL'];
				$BC_SplashImage[] = $imageTag;
				$BC_WebsafeTitle[] = $c['WebsafeTitle'];
				$BC_Title[] = stripslashes($c['Title']);
				$BC_Content[] = stripslashes($c['Content']);
				$BC_Excerpt[] = $c['Excerpt'];
				$BC_Date[] = $GLBFunc->formatDate($c['Date'])." at ".$GLBFunc->formatTime($c['Date']);
			}
			$BLD_Content['EntryID'] = $BC_ID;
			$BLD_Content['PageURL'] = $BC_PageURL;
			$BLD_Content['Author'] = $BC_Author;
			$BLD_Content['AuthorEmail'] = $BC_AuthorEmail;
			$BLD_Content['AuthorURL'] = $BC_AuthorURL;
			$BLD_Content['AuthorFacebook'] = $BC_AuthorFacebook;
			$BLD_Content['AuthorTwitter'] = $BC_AuthorTwitter;
			$BLD_Content['AuthorLinkedIn'] = $BC_AuthorLinkedIn;
			$BLD_Content['AuthorBio'] = $BC_AuthorBio;
			$BLD_Content['SplashImgURL'] = $BC_SplashImgURL;
			$BLD_Content['SplashImage'] = $BC_SplashImage;
			$BLD_Content['WebsafeTitle'] = $BC_WebsafeTitle;
			$BLD_Content['Title'] = $BC_Title;
			$BLD_Content['Content'] = $BC_Content;
			$BLD_Content['Excerpt'] = $BC_Excerpt;
			$BLD_Content['Keywords'] = '';
			$BLD_Content['Description'] = '';
			$BLD_Content['Date'] =  $BC_Date;
		}
		mysql_close($DBLink);
	}else if($Item=="Contact"){
		global $Is_Contact;
		$Is_Contact = true;
		
		$BLD_Content['Ready'] = true;
		
		$BLD_Content['Type'] = 'contact';
		
		$BLD_Content['PageURL'] = $BLD_General['Domain'].'/contact';
		$BLD_Content['Title'] = 'Contact';
		
		$BLD_Content['ContactForm'] = "<a name='cf' id='cf'></a><form action='http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]#cf' method='post'>".$Templates['ContactFormTemplate'].'</form>';
		$BLD_Content['ContactForm'] = str_replace("[[Captcha]]",$BLD_Captcha,$BLD_Content['ContactForm']);

		if(isset($_POST['IDCMS_input_Submit']) && $_POST['IDCMS_input_Submit']=='Contact'){
			// [Editable Block]
			/* ******************** Customize Contact Form ********************* */
			$DBLink = MySqlConnect();
			
			$NoFormError = true;
			
			// Validation Functions
			// Use as many functions as you'd like.
			function alphaNumSpe($str){
				return preg_replace("/[^A-Za-z0-9_,.?!@:\&\-_\='\"\/ ]/","", $str);
			}
			function isValidEmail($em){
				return preg_match("/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)*\.([a-zA-Z]{2,6})$/", $em);
			}
			
			$IDCMS_input_FullName = strip_tags(htmlspecialchars($_POST['IDCMS_input_FullName']));
			$IDCMS_input_Email = strip_tags(htmlspecialchars($_POST['IDCMS_input_Email']));
			$IDCMS_input_Subject = strip_tags(htmlspecialchars($_POST['IDCMS_input_Subject']));
			$IDCMS_input_Comment = strip_tags(htmlspecialchars($_POST['IDCMS_input_Comment']));
			$IDCMS_input_Captcha = strip_tags(htmlspecialchars($_POST['IDCMS_input_Captcha']));
			
			// Check conditions and errors.
			if($IDCMS_input_FullName=='' || $IDCMS_input_Email=='' || $IDCMS_input_Subject==''|| $IDCMS_input_Comment==''){
				$NoFormError = false;
				$FormErrorMsg = 'Please fill in the required fields.';
			}
			
			if(!isValidEmail($IDCMS_input_Email)){
				$NoFormError = false;
				$FormErrorMsg = 'Please enter a valid email.';
			}
			
			// Check if Captcha is correct. Its recommended to keep this feature.
			include('Admin/_captcha/securimage.php');
			$img = new Securimage();
			$CodeValidator = $img->check($IDCMS_input_Captcha);
			if (!$CodeValidator){
				$NoFormError = false;
				$FormErrorMsg = 'Captcha Code was invalid.';
			}
			
			// If no errors proceed.
			if($NoFormError){
				$C_FullName = alphaNumSpe($IDCMS_input_FullName);
				$C_Email = $IDCMS_input_Email;
				$C_Subject = alphaNumSpe($IDCMS_input_Subject);
				$C_Comment = $IDCMS_input_Comment;
				
				$Message = '<html><body>';
				$Message .= '<h3>From: '.$C_FullName.'</h3>';
				$Message .= '<div>'.$C_Comment.'</div>';
				$Message .= '</body></html>';
				
				$Headers = "From: ".$C_Email."\r\n";
				$Headers .= "Reply-To: ".$C_Email."\r\n";
				$Headers .= "MIME-Version: 1.0\r\n";
				$Headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				
				if(mail($BLD_General['ContactEmail'],$C_Subject,$Message,$Headers)){				
					$FormAlert = '<div class="IDCMS_css_alertSuccess">
						<strong>Success!</strong> Your message has been sent.
					</div>';
					$BLD_Content['ContactForm'] = str_replace("[[Alert]]",$FormAlert,$BLD_Content['ContactForm']);
				}else{
					$FormAlert = '<div class="IDCMS_css_alertError">
						<strong>Error!</strong> Message was not able to be sent.
					</div>';
					$BLD_Content['ContactForm'] = str_replace("[[Alert]]",$FormAlert,$BLD_Content['ContactForm']);
				}
			}else{
				$FormAlert = '<div class="IDCMS_css_alertError">
					<strong>Error!</strong>
					'.$FormErrorMsg.'
				</div>';
				$BLD_Content['ContactForm'] = str_replace("[[Alert]]",$FormAlert,$BLD_Content['ContactForm']);
			}
			
			mysql_close($DBLink);
			/* ******************** Customize Contact Form End ********************* */
		}else{
			$BLD_Content['ContactForm'] = str_replace("[[Alert]]","",$BLD_Content['ContactForm']);
		}

		$BLD_Content['Content'] = $BLD_Content['ContactForm'];
	}else{
		global $Is_Page;
		$Is_Page = true;
		
		$DBLink = MySqlConnect();
		$EntryExist = mysql_num_rows($Item);
		if($EntryExist>0){
			$e = mysql_fetch_array($Item);
			$AuthorQuery = mysql_query("SELECT * FROM IDCMS_Authors WHERE ID='$e[AuthorID]' LIMIT 1",$DBLink);
			$a = mysql_fetch_array($AuthorQuery);
			
			$BLD_Content['Ready'] = true;
			
			if($e['Type']=="blog"){
				$BLD_Content['Type'] = "blogentry";
				$BLD_Content['RemoveComments'] = $e['RemoveComments'];
				runCommentFill($e['ID']);
			}else{
				$BLD_Content['Type'] = $e['Type'];
			}
			
			if($e['SplashImgURL']!=''){
				$imageTag = '<img src="'.$e['SplashImgURL'].'" border="0"/>';
			}else{
				$imageTag = '';
			}
			
			$BLD_Content['EntryID'] = $e['ID'];
			$BLD_Content['PageURL'] = 'http://'.$BLD_General['Domain'].'/'.$e['Type'].'/'.$e['WebsafeTitle'];
			$BLD_Content['Author'] = $a['DisplayName'];
			$BLD_Content['AuthorEmail'] = $a['Email'];
			$BLD_Content['AuthorURL'] = ($a['PersonalURL']==''?'#':$a['PersonalURL']);
			$BLD_Content['AuthorFacebook'] = ($a['FacebookURL']==''?'#':$a['FacebookURL']);
			$BLD_Content['AuthorTwitter'] = ($a['TwitterURL']==''?'#':$a['TwitterURL']);
			$BLD_Content['AuthorLinkedIn'] = ($a['LinkedInURL']==''?'#':$a['LinkedInURL']);
			$BLD_Content['AuthorBio'] = nl2br(stripslashes($a['Bio']));
			$BLD_Content['SplashImgURL'] = $e['SplashImgURL'];
			$BLD_Content['SplashImage'] = $imageTag;
			$BLD_Content['WebsafeTitle'] = $e['WebsafeTitle'];
			$BLD_Content['Title'] = stripslashes($e['Title']);
			$BLD_Content['Content'] = stripslashes($e['Content']);
			$BLD_Content['Excerpt'] = $e['Excerpt'];
			$BLD_Content['Keywords'] = $e['Keywords'];
			$BLD_Content['Description'] = $e['Description'];
			$BLD_Content['Date'] = $GLBFunc->formatDate($e['Date'])." at ".$GLBFunc->formatTime($e['Date']);
		}
		mysql_close($DBLink);
	}
}

function runCodeBlock($data){
	$DBLink = MySqlConnect();
	$cbQuery = mysql_query("SELECT * FROM IDCMS_CodeBlocks",$DBLink);
	$cbCount = mysql_num_rows($cbQuery);
	if($cbCount>0){
		while($cb = mysql_fetch_array($cbQuery)){
			$cbTag = "{{".$cb['Tag']."}}";
			$cbCode = stripslashes($cb['Code']);
			$data = str_replace($cbTag,$cbCode,$data);
		}
	}
	return $data;
}

/* Direct Build Functions -------------------- */
function loadIndex(){
	$FullURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$JustDomain = "http://$_SERVER[HTTP_HOST]/";
	
	if($FullURL==$JustDomain){
		global $BLD_General;
		global $Is_Index;
		$Is_Index = true;
		
		$DBLink = MySqlConnect();
		$Query = mysql_query("SELECT * FROM IDCMS_Entries WHERE Type='page' AND Home='1' AND Publish='1' LIMIT 1",$DBLink);
		$HomeExist = mysql_num_rows($Query);
			
		if(isset($BLD_General['IndexURL']) && $BLD_General['IndexURL']!=''){
			mysql_close($DBLink);
			header('Location: '.$BLD_General['IndexURL']);
		}else if($HomeExist>0){
			mysql_close($DBLink);
			runContentFill($Query);
		}else{
			mysql_close($DBLink);
			runContentFill("Blog");
		}
	}
}

/* Get Calls -------------------- */
function get($Item){
	global $BLD_General;
	global $BLD_Content;
	
	switch($Item){
		case "SiteName":
			echo $BLD_General['SiteName'];
		break;
		case "LogoURL":
			echo $BLD_General['LogoURL'];
		break;
		case "Title":
			if($BLD_Content['Type']=="blog"){
				echo "Blog";
			}else{
				echo $BLD_Content['Title'];
			}
		break;
		case "Domain":
			echo $BLD_General['Domain'];
		break;
		case "Keywords":
			echo stripslashes($BLD_Content['Keywords']);
		break;
		case "Description":
			echo stripslashes($BLD_Content['Description']);
		break;
		case "Paging":
			echo $BLD_Content['Paging'];
		break;
		case "CommentForm":
			echo $BLD_Content['CommentForm'];
		break;
		case "GATracking":
			echo stripslashes($BLD_General['GATracking']);
		break;
	}
}

/* Register menus structures -------------------- */
function addSelectedClass($TmpBuildAnchor,$Class){
	$DOM = new DOMDocument();
	$DOM->loadHTML($TmpBuildAnchor);
	$xpath = new DOMXPath($DOM);
	$nodeList = $xpath->query('//a/@class');
	
	if($nodeList->length > 0){
		$Original = $nodeList->item($nodeList->length-1)->value;
		$TmpBuildAnchor = str_replace('class="'.$Original.'"','class="'.$Original.' '.$Class.'"',$TmpBuildAnchor);
	}else{
		if(preg_match('/.*<a\b(?=\s)(?=(?:[^>=]|=\'[^\']*\'|="[^"]*"|=[^\'"][^\s>]*))/',$TmpBuildAnchor,$matches)){
			$Original = $matches[0];
			$TmpBuildAnchor = str_replace($Original,$Original.' class="'.$Class.'" ',$TmpBuildAnchor);
		}
	}
	return $TmpBuildAnchor;
}

function matchedURL($URL){
	$ParsedURL = parse_url($URL);
	$Page = $ParsedURL['path'];
	$Host = $ParsedURL['host'];
	$CurrentPage = $_SERVER['REQUEST_URI'];
	$AtHost = $_SERVER['HTTP_HOST'];
	
	if($Page==''){
		$Page = '/';
	}
	
	if($Page==$CurrentPage) {
		return true;
	}else if($Host==$AtHost && $Page==$CurrentPage){
		return true;
	}else{
		return false;
	}
}

function register_menu($SlotName,$Build){
	global $BLD_General;
	
	$DBLink = MySqlConnect();
	
	$Query = mysql_query("SELECT * FROM IDCMS_Menus WHERE Slot='$SlotName' LIMIT 1",$DBLink);
	$Exist = mysql_num_rows($Query);
	if($Exist>0){
		$q = mysql_fetch_array($Query);
		$MenuID = mysql_escape_string($q['ID']);
		$MenuQuery = mysql_query("SELECT * FROM IDCMS_Menus WHERE ID='$MenuID' LIMIT 1",$DBLink);
		$MenuExist = mysql_num_rows($MenuQuery);
		if($MenuExist>0){
			$m = mysql_fetch_array($MenuQuery);
			$MenuTitle = $m['Title'];
			$MenuSlot = $m['Slot'];
			$MenuItemQuery = mysql_query("SELECT * FROM IDCMS_MenuOrder WHERE MenuID='$MenuID' AND ParentID='' ORDER BY ID ASC",$DBLink);
			$MenuItemExist = mysql_num_rows($MenuItemQuery);
			if($MenuItemExist>0){
				$Nav .= $Build['startWrap'];
				while($mi = mysql_fetch_array($MenuItemQuery)){
					$Target = $mi['TargetID'];
					$URL = $mi['URL'];
					$Title = $mi['Title'];
					
					$SubItemQuery = mysql_query("SELECT * FROM IDCMS_MenuOrder WHERE MenuID='$MenuID' AND ParentID='$Target' ORDER BY ID ASC",$DBLink)or die(mysql_error());
					$SubItemExist = mysql_num_rows($SubItemQuery);
					$ThereISSubMenu = false;
					if($SubItemExist>0){
						$SubNav = '';
						$ThereISSubMenu = true;
						while($submi = mysql_fetch_array($SubItemQuery)){
							$subTarget = $submi['TargetID'];
							$subURL = $submi['URL'];
							$subTitle = $submi['Title'];
							
							if(isset($subURL)&&$subURL!=""){
								$BuildWithClass = $Build['beforeLink'];
								if(matchedURL($subURL)){
									$BuildWithClass = addSelectedClass($BuildWithClass,$Build['SelectedSubClass']);
								}
								
								$SubNav .= str_replace("[[URL]]",$subURL,$BuildWithClass).
								stripslashes($subTitle).
								$Build['afterLink'];
								
								$BuildWithClass = '';
							}else{
								$subDontAdd = false;
								if($subTarget=="Index"){
									$subPageLink = "http://".$BLD_General['Domain'];
								}else if($subTarget=="Blog"){
									$subPageLink = "http://".$BLD_General['Domain']."/blog";
								}else if($subTarget=="Contact"){
									$subPageLink = "http://".$BLD_General['Domain']."/contact";
								}else if(preg_match("/CAT/i",$subTarget)){
									$subTarget = preg_replace("/CAT/","",$subTarget);							
									$subSingleItemQuery = mysql_query("SELECT * FROM IDCMS_Categories WHERE ID='$subTarget' LIMIT 1",$DBLink);
									$subSingleItemExist = mysql_num_rows($subSingleItemQuery);
									if($subSingleItemExist>0){
										$subsi = mysql_fetch_array($subSingleItemQuery);
										$subPageLink = "http://".$BLD_General['Domain']."/blog-category/".$subsi['WebsafeName'];
									}else{
										$subDontAdd = true;
									}
								}else{
									$subSingleItemQuery = mysql_query("SELECT * FROM IDCMS_Entries WHERE ID='$subTarget' AND Active='1' LIMIT 1",$DBLink);
									$subSingleItemExist = mysql_num_rows($subSingleItemQuery);
									if($subSingleItemExist>0){
										$subsi = mysql_fetch_array($subSingleItemQuery);
										$subPageLink = "http://".$BLD_General['Domain']."/".$subsi['Type']."/".$subsi['WebsafeTitle'];
									}else{
										$subDontAdd = true;
									}
								}
								
								if(!$subDontAdd){
									$BuildWithClass = $Build['beforeLink'];
									if(matchedURL($subPageLink)){
										$BuildWithClass = addSelectedClass($BuildWithClass,$Build['SelectedSubClass']);
									}
									
									$SubNav .= str_replace("[[URL]]",$subPageLink,$BuildWithClass).
									stripslashes($subTitle).
									$Build['afterLink'];
									
									$BuildWithClass = '';
								}
							}
						}
					}else{
						$SubNav = '';
					}
					
					if(isset($URL)&&$URL!=""){
						$TmpBuildAnchor .= $ThereISSubMenu ? $Build['startSubWrap']:$Build['beforeLink'];
						if(matchedURL($URL)){
							$TmpBuildAnchor = addSelectedClass($TmpBuildAnchor,$Build['SelectedClass']);
						}
							
						$Nav .= $ThereISSubMenu ?
						str_replace("[[URL]]",$URL,$TmpBuildAnchor).
						stripslashes($Title).
						$Build['midSubWrap']
						:
						str_replace("[[URL]]",$URL,$TmpBuildAnchor).
						stripslashes($Title).
						$Build['afterLink'];
						
						$TmpBuildAnchor = '';
					}else{
						$DontAdd = false;
						if($Target=="Index"){
							$PageLink = "http://".$BLD_General['Domain'];
						}else if($Target=="Blog"){
							$PageLink = "http://".$BLD_General['Domain']."/blog";
						}else if($Target=="Contact"){
							$PageLink = "http://".$BLD_General['Domain']."/contact";
						}else if(preg_match("/CAT/i",$Target)){
							$Target = preg_replace("/CAT/","",$Target);							
							$SingleItemQuery = mysql_query("SELECT * FROM IDCMS_Categories WHERE ID='$Target' LIMIT 1",$DBLink);
							$SingleItemExist = mysql_num_rows($SingleItemQuery);
							if($SingleItemExist>0){
								$si = mysql_fetch_array($SingleItemQuery);
								$PageLink = "http://".$BLD_General['Domain']."/blog-category/".$si['WebsafeName'];
							}else{
								$DontAdd = true;
							}
						}else{
							$SingleItemQuery = mysql_query("SELECT * FROM IDCMS_Entries WHERE ID='$Target' AND Active='1' LIMIT 1",$DBLink);
							$SingleItemExist = mysql_num_rows($SingleItemQuery);
							if($SingleItemExist>0){
								$si = mysql_fetch_array($SingleItemQuery);
								$PageLink = "http://".$BLD_General['Domain']."/".$si['Type']."/".$si['WebsafeTitle'];
							}else{
								$DontAdd = true;
							}
						}
						
						if(!$DontAdd){
							$TmpBuildAnchor .= $ThereISSubMenu ? $Build['startSubWrap']:$Build['beforeLink'];
							if(matchedURL($PageLink)){
								$TmpBuildAnchor = addSelectedClass($TmpBuildAnchor,$Build['SelectedClass']);
							}
							
							$Nav .= $ThereISSubMenu ?
							str_replace("[[URL]]",$PageLink,$TmpBuildAnchor).
							stripslashes($Title).
							$Build['midSubWrap']
							:
							str_replace("[[URL]]",$PageLink,$TmpBuildAnchor).
							stripslashes($Title).
							$Build['afterLink'];
							
							$TmpBuildAnchor = '';
						}
					}
					
					$Nav .= $ThereISSubMenu?$SubNav.$Build['endSubWrap']:'';				
				}
				$Nav .= $Build['endWrap'];
				echo $Nav;
			}
		}
	}
	
	mysql_close($DBLink);
}

/* Print dynamic pages -------------------- */
function print_content(){
	global $BLD_General;
	global $BLD_Content;
	global $Templates;
	
	if($BLD_Content['Ready']){
		switch($BLD_Content['Type']){
			case "blog":
				for($i=0;$i<count($BLD_Content['Content']);$i++){
					$Temp = $Templates['BlogTemplate'];
					$Temp = str_replace("[[Author]]",$BLD_Content['Author'][$i],$Temp);
					$Temp = str_replace("[[AuthorEmail]]",$BLD_Content['AuthorEmail'][$i],$Temp);
					$Temp = str_replace("[[AuthorURL]]",$BLD_Content['AuthorURL'][$i],$Temp);
					$Temp = str_replace("[[AuthorFacebook]]",$BLD_Content['AuthorFacebook'][$i],$Temp);
					$Temp = str_replace("[[AuthorTwitter]]",$BLD_Content['AuthorTwitter'][$i],$Temp);
					$Temp = str_replace("[[AuthorLinkedIn]]",$BLD_Content['AuthorLinkedIn'][$i],$Temp);
					$Temp = str_replace("[[AuthorBio]]",$BLD_Content['AuthorBio'][$i],$Temp);
					$Temp = str_replace("[[PageURL]]",$BLD_Content['PageURL'][$i],$Temp);
					$Temp = str_replace("[[SplashImgURL]]",$BLD_Content['SplashImgURL'][$i],$Temp);
					$Temp = str_replace("[[WebsafeTitle]]",$BLD_Content['WebsafeTitle'][$i],$Temp);
					$Temp = str_replace("[[Title]]",$BLD_Content['Title'][$i],$Temp);
					$Temp = str_replace("[[Excerpt]]",$BLD_Content['Excerpt'][$i],$Temp);
					$Temp = str_replace("[[Date]]",$BLD_Content['Date'][$i],$Temp);
					$Temp = str_replace("[[Paging]]",$BLD_Content['Paging'][$i],$Temp);
					$Temp = str_replace("[[Content]]",$BLD_Content['Content'][$i],$Temp);
					$Temp = runCodeBlock($Temp);
					
					$FinalPrint .= $Temp;
				}
			break;
			case "blogentry":
				$Temp = $Templates['BlogEntryTemplate'];
				$Temp = str_replace("[[Author]]",$BLD_Content['Author'],$Temp);
				$Temp = str_replace("[[AuthorEmail]]",$BLD_Content['AuthorEmail'],$Temp);
				$Temp = str_replace("[[AuthorURL]]",$BLD_Content['AuthorURL'],$Temp);
				$Temp = str_replace("[[AuthorFacebook]]",$BLD_Content['AuthorFacebook'],$Temp);
				$Temp = str_replace("[[AuthorTwitter]]",$BLD_Content['AuthorTwitter'],$Temp);
				$Temp = str_replace("[[AuthorLinkedIn]]",$BLD_Content['AuthorLinkedIn'],$Temp);
				$Temp = str_replace("[[AuthorBio]]",$BLD_Content['AuthorBio'],$Temp);
				$Temp = str_replace("[[PageURL]]",$BLD_Content['PageURL'],$Temp);
				$Temp = str_replace("[[SplashImgURL]]",$BLD_Content['SplashImgURL'],$Temp);
				$Temp = str_replace("[[WebsafeTitle]]",$BLD_Content['WebsafeTitle'],$Temp);
				$Temp = str_replace("[[Title]]",$BLD_Content['Title'],$Temp);
				$Temp = str_replace("[[Excerpt]]",$BLD_Content['Excerpt'],$Temp);
				$Temp = str_replace("[[Date]]",$BLD_Content['Date'],$Temp);			
				// [Editable Block]
				/* ******************** Customize Social Icons ********************* */
				$BLD_SocialIcons = '<table border="0" cellspacing="0" cellpadding="3">
				<tr>
					<td>
						<a class="IDCMS_css_iconFB" href="javascript:void(0);" onclick="javascript:window.open(\'https://www.facebook.com/sharer/sharer.php?u=\' + location.href, \'sharer\', \'width=626,height=436\');return false;"></a>
					</td>
					<td>
						<a class="IDCMS_css_iconGP" href="https://plus.google.com/share?url=http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" onclick="javascript:window.open(this.href,
				\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;"></a>
					</td>
					<td>
						<a target="_blank" href="http://twitter.com/home?status=http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" class="IDCMS_css_iconTW"></a>
					</td>
					<td>
						<a class="IDCMS_css_iconPN" href="javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;http://assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());" target="_blank"></a>
					</td>
				</tr>
				</table>';
				$Temp = str_replace("[[SocialShare]]",$BLD_SocialIcons,$Temp);
				/* ******************** Customize Social Icons End ********************* */
				$Temp = str_replace("[[Content]]",$BLD_Content['Content'],$Temp);
				$Temp = runCodeBlock($Temp);
				
				if($BLD_Content['RemoveComments']==0){
					$Temp = str_replace("[[Comments]]",$BLD_Content['Comments'],$Temp);
					$Temp = str_replace("[[CommentForm]]",$BLD_Content['CommentForm'],$Temp);
					$Temp = str_replace("[[CommentWrap]]",$BLD_Content['CommentWrap'],$Temp);
				}else{
					$Temp = str_replace("[[Comments]]","",$Temp);
					$Temp = str_replace("[[CommentForm]]","",$Temp);
					$Temp = str_replace("[[CommentWrap]]","",$Temp);
				}
				
				$FinalPrint = $Temp;
			break;
			case "page":
				$Temp = $Templates['PageTemplate'];
				$Temp = str_replace("[[PageURL]]",$BLD_Content['PageURL'],$Temp);
				$Temp = str_replace("[[SplashImgURL]]",$BLD_Content['SplashImgURL'],$Temp);
				$Temp = str_replace("[[WebsafeTitle]]",$BLD_Content['WebsafeTitle'],$Temp);
				$Temp = str_replace("[[Title]]",$BLD_Content['Title'],$Temp);
				$Temp = str_replace("[[Excerpt]]",$BLD_Content['Excerpt'],$Temp);
				$Temp = str_replace("[[Date]]",$BLD_Content['Date'],$Temp);
				$Temp = str_replace("[[Content]]",$BLD_Content['Content'],$Temp);
				$Temp = runCodeBlock($Temp);
				
				$FinalPrint = $Temp;
			break;
			case "contact":
				$Temp = $Templates['ContactTemplate'];
				$Temp = str_replace("[[PageURL]]",$BLD_Content['PageURL'],$Temp);
				$Temp = str_replace("[[Title]]",$BLD_Content['Title'],$Temp);
				$Temp = str_replace("[[Content]]",$BLD_Content['Content'],$Temp);
				$Temp = runCodeBlock($Temp);
				
				$FinalPrint = $Temp;
			break;
		}
		echo $FinalPrint;
	}
}

/* System Process -------------------- */

//Director Setup
if(isset($_GET['t']) && $_GET['t']!=''){
	if($_GET['t']=="p"){
		if(isset($_GET['p']) && $_GET['p']!=''){
			//Just Page Entry
			$DBLink = MySqlConnect();
			$Websafe = mysql_escape_string($_GET['p']);
			$EntryQuery = mysql_query("SELECT * FROM IDCMS_Entries WHERE Type='page' AND WebsafeTitle='$Websafe' AND Publish='1' LIMIT 1",$DBLink);
			mysql_close($DBLink);
			runContentFill($EntryQuery);
		}else{
			loadIndex();
		}
	}else if($_GET['t']=="b"){
		if(isset($_GET['c']) && $_GET['c']!=''){
			//Just Blog Entry
			runContentFill("BlogCategory");
		}else if(isset($_GET['p']) && $_GET['p']!=''){
			//Just Page Entry
			$DBLink = MySqlConnect();
			$Websafe = mysql_escape_string($_GET['p']);
			$EntryQuery = mysql_query("SELECT * FROM IDCMS_Entries WHERE Type='blog' AND WebsafeTitle='$Websafe' AND Publish='1' LIMIT 1",$DBLink);
			mysql_close($DBLink);
			runContentFill($EntryQuery);
		}else{
			runContentFill("Blog");
		}
	}else if($_GET['t']=="c"){
		runContentFill("Contact");
	}
}else{
	loadIndex();
}

//Submitted Comments -------------------- */

$BLD_Content['CommentForm'] = "<a name='cf' id='cf'></a><form action='http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]#cf' method='post'>".$Templates['CommentFormTemplate'].'</form>';
$BLD_Content['CommentForm'] = str_replace("[[Captcha]]",$BLD_Captcha,$BLD_Content['CommentForm']);

if(isset($_POST['IDCMS_input_Submit']) && $_POST['IDCMS_input_Submit']=='Comment'){
	$DBLink = MySqlConnect();
	
	$NoFormError = true;
	
	function alphaNumSpe($str){
		return preg_replace("/[^A-Za-z0-9_,.?!@:\&\-_\='\"\/ ]/","", $str);
	}
	function isValidEmail($em){
		return preg_match("/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)*\.([a-zA-Z]{2,6})$/", $em);
	}
	
	if($_POST['IDCMS_input_Username']=='' || $_POST['IDCMS_input_Email']=='' || $_POST['IDCMS_input_Comment']==''){
		$NoFormError = false;
		$FormErrorMsg = 'Please fill in the required fields.';
	}
	
	if(!isValidEmail($_POST['IDCMS_input_Email'])){
		$NoFormError = false;
		$FormErrorMsg = 'Please enter a valid email.';
	}
	
	include('Admin/_captcha/securimage.php');
	$img = new Securimage();
	$CodeValidator = $img->check($_POST['IDCMS_input_Captcha']);
	if (!$CodeValidator){
		$NoFormError = false;
		$FormErrorMsg = 'Captcha Code was invalid.';
	}
	
	if($NoFormError){
		$BC_EntryID = $BLD_Content['EntryID'];
		$BC_Username = mysql_escape_string(alphaNumSpe($_POST['IDCMS_input_Username']));
		$BC_Email = mysql_escape_string(strip_tags($_POST['IDCMS_input_Email']));
		$BC_WebURL = mysql_escape_string(strip_tags($_POST['IDCMS_input_WebURL']));
		$BC_Comment = mysql_escape_string(strip_tags($_POST['IDCMS_input_Comment']));
		$BC_Date = date("Y-m-d H:i:s");
		$BG_Approve = $BLD_General['ApproveComments'];
		
		if(mysql_query("INSERT INTO IDCMS_Comments
		(EntryID, Username, Email, WebURL, Comment, Date, Approved)
		VALUES ('$BC_EntryID','$BC_Username','$BC_Email','$BC_WebURL','$BC_Comment','$BC_Date','$BG_Approve')",$DBLink)){
			runCommentFill($BC_EntryID);
			if($BG_Approve==1){
				$FormSuccessMsg = 'Your comment has been posted.';
			}else{
				$FormSuccessMsg = 'Your comment was submitted for review.';
			}
			$FormAlert = '<div class="IDCMS_css_alertSuccess">
				<strong>Success!</strong>
				'.$FormSuccessMsg.'
			</div>';
		}else{
			$FormAlert = '<div class="IDCMS_css_alertError">
				<strong>Error!</strong>
				Comment was unable to be submitted.
			</div>';
		}
	}else{
		$FormAlert = '<div class="IDCMS_css_alertError">
			<strong>Error!</strong>
			'.$FormErrorMsg.'
		</div>';
	}
	$BLD_Content['CommentForm'] = str_replace("[[Alert]]",$FormAlert,$BLD_Content['CommentForm']);
	
	mysql_close($DBLink);
}else{
	$BLD_Content['CommentForm'] = str_replace("[[Alert]]","",$BLD_Content['CommentForm']);
}

$BLD_Content['CommentWrap'] = str_replace("[[Comments]]",$BLD_Content['Comments'],$BLD_Content['CommentWrap']);
$BLD_Content['CommentWrap'] = str_replace("[[CommentForm]]",$BLD_Content['CommentForm'],$BLD_Content['CommentWrap']);
?>