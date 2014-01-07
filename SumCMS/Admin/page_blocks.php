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

include 'inc.php';
require_once("inc_dda.php");

/* ---------- Page Script ---------- */

$rowsPerPage = 15;

if (isset($_POST['pg']) && $_POST['pg'] != '' && preg_match("/^[0-9]+$/", $_POST['pg'])){
	$pageNum = $_POST['pg'];
	$PN = true;
}else{
	$pageNum = 1;
}
$offset = ($pageNum - 1) * $rowsPerPage;

$DBLink = MySqlConnect();

$SetSQL = "SELECT * FROM IDCMS_CodeBlocks ORDER BY ID DESC";
$BlocksTotal = mysql_num_rows(mysql_query($SetSQL));
$BlocksQuery = mysql_query($SetSQL." LIMIT $offset, $rowsPerPage");
$BlocksCount = mysql_num_rows($BlocksQuery);

// Setup Paging
$maxPage = ceil($BlocksTotal/$rowsPerPage);
$nav = "";
$pageNav = '';
for($page = 1; $page <= $maxPage; $page++){
	if ($page == $pageNum){
		$nav .= "<div class=\"btnPaging\">$page</div>";
	}else{
		$nav .= "<a class=\"btnPaging\" href=\"javascript:void(0);\" onclick=\"getBlocks('$page')\">$page</a> ";
	} 
}
if($pageNum > 1){
   $page  = $pageNum - 1;
   $prev  = "<a class=\"btnPaging\" href=\"javascript:void(0);\" onclick=\"getBlocks('$page')\">&lt;</a>";
}else{
   $prev  = '';
}
if ($pageNum < $maxPage){
   $page = $pageNum + 1;
   $next = "<a class=\"btnPaging\" href=\"javascript:void(0);\" onclick=\"getBlocks('$page')\">&gt;</a>";
}else{
   $next = '';
}
if($BlocksTotal>$rowsPerPage){
	$pageNav .= '<div class="ad_row_full">
	<div class="center_wrap"><div class="center_center"><div class="center_item">
	'.$prev.$nav.$next.'
	</div></div></div>
	<div class="clear"></div>
	</div>';
}else{
	$pageNav .= '';
}

// Process...
$List .= $pageNav;

if($BlocksCount>0){	
	$List .= '<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr class="table_RowHeader">
		<td style="width:20px;">&nbsp;</td>
		<td style="width:150px;"><strong>'.$GLBLang['sub1'].'</strong></td>
		<td><strong>'.$GLBLang['sub2'].'</strong></td>
	</tr>';
	
	while($cb = mysql_fetch_array($BlocksQuery)){
		$cb_ID = $cb['ID'];
		$cb_Name = $cb['Name'];
		$cb_Tag = $cb['Tag'];
		$cb_Code = $cb['Code'];
		
		$BlockBtns = array(
			'<a href="javascript:void(0);" onclick="editBlock(\''.$cb_ID.'\');">'.$GLBLang['btn1'].'</a>',
			'<a href="javascript:void(0);" onclick="deleteBlock(\''.$cb_ID.'\');">'.$GLBLang['btn2'].'</a>'
		);
		$Btns = implode(' | ',$BlockBtns);
		
		// Finalize ------------		
		$List .= '<tr class="TableRow EMenu" id="'.$cb_ID.'">
			<td><input id="CBID[]" name="CBID[]" type="checkbox" value="'.$cb_ID.'"/></td>
			<td>
				'.$cb_Name.'<br />
				<div class="Hidden" id="EMenu'.$cb_ID.'">'.$Btns.'</div>
			</td>
			<td>
				{{'.$cb_Tag.'}}
			</td>
		</tr>';
	}
	$List .= '</table>';
}else{
	$List .= '<strong>'.$GLBLang['msg1'].'</strong>';
}

$List .= $pageNav;

mysql_close($DBLink);


/* ---------- Page Header Setup ---------- */
$PageTitle = $GLBLang['PT']; // Page Name & Title
$PageRel = 'allblocks';
$AdditionalScripts = ''; // Put additional JS or CSS files for header
require("inc_header.php");
?>

<div>
	<?php if($BlocksCount>0){?>
	<div class="ad_row_full">
    	<input class="form_submit" onclick="deleteSelectedBlocks()" type="button" value="<?php echo $GLBLang['btn3'];?>"/>
    </div>
    <?php }?>
    
	<input type="hidden" id="pg" name="pg" value="<?php echo $pageNum;?>"/>
    <!--Main Content Start-->
    <?php echo $List;?>
    <!--Main Content End-->
</div>

<div class="clear"></div>

<?php require("inc_footer.php");?>