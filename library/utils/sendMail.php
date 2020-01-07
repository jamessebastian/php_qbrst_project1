<?php

/**
* used to send email
*
* @param string $email recipient email address
*
* @return boolean returns true if mail has been sent successfully
*/ 
function sendMail($email = '', $details = [])
{

    $to = $email;
	// $subject = "Password Update";

	// $message = "Click this link to update your password- http://10.2.0.138/php/project1/updatePassword.php?token=".$token;

    $header = "From:jamessebastian916@gmail.com \r\n";
    //$header .= "Cc:jamessebastian916@gmail.com \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";    
    return mail($to,$details['subject'],$details['message'],$header);
}

?>