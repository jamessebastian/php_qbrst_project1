<?php
isLoggedIn();

$states = getStates();

$emailOptions = array(
    "never",
    "daily",
    "weekly",
    "monthly"
);

$genderOptions = array(
    "male",
    "female"
);


/**
* moves uploaded file to "uploads/images/"
*
* @return void
*/ 
function moveUploadedFile() 
{
    $name      = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $f = false;

    $increment = ''; //start with no suffix
    while (file_exists("uploads/images/" . $name . $increment . '.' . $extension)) {
        $increment++;
        $f = true;
    }
    if ($f) {
        $basename = $name . '-' . $increment . '.' . $extension;
    } else {
        $basename = $name . '.' . $extension;
    }
    
    $moved = move_uploaded_file($_FILES['image']['tmp_name'], "uploads/images/" . $basename);
    // if( $moved ) {
    //   echo "Successfully uploaded";         
    // } else {
    //   echo "Not uploaded because of error #".$_FILES["file"]["error"];
    // }
}


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
* returns class of  input field based on error of the associated field
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
* returns class of input field based on error of the associated field(If there is no error,it won't return any class)
*
* @param string   $field field name
*
* @return string
*/ 
function showFeedbackInputClassWithoutTickMark($field = '')
{
    global $errors;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        return (isset($errors[$field])) ? 'is-invalid' : '';
    }
    return NULL;
}

/**
* shows textcontent in the feedback error box(if there is no error,there won't be any textcontent inside the error box)
*
* @param string   $field field name
*
* @return string
*/ 
function showErrWithoutLooksGood($field = '')
{
    global $errors;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        return (isset($errors["$field"])) ? $errors["$field"] : '';
    }
    return NULL;
}

/**
* gets user details from the form 
*
* @return array
*/ 
function getUserInfo()
{
    $userDetails['imgPath']                    = "images/" . $_FILES['image']['name'];
    $userDetails['fName']                      = getFieldValue("fName");
    $userDetails['mName']                      = getFieldValue("mName");
    $userDetails['lName']                      = getFieldValue("lName");
    $userDetails['email']                      = getFieldValue("email");
    $userDetails['emailNotificationFrequency'] = getFieldValue("emailNotificationFrequency");
    $userDetails['phone']                      = getFieldValue("phone");
    $userDetails['dob']                        = getFieldValue("dob");
    $userDetails['gender']                     = getFieldValue("gender");
    $userDetails['address1']                   = getFieldValue("address1");
    $userDetails['address2']                   = getFieldValue("address2");
    $userDetails['city']                       = getFieldValue("city");
    $userDetails['state']                      = getFieldValue("state");
    $userDetails['pin']                        = getFieldValue("pin");
    $userDetails['password']                   = password_hash(getFieldValue("password"), PASSWORD_DEFAULT);
    return $userDetails;
}


/**
* Validates user data from the form
*
* @return array Array of errors.Returns NULL if there is no errors
*/ 
function validateUserData()
{
    $tmp      = explode('.', $_FILES['image']['name']);
    $file_ext = strtolower(end($tmp));
    //$file_ext  = strtolower(end(explode('.', $_FILES['image']['name'])));
    if (empty($file_ext)) {
        $errors['fileSize'] = "Profile picture is required";
    } else {
        if (in_array($file_ext, EXTENSIONS) === false) {
            $errors['fileExtension'] = "Extension not allowed.Please choose a JPEG, PNG or a GIF file.";
        }
        // echo $_FILES['image']['size'];
        if ($_FILES['image']['size'] > MAX_FILE_SIZE) {
            $errors['fileSize'] = 'File size must be lower than 1 MB';
        }
    }
    
    if (empty(getFieldValue("fName"))) {
        $errors['fName'] = "First name is required";
    } elseif (!preg_match(REGEX_NAME, getFieldValue("fName"))) {
        $errors['fName'] = "Only letters and white space allowed";
    }
    
    if (!empty(getFieldValue("mName")) && !preg_match(REGEX_NAME, getFieldValue("mName"))) {
        $errors['mName'] = "Only letters and white space allowed";
    }
    
    if (empty(getFieldValue("lName"))) {
        $errors['lName'] = "Last name is required";
    } elseif (!preg_match(REGEX_NAME, getFieldValue("lName"))) {
        $errors['lName'] = "Only letters and white space allowed";
    }
    
    if (empty(getFieldValue("email"))) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var(trim(getFieldValue("email")), FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    } elseif (checkEmailExists(getFieldValue("email"))) {
        $errors['email'] = "Email already exists";
    }
    
    if (empty(getFieldValue("emailNotificationFrequency"))) {
        $errors['emailNotificationFrequency'] = "Select email notification frequency";
    }
    
    if (empty(getFieldValue("phone"))) {
        $errors['phone'] = "Phone number is required";
    } elseif (!preg_match(REGEX_PHONE, getFieldValue("phone"))) {
        $errors['phone'] = "Phone number should be in the format- 1112222222";
    }

    //echo $now->format('Y-m-d H:i:s');    // MySQL datetime format 
    $now = new DateTime();
    $date=date_create(getFieldValue("dob"));
    $diff=date_diff($now,$date);
    if (empty(getFieldValue("dob"))) {
        $errors['dob'] = "Date of birth is required";
    } elseif ($diff->format("%R%a") > 0 ) {
        $errors['dob'] = "Date of birth should be valid";
    } elseif (!preg_match(REGEX_DOB, getFieldValue("dob"))) {
        $errors['dob'] = "Date of birth should be in the format 1165-11-12";
    }
    
    if (empty(getFieldValue("gender"))) {
        $errors['gender'] = "Select gender";
    }
    
    if (empty(getFieldValue("address1"))) {
        $errors['address1'] = "Address is required";
    }
    
    if (empty(getFieldValue("city"))) {
        $errors['city'] = "City is required";
    } elseif (!preg_match(REGEX_CITY, getFieldValue("city"))) {
        $errors['city'] = "City name should only contain letters, spaces and digits";
    }

    if (!ctype_digit(getFieldValue("state"))) {
        $errors['state'] = "Select state";
    }
    
    if (empty($_POST["pin"])) {
        $errors['pin'] = "PIN is required";
    } elseif (!preg_match(REGEX_PIN, getFieldValue("pin"))) {
        $errors['pin'] = "PIN should be of the format - 123456";
    }
    
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
    
    if (empty(getFieldValue("tAndC"))) {
        $errors['tAndC'] = "You need to accept the terms and conditions";
    }
    return isset($errors) ? $errors : null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = validateUserData();
    
    if (empty($errors)) {
        moveUploadedFile();
        $userDetails = getUserInfo();
        if (insertUser($userDetails)) {

            $mailDetails['subject']="Welcome";
            $mailDetails['message']="You have been successfully registered.Thank You!!";

            sendMail($userDetails['email'] , $mailDetails);
            header("Location:success.php"); //redirect to success page
            exit();
        } else {
            header("Location:somethingWentWrong.php"); 
            exit();
        }
    }
    
}

?>