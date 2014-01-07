<!--/*
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
*/-->

<?php $GLBLang = $GLBLanguage[$GLB_LangSet]['inc_sidebar'];?>
<div class="ad_sidebar">
	<div class="content">
    	<a class="nextArrow" rel="dashboard" href="page_dashboard.php">
        	<div class="icon_Dashboard Nav_icon"></div>
            <div class="Nav_txt"><?php echo $GLBLang['btn1'];?></div>
            <div class="clear"></div>
        </a>
        <?php if($log_Role=='admin' || $log_Role=='manager'){?>
        <a class="nextArrow" rel="settings" href="page_settings.php">
        	<div class="icon_Settings Nav_icon"></div>
            <div class="Nav_txt"><?php echo $GLBLang['btn2'];?></div>
            <div class="clear"></div>
        </a>
        <?php
        }
		if($log_Role=='admin' || $log_ID==1){
		?>
        <a class="nextArrow" rel="users" href="page_manageUsers.php">
        	<div class="icon_User Nav_icon"></div>
            <div class="Nav_txt"><?php echo $GLBLang['btn3'];?></div>
            <div class="clear"></div>
        </a>
        <?php }?>
        <a class="downArrow" href="javascript:void(0);" onclick="subNav('subNavBlog');">
        	<div class="icon_Entry Nav_icon"></div>
            <div class="Nav_txt"><?php echo $GLBLang['btn4'];?></div>
            <div class="clear"></div>
        </a>
        <div class="ad_sidebar_subwrap" id="subNavBlog">
        	<a class="nextArrow padLeft20" rel="blog" href="javascript:void(0);" onclick="getEntries('','','blog','')">
                <div class="icon_Entry Nav_icon"></div>
                <div class="Nav_txt"><?php echo $GLBLang['btn5'];?></div>
                <div class="clear"></div>
            </a>
            <a class="nextArrow padLeft20" rel="blogentry" href="javascript:void(0);" onclick="newEntry('blog')">
                <div class="icon_Entry Nav_icon"></div>
                <div class="Nav_txt"><?php echo $GLBLang['btn6'];?></div>
                <div class="clear"></div>
            </a>
            <?php if($log_Role=='admin' || $log_Role=='manager'){?>
            <a class="nextArrow padLeft20" rel="categories" href="page_categories.php">
                <div class="icon_Categories Nav_icon"></div>
                <div class="Nav_txt"><?php echo $GLBLang['btn7'];?></div>
                <div class="clear"></div>
            </a>
            <a class="nextArrow padLeft20" rel="comments" href="javascript:void(0);" onclick="getComments('')">
                <div class="icon_Comments Nav_icon"></div>
                <div class="Nav_txt"><?php echo $GLBLang['btn8'];?></div>
                <div class="clear"></div>
            </a>
            <?php }?>
        </div>
        <a class="downArrow" href="javascript:void(0);" onclick="subNav('subNavPages');">
        	<div class="icon_Entry Nav_icon"></div>
            <div class="Nav_txt"><?php echo $GLBLang['btn9'];?></div>
            <div class="clear"></div>
        </a>
        <div class="ad_sidebar_subwrap" id="subNavPages">
        	<a class="nextArrow padLeft20" rel="pages" href="javascript:void(0);" onclick="getEntries('','','page','')">
                <div class="icon_Entry Nav_icon"></div>
                <div class="Nav_txt"><?php echo $GLBLang['btn10'];?></div>
                <div class="clear"></div>
            </a>
            <?php if($log_Role=='admin' || $log_Role=='manager'){?>
            <a class="nextArrow padLeft20" rel="page" href="javascript:void(0);" onclick="newEntry('page')">
                <div class="icon_Entry Nav_icon"></div>
                <div class="Nav_txt"><?php echo $GLBLang['btn11'];?></div>
                <div class="clear"></div>
            </a>
            <?php }?>
        </div>
        <a class="downArrow" href="javascript:void(0);" onclick="subNav('subNavBlocks');">
        	<div class="icon_CodeBlock Nav_icon"></div>
            <div class="Nav_txt"><?php echo $GLBLang['btn12'];?></div>
            <div class="clear"></div>
        </a>
        <div class="ad_sidebar_subwrap" id="subNavBlocks">
        	<a class="nextArrow padLeft20" rel="allblocks" href="javascript:void(0);" onclick="getBlocks('')">
                <div class="icon_CodeBlockEdit Nav_icon"></div>
                <div class="Nav_txt"><?php echo $GLBLang['btn13'];?></div>
                <div class="clear"></div>
            </a>
            <a class="nextArrow padLeft20" rel="newblock" href="page_newBlock.php">
                <div class="icon_CodeBlockAdd Nav_icon"></div>
                <div class="Nav_txt"><?php echo $GLBLang['btn14'];?></div>
                <div class="clear"></div>
            </a>
        </div>
        <?php if($log_Role=='admin' || $log_Role=='manager'){?>
        <a class="nextArrow" rel="menus" href="page_menus.php">
        	<div class="icon_Menu Nav_icon"></div>
            <div class="Nav_txt"><?php echo $GLBLang['btn15'];?></div>
            <div class="clear"></div>
        </a>
		<?php }?>
        <a class="nextArrow" rel="files" href="page_manageFiles.php">
        	<div class="icon_Media Nav_icon"></div>
            <div class="Nav_txt"><?php echo $GLBLang['btn16'];?></div>
            <div class="clear"></div>
        </a>
    </div>
</div>
<?php $GLBLang = $GLBLanguage[$GLB_LangSet][$Page];?>