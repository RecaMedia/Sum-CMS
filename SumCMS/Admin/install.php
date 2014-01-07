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

$s_Domain = $_SERVER['HTTP_HOST'];

if(isset($_POST['s_Submit']) && $_POST['s_Submit']=='Install'){
	// Setup Vars	
	$s_SiteName = $_POST['s_SiteName'];
	$s_Domain = $_POST['s_Domain'];
	$s_Path = $_POST['s_Path'];
	
	$s_db_Host = $_POST['s_db_Host'];
	$s_db_User = $_POST['s_db_User'];
	$s_db_Pass = $_POST['s_db_Pass'];
	$s_db = $_POST['s_db'];
	
	$s_First = $_POST['s_First'];
	$s_Last = $_POST['s_Last'];
	$s_Email = $_POST['s_Email'];
	$s_Pass = $_POST['s_Pass'];
	
	$GLB_PG_Success = false;
	$GLB_PG_Error = false;
	
	// Validation process
	function isValidEmail($emailcheck){
		return preg_match("/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)*\.([a-zA-Z]{2,6})$/", $emailcheck);
	}

	// Start Process
	if($s_SiteName == "" || $s_Domain == "" ||
	   $s_db_Host == "" || $s_db_User == "" || $s_db_Pass == "" || $s_db == "" ||
	   $s_First == "" || $s_Last == "" || $s_Email == "" || $s_Pass == ""){
		$GLB_PG_Error = true;
		$GLB_PG_ErrorMsg .= 'Please fill out all inputs.<br />';
	}
	if(!isValidEmail($s_Email)){
		$GLB_PG_Error = true;
		$GLB_PG_ErrorMsg .= 'Invalid email.<br />';
	}
	
	$DBL = mysql_connect($s_db_Host,$s_db_User,$s_db_Pass, true);
	if($DBL){
		$DB_Select = mysql_select_db($s_db, $DBL);
		if(!$DB_Select){
			$GLB_PG_Error = true;
			$GLB_PG_ErrorMsg .= 'Failed to connect to MySQL: ' . mysqli_connect_error();
		}
	}else{
		$GLB_PG_Error = true;
		$GLB_PG_ErrorMsg .= 'Failed to connect to MySQL: ' . mysqli_connect_error();
	}
	
	$TableCheck = mysql_query('SELECT 1 FROM IDCMS_Authors');
	if($TableCheck !== FALSE){
		$GLB_PG_Error = true;
		$GLB_PG_ErrorMsg .= 'Install already exist.';
	}
	
	// Insert or Update Information
	if (!$GLB_PG_Error){
		$s_SiteName = mysql_real_escape_string($s_SiteName);
		$s_Domain = mysql_real_escape_string($s_Domain);
		$s_Path = mysql_real_escape_string($s_Path);
		
		$s_First = mysql_real_escape_string(ucfirst(strtolower(preg_replace("/[^A-Za-z ]/","", $s_First))));
		$s_Last = mysql_real_escape_string(ucfirst(strtolower(preg_replace("/[^A-Za-z ]/","", $s_Last))));
		$s_DisplayName = $s_First.' '.$s_Last;
		$s_Email = mysql_real_escape_string($s_Email);
		$s_Pass = mysql_real_escape_string($s_Pass);
		$u_DateStamp = date("Y-m-d H:i:s");
		
		
		$fname = "inc_MySQL.php";
		$fhandle = fopen($fname,"r");
		$Content = fread($fhandle,filesize($fname));
		$Content = str_replace("[[Host]]", $s_db_Host, $Content);
		$Content = str_replace("[[User]]", $s_db_User, $Content);
		$Content = str_replace("[[Pass]]", $s_db_Pass, $Content);
		$Content = str_replace("[[DB]]", $s_db, $Content);
		$fhandle = fopen($fname,"w");
		fwrite($fhandle,$Content);
		fclose($fhandle);
		
		$sql="
		CREATE TABLE IDCMS_Authors (
		  ID int(11) NOT NULL auto_increment,
		  Fname varchar(30) NOT NULL,
		  Lname varchar(30) NOT NULL,
		  NickName varchar(30) NOT NULL,
		  DisplayName varchar(30) NOT NULL,
		  Email varchar(75) NOT NULL,
		  Password varchar(30) NOT NULL,
		  PersonalURL varchar(255) NOT NULL,
		  Bio text NOT NULL,
		  FacebookURL varchar(75) NOT NULL,
		  TwitterURL varchar(75) NOT NULL,
		  LinkedInURL varchar(75) NOT NULL,
		  LastLogin datetime default NULL,
		  RegDate datetime NOT NULL,
		  Role varchar(20) NOT NULL,
		  Confirm smallint(1) NOT NULL default '0',
		  Active smallint(1) NOT NULL default '1',
		  PRIMARY KEY  (ID)
		)
		";
		if (mysql_query($sql,$DBL)){
			$GLB_PG_Success = true;
			$GLB_PG_SuccessMsg .= "Authors Table was created.<br/>";
		}else{
			$GLB_PG_Error = true;
			$GLB_PG_ErrorMsg .= "Error: " . mysql_error($DBL) . "<br/>";
		}
		
		$sql2="
		CREATE TABLE IDCMS_CateLinks (
		  PostID bigint(20) NOT NULL,
		  CateID int(11) NOT NULL
		)
		";
		if (mysql_query($sql2,$DBL)){
			$GLB_PG_Success = true;
			$GLB_PG_SuccessMsg .= "Category Links Table was created.<br/>";
		}else{
			$GLB_PG_Error = true;
			$GLB_PG_ErrorMsg .= "Error: " . mysql_error($DBL) . "<br/>";
		}
		
		$sql3="
		CREATE TABLE IDCMS_Categories (
		  ID int(11) NOT NULL auto_increment,
		  Name varchar(60) NOT NULL,
		  WebsafeName varchar(60) NOT NULL,
		  Description tinytext NOT NULL,
		  PRIMARY KEY  (ID)
		)
		";
		if (mysql_query($sql3,$DBL)){
			$GLB_PG_Success = true;
			$GLB_PG_SuccessMsg .= "Categories Table was created.<br/>";
		}else{
			$GLB_PG_Error = true;
			$GLB_PG_ErrorMsg .= "Error: " . mysql_error($DBL) . "<br/>";
		}
		
		$sql4="
		CREATE TABLE IDCMS_CodeBlocks (
		  ID int(11) NOT NULL auto_increment,
		  Name varchar(40) NOT NULL,
		  Tag varchar(40) NOT NULL,
		  Code blob NOT NULL,
		  PRIMARY KEY  (ID)
		)
		";
		if (mysql_query($sql4,$DBL)){
			$GLB_PG_Success = true;
			$GLB_PG_SuccessMsg .= "Code Block Table was created.<br/>";
		}else{
			$GLB_PG_Error = true;
			$GLB_PG_ErrorMsg .= "Error: " . mysql_error($DBL) . "<br/>";
		}
		
		$sql5="
		CREATE TABLE IDCMS_Comments (
		  ID int(11) NOT NULL auto_increment,
		  EntryID int(11) NOT NULL,
		  Username varchar(50) NOT NULL,
		  Email varchar(75) NOT NULL,
		  WebURL tinytext NOT NULL,
		  Comment text NOT NULL,
		  Date datetime NOT NULL,
		  Approved smallint(1) NOT NULL default '0',
		  Active smallint(1) NOT NULL default '1',
		  PRIMARY KEY  (ID)
		)
		";
		if (mysql_query($sql5,$DBL)){
			$GLB_PG_Success = true;
			$GLB_PG_SuccessMsg .= "Comments Table was created.<br/>";
		}else{
			$GLB_PG_Error = true;
			$GLB_PG_ErrorMsg .= "Error: " . mysql_error($DBL) . "<br/>";
		}
		
		$sql6="
		CREATE TABLE IDCMS_Entries (
		  ID bigint(20) NOT NULL auto_increment,
		  AuthorID int(11) NOT NULL,
		  Type varchar(20) NOT NULL,
		  Home smallint(1) NOT NULL default '0',
		  SplashImgURL tinytext NOT NULL,
		  WebsafeTitle text NOT NULL,
		  Title text NOT NULL,
		  Content longtext NOT NULL,
		  Excerpt mediumtext NOT NULL,
		  Keywords tinytext NOT NULL,
		  Description mediumtext NOT NULL,
		  Date datetime NOT NULL,
		  UpdateDate datetime default NULL,
		  Trashed datetime default NULL,
		  RemoveComments smallint(1) NOT NULL default '0',
		  Publish smallint(1) NOT NULL default '0',
		  Active smallint(1) NOT NULL default '1',
		  PRIMARY KEY  (ID)
		)
		";
		if (mysql_query($sql6,$DBL)){
			$GLB_PG_Success = true;
			$GLB_PG_SuccessMsg .= "Entries Table was created.<br/>";
		}else{
			$GLB_PG_Error = true;
			$GLB_PG_ErrorMsg .= "Error: " . mysql_error($DBL) . "<br/>";
		}
		
		$sql7="
		CREATE TABLE IDCMS_MenuOrder (
		  ID int(11) NOT NULL auto_increment,
		  MenuID int(11) NOT NULL,
		  TargetID varchar(15) NOT NULL,
		  ParentID varchar(15) NOT NULL,
		  URL tinytext NOT NULL,
		  Title varchar(50) NOT NULL,
		  PRIMARY KEY  (ID)
		)
		";
		if (mysql_query($sql7,$DBL)){
			$GLB_PG_Success = true;
			$GLB_PG_SuccessMsg .= "Menus Order Table was created.<br/>";
		}else{
			$GLB_PG_Error = true;
			$GLB_PG_ErrorMsg .= "Error: " . mysql_error($DBL) . "<br/>";
		}
		
		$sql8="
		CREATE TABLE IDCMS_Menus (
		  ID int(11) NOT NULL auto_increment,
		  Slot varchar(50) NOT NULL,
		  PRIMARY KEY  (ID)
		)
		";
		if (mysql_query($sql8,$DBL)){
			$GLB_PG_Success = true;
			$GLB_PG_SuccessMsg .= "Menus Table was created.<br/>";
		}else{
			$GLB_PG_Error = true;
			$GLB_PG_ErrorMsg .= "Error: " . mysql_error($DBL) . "<br/>";
		}
		
		$sql9="
		CREATE TABLE IDCMS_Settings (
		  Domain varchar(75) NOT NULL,
		  IndexURL text NOT NULL,
		  LogoURL text NOT NULL,
		  UploadPath text NOT NULL,
		  SiteName varchar(50) NOT NULL,
		  MaxFileSize varchar(20) NOT NULL,
		  BlogRollCount smallint(2) NOT NULL default '10',
		  ApproveComments smallint(1) NOT NULL default '0',
		  ContactEmail varchar(75) NOT NULL,
		  LangSet varchar(30) NOT NULL,
		  GATracking mediumtext NOT NULL
		)
		";
		if (mysql_query($sql9,$DBL)){
			$GLB_PG_Success = true;
			$GLB_PG_SuccessMsg .= "Settings Table was created.<br/>";
		}else{
			$GLB_PG_Error = true;
			$GLB_PG_ErrorMsg .= "Error: " . mysql_error($DBL) . "<br/>";
		}
		
		$sql10="
		INSERT INTO IDCMS_Authors (Fname,Lname,DisplayName,Email,Password,RegDate,Role,Confirm,Active)
		VALUES ('$s_First','$s_Last','$s_DisplayName','$s_Email','$s_Pass','$u_DateStamp','admin','1','1')
		";
		// Execute query
		if (mysql_query($sql10,$DBL)){
			$GLB_PG_Success = true;
			$GLB_PG_SuccessMsg .= "Admin was created.<br/>";
		}else{
			$GLB_PG_Error = true;
			$GLB_PG_ErrorMsg .= "Error: " . mysql_error($DBL) . "<br/>";
		}
		
		$sql11="
		INSERT INTO IDCMS_Settings (Domain,UploadPath,SiteName,MaxFileSize,BlogRollCount,ContactEmail,LangSet)
		VALUES ('$s_Domain','SumCMS/Uploads/','$s_SiteName','20M','10','$s_Email','English')
		";
		// Execute query
		if (mysql_query($sql11,$DBL)){
			$GLB_PG_Success = true;
			$GLB_PG_SuccessMsg .= "Settings have been entered.<br/>";
		}else{
			$GLB_PG_Error = true;
			$GLB_PG_ErrorMsg .= "Error: " . mysql_error($DBL) . "<br/>";
		}
		
		if($GLB_PG_Error){
			$GLB_PG_ErrorMsg .= "It is recommended to reinstall Sum CMS and delete the tables that may have been created.";
		}
	}
	mysql_close($DBL);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sum CMS Install</title>
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW">
<meta name="ROBOTS" content="NOARCHIVE">
<meta name="ROBOTS" content="NOODP">
<meta name="ROBOTS" content="NOYDIR">
<meta name="ROBOTS" content="NOSNIPPET">
<meta content='True' name='HandHeldFriendly' />
<meta name="Viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link href="css/global.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript">
function removeEle(ele){
	$('#'+ele).remove();
}
function updateDomain(){
	var path = $('#s_Domain').val()+'/SumCMS/Uploads/';
	$('#s_Path').val(path);
}
function resizeContent(){
	var Window = window.innerWidth,
	MainWindow = $('.ad_mainWindow'),
	MainWindowContent = $('.ad_mainWindow .content'),
	MainInnerWindowW = $('#MainWindow').width(),

	WindowHeight = $(window).height();
	
	if(MainInnerWindowW<750){
		$('.ad_col_half').css('width','100%');
		$('.ad_col_half .padRight10').attr('style', 'padding-right: 0px !important');
		$('.ad_col_half .padLeft10').attr('style', 'padding-left: 0px !important');
	}else{
		$('.ad_col_half').css('width',Math.floor(MainInnerWindowW*.5)+'px');
		$('.ad_col_half .padRight10').attr('style', '');
		$('.ad_col_half .padLeft10').attr('style', '');
	}
	MainWindow.css({
		'position':'absolute'
	});

	if(Window<980){
		MainWindow.css({
			'position':'relative'
		});
		MainWindowContent.css({
			'margin-left':'0px'
		});
	}
}
$(window).resize(function(){
	resizeContent();
});
$(document).ready(function(){	
	resizeContent();
	updateDomain();
});
</script>
</head>

<body>

<div class="ad_mainWindow">
	<div style="margin-left:auto; margin-right:auto; max-width:960px;">
    	<div class="padding10" id="MainWindow">
        	<div class="ad_row_full" style="margin-top:70px; text-align:center;">
            	<img class="LoginLogo" src="images/loginLogo.gif" width="360" height="100" />
            </div>
            <div class="ad_row_full" style="text-align:center;">
            	<h3>Sum CMS Install Page</h3>
            </div>
            
            <div id="AJXMsgs">
            	<?php if($GLB_PG_Error){?>
                <div class="ad_row_full" id="alertError">
                    <div class="ErrorsTxtColor">
                    	<button type="button" class="AlertCloseBtn" onclick="removeEle('alertError')">×</button>
                        <?php echo $GLB_PG_ErrorMsg;?>
                    </div>
                </div>
                <?php }
                if($GLB_PG_Success){?>
                <div class="ad_row_full" id="alertSuccess">
                    <div class="SuccessTxtColor">
                    	<button type="button" class="AlertCloseBtn" onclick="removeEle('alertSuccess')">×</button>
                        <?php echo $GLB_PG_SuccessMsg;?>
                    </div>
                </div>
                <?php }?>
            </div>
            
            <form method="post" action="install.php">
            <div class="ad_row_full">
            	<div class="ad_mod_wrap">
                    <div class="ad_mod_header">
                        iDrop Settings
                    </div>
                    <div class="ad_mod_content">
                        <div class="ad_mod_row_full">
                            <strong>Site Name:</strong>
                        </div>
                        <div class="ad_mod_row_full">
                            <div class="ad_mod_whiteWrap">
                                <input type="text" id="s_SiteName" name="s_SiteName" value="<?php echo $s_SiteName;?>"/>
                            </div>
                        </div>
                        <div class="ad_mod_content_left">
                            <div class="ad_mod_row_full">
                                <strong>Domain:</strong>
                            </div>
                            <div class="ad_mod_row_full">
                                <div class="ad_mod_whiteWrap">
                                    <input type="text" id="s_Domain" name="s_Domain" onchange="updateDomain()" onkeyup="updateDomain()" value="<?php echo $s_Domain;?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="ad_mod_content_right">
                            <div class="ad_mod_row_full">
                                <strong>Path to Upload Directory:</strong>
                            </div>
                            <div class="ad_mod_row_full">
                                <div class="ad_mod_whiteWrap">
                                    <input type="text" id="s_Path" name="s_Path" value="<?php echo $s_Path;?>" disabled="disabled"/>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        
        	<div class="ad_col_half">
                <div class="padRight10">
                    <div class="ad_mod_wrap">
                        <div class="ad_mod_header">
                            MySQL Settings
                        </div>
                        <div class="ad_mod_content">
                            <div class="ad_mod_row_full">
                                <strong>Host:</strong>
                            </div>
                            <div class="ad_mod_row_full">
                                <div class="ad_mod_whiteWrap">
                                    <input type="text" id="s_db_Host" name="s_db_Host" value="<?php echo $s_db_Host;?>"/>
                                </div>
                            </div>
                            <div class="ad_mod_row_full">
                                <strong>User:</strong>
                            </div>
                            <div class="ad_mod_row_full">
                                <div class="ad_mod_whiteWrap">
                                    <input type="text" id="s_db_User" name="s_db_User" value="<?php echo $s_db_User;?>"/>
                                </div>
                            </div>
                            <div class="ad_mod_row_full">
                                <strong>Password:</strong>
                            </div>
                            <div class="ad_mod_row_full">
                                <div class="ad_mod_whiteWrap">
                                    <input type="password" id="s_db_Pass" name="s_db_Pass" value="<?php echo $s_db_Pass;?>"/>
                                </div>
                            </div>
                            <div class="ad_mod_row_full">
                                <strong>Database:</strong>
                            </div>
                            <div class="ad_mod_row_full">
                                <div class="ad_mod_whiteWrap">
                                    <input type="text" id="s_db" name="s_db" value="<?php echo $s_db;?>"/>
                                </div>
                            </div>
						</div>
					</div>
				</div>
			</div>
            
            <div class="ad_col_half">
                <div class="padLeft10">
                    <!--Right Column Content Start-->
                    <div class="ad_mod_wrap">
                        <div class="ad_mod_header">
                            Admin Information
                        </div>
                        <div class="ad_mod_content">
                            <div class="ad_mod_row_full">
                                <strong>First Name:</strong>
                            </div>
                            <div class="ad_mod_row_full">
                                <div class="ad_mod_whiteWrap">
                                    <input type="text" id="s_First" name="s_First" value="<?php echo $s_First;?>"/>
                                </div>
                            </div>
                            <div class="ad_mod_row_full">
                                <strong>Last Name:</strong>
                            </div>
                            <div class="ad_mod_row_full">
                                <div class="ad_mod_whiteWrap">
                                    <input type="text" id="s_Last" name="s_Last" value="<?php echo $s_Last;?>"/>
                                </div>
                            </div>
                            <div class="ad_mod_row_full">
                                <strong>Email:</strong>
                            </div>
                            <div class="ad_mod_row_full">
                                <div class="ad_mod_whiteWrap">
                                    <input type="text" id="s_Email" name="s_Email" value="<?php echo $s_Email;?>"/>
                                </div>
                            </div>
                            <div class="ad_mod_row_full">
                                <strong>Password:</strong>
                            </div>
                            <div class="ad_mod_row_full">
                                <div class="ad_mod_whiteWrap">
                                    <input type="password" id="s_Pass" name="s_Pass" value="<?php echo $s_Pass;?>"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if(!$GLB_PG_Success){?>
            <div class="ad_mod_row_full">
                <input class="form_submit FloatRight" id="s_Submit" name="s_Submit" type="submit" value="Install" />
                <div class="clear"></div>
            </div>
            <?php }else{?>
			<div class="ad_mod_row_full" style="text-align:center;">
                <strong>***DELETE INSTALL.PHP FILE AFTER COMPLETION***</strong>
            </div>
			<?php }?>
            </form>

		</div>
	</div>
</div>

</body>
</html>
