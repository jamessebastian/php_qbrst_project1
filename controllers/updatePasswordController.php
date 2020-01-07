<?php
isLoggedIn();


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
* returns class of feedback error box of the field based on error of the associated field
*
* @param string   $field field name
*
* @return string
*/ 
function feedbackErrClass($field = '') 
{
    global $errors;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        return (isset($errors[$field])) ? 'invalid-feedback' : 'valid-feedback';
    }
    return NULL;
}

/**
* returns class of input field based on error of the associated field
*
* @param string   $field field name
*
* @return string
*/ 
function showFeedbackInputClass($field = '')
{
    global $errors;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        return (isset($errors[$field])) ? 'is-invalid' : 'is-valid';
    }
    return NULL;
}

/**
* shows textcontent in the feedback error box
*
* @param string   $field field name
*
* @return string
*/ 
function showFeedbackErrClass($field = '')
{
    global $errors;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        return (isset($errors["$field"])) ? $errors["$field"] : 'Looks Good';
    }
    return NULL;
}


/**
* gets password from form and converts it to hash
*
* @return string
*/ 
function getNewPassword()
{
    return password_hash(getFieldValue("password"), PASSWORD_DEFAULT);
}


/**
* Validates user data from the form
*
* @return array Array of errors.Returns NULL if there is no errors
*/ 
function validateUserData()
{   
    if (empty(getFieldValue("password"))) {
        $errors['password'] = "Password is required";
    } elseif (!preg_match(REGEX_PASSWORD, getFieldValue("password"))) {
        $errors['password']        = PASSWORD_ERR_MSSG;
        $errors['confirmPassword'] = "";
    }
    
    if (empty(getFieldValue("confirmPassword"))) {
        $errors['confirmPassword'] = "Confirm password is required";
    } elseif (getFieldValue("password") != getFieldValue("confirmPassword")) {
        $errors['confirmPassword'] = "Password should be same";
    }

    return isset($errors) ? $errors : null;
}


if (empty($_GET['token'])) {
    header("Location:invalidUrl.php"); 
    exit();    
} else {
    $result =tokenCheck($_GET['token']);

    // var_dump($result);
    // echo "<br>expiry time=".date("Y-m-d h-i-s",$result['expiry_time'])."@".$result['expiry_time'];
    // echo "<br>time now=".date("Y-m-d h-i-s",time())."@".time();

    // $exp=(int)$result['expiry_time']-time() ;
    // echo "<br>expiry_time - time_now = ".date("Y-m-d h-i-s",$exp)."@".$exp;

    if ( empty($result['id']) || ($result['expiry_time']-time() < 0) ) {
        header("Location:invalidUrl.php"); 
        exit();      
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = validateUserData();
    
    if (empty($errors)) {

        $newPassword = getNewPassword();
        if (changePassword($newPassword , $result['id'])) {
            if(deleteToken($result['id'])) {
                header("Location:loginPage.php"); 
                exit();
            } else {
                header("Location:somethingWentWrong.php"); 
                exit();                
            }
        } 
    }
    
}

?>