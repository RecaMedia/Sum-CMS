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
/* ---------- Page Script ---------- */

$DBLink = MySqlConnect();

$BlogEntriesCount = mysql_num_rows(mysql_query("SELECT * FROM IDCMS_Entries WHERE Type='blog' AND Publish='1' AND Active='1'",$DBLink));

$PageCount = mysql_num_rows(mysql_query("SELECT * FROM IDCMS_Entries WHERE Type='page' AND Publish='1' AND Active='1'",$DBLink));

$CategoryCount = mysql_num_rows(mysql_query("SELECT * FROM IDCMS_Categories",$DBLink));

$CommentCount = mysql_num_rows(mysql_query("SELECT * FROM IDCMS_Comments WHERE Active='1'",$DBLink));

$CommentApprovedCount = mysql_num_rows(mysql_query("SELECT * FROM IDCMS_Comments WHERE Approved='1' AND Active='1'",$DBLink));

$CommentUnapprovedCount = mysql_num_rows(mysql_query("SELECT * FROM IDCMS_Comments WHERE Approved='0' AND Active='1'",$DBLink));

$BlogEntriesQuery = mysql_query("SELECT * FROM IDCMS_Entries WHERE Type='blog' AND Active='1' ORDER BY ID DESC LIMIT 3",$DBLink);
$BlogEntries = mysql_num_rows($BlogEntriesQuery);
if($BlogEntries>0){
	while($B = mysql_fetch_array($BlogEntriesQuery)){
		$Latest .= '<div class="ad_mod_row_full">
			<p><strong><a href="javascript:void(0);" onclick="editEntry(\'blog\',\''.$B['ID'].'\');">'.stripslashes($B['Title']).'</a></strong> - '.$GLBFunc->formatDate($B['Date']).'</p>
			<p>'.$B['Excerpt'].'</p>
		</div>';
	}
}else{
	$Latest .= '<div class="ad_mod_row_full">
		<p>'.$GLBLang['msg1'].'</p>
	</div>';
}

mysql_close($DBLink);

/* ---------- Page Header Setup ---------- */
$PageTitle = $GLBLang['PT'];
$PageRel = 'dashboard';
$AdditionalScripts = '';
require("inc_header.php");
?>

<div class="ad_col_half">
	<div class="padRight10">
        <!--Left Column Content Start-->
        <div class="ad_mod_wrap">
            <div class="ad_mod_header">
            	<?php echo $GLBLang['sub1'];?>
            </div>
            <div class="ad_mod_content">
            	<div class="ad_mod_content_left">
                	<div class="ad_mod_row_full">
                    	<strong><?php echo $GLBLang['sub2'];?></strong>
                    </div>
                    <div class="ad_mod_row_full">
                    	<p><a href="javascript:void(0);" onclick="getEntries('','','blog','')"><strong><?php echo $BlogEntriesCount;?></strong> <?php echo $GLBLang['sub3'];?></a></p>
                    </div>
                    <div class="ad_mod_row_full">
                    	<p><a href="javascript:void(0);" onclick="getEntries('','','page','')"><strong><?php echo $PageCount;?></strong> <?php echo $GLBLang['sub4'];?></a></p>
                    </div>
                    <div class="ad_mod_row_full">
                    	<?php if($log_Role=='admin' || $log_Role=='manager'){?>
                    		<p><a href="page_categories.php"><strong><?php echo $CategoryCount;?></strong> <?php echo $GLBLang['sub5'];?></a></p>
                        <?php }else{?>
                        	<p><strong><?php echo $CategoryCount;?></strong> <?php echo $GLBLang['sub5'];?></p>
                        <?php }?>
                    </div>
                </div>
                <div class="ad_mod_content_right">
                	<div class="ad_mod_row_full">
                    	<strong><?php echo $GLBLang['sub6'];?></strong>
                    </div>
                    <?php if($log_Role=='admin' || $log_Role=='manager'){?>
                    <div class="ad_mod_row_full">
                    	<p><a href="javascript:void(0);" onclick="getComments('')"><strong><?php echo $CommentCount;?></strong> <?php echo $GLBLang['sub7'];?></a></p>
                	</div>
                    <div class="ad_mod_row_full">
                    	<p><a href="javascript:void(0);" onclick="getComments('')"><strong><?php echo $CommentApprovedCount;?></strong> <?php echo $GLBLang['sub8'];?></a></p>
                    </div>
                    <div class="ad_mod_row_full">
                    	<p><a href="javascript:void(0);" onclick="getComments('')"><strong><?php echo $CommentUnapprovedCount;?></strong> <?php echo $GLBLang['sub9'];?></a></p>
                    </div>
                    <?php }else{?>
                    <div class="ad_mod_row_full">
                    	<p><strong><?php echo $CommentCount;?></strong> <?php echo $GLBLang['sub7'];?></p>
                    </div>
                    <div class="ad_mod_row_full">
                    	<p><strong><?php echo $CommentApprovedCount;?></strong> <?php echo $GLBLang['sub8'];?></p>
                    </div>
                    <div class="ad_mod_row_full">
                    	<p><strong><?php echo $CommentUnapprovedCount;?></strong> <?php echo $GLBLang['sub9'];?></p>
                    </div>
                    <?php }?>
                </div>
                <div class="clear"></div>
                <div class="ad_mod_row_full">
               	  <p><strong><?php echo $GLBLang['sub10'];?> Sum CMS v1.3</strong></p>
                    <p><?php echo $GLBLang['sub11'];?> <a href="http://dev.sumcms.com" target="_blank">http://dev.sumcms.com</a></p>
                </div>
            </div>
        </div>
        <!--Left Column Content End-->
    </div>
</div>

<div class="ad_col_half">
	<div class="padLeft10">
        <!--Right Column Content Start-->
        <div class="ad_mod_wrap">
            <div class="ad_mod_header">
            	<?php echo $GLBLang['sub12'];?>
            </div>
            <div class="ad_mod_content">
            	<?php echo $Latest;?>
            </div>
        </div>
        <!--Right Column Content End-->
    </div>
</div>

<div class="clear"></div>

<?php require("inc_footer.php");?>