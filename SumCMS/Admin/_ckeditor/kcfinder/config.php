<?php
/** This file is part of KCFinder project
  *
  *      @desc Base configuration file
  *   @package KCFinder
  *   @version 2.51
  *    @author Pavel Tzonkov <pavelc@users.sourceforge.net>
  * @copyright 2010, 2011 KCFinder Project
  *   @license http://www.opensource.org/licenses/lgpl-2.1.php LGPLv2
  *      @link http://kcfinder.sunhater.com
  */

// IMPORTANT!!! Do not remove uncommented settings in this file even if
// you are using session configuration.
// See http://kcfinder.sunhater.com/install for setting descriptions

define('CONFIG_PATH', dirname(dirname(dirname(__FILE__))));
require_once(CONFIG_PATH.'/inc_config.php');
session_start();

$uploadpath = ltrim($GLB_UploadPath, '/');
$UPLOADURL = "http://".$GLB_Domain."/".$uploadpath;
$UPLOADDIR = CONFIG_PATH."/../Uploads";

if($_SESSION['IDCMS_UserRole']=="admin" || $_SESSION['IDCMS_UserRole']=="manager" || $_SESSION['IDCMS_UserRole']=="user"){
	$_SESSION['KCFINDER']['disabled'] = false; 
	$_SESSION['KCFINDER']['uploadURL'] = $UPLOADURL; 
	$_SESSION['KCFINDER']['uploadDir'] = $UPLOADDIR;
}

$_CONFIG = array(

    'disabled' => true,
    'denyZipDownload' => true,
    'denyUpdateCheck' => false,
    'denyExtensionRename' => false,

    'theme' => "oxygen",

    'uploadURL' => $UPLOADURL,
    'uploadDir' => $UPLOADDIR,

    'dirPerms' => 0755,
    'filePerms' => 0644,

    'access' => array(
		'files' => array(
			'upload' => true,
			'delete' => true,
			'copy' => true,
			'move' => true,
			'rename' => true
		),

		'dirs' => array(
			'create' => true,
			'delete' => true,
			'rename' => true
		)
	),

    'deniedExts' => "exe com msi bat php phps phtml php3 php4 cgi pl",
	
    'types' => array(
        // CKEditor & FCKEditor types
        'files'   =>  "",
        'flash'   =>  "swf",
        'images'  =>  "*img",
    ),

    'filenameChangeChars' => array(/*
        ' ' => "_",
        ':' => "."
    */),

    'dirnameChangeChars' => array(/*
        ' ' => "_",
        ':' => "."
    */),

    'mime_magic' => "",

    'maxImageWidth' => 0,
    'maxImageHeight' => 0,

    'thumbWidth' => 100,
    'thumbHeight' => 100,

    'thumbsDir' => ".thumbs",

    'jpegQuality' => 90,

    'cookieDomain' => "",
    'cookiePath' => "",
    'cookiePrefix' => 'KCFINDER_',

    // THE FOLLOWING SETTINGS CANNOT BE OVERRIDED WITH SESSION CONFIGURATION
    '_check4htaccess' => true,
    //'_tinyMCEPath' => "/tiny_mce",

    '_sessionVar' => &$_SESSION['KCFINDER'],
    //'_sessionLifetime' => 30,
    //'_sessionDir' => "/full/directory/path",

    //'_sessionDomain' => ".mysite.com",
    //'_sessionPath' => "/my/path",
);

if($_SESSION['IDCMS_UserRole']=="admin"){
	$_CONFIG['access'] = array(
		'files' => array(
			'upload' => true,
			'delete' => true,
			'copy' => true,
			'move' => true,
			'rename' => true
		),

		'dirs' => array(
			'create' => true,
			'delete' => true,
			'rename' => true
		)
	);
}else if($_SESSION['IDCMS_UserRole']=="manager"){
	$_CONFIG['access'] = array(
		'files' => array(
			'upload' => true,
			'delete' => true,
			'copy' => true,
			'move' => true,
			'rename' => true
		),

		'dirs' => array(
			'create' => false,
			'delete' => false,
			'rename' => false
		)
	);
}else if($_SESSION['IDCMS_UserRole']=="user"){
	$_CONFIG['access'] = array(
		'files' => array(
			'upload' => true,
			'delete' => false,
			'copy' => false,
			'move' => false,
			'rename' => false
		),

		'dirs' => array(
			'create' => false,
			'delete' => false,
			'rename' => false
		)
	);
}
?>