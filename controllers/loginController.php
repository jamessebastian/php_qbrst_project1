<?php

/**
* gets field value from the form
*
* @param string   $fieldKey  field name
*
* @return string 
*/ 
function getFieldValue($fieldKey = '')
{
    return isset($_POST[$fieldKey]) ? htmlspecialchars($_POST[$fieldKey]) : '';
}

/**
* used to show login errors
*
* @param string   $fieldKey  field name
*
* @return string 
*/ 
function showErrors($field = '')
{
    global $loginErrors;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        return (isset($loginErrors["$field"])) ? $loginErrors["$field"] : '';
    }
    return NULL;
}

/**
* Validates user data from the login form
**
* @return array Array of errors.Returns NULL if there is no errors
*/ 
function validateLoginForm()
{
    $loginErrors = NULL;
    global $userInfo;
    if (empty(getFieldValue("password"))) {
        $loginErrors['password'] = "Password is required";
    }
    if (empty(getFieldValue("email"))) {
        $loginErrors['email'] = "Email is required";
    }
    if (!empty(getFieldValue("password")) && !empty(getFieldValue("email")) ) 
    {
        $userInfo = checkUserCredentials ($_POST['email']);
        if (!isset($userInfo)) 
        {
            $loginErrors['password'] = "Invalid email or password";
            //$userInfo    = checkUserCredentials($_POST['email']);
        }
    }
    return $loginErrors;
}

isLoggedIn();

$loginErrors = validateLoginForm();

if (isset($_POST['login']) && !isset($loginErrors)) { // it checks whether the user clicked login button or not  
    $_SESSION['user'] = $userInfo;
    header("Location:home.php");
    exit();
}

?>