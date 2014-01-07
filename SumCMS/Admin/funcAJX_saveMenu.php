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

if($log_Role=='admin' || $log_Role=='manager'){
	$DBLink = MySqlConnect();
	
	$MenuID = mysql_escape_string($_POST['id']);
	$Slot = mysql_escape_string($_POST['s']);
	$Titles = $_POST['t'];
	$URLs = $_POST['u'];
	$Menu = $_POST['m'];

	if(isset($MenuID) && $MenuID!="" && preg_match("/^[0-9]+$/", $MenuID)){
		$MenuQuery = mysql_query("SELECT * FROM IDCMS_Menus WHERE ID='$MenuID' LIMIT 1",$DBLink);
		$MenuExist = mysql_num_rows($MenuQuery);
	}
	if($MenuExist>0){
		if(mysql_query("DELETE FROM IDCMS_MenuOrder WHERE MenuID='$MenuID'",$DBLink)){
			for($i=0;$i<count($Menu)-1;$i++){
				$a = $i+1;
				
				$Title = mysql_escape_string($Titles[$i]);
				$URL = mysql_escape_string($URLs[$i]);
				$TargetID = mysql_escape_string($Menu[$a]['item_id']);
				$ParentID = mysql_escape_string($Menu[$a]['parent_id']);
				
				mysql_query("INSERT INTO IDCMS_MenuOrder (MenuID,TargetID,ParentID,URL,Title)
				VALUES ('$MenuID','$TargetID','$ParentID','$URL','$Title')",$DBLink);
			}
			echo "1^".$GLBLang['msg1']."^";
		}else{
			echo "0^".$GLBLang['msg2']."^";
		}
	}else{
		echo "0^".$GLBLang['msg3']."^";
	}
	
	mysql_close($DBLink);
}
?>