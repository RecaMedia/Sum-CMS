var editor;

CodeMirror.commands.autocomplete = function(cm) {
	CodeMirror.showHint(cm, CodeMirror.htmlHint);
}

function saveCodeBlock(){
	var cName = $('#c_Name').val(),
	cTag = $('#c_Tag').val(),
	cBlock = editor.getValue();
	
	if(cName==''||cTag==''||cBlock==''){
		$('#AJXMsgs').html('<div class="ad_row_full" id="alertError">'+
			'<div class="ErrorsTxtColor">'+
				'<button type="button" class="AlertCloseBtn" onclick="removeEle(\'alertError\')">&times;</button>'+
				lang('js_calls','js10')+
			'</div>'+
		'</div>');
		window.scrollTo(0,0);
	}else{
		$.post("funcAJX_addCodeBlock.php",{Name:cName,Tag:cTag,Code:cBlock},function(data){
			if(data!=0){
				var n = data.split("^");
				if(n[0]==1){
					$('#AJXMsgs').html('<div class="ad_row_full" id="alertSuccess">'+
						'<div class="SuccessTxtColor">'+
							'<button type="button" class="AlertCloseBtn" onclick="removeEle(\'alertSuccess\')">&times;</button>'+
							n[1]+
						'</div>'+
					'</div>');
				}else{
					$('#AJXMsgs').html('<div class="ad_row_full" id="alertError">'+
						'<div class="ErrorsTxtColor">'+
							'<button type="button" class="AlertCloseBtn" onclick="removeEle(\'alertError\')">&times;</button>'+
							n[1]+
						'</div>'+
					'</div>');
				}
				window.scrollTo(0,0);
			}
		});
	}
}