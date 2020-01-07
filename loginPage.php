<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include "constants.php";
include 'models/dbConnection.php';
include 'models/users.php';
include "library/utils/loginCheck.php";
include "controllers/loginController.php";
include "templates/htmlHead.php";

?>

<!DOCTYPE html>
<html>
   <?php htmlHead("Login","loginPage.css"); ?>
   <body>
      <div id="loaderDiv" class="myLoader text-center" style="display:none"><img id="loader" src="loader.gif"></div>
      <div id="fullWrapper">
         <nav class="p-4 navbar navbar-dark bg-dark justify-content-around">
            <span class="navbar-brand mb-0 h1">LOGIN</span>
         </nav>
         <div class="container">
            <div class="loginContainer">
               <form onsubmit="return validate();" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                  <div class="form-group">
                     <input type="text" value="<?php echo getFieldValue("email"); ?>" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Email">
                     <small id="emailErr" class="form-text red"><?php echo showErrors("email");  ?></small>  
                  </div>
                  <div class="form-group">
                     <input type="password" value="<?php echo getFieldValue("password"); ?>" name="password" class="form-control" id="password" placeholder="Password">
                     <small id="passwordErr" class="form-text red"><?php echo showErrors("password");  ?></small>
                     <a href="forgotPassword.php"><small class="black">Forgot Password?</small></a>
                  </div>
                   <input class="btn btn-primary btn-sm" type="submit" name="login" value="LOGIN">
                   <a class="btn btn-primary btn-sm" href='register.php'> REGISTER</a>
               </form>
            </div>
         </div>
      </div>
      <script src="assets/javascript/loginValidation.js"></script>  
      <script src="assets/javascript/common.js"></script>
    
   </body>
</html>

