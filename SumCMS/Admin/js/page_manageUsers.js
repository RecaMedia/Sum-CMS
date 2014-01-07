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

function editUser(ID){	
	var dictionary = [];
    dictionary["formType"] = "update";
	dictionary["u_User"] = ID;
	
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "page_manageUsers.php");
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

function deleteUser(ID){
	$.post("funcAJX_delUser.php",{id:ID},function(data){
		if(data!=0){
			$('#AJXMsgs').html(data);
		}
		getUsers('');
	});
}

function getUsers(PG){
	$.post("funcAJX_getUsers.php",{pg:PG},function(data){
		if(data!=0){
			$('#UsersList').html(data);
		}
		tooltip();
	});
}

$(document).ready(function(){
	getUsers('');
});