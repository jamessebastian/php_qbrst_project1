<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include "constants.php";
include 'models/dbConnection.php';
include 'models/users.php';
include "library/utils/loginCheck.php";
include "library/utils/sendMail.php";
include "controllers/forgotPasswordController.php";
include "templates/htmlHead.php";

?>

<!DOCTYPE html>
<html>
   <?php htmlHead("forgot password","forgotPassword.css"); ?>
   <body>
      <div id="loaderDiv" class="myLoader text-center" style="display:none"><img id="loader" src="loader.gif"></div>
      <div id="fullWrapper">    
      <nav class="p-4 navbar navbar-dark bg-dark justify-content-around">
         <span class="navbar-brand mb-0 h1">FORGOT PASSWORD</span>
      </nav>
      <div class="container">
         <?php if (isset($flag)) { ?>
         <div class="jumbotron mt-sm-4">
           <div class="container">
               <h2><i class="fa fa-check green" aria-hidden="true"></i>
                  Link has been sent to mail
               </h2>
           </div>
         </div>
         <?php } ?>        

         <div class="loginContainer">
            <form onsubmit="return validate()" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
               <div class="form-group">
                  <input type="text" value="<?php echo getFieldValue("email"); ?>" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Email">
                  <small id="emailErr" class="form-text red"><?php echo showErrors("email");  ?></small>  
               </div>
                <input class="btn btn-primary btn-sm" type="submit" name="submit" value="SUBMIT">
                              
	            <a class="btn btn-primary btn-sm" href='loginPage.php'>CANCEL</a>
            
            </form>
         </div>
      </div>
    </div>
      <script src="assets/javascript/common.js"></script>
      <script src="assets/javascript/forgotPasswordValidation.js"></script>  
    
   </body>
</html>

