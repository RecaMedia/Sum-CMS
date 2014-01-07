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

function stripText($str){
	return preg_replace("/[^A-Za-z0-9 ]/","", $str);
}
function noSpaces($str){
	return str_replace(" ","",$str);
}

$bName = mysql_real_escape_string(stripText($_POST['Name']));
$bTag = mysql_real_escape_string(strtolower(noSpaces(stripText($_POST['Tag']))));
$bCode = mysql_real_escape_string($_POST['Code']);


$cbquery = mysql_query("SELECT * FROM IDCMS_CodeBlocks WHERE Tag='$bTag' LIMIT 1",$DBLink);
$cbexist = mysql_num_rows($cbquery);
if($cbexist>0){
	$row = mysql_fetch_array($cbquery);
	$CBID = $row['ID'];
	$msg = $GLBLang['msg1'];
	$sql = "UPDATE IDCMS_CodeBlocks SET Name='$bName', Tag='$bTag', Code='$bCode' WHERE ID='$CBID'";
}else{
	$msg = $GLBLang['msg2'];
	$sql = "INSERT INTO IDCMS_CodeBlocks (Name,Tag,Code) VALUES ('$bName','$bTag','$bCode')";
}

if(mysql_query($sql,$DBLink)){
	echo '1^'.$msg.'^';
}else{
	echo '0^'.$GLBLang['msg3'].'^';
}

mysql_close($DBLink);
?>