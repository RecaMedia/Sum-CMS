/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config )
{
	config.height = '380px';
	
	config.filebrowserBrowseUrl = '_ckeditor/kcfinder/browse.php?type=files';
	config.filebrowserImageBrowseUrl = '_ckeditor/kcfinder/browse.php?type=files';
	config.filebrowserFlashBrowseUrl = '_ckeditor/kcfinder/browse.php?type=files';
	config.filebrowserUploadUrl = '_ckeditor/kcfinder/upload.php?type=files';
	config.filebrowserImageUploadUrl = '_ckeditor/kcfinder/upload.php?type=files';
	config.filebrowserFlashUploadUrl = '_ckeditor/kcfinder/upload.php?type=files';
	
	config.allowedContent = true;
	config.extraAllowedContent = 'a[!href,document-href]';
	
	config.scayt_autoStartup = true;
	
	config.FormatSource	 = false;
	config.FormatOutput	 = false;
	
	config.entities = false;
	config.htmlencodeoutput = false;
	
	config.extraPlugins = 'codeblock,codeblockadd,codemirror';
	config.codemirror = {
		theme: 'default',
		lineNumbers: true,
		lineWrapping: true,
		matchBrackets: true,
		autoCloseTags: false,
		autoCloseBrackets: true,
		enableSearchTools: true,
		enableCodeFolding: false,
		enableCodeFormatting: true,
		autoFormatOnStart: true,
		autoFormatOnModeChange: true,
		autoFormatOnUncomment: true,
		highlightActiveLine: true,
		showSearchButton: true,
		showTrailingSpace: true,
		highlightMatches: true,
		showFormatButton: true,
		showCommentButton: true,
		showUncommentButton: true,
		showAutoCompleteButton: true
	};
};

CKEDITOR.on( 'dialogDefinition', function( ev ){
	var dialogName = ev.data.name;
	var dialogDefinition = ev.data.definition;
	if ( dialogName == 'link' ){
		dialogDefinition.removeContents( 'upload' );
		dialogDefinition.removeContents( 'advanced' );
		var infoTab = dialogDefinition.getContents( 'info' );      
		infoTab.remove( 'protocol');
	}
});