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

if(!class_exists('GlobeFunc')){
	class GlobeFunc{
		var $connection;
		var $db_select;
		
		function __construct($GLB_DB){
			$this->connection = mysql_connect($GLB_DB['Host'],$GLB_DB['User'],$GLB_DB['Pass'], true);
			if($this->connection){
				$db_select = mysql_select_db($GLB_DB['DB'], $this->connection);
				if(!$db_select){
					die('MySql Database Selection Error - Please check the mysql config file');
				}
			}else{
				die('MySql Connection Error - Please check the mysql config file');
			}
		}
		
		function __destruct(){
			mysql_close($this->connection);
		}
			
		function formatDate($Date){
			$Date = substr($Date,0,10);
			list($year, $month, $day) = preg_split('[/|\.|-]', $Date);
			switch($month){
				case "1":
					$month = "Jan.";
					break;
				case "2":
					$month = "Feb.";
					break;
				case "3":
					$month = "Mar.";
					break;
				case "4":
					$month = "Apr.";
					break;
				case "5":
					$month = "May";
					break;
				case "6":
					$month = "Jun.";
					break;
				case "7":
					$month = "Jul.";
					break;
				case "8":
					$month = "Aug.";
					break;
				case "9":
					$month = "Sep.";
					break;
				case "10":
					$month = "Oct.";
					break;
				case "11":
					$month = "Nov.";
					break;
				case "12":
					$month = "Dec.";
					break;
			}
			$Date = $month.' '.$day.', '.$year;
			
			return $Date;
		}
		
		function formatTime($Time){
			$Temp = substr($Time,11,5);
			$split = explode(":",$Temp);
			$hours = $split[0];
			$minutes = $split[1];
			$AMPM = 'am';
			if($hours == 0){
				$hours = 12;
			}
			if($hours>12){
				$AMPM = 'pm';
				$hours = $hours-12;
			}
			
			$NewTime = $hours.':'.$minutes.$AMPM;
			
			return $NewTime;
		}
		
		function getSettings(){
			$SettingsQuery = mysql_query("SELECT * FROM IDCMS_Settings",$this->connection);
			$Settings = mysql_fetch_array($SettingsQuery);
			
			return $Settings;
		}
		
		function phpSelf($http){
			$Page = substr(strrchr($http, "/"), 1);
			$Page = str_replace(".php", "", $Page);
			return $Page;
		}
		
		function getGravatar( $email, $s = 80, $d = 'identicon', $r = 'g',$atts = array() ) {
			$url = 'http://www.gravatar.com/avatar/';
			$url .= md5( strtolower( trim( $email ) ) );
			$url .= "?s=$s&d=$d&r=$r";
			$url = '<img src="' . $url . '"';
			foreach ( $atts as $key => $val )
				$url .= ' ' . $key . '="' . $val . '"';
			$url .= ' />';
			return $url;
		}
	}
}
?>