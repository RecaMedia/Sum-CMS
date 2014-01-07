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

if(($log_Role=='admin' || $log_Role=='manager') && isset($_POST['eid']) && $_POST['eid'] != ''){
	$DBLink = MySqlConnect();
	
	$EIDs = $_POST['eid'];
	
	if(is_array($EIDs)){
		$SuccessCount = 0;
		$TotalCount = count($EIDs);
		for($i=0; $i<$TotalCount; $i++){
			$ThisEID = mysql_escape_string($EIDs[$i]);
			$TrashedStamp = date("Y-m-d H:i:s");
		
			if(mysql_query("UPDATE IDCMS_Entries SET Trashed='$TrashedStamp', Publish='0', Active='0' WHERE ID='$ThisEID' LIMIT 1",$DBLink)){
				mysql_query("UPDATE IDCMS_Comments SET Active='0' WHERE EntryID='$ThisEID'",$DBLink);
				$SuccessCount++;
			}
		}
		if($SuccessCount==$TotalCount){
			setcookie("alertSuccess", $GLBLang['msg1']);
			echo "All entries were successfully removed.";
		}else{
			setcookie("alertError", $GLBLang['msg2']);
			echo "Not all entries were successfully removed.";
		}
	}else if(preg_match("/^[0-9]+$/",$EIDs)){
		$EIDs = mysql_escape_string($EIDs);
		$TrashedStamp = date("Y-m-d H:i:s");
	
		if(mysql_query("UPDATE IDCMS_Entries SET Trashed='$TrashedStamp', Publish='0', Active='0' WHERE ID='$EIDs' LIMIT 1",$DBLink)){
			mysql_query("UPDATE IDCMS_Comments SET Active='0' WHERE EntryID='$EIDs'",$DBLink);
			
			setcookie("alertSuccess", $GLBLang['msg3']);
			echo "Entry successfully removed.";
		}else{
			setcookie("alertError", $GLBLang['msg4']);
			echo "Ran into error removing entry.";
		}
	}else{
		setcookie("alertError", $GLBLang['msg5']);
		echo "Ran into error.";
	}

	mysql_close($DBLink);
}
?>