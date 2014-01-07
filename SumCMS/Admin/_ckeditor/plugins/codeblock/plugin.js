/*
 Copyright (c) 2003-2013, CodeBlock - Shannon Reca. All rights reserved.
 For licensing, see LICENSE.html
*/
CKEDITOR.plugins.add( 'codeblock',{
	init: function(editor){
		editor.addCommand( 'codeblockDialog', new CKEDITOR.dialogCommand( 'codeblockDialog' ) );
		editor.ui.addButton('CodeBlock',{
			label: 'Insert Code Block',
			command: 'codeblockDialog',
			icon: this.path + 'images/icon_insertCodeBlock.png'
		});
		CKEDITOR.dialog.add( 'codeblockDialog',function(editor){
			return {
				title : 'Available Code Blocks',
				width : 200,
				height : 160,
				contents :
				[
					{
						id : 'general',
						label : 'Select',
						elements :
						[
							{
								type : 'html',
								html : '<p>Choose any of the available code blocks that were previously created.</p><br><p>To create a code block, click on Code Block icon <img src="_ckeditor/plugins/codeblockadd/images/icon_addCodeBlock.png"/>.</p>'		
							},
							{
								type : 'select',
								id : 'cblocks',
								label : 'Code Blocks',
								validate : CKEDITOR.dialog.validate.notEmpty('A code block must be selected.'),
								items : [],
								onShow : function(element) {
									var element_id = '#' + this.getInputElement().$.id;
									$.ajax({
										type: 'POST',
										url: "funcAJX_getCodeBlocks.php",
										dataType: 'json',
										async: false,
										success: function(data){
											$(element_id).html('');
											$(element_id).append("<option selected='selected'>Select Code Block</option>");
											$.each(data, function(key, value) {   
												$(element_id).append($('<option>',{
													value : '{{'+value+'}}'
												}).text(key)); 
											});
										}
									});
								},
								required : true,
								commit : function( data )
								{
									data.cblocks = this.getValue();
								}
							}
						]
					}
				],
				onOk : function(){
					var dialog = this;
					var data = {};
					this.commitContent(data);
					
					var block = data.cblocks;
					
					if(block==''||block=='undefined'||block==undefined){
						var final = '';
					}else{
						var final = block;
					}
					
					editor.insertHtml(final);
				}
			};
		});
		
	}
});
