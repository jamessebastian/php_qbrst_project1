<?php
/**
 * Tells whether email already exists or not
 *
 * @param string $email email to check
 *
 * @return boolean
 */
function checkEmailExists($email = '')
{
    global $conn;
    $sql = sprintf("SELECT id FROM users where email='%s'", $conn->real_escape_string($email));
    
    $result = $conn->query($sql);
    return ($result->num_rows > 0) ? true : false;
}


/**
 * Tells whether email already exists or not
 *
 * @param string $token token for verification
 *
 * @return Array
 */
function tokenCheck($token = '')
{
    global $conn;
    $sql = sprintf("SELECT id,expiry_time FROM users where token='%s'", $conn->real_escape_string($token));
    
    $result = $conn->query($sql);

    return ($result->num_rows == 1 ) ? $result->fetch_assoc() : NULL;
}

/**
 * Deletes token of the user id
 *
 * @param int $id user id
 *
 * @return boolean
 */
function deleteToken($id = '')
{
    global $conn;
    $sql = "UPDATE users 
            SET token=NULL , expiry_time=NULL WHERE id = ".(int)$id.";";     

    if ($conn->query($sql) === TRUE) { 
       return true;
    } else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
        return false;
    }
}

/**
 * Inserts user data into user table in the database.
 *
 * @param Array $userInfo  User details from the form.
 *
 * @return boolean Returns true on successful data insertion otherwise returns false.
 */
function insertUser($userInfo = []) 
{
	global $conn;
	$sql = "INSERT INTO users (img_path, f_name, m_name, l_name, email, email_frequency, phone , dob, gender, address1, address2, city, state, pin, password) 
			VALUES ('"
			.$conn->real_escape_string($userInfo['imgPath'])."','"
			.$conn->real_escape_string($userInfo['fName'])."','" 
			.$conn->real_escape_string($userInfo['mName'])."','" 
			.$conn->real_escape_string($userInfo['lName'])."','"
			.$conn->real_escape_string($userInfo['email'])."','"
			.$conn->real_escape_string($userInfo['emailNotificationFrequency'])."','"
			.$conn->real_escape_string($userInfo['phone'])."','"
			.$conn->real_escape_string($userInfo['dob'])."','"
			.$conn->real_escape_string($userInfo['gender'])."','"
			.$conn->real_escape_string($userInfo['address1'])."','"
			.$conn->real_escape_string($userInfo['address2'])."','"
			.$conn->real_escape_string($userInfo['city'])."','"
			.(int)$userInfo['state']."','"
			.(int)$userInfo['pin']."','"
			.$conn->real_escape_string($userInfo['password'])."');";

	if ($conn->query($sql) === TRUE) { 
	   return true;
	} else {
	    //echo "Error: " . $sql . "<br>" . $conn->error;
	    return false;
	}
}

/**
 * updates password of the user.
 *
 * @param string new password
 *
 * @return boolean Returns true on successful password updation otherwise returns false.
 */
function changePassword($newPassword = '', $id = '') 
{
    global $conn;
    $sql = "UPDATE users SET password='".$conn->real_escape_string($newPassword)."' WHERE id=".(int)$id.";";
  
    if ($conn->query($sql) === TRUE) { 
       return true;
    } else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
        return false;
    }
}

/**
 * Updates user data
 *
 * @param Array $userInfo  User details from the form.
 * @param int $id  User id
 *
 * @return boolean Returns true on successful data insertion otherwise returns false.
 */
function editUser($userInfo = [], $id = '') 
{
    global $conn;
    $email = ($_SESSION['user']['id'] == $id)? "email='".$userInfo['email']."' ," : "";

    $sql = "UPDATE users 
            SET img_path='".$conn->real_escape_string($userInfo['imgPath'])."' ,
                 f_name='".$conn->real_escape_string($userInfo['fName'])."' ,
                 m_name='".$conn->real_escape_string($userInfo['mName'])."' ,
                 l_name='".$conn->real_escape_string($userInfo['lName'])."' ,".$email.
                 "email_frequency='".$conn->real_escape_string($userInfo['emailNotificationFrequency'])."' ,
                 phone='".$conn->real_escape_string($userInfo['phone'])."' ,
                 dob='".$conn->real_escape_string($userInfo['dob'])."' ,
                 gender='".$conn->real_escape_string($userInfo['gender'])."' ,
                 address1='".$conn->real_escape_string($userInfo['address1'])."' ,
                 address2='".$conn->real_escape_string($userInfo['address2'])."' ,
                 city='".$conn->real_escape_string($userInfo['city'])."' ,
                 state=".(int)$userInfo['state']." ,
                 pin=".(int)$userInfo['pin']."  
            WHERE id = ".(int)$id.";";     

    if ($conn->query($sql) === TRUE) { 
       return true;
    } else {
       // echo "Error: " . $sql . "<br>" . $conn->error; //todo
        return false;
    }
}

/**
 * Inserts token for verification
 *
 * @param string $email email of the user who forgot his password
 * @param string $id token for verification
 *
 * @return boolean Returns true on successful data insertion otherwise returns false.
 */
function insertToken($email = '' , $token = '') 
{
    global $conn;
    $expiryTime = time() + (EXPIRY_DURATION * 60 * 60);
    $sql = "UPDATE users SET expiry_time=".$expiryTime.",token='".$token."' WHERE email = '".$conn->real_escape_string($email)."';";     

    if ($conn->query($sql) === TRUE) { 
        return true;
    } else {
       // echo "Error: " . $sql . "<br>" . $conn->error; //todo
        return false;
    }
}


/**
 * Checks login details.
 *
 * @param string $email entered email
 *
 * @return array Returns user details, only if the user credentials are correct 
 */
function checkUserCredentials($email = '')
{
    global $conn;
    $sql    = sprintf("SELECT id,f_name,m_name,l_name,password,email FROM users WHERE email='%s'", $conn->real_escape_string($email));
    $result = $conn->query($sql);
    $row    = $result->fetch_assoc();
    
    if (password_verify($_POST['password'], $row['password'])) {
        return $row;
    }
    return NULL;
}


/**
 * gets search results of users by running sql query
 *
 * @param array $constraints query parameters.
 *
 * @return object
 */
function getUsersList($constraints = [])
{
    global $conn;

    $whereCondition = empty($constraints['searchItem'])? "": " AND concat(f_name,' ',m_name,' ',l_name,' ',email) 
        LIKE '%".$conn->real_escape_string($constraints['searchItem'])."%' " ;

    $sql = "SELECT
                id,
    			f_name,
    			m_name,
    			l_name,
    			email,
    			dob,
    			gender,
    			date(creation_date) 
    		FROM users WHERE id!=".$_SESSION['user']['id'].$whereCondition." 
            ORDER BY " . $conn->real_escape_string($constraints['column']) . " " . $conn->real_escape_string($constraints['order']) . 
    		" limit " . (int)$constraints['start'] . "," . (int)$constraints['limit'];
    
    $result = $conn->query($sql);
    return $result;
}


/**
 * counts the total no of records in user table if the parameter is empty.Otherwise it finds the total no of records after searching
 *
 * @param string $searchItem search keyword.
 *
 * @return integer
 */
function countRows($searchItem = '')
{
    global $conn;
    if (empty($searchItem)) {
        $sql = "SELECT count(*) AS count FROM users WHERE id!=".$_SESSION['user']['id'];
    } else {
        $sql = "SELECT count(*) AS count FROM users WHERE id!=".$_SESSION['user']['id']." AND concat(f_name,' ',m_name,' ',l_name,' ',email) LIKE '%".$conn->real_escape_string($searchItem)."%'";
    }
    $result = $conn->query($sql);
    return $result->fetch_assoc()['count'];
}


/**
 * gets details of a particular user, given id
 *
 * @param int $id user id
 *
 * @return array
 */
function getUserDetails($id = '')
{
    global $conn;
    $sql = "SELECT 
                img_path,
                f_name,
                m_name,
                l_name,
                email,
                email_frequency,
                phone,
                dob,
                gender,
                address1,
                address2,
                city,
                name,
                pin,
                date(creation_date) AS join_date
            FROM users 
            INNER JOIN states 
            ON states.id=users.state 
            WHERE users.id = ".(int)$id;
    $result = $conn->query($sql);
    return $result->fetch_assoc();            
}


/**
 * gets details of a particular user, given id for form default values
 *
 * @param int $id user id
 *
 * @return arraay
 */
function getUserDetailsForForm($id = '')
{
    global $conn;
    $sql = "SELECT 
                img_path,
                f_name,
                m_name,
                l_name,
                email,
                email_frequency,
                phone,
                dob,
                gender,
                address1,
                address2,
                city,
                state,
                pin            
            FROM users 
            WHERE users.id = ".(int)$id;
    $result = $conn->query($sql);
    return $result->fetch_assoc();            
}


/**
 * Deletes user from database.
 *
 * @param int $id user id
 *
 * @return boolean Returns true on successful user deletion otherwise returns false.
 */
function deleteUser($id = '') 
{
    global $conn;
    $sql = "DELETE FROM users WHERE id=".(int)$id;

    if ($conn->query($sql) === TRUE) { 
       return true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        return false;
    }
}


?>
