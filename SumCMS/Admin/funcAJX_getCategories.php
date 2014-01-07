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
	$rowsPerPage = 10;
	if (isset($_POST['pg']) && $_POST['pg'] != '' && preg_match("/^[0-9]+$/", $_POST['pg'])){
		$pageNum = $_POST['pg'];
		$PN = true;
	}else{
		$pageNum = 1;
	}
	$offset = ($pageNum - 1) * $rowsPerPage;
	
	$DBLink = MySqlConnect();
	$SetSQL = "FROM IDCMS_Categories ORDER BY Name ASC";
	$CateTotal = mysql_num_rows(mysql_query("SELECT * ".$SetSQL,$DBLink));
	$CateQuery = mysql_query("SELECT * ".$SetSQL." LIMIT $offset, $rowsPerPage",$DBLink);
	$CateCount = mysql_num_rows($CateQuery);
	
	// Setup Paging
	$maxPage = ceil($CateTotal/$rowsPerPage);
	$nav = "";
	for($page = 1; $page <= $maxPage; $page++){
		if ($page == $pageNum){
			$nav .= "<div class=\"btnPaging\">$page</div>";
		}else{
			$nav .= "<a class=\"btnPaging\" href=\"javascript:void(0);\" onclick=\"getCate('$page')\">$page</a> ";
		} 
	}
	if($pageNum > 1){
	   $page  = $pageNum - 1;
	   $prev  = "<a class=\"btnPaging\" href=\"javascript:void(0);\" onclick=\"getCate('".$page."')\">&lt;</a>";
	}else{
	   $prev  = '';
	}
	if ($pageNum < $maxPage){
	   $page = $pageNum + 1;
	   $next = "<a class=\"btnPaging\" href=\"javascript:void(0);\" onclick=\"getCate('".$page."')\">&gt;</a>";
	}else{
	   $next = '';
	}
	if($CateTotal>$rowsPerPage){
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
		<td><strong>'.$GLBLang['sub1'].'</strong></td>
		<td style="width:80px;">&nbsp;</td>
	</tr>';

	if($CateCount>0){
		while($C = mysql_fetch_array($CateQuery)){
			$CateBtns = array();
			$CateBtns[] = '<a href="javascript:void(0);" onclick="editCate(\''.$C['ID'].'\');">'.$GLBLang['btn1'].'</a>';
			$CateBtns[] = '<a href="javascript:void(0);" onclick="deleteCate(\''.$C['ID'].'\');">'.$GLBLang['btn2'].'</a>';
			$Btns = implode(' | ',$CateBtns);
			
			// Finalize ------------			
			$List .= '<tr class="TableRow">
				<td title="'.stripslashes($C['Description']).'">'.ucwords(strtolower(stripslashes($C['Name']))).'</td>
				<td>'.$Btns.'</td>
			</tr>';
		}
	}else{
		$List .= '<tr>
			<td colspan="2"><strong>'.$GLBLang['msg1'].'</strong></td>
		</tr>';
	}
	
	$List .= '</table>';
	
	$List .= $pageNav;
	
	echo $List;
	
	mysql_close($DBLink);
}
?>