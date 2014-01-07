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

$DBLink = MySqlConnect();
$CID = mysql_escape_string($_POST['cid']);
$IsOwner = mysql_num_rows(mysql_query("SELECT * FROM IDCMS_Comments c JOIN IDCMS_Entries e ON c.EntryID = e.ID LEFT JOIN IDCMS_Authors a ON e.AuthorID = a.ID WHERE a.ID = '$log_ID' AND c.ID = '$CID'",$DBLink));

if(($log_Role=='admin' || $log_Role=='manager' || $IsOwner>0) && isset($_POST['cid']) && $_POST['cid'] != ''){

	$CommentQuery = mysql_query("SELECT * FROM IDCMS_Comments WHERE ID='$CID' LIMIT 1",$DBLink);
	$CommentExist = mysql_num_rows($CommentQuery);
	
	if($CommentExist>0){
		$c = mysql_fetch_array($CommentQuery);
		$Approved = $c['Approved'];
		if($Approved==0){
			$Approved = 1;
		}else{
			$Approved = 0;
		}
		
		if(mysql_query("UPDATE IDCMS_Comments SET Approved='$Approved' WHERE ID='$CID' LIMIT 1",$DBLink)){
			echo 'success^'.$Approved.'^'.$CID.'^';
		}
	}
}
mysql_close($DBLink);
?>