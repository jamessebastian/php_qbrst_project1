<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include "library/utils/loginCheck.php";

include 'constants.php';
include 'models/dbConnection.php';
include 'models/users.php';
include 'controllers/updatePasswordController.php';
include "templates/htmlHead.php";

?>

<!DOCTYPE html>
<html>
   <?php htmlHead("update password","changePassword.css"); ?>
   <body>
      <div id="loaderDiv" class="myLoader text-center" style="display:none"><img id="loader" src="loader.gif"></div>
      <div id="fullWrapper">
         <nav class="p-4 navbar navbar-dark bg-dark justify-content-around">
            <span class="navbar-brand mb-0 h1">UPDATE PASSWORD</span>
         </nav>
         <div class="container">
            <form onsubmit="return validate()" enctype = "multipart/form-data" name="regForm" class="mb-5 mt-2" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?token=<?php echo $_GET['token'];?>">
               <div class="form-group row mt-5">
                  <label for="password" class="col-sm-2 col-form-label">Password<span class="red"><?php echo REQUIRED; ?></span></label>
                  <div class="col-sm-3">
                     <input id="password" class="form-control <?php echo showFeedbackInputClass("password"); ?>" type="password" name="password" value="<?php echo getFieldValue("password"); ?>">
                  </div>
                  <div id="passwordErr" class="col-sm-7  errBox <?php echo feedbackErrClass("password"); ?> d-inline"><?php echo showFeedbackErrClass("password");  ?></div>
               </div>
               <div class="form-group row">
                  <label for="confirmPassword" class="col-sm-2 col-form-label">Confirm Password<span class="red"><?php echo REQUIRED; ?></span></label>
                  <div class="col-sm-3">
                     <input id="confirmPassword" class="form-control <?php echo showFeedbackInputClass("confirmPassword"); ?>" type="password" name="confirmPassword" value="<?php echo getFieldValue("confirmPassword"); ?>">
                  </div>
                  <div id="confirmPasswordErr" class="col-sm-7  errBox <?php echo feedbackErrClass("confirmPassword"); ?> d-inline"><?php echo showFeedbackErrClass("confirmPassword");  ?></div>
               </div>
               <div class="row">
                  <div class="submitButtonWrapper col-sm-1">
                     <input class="btn btn-primary " type="submit" name="submit" value="Submit">
                  </div>
               </div>
            </form>
         </div> 
      </div>
      <script src="assets/javascript/common.js"></script>      
      <script src="assets/javascript/changePassword.js"></script>
   </body>
</html>

