<?php
function __autoload($className){
	include_once("models/$className.php");	
}

$users=new User("your_host","your_user","your_password","your_database");

if(!isset($_POST['action'])) {
	print json_encode(0);
	return;
}

switch($_POST['action']) {
	case 'get_users':
		print $users->getUsers();		
	break;
	
	case 'add_user':
		$user = new stdClass;
		$user = json_decode($_POST['user']);
		print $users->add($user);		
	break;
	
	case 'delete_user':
		$user = new stdClass;
		$user = json_decode($_POST['user']);
		print $users->delete($user);		
	break;
	
	case 'update_field_data':
		$user = new stdClass;
		$user = json_decode($_POST['user']);
		print $users->updateValue($user);				
	break;
}

exit();