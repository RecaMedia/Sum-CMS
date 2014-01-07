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

// Load Existing Entry ----------------------------------------------------------------------
if(isset($_POST['formType']) && $_POST['formType']=='update' && isset($_POST['blockID']) && $_POST['blockID']!=''){
	
	// Connect to MySql and get data
	$DLINK = MySqlConnect();
	
	$blockID = mysql_escape_string($_POST['blockID']);
	
	$blockQuery = mysql_query("SELECT * FROM IDCMS_CodeBlocks WHERE ID='$blockID' LIMIT 1");
	$cbxist = mysql_num_rows($blockQuery);
	
	// If data exist, continue
	if($cbxist>0){
		$cb = mysql_fetch_array($blockQuery);
		$c_ID = $cb['ID'];
		$c_Name = $cb['Name'];
		$c_Tag = $cb['Tag'];
		$c_Code = $cb['Code'];
	}else{
		$GLB_PG_Error = true;
		$GLB_PG_ErrorMsg .= $GLBLang['msg1'];
	}
}

/* ---------- Page Header Setup ---------- */
$PageTitle = $GLBLang['PT']; // Page Name & Title
$PageRel = 'newblock';
$AdditionalScripts = '
<link rel="stylesheet" href="_codemirror/codemirror.css">
<link rel="stylesheet" href="_codemirror/hint/show-hint.css">
<script src="_codemirror/codemirror.js"></script>
<script src="_codemirror/hint/show-hint.js"></script>
<script src="_codemirror/hint/xml-hint.js"></script>
<script src="_codemirror/hint/html-hint.js"></script>
<script src="_codemirror/mode/xml/xml.js"></script>
<script src="_codemirror/mode/javascript/javascript.js"></script>
<script src="_codemirror/mode/php/php.js"></script>
<script src="_codemirror/mode/css/css.js"></script>
<script src="_codemirror/mode/htmlmixed/htmlmixed.js"></script>
'; // Put additional JS or CSS files for header
require("inc_header.php");
?>

<div class="ad_row_full">
	<div class="ad_mod_wrap">
        <div class="ad_mod_header">
            <?php echo $GLBLang['sub1'];?>
        </div>
        <div class="ad_mod_content">
            <div class="ad_col_half">
                <div class="padRight10">
                    <!--Left Column Content Start-->
                    <div class="ad_mod_row_full">
                        <strong><?php echo $GLBLang['sub2'];?>:</strong>
                    </div>
                    <div class="ad_mod_row_full">
                        <div class="ad_mod_whiteWrap">
                            <input type="text" id="c_Name" name="c_Name" value="<?php echo $c_Name;?>"/>
                        </div>
                    </div>
                    <!--Left Column Content End-->
                </div>
            </div>
            <div class="ad_col_half">
                <div class="padLeft10">
                    <!--Right Column Content Start-->
                    <div class="ad_mod_row_full">
                        <strong><?php echo $GLBLang['sub3'];?>:</strong> <em>(<?php echo $GLBLang['sub4'];?>)</em>
                    </div>
                    <div class="ad_mod_row_full">
                        <div class="ad_mod_whiteWrap">
                            <input type="text" id="c_Tag" name="c_Tag" value="<?php echo $c_Tag;?>"/>
                        </div>
                    </div>
                    <!--Right Column Content End-->
                </div>
            </div>
            <div class="clear"></div>
            <div class="ad_mod_row_full">
                <?php echo $GLBLang['sub5'];?>
            </div>
            <div class="ad_mod_row_full">
                <strong><?php echo $GLBLang['sub6'];?>:</strong>
            </div>
            <div class="ad_mod_row_full">
                <div class="ad_mod_whiteWrap">
                    <div id="MyCode"></div>
                </div>
            </div>
            <div class="ad_mod_row_full">
                <input class="form_submit FloatRight" id="c_Submit" name="c_Submit" type="button" value="<?php echo $GLBLang['btn1'];?>" />
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>

<textarea style="display:none;" id="loadedCode"><?php echo stripslashes($c_Code);?></textarea>
<script>
$(document).ready(function(){
	editor = CodeMirror(document.getElementById("MyCode"),{
		mode: "text/html",
		extraKeys: {"Ctrl-Space": "autocomplete"},
		lineWrapping: true,
		lineNumbers: true,
	});
	editor.setValue($('#loadedCode').val());
	$('#code textarea').attr('id','c_Code');
	$('#c_Submit').click(function(){
		saveCodeBlock();
	});
});
</script>

<?php require("inc_footer.php");?>