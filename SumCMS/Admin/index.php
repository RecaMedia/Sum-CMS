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

require_once("inc_config.php");
require_once("inc_language.php");
$GLBLang = $GLBLanguage[$GLB_LangSet]['index'];

if(!isset($_SESSION)){session_start();}

$log_ID = $_SESSION['IDCMS_ID'];

if(isset($log_ID) && $log_ID!=''){
	header("location: page_dashboard.php");
}

$FinalKey = trim(substr(hash('sha256', rand(1, 256).date("Y-m-d H:m:s")), 0, 16));

if($_POST['Submit'] == $GLBLang['btn1']){
	function isValidEmail($em){
		return preg_match("/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)*\.([a-zA-Z]{2,6})$/", $em);
	}
	
	$form_Email = $_POST['Email'];
	$form_Pass = $_POST['Pass'];
	$form_Key = $_POST['FormKey'];
	
	if($form_Email == '' || $form_Pass == ''){
		$error = true;
		$errorMsg .= $GLBLang['msg1'].'<br />';
	}
	
	if(isset($_SESSION['IDCMS_LoginKey']) && $_SESSION['IDCMS_LoginKey'] != $form_Key){
		$error = true;
		$errorMsg .= 'Incorrect Session Key '.$_SESSION['IDCMS_LoginKey'].' - '.$form_Key.'.<br />Make sure your are logging in to the correct domain.<br />';
	}

	if (!isValidEmail($form_Email)){
		$error = true;
		$errorMsg .= $GLBLang['msg2'];
	}
	
	if(!$error){
		MySqlConnect();
		
		$form_Email = mysql_real_escape_string($form_Email);
		$form_Pass = mysql_real_escape_string($form_Pass);
			
		$LoginQuery = mysql_query("SELECT * FROM IDCMS_Authors WHERE Email='$form_Email' AND Active='1' LIMIT 1"); 
		$Exist = mysql_num_rows($LoginQuery);
		$UsersCred = mysql_fetch_array($LoginQuery); 
	
		if($Exist > 0){
			if($UsersCred['Password']==$form_Pass){
				if($UsersCred['Confirm'] == 1){			
					$_SESSION['IDCMS_ID'] = $UsersCred['ID'];
					$_SESSION['IDCMS_Fname'] = $UsersCred['Fname'];
					$_SESSION['IDCMS_Lname'] = $UsersCred['Lname'];
					$_SESSION['IDCMS_Email'] = $UsersCred['Email'];
					$_SESSION['IDCMS_PersonalURL'] = $UsersCred['PersonalURL'];
					$_SESSION['IDCMS_LastLogin'] = $UsersCred['LastLogin'];
					$_SESSION['IDCMS_RegDate'] = $UsersCred['RegDate'];
					$_SESSION['IDCMS_UserRole'] = $UsersCred['Role'];
					
					$UID = $UsersCred['ID'];
					$LastLogin = date("Y-m-d H:i:s");
					mysql_query("UPDATE IDCMS_Authors SET LastLogin='$LastLogin' WHERE ID='$UID'");
					mysql_close(MySqlConnect());
					
					header("location: page_dashboard.php");
				}else{
					mysql_close(MySqlConnect());
					$error = true;
					$errorMsg .= $GLBLang['msg3'];
				}
			}else{
				mysql_close(MySqlConnect());
				$error = true;
				$errorMsg .= $GLBLang['msg4'];
			}
		}else{
			mysql_close(MySqlConnect());
			$error = true;
			$errorMsg .= $GLBLang['msg5'];
		}
	}
}

$_SESSION['IDCMS_LoginKey'] = $FinalKey;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sum CMS | <?php echo $GLBLang['sub1'];?></title>
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW">
<meta name="ROBOTS" content="NOARCHIVE">
<meta name="ROBOTS" content="NOODP">
<meta name="ROBOTS" content="NOYDIR">
<meta name="ROBOTS" content="NOSNIPPET">
<meta content='True' name='HandHeldFriendly' />
<meta name="Viewport" content="width=360px, initial-scale=.85, maximum-scale=.85" />
<link href="css/index.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="LogBoxWrap">
    <img class="LoginLogo" src="images/loginLogo.gif" width="360" height="100" />
    <?php if($error){?>
    <div class="errors">
    	<?php echo $errorMsg;?>
    </div>
    <?php }?>
    <div class="LogBox">
    	<form action="index.php" method="post">
        <input id="FormKey" name="FormKey" type="hidden" value="<?php echo $FinalKey;?>" />
    	<div class="LogRow">
        	<div>
            	<strong><?php echo $GLBLang['sub2'];?>:</strong>
            </div>
            <div class="Form_whiteWrap">
            	<input class="Form_input" type="text" id="Email" name="Email" value="<?php echo $form_Email;?>"/>
            </div>
        </div>
        <div class="LogRow">
        	<div>
            	<strong><?php echo $GLBLang['sub3'];?>:</strong>
            </div>
            <div class="Form_whiteWrap">
            	<input class="Form_input" type="password" id="Pass" name="Pass"/>
            </div>
        </div>
        <div class="LogRow">
        	<div class="center_wrap">
            	<div class="center_center">
                    <div class="center_item">
                    	<input class="Form_submit" id="Submit" name="Submit" type="submit" value="<?php echo $GLBLang['btn1'];?>"/>
                    </div>
            	</div>
            </div>
        </div>
        </form>
    </div>
</div>
</body>
</html>
