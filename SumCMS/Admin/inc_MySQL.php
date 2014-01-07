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

$GLB_DB_SET = array('Host'=>'[[Host]]','User'=>'[[User]]','Pass'=>'[[Pass]]','DB'=>'[[DB]]');
define('DB_Host',$GLB_DB_SET['Host']);
define('DB_User',$GLB_DB_SET['User']);
define('DB_Pass',$GLB_DB_SET['Pass']);
define('DB_DB',$GLB_DB_SET['DB']);

if(!function_exists('MySqlConnect')){
	function MySqlConnect(){
		$DBL = mysql_connect(DB_Host,DB_User,DB_Pass, true);
		if($DBL){
			$DB_Select = mysql_select_db(DB_DB, $DBL);
			if(!$DB_Select){
				die('MySql Database Selection Error - Please check the mysql config file');
			}else{
				return $DBL;
			}
		}else{
			die('MySql Connection Error - Please check the mysql config file');
		}
	}
}
?>