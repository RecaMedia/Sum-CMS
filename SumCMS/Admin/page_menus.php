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
// inc_dda.php file will prevent other from posting to this file from an external location.
// require_once("inc_dda.php");

/* ---------- Page Script ---------- */

/* ---------- Page Header Setup ---------- */
$PageTitle = $GLBLang['PT']; // Page Name & Title
$PageRel = 'menus';
$AdditionalScripts = ''; // Put additional JS files for header
require("inc_header.php");
?>
<div class="ad_col_left">
	<div class="padRight10">
        <!--Left Column Content Start-->
        <div class="ad_mod_wrap">
            <div id="AvailableSlots" style="border-bottom: 1px solid #CED0D0;">
            	
            </div>
            <div class="ad_mod_content">
            	<input id="MenuID" name="MenuID" type="hidden" value=""/>
                <input id="MenuSlots" name="MenuSlots" type="hidden" value=""/>
            	<div class="ad_mod_row_full">
                	<div id="noMenuListed" class="SimpleAlert" style="text-align:center;">
                    	<strong><?php echo $GLBLang['msg1'];?></strong>
                    </div>
                    <ol class="sortable">
                    </ol>
                </div>
                <hr/>
                <div class="ad_mod_row_full">
                	<a class="btnLink FloatLeft" href="page_menus.php"><?php echo $GLBLang['btn1'];?></a>
                	<input class="form_submit FloatRight" id="SaveMenu" name="SaveMenu" type="button" value="<?php echo $GLBLang['btn2'];?>"/>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <!--Left Column Content End-->
    </div>
</div>

<div class="ad_col_right">
	<div class="padLeft10">
        <!--Right Column Content Start-->
        <div class="ad_mod_wrap">
        	<div class="ad_mod_header">
            	<?php echo $GLBLang['sub1'];?>
            </div>
        	<div class="ad_mod_content">
                <div class="ad_mod_row_full">
                    <div class="ad_mod_whiteWrap">
                        <select id="MenuSelection" name="MenuSelection">
                        </select>
                    </div>
                </div>
                <div class="ad_mod_row_full">
                    <input class="form_submit FloatRight" id="AddItem" name="AddItem" type="button" value="<?php echo $GLBLang['btn3'];?>"/>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <!--Right Column Content End-->
    </div>
</div>

<div class="clear"></div>

<?php require("inc_footer.php");?>