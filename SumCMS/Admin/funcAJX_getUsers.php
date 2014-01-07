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

if($log_Role=='admin'){
	$rowsPerPage = 10;
	if (isset($_POST['pg']) && $_POST['pg'] != '' && preg_match("/^[0-9]+$/", $_POST['pg'])){
		$pageNum = $_POST['pg'];
		$PN = true;
	}else{
		$pageNum = 1;
	}
	$offset = ($pageNum - 1) * $rowsPerPage;
	
	$DBLink = MySqlConnect();
	$SetSQL = "FROM IDCMS_Authors WHERE Active='1' ORDER BY ID ASC";
	$UsersTotal = mysql_num_rows(mysql_query("SELECT * ".$SetSQL,$DBLink));
	$UsersQuery = mysql_query("SELECT * ".$SetSQL." LIMIT $offset, $rowsPerPage",$DBLink);
	$UsersCount = mysql_num_rows($UsersQuery);
	
	// Setup Paging
	$maxPage = ceil($UsersTotal/$rowsPerPage);
	$nav = "";
	for($page = 1; $page <= $maxPage; $page++){
		if ($page == $pageNum){
			$nav .= "<div class=\"btnPaging\">$page</div>";
		}else{
			$nav .= "<a class=\"btnPaging\" href=\"javascript:void(0);\" onclick=\"getUsers('$page')\">$page</a> ";
		} 
	}
	if($pageNum > 1){
	   $page  = $pageNum - 1;
	   $prev  = "<a class=\"btnPaging\" href=\"javascript:void(0);\" onclick=\"getUsers('".$page."')\">&lt;</a>";
	}else{
	   $prev  = '';
	}
	if ($pageNum < $maxPage){
	   $page = $pageNum + 1;
	   $next = "<a class=\"btnPaging\" href=\"javascript:void(0);\" onclick=\"getUsers('".$page."')\">&gt;</a>";
	}else{
	   $next = '';
	}
	if($UsersTotal>$rowsPerPage){
		$pageNav .= '<div class="ad_mod_row_full">
		<div class="center_wrap"><div class="center_center"><div class="center_item">
		'.$prev.$nav.$next.'
		</div></div></div>
		<div class="clear"></div>
		</div>';
	}else{
		$pageNav .= '';
	}
	
	$List .= '<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr class="table_RowHeader">
		<td style="width:60px;"><strong>'.$GLBLang['sub1'].'</strong></td>
		<td><strong>'.$GLBLang['sub2'].'</strong></td>
		<td style="width:50px;"><strong>'.$GLBLang['sub3'].'</strong></td>
		<td style="width:80px;">&nbsp;</td>
	</tr>';

	if($UsersCount>0){
		while($U = mysql_fetch_array($UsersQuery)){
			$UserBtns = array();
			$IsAdmin = false;
			if($log_Role=="admin"){
				$IsAdmin = true;
			}
			if($IsAdmin && $log_ID!=$U['ID'] && $U['ID']!=1){
				$UserBtns[] = '<a href="javascript:void(0);" onclick="editUser(\''.$U['ID'].'\');">'.$GLBLang['btn1'].'</a>';
			}
			if($IsAdmin && $U['ID']!=$log_ID && $U['ID']!=1 || $log_ID==1 && $U['ID']!=1){
				$UserBtns[] = '<a href="javascript:void(0);" onclick="deleteUser(\''.$U['ID'].'\');">'.$GLBLang['btn2'].'</a>';
			}
			$Btns = implode(' | ',$UserBtns);
			
			if($U['Confirm']==1){
				$Confirm = $GLBLang['msg1'];
			}else{
				$Confirm = $GLBLang['msg2'];
			}
			
			$LastLog = '';
			if($U['LastLogin']!=NULL){
				$LastLog = $GLBLang['msg3'];
			}
			
			// Finalize ------------			
			$List .= '<tr class="TableRow">
				<td>'.ucfirst(strtolower($U['Role'])).'</td>
				<td'.$LastLog.'>'.ucwords(strtolower(stripslashes($U['Fname'].' '.$U['Lname']))).'</td>
				<td>'.$Confirm.'</td>
				<td>'.$Btns.'</td>
			</tr>';
		}
	}else{
		$List .= '<strong>'.$GLBLang['msg4'].'</strong>';
	}
	$List .= '</table>';
	$List .= $pageNav;
	
	echo $List;
	
	mysql_close($DBLink);
}
?>