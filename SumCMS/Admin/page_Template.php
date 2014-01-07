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
/* inc_dda.php file will prevent other from posting to this file from an external location. */
// require_once("inc_dda.php");

/* ---------- Page Script ---------- */
// Your code goes here.


/* ---------- Page Header Setup ---------- */
$PageTitle = 'New Page'; // Page Name & Title
$AdditionalScripts = ''; // Put additional JS or CSS files for header
require("inc_header.php");
?>

<div class="ad_row_full">
    <!--Main Content Start-->
    
    <!--Main Content End-->
</div>

<div class="clear"></div>

<?php require("inc_footer.php");?>