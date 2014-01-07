function deleteBlock(id){
	$.post("funcAJX_delBlocks.php",{cbid:id},function(data){
		if(data!=0){
			getBlocks($('#pg').val());
		}
	});
}

function deleteSelectedBlocks(){
	var selected = new Array();
	$.each($("input[name='CBID[]']:checked"),function() {
		selected.push($(this).val());
	});
	if(selected.length==1){
		selected = selected[0];
	}
	if(selected.length==0){
		$('#AJXMsgs').html('<div class="ad_row_full" id="alertError">'+
			'<div class="ErrorsTxtColor">'+
				'<button type="button" class="AlertCloseBtn" onclick="removeEle(\'alertError\')">&times;</button>'+
				lang('js_calls','js11')+
			'</div>'+
		'</div>');
		window.scrollTo(0,0);
	}else{
		$.post("funcAJX_delBlocks.php",{cbid:selected},function(data){
			if(data!=0){
				getBlocks($('#pg').val());
			}
		});
	}
}

function editBlock(ID){
	var dictionary = [];
    dictionary["formType"] = "update";
	dictionary["blockID"] = ID;
	
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "page_newBlock.php");
    for (key in dictionary) {
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", key);
        hiddenField.setAttribute("value", dictionary[key]);
        form.appendChild(hiddenField);
    }
    document.body.appendChild(form);
    form.submit();
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
});