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

if(isset($_POST['cbid']) && $_POST['cbid'] != ''){
	$DBLink = MySqlConnect();
	
	$CBIDs = $_POST['cbid'];
	
	if(is_array($CBIDs)){
		$SuccessCount = 0;
		$TotalCount = count($CBIDs);
		for($i=0; $i<$TotalCount; $i++){
			$ThisCBID = mysql_escape_string($CBIDs[$i]);
		
			if(mysql_query("DELETE FROM IDCMS_CodeBlocks WHERE ID='$ThisCBID'",$DBLink)){
				$SuccessCount++;
			}
		}
		if($SuccessCount==$TotalCount){
			setcookie("alertSuccess", $GLBLang['msg1']);
			echo "All blocks were successfully removed.";
		}else{
			setcookie("alertError", $GLBLang['msg2']);
			echo "Not all blocks were successfully removed.";
		}
	}else if(preg_match("/^[0-9]+$/",$CBIDs)){
		$CBIDs = mysql_escape_string($CBIDs);
	
		if(mysql_query("DELETE FROM IDCMS_CodeBlocks WHERE ID='$CBIDs'",$DBLink)){
			setcookie("alertSuccess", $GLBLang['msg3']);
			echo "Block successfully removed.";
		}else{
			setcookie("alertError", $GLBLang['msg4']);
			echo "Ran into error removing block.";
		}
	}

	mysql_close($DBLink);
}
?>