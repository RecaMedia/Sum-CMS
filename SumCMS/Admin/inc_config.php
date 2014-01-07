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

include 'inc_MySQL.php';

$DBLink = MySqlConnect();
$GLB_SettingsQuery = mysql_query("SELECT * FROM IDCMS_Settings",$DBLink);
$GLB_Settings = mysql_fetch_array($GLB_SettingsQuery);
mysql_close($DBLink);

$GLB_Domain = $GLB_Settings['Domain'];
$GLB_UploadPath = $GLB_Settings['UploadPath'];
$GLB_SiteName = $GLB_Settings['SiteName'];
$GLB_SiteName = $GLB_Settings['LogoURL'];
$GLB_MaxFileSize = $GLB_Settings['MaxFileSize'];
$GLB_BlogRollCount = $GLB_Settings['BlogRollCount'];
$GLB_ApproveComments = $GLB_Settings['ApproveComments'];
$GLB_ThemeIndex = $GLB_Settings['ThemeIndex'];
$GLB_ThemeFolder = $GLB_Settings['ThemeFolder'];
$GLB_ContactEmail = $GLB_Settings['ContactEmail'];
$GLB_IndexURL = $GLB_Settings['IndexURL'];
$GLB_LangSet = $GLB_Settings['LangSet'];
$GLB_GATracking = $GLB_Settings['GATracking'];

$GLB_PG_Success = false;
$GLB_PG_SuccessMsg = '';
$GLB_PG_Error = false;
$GLB_PG_ErrorMsg = '';
?>