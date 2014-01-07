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
	
	$CateMenuItemQuery = mysql_query("SELECT * FROM IDCMS_Categories ORDER BY WebsafeName ASC",$DBLink);
	$CateMenuItemCount = mysql_num_rows($CateMenuItemQuery);
	
	if($CateMenuItemCount>0){
		while($C = mysql_fetch_array($CateMenuItemQuery)){
			$Items .= '
			<option id="'.ucwords(str_replace("_"," ",$C['WebsafeName'])).'" title="" value="CAT'.$C['ID'].'">'.stripslashes($C['Name']).'</option>';
		}
	}
	
	$MenuItemQuery = mysql_query("SELECT * FROM IDCMS_Entries WHERE Publish='1' ORDER BY WebsafeTitle ASC",$DBLink);
	$MenuItemCount = mysql_num_rows($MenuItemQuery);
	
	if($MenuItemCount>0){
		while($M = mysql_fetch_array($MenuItemQuery)){
			$Items .= '
			<option id="'.ucwords(str_replace("_"," ",$M['WebsafeTitle'])).'" title="" value="'.$M['ID'].'">'.stripslashes($M['Title']).'</option>';
		}
	}
	
	mysql_close($DBLink);
	
	echo $Items;
}
?>