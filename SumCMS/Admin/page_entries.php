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

/* ---------- Page Script ---------- */

if (isset($_POST['listBy']) && $_POST['listBy'] != ''){
	$listBy = $_POST['listBy'];
}else{
	$listBy = "WebsafeTitle";
}
if (isset($_POST['listOrder']) && $_POST['listOrder'] != ''){
	$listOrder = $_POST['listOrder'];
}else{
	$listOrder = "ASC";
}
$entryType = $_POST['entryType'];

$rowsPerPage = 15;
if (isset($_POST['pg']) && $_POST['pg'] != '' && preg_match("/^[0-9]+$/", $_POST['pg'])){
	$pageNum = $_POST['pg'];
	$PN = true;
}else{
	$pageNum = 1;
}
$offset = ($pageNum - 1) * $rowsPerPage;

$DBLink = MySqlConnect();

/*
$SetSQL = "SELECT * FROM IDCMS_Entries WHERE AuthorID='$log_ID' AND Active='1' AND p.Type='$entryType' ORDER BY $listBy $listOrder";
*/

$SetSQL = "SELECT p.*, a.Fname, a.Lname FROM IDCMS_Entries p
INNER JOIN IDCMS_Authors a
	ON p.AuthorID=a.ID
WHERE p.Active='1' AND p.Type='$entryType' ORDER BY $listBy $listOrder";

$EntryTotal = mysql_num_rows(mysql_query($SetSQL));
$EntryQuery = mysql_query($SetSQL." LIMIT $offset, $rowsPerPage");
$EntryCount = mysql_num_rows($EntryQuery);

// Setup Paging
$maxPage = ceil($EntryTotal/$rowsPerPage);
$nav = "";
$pageNav = '';
for($page = 1; $page <= $maxPage; $page++){
	if ($page == $pageNum){
		$nav .= "<div class=\"btnPaging\">$page</div>";
	}else{
		$nav .= "<a class=\"btnPaging\" href=\"javascript:void(0);\" onclick=\"getEntries('$listBy','$listOrder','$entryType','$page')\">$page</a> ";
	} 
}
if($pageNum > 1){
   $page  = $pageNum - 1;
   $prev  = "<a class=\"btnPaging\" href=\"javascript:void(0);\" onclick=\"getEntries('$listBy','$listOrder','$entryType','$page')\">&lt;</a>";
}else{
   $prev  = '';
}
if ($pageNum < $maxPage){
   $page = $pageNum + 1;
   $next = "<a class=\"btnPaging\" href=\"javascript:void(0);\" onclick=\"getEntries('$listBy','$listOrder','$entryType','$page')\">&gt;</a>";
}else{
   $next = '';
}
if($EntryTotal>$rowsPerPage){
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

if($EntryCount>0){
	$BlogColumnHeaders = ($entryType=="blog"?'
	<td style="width:100px;"><strong>'.$GLBLang['sub1'].'</strong></td>
	<td style="width:120px;"><strong>'.$GLBLang['sub2'].'</strong></td>
	<td style="width:150px;"><strong>'.$GLBLang['sub3'].'</strong></td>
	<td style="width:150px;"><strong>'.$GLBLang['sub4'].'</strong></td>':'');
	
	$List .= '<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr class="table_RowHeader">
		<td style="width:20px;">&nbsp;</td>
		<td><strong>'.$GLBLang['sub5'].'</strong></td>
		'.$BlogColumnHeaders.'
	</tr>';
	
	while($E = mysql_fetch_array($EntryQuery)){
		$EID = $E['ID'];
		
		if($log_Role=='admin'||$log_Role=='manager' || $log_ID==$E['AuthorID']){
			$EntryBtns = array(
				'<a href="javascript:void(0);" onclick="editEntry(\''.$entryType.'\',\''.$EID.'\');">'.$GLBLang['btn1'].'</a>',
				'<a href="javascript:void(0);" onclick="deleteEntry(\''.$EID.'\');">'.$GLBLang['btn2'].'</a>'
			);
			$Btns = ' | '.implode(' | ',$EntryBtns);
		}else{
			$Btns = '';
		}
		
		$Date = $GLBFunc->formatDate($E['Date']).' at '.$GLBFunc->formatTime($E['Date']);
		if($E['UpdateDate']==NULL){
			$UpdateDate = '';
		}else{
			$UpdateDate = $GLBFunc->formatDate($E['UpdateDate']).' at '.$GLBFunc->formatTime($E['UpdateDate']);
		}
		
		if($E['Publish']==1){
			$Publish = $GLBLang['msg1'];
		}else{
			$Publish = $GLBLang['msg2'];
		}
		
		if($E['AuthorID']!=$log_ID){
			$WrittenBy = '<div class="FloatLeft ad_mod_cell">
				'.ucwords(strtolower(stripslashes($E['Fname'].' '.$E['Lname']))).'
			</div>';
		}else{
			$WrittenBy = '<div class="FloatLeft ad_mod_cell">
				'.$GLBLang['msg3'].'
			</div>';
		}
		
		$AllCate = '';
		$CateTitle = '';
		$CateListed = '';
		$CateQuery = mysql_query("SELECT n.Name FROM IDCMS_CateLinks c
		INNER JOIN IDCMS_Categories n
			ON c.CateID=n.ID
		WHERE c.PostID='$EID' ORDER BY n.Name ASC");
		$CateCount = mysql_num_rows($CateQuery);
		if($CateCount>0){
			$AllCate = array();
			while($C = mysql_fetch_array($CateQuery)){
				$AllCate[] = ucwords(strtolower(stripslashes($C['Name'])));
			}
			if($CateCount>3){
				$Rest = array_slice($AllCate, 3);
				$AllCate = array_slice($AllCate, 0, 3);
				$CateTitle = ' title="Including: '.implode(", ",$Rest).'"';
			}
			$CateListed = implode(", ",$AllCate);
		}
		
		$BlogColumnItems = ($entryType=="blog"?'
		<td>'.$WrittenBy.'</td>
		<td'.$CateTitle.'>'.$CateListed.'</td>
		<td>'.$Date.'</td>
		<td>'.$UpdateDate.'</td>':'');
		
		// Finalize ------------
		$List .= '<tr class="TableRow EMenu" id="'.$E['ID'].'">
			<td><input id="EID[]" name="EID[]" type="checkbox" value="'.$E['ID'].'"/></td>
			<td>
				<strong>'.stripslashes($E['Title']).'</strong><br />
				<div class="Hidden" id="EMenu'.$E['ID'].'">'.$Publish.$Btns.'</div>
			</td>
			'.$BlogColumnItems.'
		</tr>';
	}
	$List .= '</table>';
}else{
	$List .= '<strong>'.$GLBLang['msg4'].' '.($entryType=="blog"?$GLBLang['msg5']:$GLBLang['msg6']).'.</strong>';
}

$List .= $pageNav;

mysql_close($DBLink);


/* ---------- Page Header Setup ---------- */
$PageTitle = ($entryType=="blog"?$GLBLang['PT1']:$GLBLang['PT2']).' '.$GLBLang['PT3'];
$PageRel = ($entryType=="blog"?'blog':'pages');
$AdditionalScripts = '';
require("inc_header.php");
?>

<?php if($EntryCount>0){?>
<div class="ad_row_full">
    <input class="form_submit FloatLeft" style="margin-top:7px;" onclick="deleteSelectedEntries()" type="button" value="<?php echo $GLBLang['btn3'];?>"/>
	<form action="page_entries.php" method="post">
    <input type="hidden" id="entryType" name="entryType" value="<?php echo $entryType;?>" />
    <input type="hidden" id="pg" name="pg" value="<?php echo $pageNum;?>" />
    <?php if($entryType=="blog"){?>
    <div class="FloatRight" style="margin-left:10px; padding-top:7px;">
    	<input class="form_submit" id="SubmitBtn" name="SubmitBtn" type="submit" value="Sort list"/>
    </div>
	<div class="FloatRight" style="margin-left:10px;">
        <div class="ad_mod_whiteWrap FloatRight" style="width:80px;">
            <select id="listOrder" name="listOrder">
                <option <?php if($listOrder=="DESC"){echo'selected="selected"';}?> value="DESC"><?php echo $GLBLang['sub6'];?></option>
                <option <?php if($listOrder=="ASC"){echo'selected="selected"';}?> value="ASC"><?php echo $GLBLang['sub7'];?></option>
            </select>
        </div>
        <div class="FloatRight" style="padding-top:10px; padding-right:5px;">
            <strong><?php echo $GLBLang['sub8'];?>:</strong>
        </div>
    </div>
    <div class="FloatRight">
        <div class="ad_mod_whiteWrap FloatRight" style="width:80px;">
            <select id="listBy" name="listBy">
                <option <?php if($listBy=="WebsafeTitle"){echo'selected="selected"';}?> value="WebsafeTitle"><?php echo $GLBLang['sub9'];?></option>
                <option <?php if($listBy=="Date"){echo'selected="selected"';}?> value="Date"><?php echo $GLBLang['sub10'];?></option>
                <option <?php if($listBy=="UpdateDate"){echo'selected="selected"';}?> value="UpdateDate"><?php echo $GLBLang['sub11'];?></option>
            </select>
        </div>
        <div class="FloatRight" style="padding-top:10px; padding-right:5px;">
            <strong><?php echo $GLBLang['sub12'];?>:</strong>
        </div>
    </div>
    <?php }?>
    </form>
    <div class="clear"></div>
</div>
<?php }?>

<div>
    <!--Main Content Start-->
    <?php echo $List;?>
    <!--Main Content End-->
</div>

<div class="clear"></div>

<?php require("inc_footer.php");?>