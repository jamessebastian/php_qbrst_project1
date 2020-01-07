<?php 
session_start();
// include 'library/utils/loginCheck.php';
// isLoggedOut();

include 'constants.php';
include 'models/dbConnection.php';
include "models/users.php";


if (isset($_SESSION['user']) && ($_SESSION['user']['email']==$_POST['email'])) {
	$form_data['success'] = false;
} elseif (checkEmailExists($_POST['email'])) {

	$form_data = array(); 
	$form_data['success'] = true;
	//$form_data['message'] = $_POST['id'].'was deleted';
	    
} else {
	$form_data['success'] = false;
}
echo json_encode($form_data); //Return the data back


?>