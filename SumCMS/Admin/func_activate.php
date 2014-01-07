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
$GLBLang = $GLBLanguage[$GLB_LangSet]['func_activate'];

function isValidEmail($emailcheck){
	return preg_match("/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)*\.([a-zA-Z]{2,6})$/", $emailcheck);
}

$ShowLogin = false;
$EmailReceived = urldecode($_GET['e']);

if(isset($EmailReceived) && $EmailReceived != '' && isValidEmail($EmailReceived)){
	MySqlConnect();
	$UsersEmail = mysql_escape_string($EmailReceived);
	$UserQuery = mysql_query("SELECT * FROM IDCMS_Authors WHERE Email='$UsersEmail'");
	$Exist = mysql_num_rows($UserQuery);
	
	if($Exist>0){
		if($Exist>1){
			mysql_query("DELETE FROM IDCMS_Authors WHERE Email='$UsersEmail' AND Active='0'");
		}
		if(mysql_query("UPDATE IDCMS_Authors SET Confirm='1' WHERE Email='$UsersEmail'")){
			$Msg = $GLBLang['msg1'];
			$ShowLogin = $GLBLang['msg2'];
		}else{
			$Msg = $GLBLang['msg3'];
		}
	}else{
		$Msg = $GLBLang['msg4'];
	}
	mysql_close(MySqlConnect());
}else{
	$Msg = $GLBLang['msg5'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sum CMS | Login</title>
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
    <div class="LogRow" style="text-align:center;">
    	<?php echo $Msg;?>
    </div>
    <?php if($ShowLogin){?>
    <div class="LogRow" style="text-align:center;">
    	<?php echo $ShowLogin;?>
    </div>
    <?php }?>
</div>
</body>
</html>
