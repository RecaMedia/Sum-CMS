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
	
	// Retrieve all slots
	$result = array();
	$iDrop = file_get_contents('../../index.php');
	if (preg_match_all('/register_menu((.*?));/s', $iDrop, $regs)) {
		$DBLink = MySqlConnect();
		if($regs[0]>0){
			for($i=0;$i<count($regs[0]);$i++){
				$halfClean = substr($regs[0][$i],14);
				$halfCleanParts = explode(",",$halfClean);
				$CleanName = ucwords(strtolower(str_replace('"','',str_replace("'","",$halfCleanParts[0]))));
				
				$Slot = mysql_escape_string($CleanName);
				$MQuery = mysql_query("SELECT * FROM IDCMS_Menus WHERE Slot='$Slot' LIMIT 1",$DBLink);
				$MCount = mysql_num_rows($MQuery);
				
				if($MCount>0){
					$M = mysql_fetch_array($MQuery);
					$MID = $M['ID'];
				}else{
					mysql_query("INSERT INTO IDCMS_Menus (Slot) VALUES ('$Slot')",$DBLink);
					$MID = mysql_insert_id($DBLink);
				}
				
				$result[] = '<td><div class="ad_mod_header"><a href="javascript:void(0);" onclick="editMenu(\''.$MID.'\',this);">'.$CleanName.'</a></div></td>';
			}
			
			mysql_close($DBLink);
	
			$AvailableSlots = '<table style="margin-bottom:-1px;" width="100%" border="0" cellspacing="0" cellpadding="0"><tr>'.implode('<td>&nbsp;</td>',$result).'</tr></table>';
			
			echo $AvailableSlots;
		}else{
			mysql_close($DBLink);
		}
	}
}
?>