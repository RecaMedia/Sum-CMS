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

if(!isset($_SESSION)){session_start();}

$log_ID = $_SESSION['IDCMS_ID'];
$log_Fname = $_SESSION['IDCMS_Fname'];
$log_Lname = $_SESSION['IDCMS_Lname'];
$log_Email = $_SESSION['IDCMS_Email'];
$log_PersonalURL = $_SESSION['IDCMS_PersonalURL'];
$log_LastLogin = $_SESSION['IDCMS_LastLogin'];
$log_RegDate = $_SESSION['IDCMS_RegDate'];
$log_Role = $_SESSION['IDCMS_UserRole'];

if(!isset($log_ID) && $log_ID==''){
	session_destroy();
	header("location: index.php");
}
?>