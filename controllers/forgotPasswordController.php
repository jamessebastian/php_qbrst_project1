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
    global $errors;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        return (isset($errors["$field"])) ? $errors["$field"] : '';
    }
    return NULL;
}

/**
* Validates email by checking if the email exists in the database
*
* @return array Array of errors.Returns NULL if there is no errors
*/ 
function validateUserData()
{
    if (empty(getFieldValue("email"))) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var(trim(getFieldValue("email")), FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    } elseif (!checkEmailExists(getFieldValue("email"))) {
        $errors['email'] = "This email is not registered with us";
    }

    return isset($errors) ? $errors : null;

}

isLoggedIn();

if (isset($_POST['submit'])) { // it checks whether the user clicked submit button or not  
    $errors = validateUserData();

    if (empty($errors)) {
        $token = md5(uniqid(rand(), true));
        insertToken(getFieldValue("email"), $token);

        $mailDetails['subject']="Password Update";
        $mailDetails['message']="Click this link to update your password- http://10.2.0.138/php/project1/updatePassword.php?token=".$token." \n .The link will expire within 1 hour";

        if (sendMail(getFieldValue('email'), $mailDetails)) {
            $flag = true;
        }
    }
}

?>