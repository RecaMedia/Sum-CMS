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

function deleteComment(id){
	$.post("funcAJX_delComments.php",{cid:id,cp:1},function(data){
		if(data!=0){
			var n = data.split("^");
			if(n[0]=='success'){
				getComments($('#pg').val());
			}
		}
	});
}

function deleteSelectedComments(){
	var selected = new Array();
	$.each($("input[name='CID[]']:checked"),function() {
		selected.push($(this).val());
	});
	if(selected.length==0){
		$('#AJXMsgs').html('<div class="ad_row_full" id="alertError">'+
			'<div class="ErrorsTxtColor">'+
				'<button type="button" class="AlertCloseBtn" onclick="removeEle(\'alertError\')">&times;</button>'+
				lang('js_calls','js8')+
			'</div>'+
		'</div>');
		window.scrollTo(0,0);
	}else{
		for(var i = 0; i < selected.length; i++){
			$.post("funcAJX_delComments.php",{cid:selected[i],cp:1},function(data){
				if(data!=0){
					var n = data.split("^");
					if(n[0]=='success'){
						getComments($('#pg').val());
					}
				}
			});
		}
	}
}

function updatedComment(id){
	$.post("funcAJX_updateComments.php",{cid:id},function(data){
		if(data!=0){
			var n = data.split("^");
			if(n[0]=='success'){
				switch(n[1]){
					case '0':
						$('#Combtn'+n[2]).html('<a href="javascript:void(0);" onclick="updatedComment(\''+n[2]+'\')">'+lang('js_calls','btn3')+'</a><br /><a href="javascript:void(0);" onclick="deleteComment(\''+n[2]+'\')">Delete</a>');
					break;
					case '1':
						$('#Combtn'+n[2]).html('<a href="javascript:void(0);" onclick="updatedComment(\''+n[2]+'\')">'+lang('js_calls','btn4')+'</a><br /><a href="javascript:void(0);" onclick="deleteComment(\''+n[2]+'\')">Delete</a>');
					break;
				}
			}
		}
		$('#MenuSlots').html('<option id="NoOption">'+lang('js_calls','js9')+'</option>'+data);
	});
}