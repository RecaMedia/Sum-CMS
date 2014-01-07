/*
 Copyright (c) 2003-2013, CodeBlock - Shannon Reca. All rights reserved.
 For licensing, see LICENSE.html
*/
CKEDITOR.plugins.add( 'codeblockadd',{
	init: function(editor){
		editor.addCommand( 'codeblockaddDialog', new CKEDITOR.dialogCommand( 'codeblockaddDialog' ) );
		editor.ui.addButton('CodeBlockAdd',{
			label: 'Add Code Block',
			command: 'codeblockaddDialog',
			icon: this.path + 'images/icon_addCodeBlock.png'
		});
		CKEDITOR.dialog.add( 'codeblockaddDialog',function(editor){
			return {
				title : 'Add Your Code Block',
				width : 350,
				height : 250,
				contents :
				[
					{
						id : 'general',
						label : 'Enter Code',
						elements :
						[
							{
								type : 'text',
								id : 'name',
								label : 'Block Name',
								validate : CKEDITOR.dialog.validate.notEmpty( 'This block must have a name.' ),
								required : true,
								commit : function( data )
								{
									data.name = this.getValue();
								}
							},
							{
								type : 'text',
								id : 'tag',
								label : 'Block Tag (No Spaces)',
								validate : CKEDITOR.dialog.validate.notEmpty( 'This block must have a tag.' ),
								required : true,
								commit : function( data )
								{
									data.tag = this.getValue();
								}
							},
							{
								type : 'textarea',
								id : 'blockcontent',
								label : 'Enter Code:',
								validate : CKEDITOR.dialog.validate.notEmpty( 'This field cannot be empty.' ),
								required : true,
								commit : function( data )
								{
									data.blockcontent = this.getValue();
								}
							}
						]
					}
				],
				onOk : function(){
					var dialog = this;
					var data = {};
					this.commitContent(data);
					
					$.post("funcAJX_addCodeBlock.php",{Name:data.name,Tag:data.tag,Code:data.blockcontent},function(data){
						if(data!=0){
							var n = data.split("^");
							alert(n[1]);
						}
					});
				}
			};
		});
	}
});
