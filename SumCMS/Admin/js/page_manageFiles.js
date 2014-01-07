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

function openKCFinder(){
    var div = document.getElementById('kcfinderWin');
    div.innerHTML = '<iframe id="kcfinderFrame" name="kcfinder_iframe" class="grayBoarder roundedCorners5 overflowHidden" src="_ckeditor/kcfinder/browse.php?type=files&dir=files"'+
    'frameborder="0" marginwidth="0" marginheight="0" scrolling="no" />';
	resizeContent();
}

$(document).ready(function(){
	openKCFinder();
});