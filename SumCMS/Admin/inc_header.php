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

if(isset($_COOKIE["alertError"]) && $_COOKIE["alertError"]!=''){
	$GLB_PG_Error = true;
	$GLB_PG_ErrorMsg = $_COOKIE["alertError"].'<br />';
	setcookie("alertError", "", time()-86400);
}
if(isset($_COOKIE["alertSuccess"]) && $_COOKIE["alertSuccess"]!=''){
	$GLB_PG_Success = true;
	$GLB_PG_SuccessMsg = $_COOKIE["alertSuccess"].'<br />';
	setcookie("alertSuccess", "", time()-86400);
}
$GLBLang = $GLBLanguage[$GLB_LangSet]['inc_header'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $GLB_SiteName.' '.$GLBLang['sub1'];?> - <?php echo $PageTitle;?></title>
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW">
<meta name="ROBOTS" content="NOARCHIVE">
<meta name="ROBOTS" content="NOODP">
<meta name="ROBOTS" content="NOYDIR">
<meta name="ROBOTS" content="NOSNIPPET">
<meta content='True' name='HandHeldFriendly' />
<meta name="Viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link href="css/global.css" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<?php echo $AdditionalScripts;?>
<?php $js='js/'.$Page.'.js'; if(file_exists($js)){?>
<script type="text/javascript" src="js/<?php echo $Page;?>.js"></script>
<?php }?>
<script type="text/javascript" src="js/global.js"></script>
</head>

<body>
<div class="ad_topBar">
    <div class="FloatRight padding5 padRight10">
        <?php echo $Gravatar18;?>
    </div>
    <div class="FloatRight BGWhite">
        <div class="ad_topBar_weltxt roundedCornersBL5">
        	<span id="WelcomeText"><?php echo $GLBLang['sub2'].' '.ucfirst(strtolower($log_Fname));?></span>
        </div>
    </div>
	<div class="FloatRight BGWhite" id="topBarNav">
        <a class="roundedCornersBR5" href="page_logout.php"><?php echo $GLBLang['btn1'];?></a>
        <a href="page_myaccount.php"><?php echo $GLBLang['btn2'];?></a>
    </div>
</div>
<div class="ad_mainWindow">
	<div class="content">
    	<div class="padding10" id="MainWindow">
        	<div class="ad_row_full">
                <h1><?php echo $PageTitle;?></h1>
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
            <?php $GLBLang = $GLBLanguage[$GLB_LangSet][$Page];?>