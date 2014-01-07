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

require_once("inc_session.php");
require_once("inc_config.php");
require_once("class_global.php");
require_once("inc_language.php");
require_once("func_mobileDetect.php");
$GLBFunc = new GlobeFunc($GLB_DB_SET);

$MobileSniff = new Mobile_Detect();
$Page = $GLBFunc->phpSelf($_SERVER['PHP_SELF']);
$Gravatar18 = $GLBFunc->getGravatar($log_Email,18,'identicon','pg',array('class'=>'grayBoarder FloatRight'));
$Platform = ($MobileSniff->isMobile() ? ($MobileSniff->isTablet() ? 'tablet' : 'mobile') : 'desktop');

$GLBLang = $GLBLanguage[$GLB_LangSet][$Page];
?>