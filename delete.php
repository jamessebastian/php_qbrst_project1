<?php 
session_start();
include 'library/utils/loginCheck.php';
isLoggedOut();

include 'constants.php';
include 'models/dbConnection.php';
include "models/users.php";

if (deleteUser($_POST['id'])) {

	$form_data = array(); 
	$form_data['success'] = true;
	//$form_data['message'] = $_POST['id'].'was deleted';

    //Return the data back
    echo json_encode($form_data);
}


?>