<?php
require("_templates.php");

/*------------------ Edit Name & Builds ------------------*/
$TopNavBuild = array(
	'startWrap' => '',
	'beforeLink' => '[[URL]]',
	'afterLink' => '',
	'startSubWrap' => '[[URL]]',
	'midSubWrap' => '',
	'endSubWrap' => '',
	'endWrap' => '',
	'SelectedClass' => '',
	'SelectedSubClass' => ''
);

$SideNavBuild = array(
	'startWrap' => '',
	'beforeLink' => '[[URL]]',
	'afterLink' => '',
	'startSubWrap' => '[[URL]]',
	'midSubWrap' => '',
	'endSubWrap' => '',
	'endWrap' => '',
	'SelectedClass' => '',
	'SelectedSubClass' => ''
);

/*------------------ Start Builder ------------------*/
require("SumCMS/builder.php");
?>

<!--Modify the site structure as needed.-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php get('SiteName');?> | <?php get('Title');?></title>
<meta name="keywords" content="<?php get('Keywords');?>" />
<meta name="description" content="<?php get('Description');?>" />
<link href="css/style.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/general.js"></script>
</head>

<body>

<?php register_menu('Top Navigation',$TopNavBuild);?>
<?php register_menu('Side Navigation',$SideNavBuild);?>

<?php print_content();?>
<?php get('Paging');?>

<?php get('GATracking');?>

</body>
</html>