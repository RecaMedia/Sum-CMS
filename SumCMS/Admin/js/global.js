/*
-------------------------- WatermarkInput.js Start ----------------------------
 * Copyright (c) 2007 Josh Bush (digitalbush.com)
 * 
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:

 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE. 

 * Version: Beta 1
 * Release: 2007-06-01
*/ 
(function($) {
	var map=new Array();
	$.Watermark = {
		ShowAll:function(){
			for (var i=0;i<map.length;i++){
				if(map[i].obj.val()==""){
					map[i].obj.val(map[i].text);					
					map[i].obj.css("color",map[i].WatermarkColor);
				}else{
				    map[i].obj.css("color",map[i].DefaultColor);
				}
			}
		},
		HideAll:function(){
			for (var i=0;i<map.length;i++){
				if(map[i].obj.val()==map[i].text)
					map[i].obj.val("");					
			}
		}
	}
	
	$.fn.Watermark = function(text,color) {
		if(!color)
			color="#aaa";
		return this.each(
			function(){		
				var input=$(this);
				var defaultColor=input.css("color");
				map[map.length]={text:text,obj:input,DefaultColor:defaultColor,WatermarkColor:color};
				function clearMessage(){
					if(input.val()==text)
						input.val("");
					input.css("color",defaultColor);
				}

				function insertMessage(){
					if(input.val().length==0 || input.val()==text){
						input.val(text);
						input.css("color",color);	
					}else
						input.css("color",defaultColor);				
				}

				input.focus(clearMessage);
				input.blur(insertMessage);								
				input.change(insertMessage);
				
				insertMessage();
			}
		);
	};
})(jQuery);
//-------------------------- WatermarkInput.js End ----------------------------
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

var inputField;
function BrowseServer(inputId){
	inputField = inputId;
	window.KCFinder = {};
    window.KCFinder.callBack = function(url) {
        window.KCFinder = null;
		document.getElementById(inputField).value = url;
    };
	window.open('_ckeditor/kcfinder/browse.php?type=files','kcfinder_single','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
}

function toggle(ele){
	$('#'+ele).toggle('fast');
}

function removeEle(ele){
	$('#'+ele).remove();
}

function lang(p,k){
	var lang = null;
	$.ajaxSetup({async: false});
	$.post("funcAJX_lang.php",{p:p,k:k},function(data){
		lang = data;
	});
	$.ajaxSetup({async: true});
	return lang;
}

function tooltip(){
	if($('[title]').length > 0){
		$('[title]').hover(function(){
			// Hover over code
			var title = $(this).attr('title');
			if(title!='CKFinder'){
				$(this).data('tipText', title).removeAttr('title');
				if($(".tooltip").length == 0){
					$('<div class="tooltip"><div class="tooltipContent"></div></div>').appendTo('body');
				}
				$('.tooltipContent').html(title);
				$('.tooltip').fadeIn('slow');
			}
		},function(){
			// Hover out code
			$(this).attr('title', $(this).data('tipText'));
			$('.tooltip').remove();
		}).mousemove(function(e){
			var mousex = e.pageX + 10; //Get X coordinates
			var mousey = e.pageY + 10; //Get Y coordinates
			$('.tooltip').css({ top: mousey, left: mousex })
		});
	}
}

var MobileToolbar = false;

function subNav(Sub){
	$('#'+Sub).slideToggle();
}

function newEntry(Type){
	var dictionary = [];
    dictionary["entryType"] = Type;
	
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "page_newEntry.php");
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

function editEntry(Type,ID){
	var dictionary = [];
    dictionary["entryType"] = Type;
    dictionary["formType"] = "update";
	dictionary["entryID"] = ID;
	
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "page_newEntry.php");
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

function getEntries(LB,LO,Type,PG){	
	var dictionary = [];
    dictionary["listBy"] = LB;
    dictionary["listOrder"] = LO;
	dictionary["entryType"] = Type;
	dictionary["pg"] = PG;
	
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "page_entries.php");
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

function getComments(PG){
	var dictionary = [];
	dictionary["pg"] = PG;
	
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "page_comments.php");
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

function getBlocks(PG){
	var dictionary = [];
	dictionary["pg"] = PG;
	
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "page_blocks.php");
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

function chkCurrentPage(Page){
	$('.nextArrow').each(function(index){
		$(this).removeClass('ad_sidebar_selected');
	});
	$('.nextArrow').each(function(index){
		var thisPage = $(this).attr('rel');
		if(thisPage==Page){
			$(this).addClass('ad_sidebar_selected');
			$(this).css('background-image','url(images/nextArrowWhite.png)');
			if($(this).parent().hasClass('ad_sidebar_subwrap')){
				var subID = $(this).parent().attr('id');
				$('#'+subID).show();
			}
		}
	});
}

function resizeContent(){
	var Window = window.innerWidth,
	MainWindow = $('.ad_mainWindow'),
	MainWindowContent = $('.ad_mainWindow .content'),
	MainInnerWindowW = $('#MainWindow').width(),
	Sidebar = $('.ad_sidebar'),
	SidebarContent = $('.ad_sidebar .content'),
	WindowHeight = $(window).height();
	
	var numbers_array = [MainWindowContent.height()+30,WindowHeight];
	var SetSideHeight = Math.max.apply(null,numbers_array);
	
	if(MainInnerWindowW<750){
		$('.ad_col_left').css('width','100%');
		$('.ad_col_right').css('width','100%');
		$('.ad_col_half').css('width','100%');
		$('.ad_col_half .padRight10').attr('style', 'padding-right: 0px !important');
		$('.ad_col_half .padLeft10').attr('style', 'padding-left: 0px !important');
		$('#RightBar').attr('style', 'padding-left: 0px !important');
		MobileToolbar = true;
	}else{
		$('.ad_col_left').css('width',Math.floor(MainInnerWindowW*.7)+'px');
		$('.ad_col_right').css('width',Math.floor(MainInnerWindowW*.3)+'px');
		$('.ad_col_half').css('width','50%'); //Math.floor(MainInnerWindowW*.5)+'px'
		$('.ad_col_half .padRight10').attr('style', '');
		$('.ad_col_half .padLeft10').attr('style', '');
		$('#RightBar').attr('style', '');
		MobileToolbar = false;
	}
	MainWindow.css({
		'position':'absolute'
	});
	MainWindowContent.css({
		'margin-left':'190px'
	});
	Sidebar.css({
		'position':'absolute',
		'top':'0px',
		'width':'180px',
		'height':SetSideHeight+'px',
		'border-top':'',
		'border-right':'1px solid #CED0D0'
	});
	SidebarContent.css({
		'margin-top':'31px'
	});
	
	if(Window<300){
		$('#WelcomeText').hide();
	}else{
		$('#WelcomeText').show();
	}
	
	if($('#kcfinderFrame').length>0){
		$('#kcfinderFrame').css({'width':MainInnerWindowW,'height':'70%'});
	}
	
	if(Window<980){
		MainWindow.css({
			'position':'relative'
		});
		MainWindowContent.css({
			'margin-left':'0px'
		});
		Sidebar.css({
			'position':'relative',
			'width':'100%',
			'height':'',
			'border-top':'5px solid #CED0D0',
			'border-right':''
		});
		SidebarContent.css({
			'margin-top':'0px'
		});
		if($('#kcfinderFrame').length>0){
			$('#kcfinderFrame').css({'width':MainInnerWindowW,'height':'300px'});
			Sidebar.css({
				'top':$('#kcfinderFrame').height()+'px'
			});
		}
	}
	if(typeof ckeditorLoad == 'function'){ 
		ckeditorLoad(MobileToolbar);
	}
	
	
}

function alertCheck(){
	setTimeout(function(){alertReset()}, 10000);
	console.log("Alert check in 10 secs.");
}

function alertReset(){
	console.log("Alert had been checked.");
	if($('#AJXMsgs').html()!=''){
		$('#AJXMsgs').fadeOut('slow',function(){
			$(this).html('').show();
		});
	}
	alertCheck();
}

$(window).resize(function(){
	resizeContent();
});

$(document).ready(function(){	
	resizeContent();
	tooltip();
	alertCheck();
});