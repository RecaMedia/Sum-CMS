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

$start = 0;
$DBLink;

function getSubMenuItems($MenuID,$TargetID,$DBLink2){
	global $DBLink;
	global $start;
	global $GLBLang;
	
	$SubItemQuery = mysql_query("SELECT * FROM IDCMS_MenuOrder WHERE MenuID='$MenuID' AND ParentID='$TargetID' ORDER BY ID ASC",$DBLink2)or die(mysql_error());
	$SubItemExist = mysql_num_rows($SubItemQuery);
	if($SubItemExist>0){
		$SubList .= '<ol>';
		while($submi = mysql_fetch_array($SubItemQuery)){
			$subTarget = $submi['TargetID'];
			$subURL = $submi['URL'];
			$subTitle = $submi['Title'];
			
			if(isset($subURL)&&$subURL!=""){
				$SubList .= '
				<li id="MU_URL'.$start.'">
				<div class="divWrap">
					<div>
						<div class="FloatLeft ad_mod_whiteWrap" style="width:50%;">
							<input id="titles" name="titles[]" type="text" value="'.stripslashes($subTitle).'">
						</div>
						<div class="FloatRight" style="margin-top:8px;">
							<a href="javascript:void(0);" onclick="toggle(\'MUEdit_'.$start.'\')">'.$GLBLang['btn1'].'</a> | <a href="javascript:void(0);" onclick="removeMenuEle(\'MU_URL'.$start.'\')">'.$GLBLang['btn2'].'</a>
						</div>
						<div class="clear"></div>
					</div>
					<div id="MUEdit_'.$start.'" class="Hidden ad_mod_whiteWrap marTop5">
						<input id="urls" name="urls[]" type="text" value="'.$subURL.'">
					</div>
				</div>
				</li>';
			}else{
				$subSingleItemQuery = mysql_query("SELECT * FROM IDCMS_Entries WHERE ID='$subTarget' LIMIT 1",$DBLink2);
				$subSingleItemExist = mysql_num_rows($subSingleItemQuery);
				if($subSingleItemExist>0){
					$subsi = mysql_fetch_array($subSingleItemQuery);
					$subPageTitle = ucwords(str_replace("_"," ",$subsi['WebsafeTitle']));
				}else{
					if($subTarget=="Index"){
						$subPageTitle = "S-Home";
					}else if($subTarget=="Blog"){
						$subPageTitle = "S-Blog";
					}else if($subTarget=="Contact"){
						$subPageTitle = "S-Contact";
					}else if(preg_match("/CAT/i",$subTarget)){
						$SqlTarget = preg_replace("/CAT/","",$subTarget);							
						$subCateQuery = mysql_query("SELECT * FROM IDCMS_Categories WHERE ID='$SqlTarget' LIMIT 1",$DBLink)or die(mysql_error());
						$subCateExist = mysql_num_rows($subCateQuery);
						if($subCateExist>0){
							$si = mysql_fetch_array($subCateQuery);
							$subPageTitle = ucwords(str_replace("_"," ",$si['WebsafeName']));
						}else{
							$subPageTitle = $GLBLang['msg1'];
						}
					}else{
						$subPageTitle = $GLBLang['msg1'];
					}
				}
				
				$SubList .= '
				<li id="MU_'.$subTarget.'">
				<div class="divWrap">
					<div>
						'.$subPageTitle.' <div class="FloatRight"><a href="javascript:void(0);" onclick="toggle(\'MUEdit_'.$start.'\')">'.$GLBLang['btn1'].'</a> | <a href="javascript:void(0);" onclick="removeMenuEle(\'MU_'.$subTarget.'\')">'.$GLBLang['btn2'].'</a></div>
					</div>
					<div id="MUEdit_'.$start.'" class="Hidden ad_mod_whiteWrap marTop5">
						<input id="titles" name="titles[]" type="text" value="'.stripslashes($subTitle).'">
					</div>
				</div>
				<input id="urls" name="urls[]" type="hidden">
				</li>';
			}
			$start++;
		}
		$SubList .= '</ol>';
		
		return $SubList;
	}else{
		return '';
	}
}

if($log_Role=='admin' || $log_Role=='manager'){
	global $DBLink;
	$DBLink = MySqlConnect();

	if(isset($_POST['id']) && $_POST['id']!="" && preg_match("/^[0-9]+$/", $_POST['id'])){
		$MenuID = mysql_escape_string($_POST['id']);
		$MenuQuery = mysql_query("SELECT * FROM IDCMS_Menus WHERE ID='$MenuID' LIMIT 1",$DBLink);
		$MenuExist = mysql_num_rows($MenuQuery);
		if($MenuExist>0){
			$m = mysql_fetch_array($MenuQuery);
			$MenuSlot = $m['Slot'];
			$MenuItemQuery = mysql_query("SELECT * FROM IDCMS_MenuOrder WHERE MenuID='$MenuID' AND ParentID='' ORDER BY ID ASC",$DBLink);
			$MenuItemExist = mysql_num_rows($MenuItemQuery);
			$List = '';
			if($MenuItemExist>0){
				while($mi = mysql_fetch_array($MenuItemQuery)){
					$Target = $mi['TargetID'];
					$URL = $mi['URL'];
					$Title = $mi['Title'];
					
					if(isset($URL)&&$URL!=""){
						$List .= '
						<li id="MU_URL'.$start.'">
						<div class="divWrap">
							<div>
								<div class="FloatLeft ad_mod_whiteWrap" style="width:50%;">
									<input id="titles" name="titles[]" type="text" value="'.stripslashes($Title).'">
								</div>
								<div class="FloatRight" style="margin-top:8px;">
									<a href="javascript:void(0);" onclick="toggle(\'MUEdit_'.$start.'\')">'.$GLBLang['btn1'].'</a> | <a href="javascript:void(0);" onclick="removeMenuEle(\'MU_URL'.$start.'\')">'.$GLBLang['btn2'].'</a>
								</div>
								<div class="clear"></div>
							</div>
							<div id="MUEdit_'.$start.'" class="Hidden ad_mod_whiteWrap marTop5">
								<input id="urls" name="urls[]" type="text" value="'.$URL.'">
							</div>
						</div>';
					}else{
						$SingleItemQuery = mysql_query("SELECT * FROM IDCMS_Entries WHERE ID='$Target' LIMIT 1",$DBLink);
						$SingleItemExist = mysql_num_rows($SingleItemQuery);
						if($SingleItemExist>0){
							$si = mysql_fetch_array($SingleItemQuery);
							$PageTitle = ucwords(str_replace("_"," ",$si['WebsafeTitle']));
						}else{
							if($Target=="Index"){
								$PageTitle = "S-Home";
							}else if($Target=="Blog"){
								$PageTitle = "S-Blog";
							}else if($Target=="Contact"){
								$PageTitle = "S-Contact";
							}else if(preg_match("/CAT/i",$Target)){
								$SqlTarget = preg_replace("/CAT/","",$Target);							
								$CateQuery = mysql_query("SELECT * FROM IDCMS_Categories WHERE ID='$SqlTarget' LIMIT 1",$DBLink);
								$CateExist = mysql_num_rows($CateQuery);
								if($CateExist>0){
									$s = mysql_fetch_array($CateQuery);
									$PageTitle = ucwords(str_replace("_"," ",$s['WebsafeName']));
								}else{
									$PageTitle = $GLBLang['msg1'];
								}
							}else{
								$PageTitle = $GLBLang['msg1'];
							}
						}
						
						$List .= '
						<li id="MU_'.$Target.'">
						<div class="divWrap">
							<div>
								'.$PageTitle.' <div class="FloatRight"><a href="javascript:void(0);" onclick="toggle(\'MUEdit_'.$start.'\')">'.$GLBLang['btn1'].'</a> | <a href="javascript:void(0);" onclick="removeMenuEle(\'MU_'.$Target.'\')">'.$GLBLang['btn2'].'</a></div>
							</div>
							<div id="MUEdit_'.$start.'" class="Hidden ad_mod_whiteWrap marTop5">
								<input id="titles" name="titles[]" type="text" value="'.stripslashes($Title).'">
							</div>
						</div>
						<input id="urls" name="urls[]" type="hidden">';
					}
					
					$start++;
					
					$List .= getSubMenuItems($MenuID,$Target,$DBLink);
					
					$List .= '</li>';
				}
			}
			
			echo "1^".$MenuID."^".$MenuSlot."^".$List ."^";
		}else{
			echo "0^".$GLBLang['msg2']."^";
		}
	}else{
		echo "0^".$GLBLang['msg3']."^";
	}
	
	mysql_close($DBLink);
}
?>