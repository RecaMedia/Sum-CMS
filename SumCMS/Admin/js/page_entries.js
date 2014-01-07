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

function deleteEntry(ID){
	$.post("funcAJX_delEntry.php",{eid:ID},function(data){
		if(data!=0){
			if($('#entryType').val()=='page'){
				getEntries('','','page','');
			}else if($('#entryType').val()=='blog'){
				getEntries($('#listBy').find(":selected").val(),$('#listOrder').find(":selected").val(),'blog',$('#pg').val());
			}
		}
	});
}

function deleteSelectedEntries(){
	var selected = new Array();
	$.each($("input[name='EID[]']:checked"),function() {
		selected.push($(this).val());
	});
	if(selected.length==1){
		selected = selected[0];
	}
	if(selected.length==0){
		$('#AJXMsgs').html('<div class="ad_row_full" id="alertError">'+
			'<div class="ErrorsTxtColor">'+
				'<button type="button" class="AlertCloseBtn" onclick="removeEle(\'alertError\')">&times;</button>'+
				lang('js_calls','js1')+
			'</div>'+
		'</div>');
		window.scrollTo(0,0);
	}else{
		$.post("funcAJX_delEntry.php",{eid:selected},function(data){
			if(data!=0){
				if($('#entryType').val()=='page'){
					getEntries('','','page','');
				}else if($('#entryType').val()=='blog'){
					getEntries($('#listBy').find(":selected").val(),$('#listOrder').find(":selected").val(),'blog',$('#pg').val());
				}
			}
		});
	}
}

$(document).ready(function(){
	$(".EMenu").hover(function(){
		var divID = $(this).attr('id');
		if($('#EMenu'+divID).length>0){
			$('#EMenu'+divID).fadeIn('fast');
		}
	},function () {
		var divID = $(this).attr('id');
		if($('#EMenu'+divID).length>0){
			$('#EMenu'+divID).fadeOut('fast');
		}
	});
	tooltip();
});