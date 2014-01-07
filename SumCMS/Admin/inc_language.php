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

$GLBLanguage = array(
	// Languages Level ----------------------------------------------
	'English' => array(
		// All Pages   ----------------------------------------------
		
		// Leave any varialbes within the values, as is. (e.g.$MyVar)
		'func_activate' => array(
			// Key => Value
			'msg1' => 'You have successfully activated your account.',
			'msg2' => "<a href=\"$GLB_Domain/SumCMS/Admin/\">Click here</a> to log in.",
			'msg3' => 'We ran into an error activating your account.<br />Please contact the admin who created your account.',
			'msg4' => 'This account does not exist.',
			'msg5' => 'You provided an incorrect email address.'
		),
		'func_mail' => array(
			'msg1' => "To access your account, please activate it by clicking or following the link below:\n
$Domain/activate/$EncodeEmail",
			'msg2' => "Your account has already been activated for you by an admin.",
			'msg3' => "Hi $Fname,\n\n An account has been created for you to manage $Domain. $ActiveMsg\n\n To log in, please use the information below:\n\n Email: $Email\n Password: $Pass\n\n $Domain/SumCMS/Admin/",
			'msg4' => 'Login for'
		),
		'funcAJX_addCodeBlock' => array(
			'msg1' => 'Code Block successfully updated!',
			'msg2' => 'Code Block successfully added!',
			'msg3' => 'There was an error adding Code Block.'
		),
		'funcAJX_delBlocks' => array(
			'msg1' => "$SuccessCount out of $TotalCount blocks have been deleted.",
			'msg2' => "Only $SuccessCount out of $TotalCount blocks were deleted.",
			'msg3' => "Block has been deleted.",
			'msg4' => "There was an error deleting this block."
		),
		'funcAJX_delCategories' => array(
			'msg1' => 'You have successfully deleted this category.',
			'msg2' => 'We ran into an error deleting this category. Please try again.'
		),
		'funcAJX_delComments' => array(
			'msg1' => "Comments have been deleted."
		),
		'funcAJX_delEntry' => array(
			'msg1' => "$SuccessCount out of $TotalCount entries have been deleted.",
			'msg2' => "Only $SuccessCount out of $TotalCount entries were deleted.",
			'msg3' => "Entry has been deleted.",
			'msg4' => "There was an error deleting this entry.",
			'msg5' => "Error deleting entries."
		),
		'funcAJX_delUser' => array(
			'msg1' => 'You have successfully deleted this user.',
			'msg2' => 'We ran into an error deleting this user. Please try again.'
		),
		'funcAJX_getCategories' => array(
			'sub1' => 'Categories',
			'btn1' => 'Edit',
			'btn2' => 'Delete',
			'msg1' => 'You currently have no categories.'
		),
		'funcAJX_getUsers' => array(
			'sub1' => 'Role',
			'sub2' => 'Name',
			'sub3' => 'Status',
			'btn1' => 'Edit',
			'btn2' => 'Delete',
			'msg1' => 'Active',
			'msg2' => 'Pending',
			'msg3' => " title=\"Last login: $GLBFunc->formatDate($U[LastLogin]) at $GLBFunc->formatTime($U[LastLogin]).\"",
			'msg4' => 'You currently have no users.'
		),
		'funcAJX_loadMenu' => array(
			'btn1' => 'Edit',
			'btn2' => 'Remove',
			'msg1' => 'Entry does not exist.',
			'msg2' => 'Menu not found.',
			'msg3' => 'Menu ID not provided.'
		),
		'funcAJX_saveMenu' => array(
			'msg1' => "$_POST[s] has been saved.",
			'msg2' => "Unable to save menu.",
			'msg3' => "Menu does not exist."
		),
		'inc_header' => array(
			'sub1' => 'Admin Panel',
			'sub2' => 'Hello',
			'btn1' => 'Logout',
			'btn2' => 'My Account'
		),
		'inc_sidebar' => array(
			'btn1' => 'Dashboard',
			'btn2' => 'Settings',
			'btn3' => 'Manage Users',
			'btn4' => 'Blog',
			'btn5' => 'All Entries',
			'btn6' => 'New Entry',
			'btn7' => 'Categories',
			'btn8' => 'Comments',
			'btn9' => 'Pages',
			'btn10' => 'All Pages',
			'btn11' => 'New Page',
			'btn12' => 'Code Blocks',
			'btn13' => 'All Blocks',
			'btn14' => 'New Block',
			'btn15' => 'Menus',
			'btn16' => 'Media Files'
		),
		'index' => array(
			'msg1' => 'Fields are blank.',
			'msg2' => 'Invalid Email.',
			'msg3' => 'This account has not been confirmed.',
			'msg4' => 'You have an incorrect password.',
			'msg5' => 'There is no record of this account.',
			'sub1' => 'Login',
			'sub2' => 'EMAIL',
			'sub3' => 'PASSWORD',
			'btn1' => 'Log In'
		),
		'page_blocks' => array (
			'sub1' => 'Name',
			'sub2' => 'Tag',
			'btn1' => 'Edit',
			'btn2' => 'Delete',
			'btn3' => 'Delete Blocks',
			'msg1' => 'You currently have no Blocks.',
			'PT' => 'Code Blocks'
		),
		'page_categories' => array(
			'msg1' => 'This category does not exist.',
			'msg2' => 'Please fill out all inputs.',
			'msg3' => 'updated',
			'msg4' => 'updating',
			'msg5' => 'added',
			'msg6' => 'adding',
			'msg7' => "You have successfully $SucTxt $c_Name category.",
			'msg8' => "We ran into an error $ErrTxt $c_Name category.",
			'PT' => 'Blog Categories',
			'sub1' => 'Update Category',
			'sub2' => 'Add Category',
			'sub3' => "$FormBtnTitle Form",
			'sub4' => 'Name',
			'sub5' => 'Description'
		),
		'page_comments' => array(
			'sub1' => 'From',
			'sub2' => 'Comment',
			'sub3' => 'Date',
			'sub4' => 'Blog Entry',
			'btn1' => 'Approved',
			'btn2' => 'Unapprove',
			'btn3' => 'Delete',
			'btn4' => 'Delete Comments',
			'msg1' => 'You currently have no comments.',
			'PT' => 'Comments'
		),
		'page_dashboard' => array(
			'msg1' => 'You currently have not published any blog entries.',
			'PT' => 'Dashboard',
			'sub1' => 'Currently',
			'sub2' => 'Content',
			'sub3' => 'Published Blog Entries',
			'sub4' => 'Published Pages',
			'sub5' => 'Categories',
			'sub6' => 'Discussion',
			'sub7' => 'Comments',
			'sub8' => 'Approved',
			'sub9' => 'Unapproved',
			'sub10' => 'You are using',
			'sub11' => 'For more information regarding Sum CMS, please visit',
			'sub12' => 'Latest Blog Entries'
		),
		'page_entries' => array(
			'sub1' => 'Author',
			'sub2' => 'Categories',
			'sub3' => 'Created on',
			'sub4' => 'Last Updated',
			'sub5' => 'Title',
			'btn1' => 'Edit',
			'btn2' => 'Delete',
			'btn3' => 'Delete Entries',
			'msg1' => 'Published',
			'msg2' => 'Unpublished',
			'msg3' => 'You',
			'msg4' => 'You currently have no',
			'msg5' => 'blog entries',
			'msg6' => 'pages',
			'PT1' => 'Blog',
			'PT2' => 'Page',
			'PT3' => 'Entries',
			'sub6' => 'Descending',
			'sub7' => 'Ascending',
			'sub8' => 'Order',
			'sub9' => 'Title',
			'sub10' => 'Date',
			'sub11' => 'Update',
			'sub12' => 'Sort By'
		),
		'page_manageFiles' => array(
			'PT' => "Manage Media Files"
		),
		'page_manageUsers' => array(
			'msg1' => 'Activated.',
			'msg2' => 'This user does not exist.',
			'btn1' => 'Update User',
			'btn2' => 'Add User',
			'msg3' => 'Please fill out all inputs.',
			'msg4' => 'Invalid email.',
			'msg5' => 'An account already exist with this email.',
			'msg6' => 'reinstated',
			'msg7' => 'updating',
			'msg8' => 'updated',
			'msg9' => 'added',
			'msg10' => 'adding',
			'msg11' => " An email has been sent to $u_Fname with his or her login credentials.",
			'msg12' => "We ran into an error $ErrTxt this user. Please try again.",
			'PT' => 'Manage Users',
			'sub1' => 'First Name',
			'sub2' => 'Last Name',
			'sub3' => 'Email',
			'sub4' => 'User Role:',
			'sub5' => 'Admin',
			'sub6' => 'Manager',
			'sub7' => 'User',
			'sub8' => 'Active',
			'btn3' => 'Add New User'
		),
		'page_menus' => array(
			'PT' => 'Menus',
			'msg1' => 'Select a menu tab to load menu items.',
			'btn1' => 'Clear All',
			'btn2' => 'Save Menu',
			'sub1' => 'Menu Items',
			'btn3' => 'Add Item'
		),
		'page_myaccount' => array(
			'btn1' => 'Update Account',
			'msg1' => 'Please fill out all inputs.',
			'msg2' => 'Invalid email.',
			'msg3' => 'An account already exist with this email.',
			'msg4' => 'Your account has been updated.',
			'msg5' => 'We ran into an error updating your account.',
			'PT' => 'My Account',
			'sub1' => 'Account Settings',
			'sub2' => 'First Name',
			'sub3' => 'Last Name',
			'sub4' => 'Nickname',
			'sub5' => 'Display Name',
			'sub6' => 'Email',
			'sub7' => 'Password',
			'sub8' => 'Profile Information',
			'sub9' => 'Personal URL',
			'sub10' => 'Facebook URL',
			'sub11' => 'Twitter URL',
			'sub12' => 'LinkedIn URL',
			'sub13' => 'Bio'
		),
		'page_newBlock' => array(
			'msg1' => 'Unable to load Block.',
			'PT' => 'Code Block',
			'sub1' => 'Code Block Editor',
			'sub2' => 'Name',
			'sub3' => 'Tag',
			'sub4' => 'No Spaces',
			'sub5' => 'Press <strong>ctrl-space</strong> to activate completion.',
			'sub6' => 'Code',
			'btn1' => 'Save'
		),
		'page_newEntry' => array(
			'msg1' => 'Please enter title and content for this entry.',
			'msg2' => 'An entry already exist with this title.',
			'msg3' => 'You have successfully saved this entry.',
			'msg4' => 'You have successfully updated this entry.',
			'msg5' => 'You have successfully published this entry.',
			'msg6' => 'You have successfully saved and published this entry.',
			'msg7' => 'You have successfully unpublished this entry.',
			'msg8' => "We ran into an error with this entry. ($mysqlError) Please try again.",
			'msg9' => 'You currently have no categories.',
			'btn1' => 'Approved',
			'btn2' => 'Delete',
			'btn3' => 'Unapprove',
			'msg10' => 'You currently do not have any comments.',
			'msg11' => "You do not have access to this $entryType entry.",
			'btn4' => 'Unpublish',
			'btn5' => 'Update',
			'btn6' => 'New Entry',
			'msg12' => "Unable to reload this $entryType entry.",
			'btn7' => 'Publish',
			'btn8' => 'Save',
			'msg13' => 'You currently have no categories.',
			'PT1' => 'New',
			'PT2' => 'Blog Entry',
			'PT3' => 'Page',
			'sub1' => 'This entry created by',
			'sub2' => 'Make this entry the home page.',
			'sub3' => 'Direct URL',
			'sub4' => 'Not available',
			'sub5' => 'Comments',
			'btn9' => 'Delete Comments',
			'sub6' => 'Do not allow comments for this entry.',
			'sub7' => 'Splash Image',
			'sub8' => 'Enter URL of the splash image for this post',
			'btn10' => 'Select File',
			'sub9' => 'Categories',
			'sub10' => 'Keywords',
			'sub11' => 'Description',
			'sub12' => 'Auto-generate description from content.'
		),
		'page_settings' => array(
			'msg1' => 'Please fill all inputs before updating settings.',
			'msg2' => 'Incorrect file size.',
			'msg3' => 'Please set language.',
			'msg4' => 'You have successfully updated your settings.',
			'msg5' => 'We ran into an error with this entry. Please try again.',
			'PT' => 'Settings',
			'sub1' => 'General',
			'sub2' => 'Domain',
			'sub3' => 'Upload Path',
			'sub4' => 'Site Name',
			'sub5' => 'Logo URL',
			'sub6' => 'Contact Email',
			'sub7' => 'Max Upload File Size',
			'sub8' => 'Number of Blog Entries per page',
			'sub9' => 'Index URL',
			'sub10' => 'Google Analytics',
			'sub11' => 'Tracking Code',
			'sub12' => 'Switches',
			'sub13' => 'Set Language',
			'sub14' => 'Auto-Approve Comments',
			'sub15' => 'Approve all future comments for blog entries.',
			'btn1' => 'Browse',
			'btn2' => 'Update'
		),
		'js_calls' => array(
			'js1' => 'You have no entries selected.',
			'js2' => 'You have not registered any menus',
			'js3' => 'Please register your menus within the design and layout. For more information, please visit',
			'js4' => 'You have no menu items listed.',
			'js5' => 'Comments have been deleted.',
			'js6' => 'You have no comments selected.',
			'js7' => 'Select an available slot for this menu',
			'js8' => 'You have no comments selected.',
			'js9' => 'Select an available slot for this menu',
			'js10' => 'Please fill out all inputs.',
			'js11' => 'You have no blocks selected.',
			'btn1' => 'Edit',
			'btn2' => 'Remove',
			'btn3' => 'Approve',
			'btn4' => 'Unapprove'
		)
	),
	// Languages Level ----------------------------------------------
	'Spanish' => array(
		// All Pages   ----------------------------------------------
		// Leave any varialbes within the values, as is. (e.g.$MyVar)
		'func_activate' => array(
			// Key => Value
			'msg1' => 'Ha activado su cuenta.',
			'msg2' => "<a href=\"$GLB_Domain/SumCMS/Admin/\">Haga clic aqu&iacute;</a> para iniciar sesi&oacute;n.",
			'msg3' => 'Nos encontramos con un error de activaci&oacute;n de su cuenta.<br />Por favor, p&oacute;ngase en contacto con el administrador que cre&oacute; su cuenta.',
			'msg4' => 'Esta cuenta no existe.',
			'msg5' => 'Se proporcion&oacute; una direcci&oacute;n de correo electr&oacute;nico incorrecta.'
		),
		'func_mail' => array(
			'msg1' => "Para acceder a su cuenta, por favor, activa haciendo clic o seguir el enlace abajo:\n
$Domain/activate/$EncodeEmail",
			'msg2' => "Su cuenta ha sido activada para usted por un administrador.",
			'msg3' => "Hola $Fname,\n\n Una cuenta ha sido creada para que pueda administrar $Domain. $ActiveMsg\n\n Para iniciar sesi&oacute;n, por favor utilice la siguiente informaci&oacute;n:\n\n Email: $Email\n Password: $Pass\n\n $Domain/SumCMS/Admin/",
			'msg4' => 'Inicie la sesi&oacute;n para'
		),
		'funcAJX_addCodeBlock' => array(
			'msg1' => 'Bloque de c&oacute;digo actualizado correctamente!',
			'msg2' => 'Bloque de c&oacute;digo agregado con &eacute;xito!',
			'msg3' => 'Hubo un error al agregar bloque de c&oacute;digo.'
		),
		'funcAJX_delBlocks' => array(
			'msg1' => "$SuccessCount de $TotalCount bloques se han eliminado.",
			'msg2' => "S&oacute;lo $SuccessCount de $TotalCount bloques se han suprimido.",
			'msg3' => "La bloque ha sido eliminada.",
			'msg4' => "Hubo un error al eliminar la bloque."
		),
		'funcAJX_delCategories' => array (
			'msg1' => 'Elimin&oacute; correctamente esta categor&iacute;a.',
			'msg2' => 'Nos encontramos con un error eliminar esta categor&iacute;a. Por favor, int&eacute;ntelo de nuevo. '
		),
		'funcAJX_delComments' => array (
			'msg1' => "Comentarios se han eliminado."
		),
		'funcAJX_delEntry' => array (
			'msg1' => "$SuccessCount de $TotalCount entradas se han eliminado.",
			'msg2' => "S&oacute;lo $SuccessCount de $TotalCount entradas se han suprimido.",
			'msg3' => "La entrada ha sido eliminada.",
			'msg4' => "Hubo un error al eliminar la entrada.",
			'msg5' => "Error al eliminar entradas."
		),
		'funcAJX_delUser' => array (
			'msg1' => 'Elimin&oacute; correctamente a este usuario.',
			'msg2' => 'Nos encontramos con un error eliminar este usuario. Por favor, int&eacute;ntelo de nuevo. '
		),
		'funcAJX_getCategories' => array (
			'sub1' => 'Categor&iacute;as',
			'btn1' => 'Editar',
			'btn2' => 'Borrar',
			'msg1' => 'Por ahora no tiene categor&iacute;as.'
		),
		'funcAJX_getUsers' => array (
			'sub1' => 'Papel',
			'sub2' => 'Nombre',
			'sub3' => 'Estado',
			'btn1' => 'Editar',
			'btn2' => 'Borrar',
			'msg1' => 'Activa',
			'msg2' => 'En espera',
			'msg3' => " title=\"Last login: $GLBFunc->formatDate($U[LastLogin]) at $GLBFunc->formatTime($U[LastLogin]).\"",
			'msg4' => 'Por ahora no tiene usuarios.'
		),
		'funcAJX_loadMenu' => array (
			'btn1' => 'Editar',
			'btn2' => 'Eliminar',
			'msg1' => 'La entrada no existe.',
			'msg2' => 'Men&uacute; no se encuentra.',
			'msg3' => 'Men&uacute; ID no proporcionada.'
		),
		'funcAJX_saveMenu' => array (
			'msg1' => "$_POST[s] ha sido guardada.",
			'msg2' => "No se puede guardar el men&uacute;.",
			'msg3' => "Men&uacute; no existe."
		),
		'inc_header' => array (
			'sub1' => 'Administraci&oacute;n',
			'sub2' => 'Hola',
			'btn1' => 'Salir',
			'btn2' => 'Mi cuenta'
		),
		'inc_sidebar' => array (
			'btn1' => 'Salpicadero',
			'btn2' => 'Configuraci&oacute;n',
			'btn3' => 'Usuarios',
			'btn4' => 'Blog',
			'btn5' => 'Todas Blog',
			'btn6' => 'Nueva Blog',
			'btn7' => 'Categor&iacute;as',
			'btn8' => 'Comentarios',
			'btn9' => 'P&aacute;ginas',
			'btn10' => 'Todas P&aacute;ginas',
			'btn11' => 'Nueva P&aacute;gina',
			'btn12' => 'Bloques de c&oacute;digo',
			'btn13' => 'Todos los bloques',
			'btn14' => 'Nuevo bloque',
			'btn15' => 'Men&uacute;s',
			'btn16' => 'Archivos'
		),
		'index' => array (
			'msg1' => 'Los campos est&aacute;n en blanco.',
			'msg2' => 'inv&aacute;lido Email.',
			'msg3' => 'No se ha confirmado esta cuenta.',
			'msg4' => 'Usted tiene una contrase&ntilde;a incorrecta.',
			'msg5' => 'No hay registro de esta cuenta.',
			'sub1' => 'Login',
			'sub2' => 'EMAIL',
			'sub3' => 'PASSWORD',
			'btn1' => 'Iniciar la Sesi&oacute;n'
		),
		'page_blocks' => array (
			'sub1' => 'Nombre',
			'sub2' => 'Etiqueta',
			'btn1' => 'Editar',
			'btn2' => 'Borrar',
			'btn3' => 'Eliminar Bloques',
			'msg1' => 'Por ahora no tiene bloques.',
			'PT' => 'Bloques C&oacute;digo'
		),
		'page_categories' => array (
			'msg1' => 'no existe esta categor&iacute;a.',
			'msg2' => 'Por favor complete todas las entradas.',
			'msg3' => 'actualizado',
			'msg4' => 'actualizaci&oacute;n',
			'msg5' => 'a&ntilde;adido',
			'msg6' => 'a&ntilde;adir',
			'msg7' => "Usted tiene $SucTxt &eacute;xito $c_Name.",
			'msg8' => "Nos encontramos con un error $ErrTxt $c_Name categor&iacute;a.",
			'PT' => 'Categor&iacute;as del Blog',
			'sub1' => 'Actualizar Categor&iacute;a',
			'sub2' => 'A&ntilde;adir Categor&iacute;a',
			'sub3' => "Formulario de $FormBtnTitle",
			'sub4' => 'Nombre',
			'sub5' => 'Descripci&oacute;n'
		),
		'page_comments' => array (
			'sub1' => 'De',
			'sub2' => 'Comentario',
			'sub3' => 'Fecha',
			'sub4' => 'Blog',
			'btn1' => 'Aprobado',
			'btn2' => 'Desaprobar',
			'btn3' => 'Borrar',
			'btn4' => 'Borrar comentarios',
			'msg1' => 'Por ahora no tiene comentarios.',
			'PT' => 'Comentarios'
		),
		'page_dashboard' => array (
			'msg1' => 'Usted actualmente no ha publicado ninguna entrada en el blog.',
			'PT' => 'Salpicadero',
			'sub1' => 'En la actualidad',
			'sub2' => 'Contenido',
			'sub3' => 'entradas de blog publicadas',
			'sub4' => 'P&aacute;ginas publicadas',
			'sub5' => 'Categor&iacute;as',
			'sub6' => 'Discusi&oacute;n',
			'sub7' => 'Comentarios',
			'sub8' => 'Aprobado',
			'sub9' => 'No aprobado',
			'sub10' => 'Est&aacute; utilizando',
			'sub11' => 'Para obtener m&aacute;s informaci&oacute;n sobre SumCMS, visite',
			'sub12' => '&Uacute;ltimas Entradas en el blog'
		),
		'page_entries' => array (
			'sub1' => 'Autor',
			'sub2' => 'Categor&iacute;as',
			'sub3' => 'Fabricado en',
			'sub4' => '&Uacute;ltima Actualizaci&oacute;n',
			'sub5' => 'T&iacute;tulo',
			'btn1' => 'Editar',
			'btn2' => 'Borrar',
			'btn3' => 'Eliminar las entradas',
			'msg1' => 'Publicado',
			'msg2' => 'In&eacute;dito',
			'msg3' => 'Usted',
			'msg4' => 'Actualmente tiene no',
			'msg5' => 'blog',
			'msg6' => 'p&aacute;ginas',
			'PT1' => 'Blog',
			'PT2' => 'P&aacute;gina',
			'PT3' => '',
			'sub6' => 'Descendente',
			'sub7' => 'Ascendente',
			'sub8' => 'Orden',
			'sub9' => 'T&iacute;tulo',
			'sub10' => 'Fecha',
			'sub11' => 'Actualizar',
			'sub12' => 'Ordenar por'
		),
		'page_manageFiles' => array (
			'PT' => 'Administrar Archivos' 
		),
		'page_manageUsers' => array (
			'msg1' => 'Activado',
			'msg2' => 'no existe este usuario.',
			'btn1' => 'Actualizar usuario',
			'btn2' => 'A&ntilde;adir usuario',
			'msg3' => 'Por favor complete todas las entradas.',
			'msg4' => 'correo electr&oacute;nico no es v&aacute;lida.',
			'msg5' => 'Una cuenta ya existen con este correo electr&oacute;nico.',
			'msg6' => 'reincorporado',
			'msg7' => 'actualizaci&oacute;n',
			'msg8' => 'actualizado',
			'msg9' => 'a&ntilde;adido',
			'msg10' => 'a&ntilde;adir',
			'msg11' => "Un correo electr&oacute;nico ha sido enviado a $u_Fname con sus credenciales de inicio de sesi&oacute;n.",
			'msg12' => "Nos encontramos con un error de $ErrTxt. Por favor, int&eacute;ntelo de nuevo.",
			'PT' => 'Administrar Usuarios',
			'sub1' => 'Nombre',
			'sub2' => 'Apellido',
			'sub3' => 'Email',
			'sub4' => 'Funci&oacute;n de usuario',
			'sub5' => 'Administrador',
			'sub6' => 'Administrador',
			'sub7' => 'Usuario',
			'sub8' => 'Activa',
			'btn3' => 'Crear Nuevo usuario'
		),
		'page_menus' => array (
			'PT' => 'Men&uacute;s',
			'msg1' => 'Seleccione una pesta&ntilde;a de men&uacute; para cargar los elementos de men&uacute;.',
			'btn1' => 'Borrar todo',
			'btn2' => 'Save Menu',
			'sub1' => 'Opciones de men&uacute;',
			'btn3' => 'Agregar elemento'
		),
		'page_myaccount' => array (
			'btn1' => 'Actualizar Cuenta',
			'msg1' => 'Por favor complete todas las entradas.',
			'msg2' => 'correo electr&oacute;nico no es v&aacute;lida.',
			'msg3' => 'Una cuenta ya existen con este correo electr&oacute;nico.',
			'msg4' => 'Su cuenta ha sido actualizada.',
			'msg5' => 'Nos encontramos con un error al actualizar su cuenta.',
			'PT' => 'Mi cuenta',
			'sub1' => 'Configuraci&oacute;n de la cuenta',
			'sub2' => 'Nombre',
			'sub3' => 'Apellido',
			'sub4' => 'Alias',
			'sub5' => 'Nombre para mostrar',
			'sub6' => 'Email',
			'sub7' => 'Contrase&ntilde;a',
			'sub8' => 'Informaci&oacute;n de perfil',
			'sub9' => 'URL personal',
			'sub10' => 'Facebook URL',
			'sub11' => 'Twitter URL',
			'sub12' => 'LinkedIn URL',
			'sub13' => 'Bio'
		),
		'page_newBlock' => array(
			'msg1' => 'No se puede cargar Bloque.',
			'PT' => 'Bloque de c&oacute;digo',
			'sub1' => 'Bloque de c&oacute;digo del editor',
			'sub2' => 'Nombre',
			'sub3' => 'Tag',
			'sub4' => 'No hay Spaces',
			'sub5' => 'Prensa <strong> ctrl-espacio </ strong> para activar la terminaci&oacute;n.',
			'sub6' => 'C&oacute;digo',
			'btn1' => 'Guardar'
		),
		'page_newEntry' => array (
			'msg1' => 'Por favor escriba el t&iacute;tulo y el contenido de esta entrada.',
			'msg2' => 'Ya existe una entrada con este t&iacute;tulo.',
			'msg3' => 'Ha guardado correctamente esta entrada.',
			'msg4' => 'Ha actualizado correctamente esta entrada.',
			'msg5' => 'Ha publicado con &eacute;xito esta entrada.',
			'msg6' => 'Ha guardado y publicado esta entrada.',
			'msg7' => 'Esta entrada no se publica.',
			'msg8' => "Nos encontramos con un error en esta entrada. ($MysqlError) Por favor, int&eacute;ntelo de nuevo.",
			'msg9' => 'Por ahora no tiene categor&iacute;as.',
			'btn1' => 'Aprobado',
			'btn2' => 'Borrar',
			'btn3' => 'desaprobar',
			'msg10' => 'Usted actualmente no tiene comentarios.',
			'msg11' => "Usted no tiene acceso a esta entrada $EntryType.",
			'btn4' => 'No Publicar',
			'btn5' => 'Actualizar',
			'btn6' => 'Nueva Blog',
			'msg12' => "No se puede cargar la entrada $EntryType.",
			'btn7' => 'Publicar',
			'btn8' => 'Guardar',
			'msg13' => 'Por ahora no tiene categor&iacute;as.',
			'PT1' => 'Nuevo',
			'PT2' => 'entrada de blog',
			'PT3' => 'P&aacute;gina',
			'sub1' => 'Esta entrada creada por el',
			'sub2' => 'Establecer como entrada la p&aacute;gina principal.',
			'sub3' => 'URL directo',
			'sub4' => 'No disponible',
			'sub5' => 'Comentarios',
			'btn9' => 'Borrar comentarios',
			'sub6' => 'No se permitir&aacute;n comentarios para esta entrada.',
			'sub7' => 'Imagen Splash',
			'sub8' => 'Introduzca la URL de la imagen de fondo de este art&iacute;culo',
			'btn10' => 'Seleccionar Archivo',
			'sub9' => 'Categor&iacute;as',
			'sub10' => 'Palabras clave',
			'sub11' => 'Descripci&oacute;n',
			'sub12' => 'Auto-generar Descripci&oacute;n del contenido.'
		),
		'page_settings' => array (
			'msg1' => 'Por favor complete todas las entradas antes de actualizar la configuraci&oacute;n.',
			'msg2' => 'Tama&ntilde;o de archivo incorrecto.',
			'msg3' => 'Por favor, configure el idioma.',
			'msg4' => 'Ha actualizado correctamente la configuraci&oacute;n.',
			'msg5' => 'Nos encontramos con un error en esta entrada. Por favor, int&eacute;ntelo de nuevo. ',
			'PT' => 'Configuraci&oacute;n',
			'sub1' => 'General',
			'sub2' => 'Domain',
			'sub3' => 'Subir Ruta',
			'sub4' => 'Nombre del sitio',
			'sub5' => 'URL del Logo',
			'sub6' => 'Correo de contacto',
			'sub7' => 'Tama&ntilde;o del archivo',
			'sub8' => 'N&uacute;mero de entradas de blog por p&aacute;gina',
			'sub9' => 'URL Index',
			'sub10' => 'Google Analytics',
			'sub11' => 'Code',
			'sub12' => 'Cambia',
			'sub13' => 'Definir Idioma',
			'sub14' => 'Aprobar Comentarios',
			'sub15' => 'Aprobar todas las observaciones futuras para las entradas de blog.',
			'btn1' => 'Navegar',
			'btn2' => 'Actualizar'
		),
		'js_calls' => array(
			'js1' => 'No tiene entradas seleccionadas.',
			'js2' => 'Usted no se ha registrado ning&uacute;n men&uacute;s',
			'js3' => 'Por favor reg&iacute;strese sus men&uacute;s en el dise&ntilde;o y la maquetaci&oacute;n. Para obtener m&aacute;s informaci&oacute;n, por favor visite',
			'js4' => 'Usted ha enumerado sin los elementos de men&uacute;.',
			'js5' => 'Comentarios se han eliminado.',
			'js6' => 'No tiene comentarios seleccionados.',
			'js7' => 'Seleccione una ranura disponible para este men&uacute;',
			'js8' => 'No tiene comentarios seleccionados.',
			'js9' => 'Seleccione una ranura disponible para este men&uacute;',
			'js10' => 'Por favor complete todas las entradas.',
			'btn1' => 'Editar',
			'btn2' => 'Eliminar',
			'btn3' => 'Aprobar',
			'btn4' => 'Desaprobar'		
		)
	)
);
?>