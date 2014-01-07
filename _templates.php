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
/*
----------Blog Templates, BlogEntry Templates, and Page Templates----------

[[Author]] - Blog & Blog Entry
[[AuthorEmail]] - Blog & Blog Entry
[[AuthorURL]] - Blog & Blog Entry
[[AuthorFacebook]] - Blog & Blog Entry
[[AuthorTwitter]] - Blog & Blog Entry
[[AuthorLinkedIn]] - Blog & Blog Entry
[[AuthorBio]] - Blog & Blog Entry

[[PageURL]] - Universal
[[SplashImgURL]] - Universal
[[WebsafeTitle]] - Universal
[[Title]] - Universal
[[Content]] - Universal
[[Excerpt]] - Universal
[[Date]] - Universal

[[Paging]] - Blog only
[[SocialShare]] - Blog Entry only
[[Comments]] - Blog Entry only
[[CommentForm]] - Blog Entry only
[[CommentWrap]] - Blog Entry only

----------Comment Template----------

[[Avatar]]
[[Username]]
[[Email]]
[[WebURL]]
[[Comment]]

----------Comment Form Template----------

[[Alert]]
[[Captcha]]

Form input IDS
- IDCMS_input_Username
- IDCMS_input_Email
- IDCMS_input_WebURL
- IDCMS_input_Comment
- IDCMS_input_Captcha
- IDCMS_input_Submit : Value = Comment

----------Comment Wrap----------

[[Comments]]
[[CommentForm]]

----------Contact Form Template----------

[[Alert]]
[[Captcha]]

Form input IDS
- IDCMS_input_FullName
- IDCMS_input_Email
- IDCMS_input_Subject
- IDCMS_input_Comment
- IDCMS_input_Captcha
- IDCMS_input_Submit : Value = Contact

----------Contact Template----------

[[Title]]
[[Content]]
*/

//------------------ Edit Templates and Builds | Do Not Rename Vars ------------------
$Templates = array(
	'BlogEntryTemplate' => '
		[[SplashImgURL]]
		[[Title]]
		[[Content]]
		[[Author]]
		[[Date]]
		[[SocialShare]]
		[[CommentWrap]]
	',
	
	'BlogTemplate' => '
		[[PageURL]]
		[[Title]]
		[[Excerpt]]
	',
	
	'PageTemplate' => '
		[[SplashImgURL]]
		[[Title]]
		[[Content]]
	',
	
	'CommentTemplate' => '
		[[Avatar]]
		[[WebURL]]
		[[Username]]
		[[Date]]
		[[Comment]]
	',
	
	'CommentFormTemplate' => '
		[[Alert]]
		<input id="IDCMS_input_Username" type="text">
		<input id="IDCMS_input_Email" type="text">
		<input id="IDCMS_input_WebURL"type="text">
		<textarea id="IDCMS_input_Comment"></textarea>
		[[Captcha]]
		<input id="IDCMS_input_Captcha">
		<button id="IDCMS_input_Submit" type="submit" value="Comment">Submit Comment</button>
	',
	
	'CommentWrap' => '
		[[Comments]]
		[[CommentForm]]
	',
	
	'ContactTemplate' => '
		[[Title]]
		[[Content]]
	',
	
	'ContactFormTemplate' => '
		[[Alert]]
		<input id="IDCMS_input_FullName" type="text">
		<input id="IDCMS_input_Email" type="text">
		<input id="IDCMS_input_Subject" type="text">
		<textarea id="IDCMS_input_Comment"></textarea>
		[[Captcha]]
		<input id="IDCMS_input_Captcha" type="text">
		<button id="IDCMS_input_Submit" value="Contact">Send Message</button>
	'
);

// Paging Build must contain the following array with keys.

$PagingBuild = array(
	'startWrap' => '',
	'beforePrev' => '[[URL]]',
	'titlePrev' => '',
	'afterPrev' => '',
	'beforeNonLink' => '',
	'afterNonLink' => '',
	'beforeLink' => '[[URL]]',
	'afterLink' => '',
	'beforeNext' => '[[URL]]',
	'titleNext' => '',
	'afterNext' => '',
	'endWrap' => ''
);
?>