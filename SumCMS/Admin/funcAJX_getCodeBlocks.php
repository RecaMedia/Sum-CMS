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

$DBLink = MySqlConnect();

$cbquery = mysql_query("SELECT * FROM IDCMS_CodeBlocks ORDER BY Name ASC",$DBLink);
$cbexist = mysql_num_rows($cbquery);
if($cbexist>0){
	$cbarray = array();
	while($row = mysql_fetch_array($cbquery)){
		$cbarray[$row['Name']] = $row['Tag'];
	}
	echo json_encode($cbarray);
}

mysql_close($DBLink);
?>