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

require_once("inc.php");
require_once("inc_dda.php");

if($log_Role=='admin' && isset($_POST['id']) && $_POST['id'] != '' && preg_match("/^[0-9]+$/", $_POST['id'])){
	$DBLink = MySqlConnect();
	$CateID = mysql_escape_string($_POST['id']);
	if(mysql_query("DELETE FROM IDCMS_Categories WHERE ID='$CateID'",$DBLink)){
		mysql_query("DELETE FROM IDCMS_CateLinks WHERE CateID='$CateID'",$DBLink);
		echo '<div class="ad_row_full" id="alertSuccess">
			<div class="SuccessTxtColor">
				<button type="button" class="AlertCloseBtn" onclick="removeEle(\'alertSuccess\')">&times;</button>
				'.$GLBLang['msg1'].'
			</div>
		</div>';
	}else{
		echo '<div class="ad_row_full" id="alertError">
			<div class="ErrorsTxtColor">
				<button type="button" class="AlertCloseBtn" onclick="removeEle(\'alertError\')">&times;</button>
				'.$GLBLang['msg2'].'
			</div>
		</div>';
	}
	mysql_close($DBLink);
}
?>