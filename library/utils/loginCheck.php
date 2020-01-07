<?php

/**
* If session is set then redirect to Home Page
*
*@return void
*/ 
function isLoggedIn() 
{
	if (isset($_SESSION['user'])) {
	    header("Location:home.php");
	    exit();
	}
}

/**
* If session is not set then redirect to Login Page
*
*@return void
*/  
function isLoggedOut() 
{
	if (!isset($_SESSION['user'])) {               
	    header("Location:loginPage.php");
	    exit();
	}
}
