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

$rowsPerPage = 15;

if (isset($_POST['pg']) && $_POST['pg'] != '' && preg_match("/^[0-9]+$/", $_POST['pg'])){
	$pageNum = $_POST['pg'];
	$PN = true;
}else{
	$pageNum = 1;
}
$offset = ($pageNum - 1) * $rowsPerPage;

$DBLink = MySqlConnect();

$SetSQL = "SELECT c.ID, c.EntryID, c.Username, c.Email, c.WebURL, c.Comment, c.Date, c.Approved, e.WebsafeTitle, e.Title FROM 
IDCMS_Comments c LEFT JOIN IDCMS_Entries e 
	ON c.EntryID=e.ID 
WHERE c.Active='1' ORDER BY ID DESC";

$CommentsTotal = mysql_num_rows(mysql_query($SetSQL));
$CommentsQuery = mysql_query($SetSQL." LIMIT $offset, $rowsPerPage");
$CommentsCount = mysql_num_rows($CommentsQuery);

// Setup Paging
$maxPage = ceil($CommentsTotal/$rowsPerPage);
$nav = "";
$pageNav = '';
for($page = 1; $page <= $maxPage; $page++){
	if ($page == $pageNum){
		$nav .= "<div class=\"btnPaging\">$page</div>";
	}else{
		$nav .= "<a class=\"btnPaging\" href=\"javascript:void(0);\" onclick=\"getComments('$page')\">$page</a> ";
	} 
}
if($pageNum > 1){
   $page  = $pageNum - 1;
   $prev  = "<a class=\"btnPaging\" href=\"javascript:void(0);\" onclick=\"getComments('$page')\">&lt;</a>";
}else{
   $prev  = '';
}
if ($pageNum < $maxPage){
   $page = $pageNum + 1;
   $next = "<a class=\"btnPaging\" href=\"javascript:void(0);\" onclick=\"getComments('$page')\">&gt;</a>";
}else{
   $next = '';
}
if($CommentsTotal>$rowsPerPage){
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

if($CommentsCount>0){	
	$List .= '<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr class="table_RowHeader">
		<td style="width:20px;">&nbsp;</td>
		<td style="width:180px;"><strong>'.$GLBLang['sub1'].'</strong></td>
		<td><strong>'.$GLBLang['sub2'].'</strong></td>
		<td style="width:150px;"><strong>'.$GLBLang['sub3'].'</strong></td>
		<td style="width:150px;"><strong>'.$GLBLang['sub4'].'</strong></td>
	</tr>';
	
	while($Com = mysql_fetch_array($CommentsQuery)){
		$com_ID = $Com['ID'];
		$com_Avatar = $GLBFunc->getGravatar($Com['Email'],40,'identicon','pg',array('class'=>'comment_avatar'));
		$com_Username = stripslashes($Com['Username']);
		$com_Email = $Com['Email'];
		$com_Comment = nl2br(stripslashes($Com['Comment']));
		$com_Date = $GLBFunc->formatDate($Com['Date'])." at ".$GLBFunc->formatTime($Com['Date']);
		$com_Title = '<a href="http://'.$GLB_Domain.'/blog/'.$Com['WebsafeTitle'].'" target="_blank">'.stripslashes($Com['Title']).'</a>';
		
		if($Com['WebURL']==''){
			$com_AvUser = ''.$com_Avatar.'<br /><br />
			'.$com_Username.'<br />';
		}else{
			$com_AvUser = '<a href="'.$Com['WebURL'].'" target="_blank">'.$com_Avatar.'<br /><br />
			'.$com_Username.'</a><br />';
		}
		
		if($log_Role=='admin'||$log_Role=='manager' || $log_ID==$entryAuthorID){
			if($Com['Approved']==0){
				$com_Btns = '<div id="Combtn'.$com_ID.'" class="FloatRight" style="text-align:right;">
				<a href="javascript:void(0);" onclick="updatedComment(\''.$com_ID.'\')">'.$GLBLang['btn1'].'</a><br />
				<a href="javascript:void(0);" onclick="deleteComment(\''.$com_ID.'\')">'.$GLBLang['btn3'].'</a>
				</div>';
			}else{
				$com_Btns = '<div id="Combtn'.$com_ID.'" class="FloatRight" style="text-align:right;">
				<a href="javascript:void(0);" onclick="updatedComment(\''.$com_ID.'\')">'.$GLBLang['btn2'].'</a><br />
				<a href="javascript:void(0);" onclick="deleteComment(\''.$com_ID.'\')">'.$GLBLang['btn3'].'</a>
				</div>';
			}
		}else{
			$com_Btns = '';
		}
		
		// Finalize ------------
		$List .= '<tr class="TableRow EMenu" id="'.$com_ID.'" style="vertical-align:top;">
			<td><input id="CID[]" name="CID[]" type="checkbox" value="'.$com_ID.'"/></td>
			<td>
				'.$com_Btns.'
				'.$com_AvUser.'
				<a href="mailto:'.$com_Email.'">'.$com_Email.'</a><br />
			</td>
			<td>
				'.$com_Comment.'
			</td>
			<td>
				'.$com_Date.'
			</td>
			<td>
				'.$com_Title.'
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
$PageTitle = $GLBLang['PT'];
$PageRel = 'comments';
$AdditionalScripts = '';
require("inc_header.php");
?>

<div>
	<div class="ad_row_full">
    	<input class="form_submit" onclick="deleteSelectedComments()" type="button" value="<?php echo $GLBLang['btn4'];?>"/>
    </div>
    
	<input type="hidden" id="pg" name="pg" value="<?php echo $pageNum;?>"/>
    <!--Main Content Start-->
    <?php echo $List;?>
    <!--Main Content End-->
</div>

<div class="clear"></div>

<?php require("inc_footer.php");?>