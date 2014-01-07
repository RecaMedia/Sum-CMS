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

function ckeditorLoad(Mobile){
	var instance = CKEDITOR.instances['entryEditor'];
	if(Mobile){
    	if(!instance){
			CKEDITOR.replace('entryEditor',{
				toolbar : [
					['Source','-','Bold','Italic','Strike','-','RemoveFormat'],
				],
				filebrowserWindowWidth : '720',
				filebrowserWindowHeight : '480'
			});
		}
	}else{
		if(!instance){
			CKEDITOR.replace('entryEditor',{
				toolbar : [
					{ name: 'code', items : ['Source','CodeMirror','-','CodeBlock','CodeBlockAdd'] },
					{ name: 'document', items : ['NewPage','Preview','Print'] },
					{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
					{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
					{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
					{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
					'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
					{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
					{ name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
					{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
					{ name: 'colors', items : [ 'TextColor','BGColor' ] },
					{ name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
				],
				filebrowserWindowWidth : '720',
				filebrowserWindowHeight : '480'
			});
		}
	}
	CKEDITOR.on('dialogDefinition', function(ev){
		var dialogName = ev.data.name;
		var dialogDefinition = ev.data.definition;
		if (dialogName == 'image') {
			dialogDefinition.removeContents('Link');
			dialogDefinition.removeContents('Upload');
		}
	});
}

function deleteComment(id){
	$.post("funcAJX_delComments.php",{cid:id},function(data){
		if(data!=0){
			var n = data.split("^");
			if(n[0]=='success'){
				$('#Combox'+n[1]).hide();
				$('#AJXMsgs').html('<div class="ad_row_full" id="alertSuccess">'+
					'<div class="SuccessTxtColor">'+
						'<button type="button" class="AlertCloseBtn" onclick="removeEle(\'alertSuccess\')">&times;</button>'+
						lang('js_calls','js5')+
					'</div>'+
				'</div>');
				window.scrollTo(0,0);
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
				lang('js_calls','js6')+
			'</div>'+
		'</div>');
		window.scrollTo(0,0);
	}else{
		for(var i = 0; i < selected.length; i++){
			$.post("funcAJX_delComments.php",{cid:selected[i]},function(data){
				if(data!=0){
					var n = data.split("^");
					if(n[0]=='success'){
						$('#Combox'+n[1]).hide();
						$('#AJXMsgs').html('<div class="ad_row_full" id="alertSuccess">'+
							'<div class="SuccessTxtColor">'+
								'<button type="button" class="AlertCloseBtn" onclick="removeEle(\'alertSuccess\')">&times;</button>'+
								lang('js_calls','js5')+
							'</div>'+
						'</div>');
						window.scrollTo(0,0);
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
						$('#Combtn'+n[2]).html('<a href="javascript:void(0);" onclick="updatedComment(\''+n[2]+'\')">Approved</a><br /><a href="javascript:void(0);" onclick="deleteComment(\''+n[2]+'\')">Delete</a>');
					break;
					case '1':
						$('#Combtn'+n[2]).html('<a href="javascript:void(0);" onclick="updatedComment(\''+n[2]+'\')">Unapprove</a><br /><a href="javascript:void(0);" onclick="deleteComment(\''+n[2]+'\')">Delete</a>');
					break;
				}
			}
		}
		$('#MenuSlots').html('<option id="NoOption">'+lang('js_calls','js7')+'</option>'+data);
	});
}

$(document).ready(function(){
	resizeContent();
	$("#entryTitle").Watermark("[Enter a title for this entry.]","#999999");
	$("#entrySplashImg").Watermark("[Enter URL of splash image.]","#999999");
	$("#entryKeywords").Watermark("[Enter keywords for this post. Separate with commas, ex:(one, two).]","#999999");
	$("#entryDescription").Watermark("[Enter description for this post.]","#999999");
});