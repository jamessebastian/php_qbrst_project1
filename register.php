<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include "library/utils/loginCheck.php";

include 'constants.php';
include 'models/dbConnection.php';
include 'models/states.php';
include 'models/users.php';
include "library/utils/sendMail.php";
include 'controllers/userController.php';
include "templates/htmlHead.php";

?>

<!DOCTYPE html>
<html>
   <?php htmlHead("Register","register.css"); ?>
   <body>
      <div id="loaderDiv" class="myLoader text-center" style="display:none"><img id="loader" src="loader.gif"></div>
      <div id="fullWrapper">
         <nav class="p-4 navbar navbar-dark bg-dark justify-content-around">
            <span class="navbar-brand mb-0 h1">USER REGISTRATION</span>
         </nav>
         <div class="container">
            <form onsubmit="return validate()" enctype = "multipart/form-data" name="regForm" class="mb-5 mt-2" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
               <div>
                  <div id="useless" class="d-none"></div>
                  <div id="adw" class="form-group row">
                     <label for="fName" class="col-sm-2 col-form-label">First Name<span class="red"><?php echo REQUIRED; ?></span></label>
                     <div class="col-sm-3">
                        <input id="fName" class="form-control <?php echo showFeedbackInputClass("fName"); ?>" type="text" name="fName" value="<?php echo getFieldValue("fName"); ?>">
                     </div>
                     <div id="fNameErr" class="col-sm-7  errBox <?php echo feedbackErrClass("fName"); ?> d-inline"><?php echo showFeedbackErrClass("fName");  ?></div>
                  </div>
                  <div class="form-group row">
                     <label for="mName" class="col-sm-2 col-form-label">Middle name</label>
                     <div class="col-sm-3">
                        <input id="mName" class="form-control <?php echo showFeedbackInputClassWithoutTickMark("mName"); ?>" type="text" name="mName" value="<?php echo getFieldValue("mName"); ?>">
                     </div>
                     <div id="mNameErr" class="col-sm-7  errBox <?php echo feedbackErrClass("mName"); ?> d-inline"><?php echo showErrWithoutLooksGood("mName"); ?></div>
                  </div>
                  <div class="form-group row">
                     <label for="lName" class="col-sm-2 col-form-label">Last name<span class="red"><?php echo REQUIRED; ?></span></label>
                     <div class="col-sm-3">
                        <input id="lName" class="form-control <?php echo showFeedbackInputClass("lName"); ?>" type="text" name="lName" value="<?php echo getFieldValue("lName"); ?>">
                     </div>
                     <div id="lNameErr" class="col-sm-7  errBox <?php echo feedbackErrClass("lName"); ?> d-inline"><?php echo showFeedbackErrClass("lName");  ?></div>
                  </div>
                  <div class="form-group row">
                     <label for="email" class="col-sm-2 col-form-label">Email<span class="red"><?php echo REQUIRED; ?></span></label>
                     <div class="col-sm-3">
                        <input id="email" class="form-control <?php echo showFeedbackInputClass("email"); ?>" type="text" name="email" value="<?php echo getFieldValue("email"); ?>">
                     </div>
                     <div id="emailErr" class="col-sm-7 errBox <?php echo feedbackErrClass("email"); ?> d-inline"><?php echo showFeedbackErrClass("email");  ?></div>
                  </div>
                  <div class="row form-group">
                     <div class="col-form-label col-sm-2 pt-0">Email notification frequency<span class="red"><?php echo REQUIRED; ?></span></div>
                     <div class="col-sm-3">
                        <?php foreach ($emailOptions as $option) { ?>
                        <div class="form-check">
                           <input class="pointer form-check-input" <?php echo (getFieldValue("emailNotificationFrequency")==$option)? "checked " : ''; ?> type="radio" name="emailNotificationFrequency" id="<?php echo $option;?>" value="<?php echo $option;?>" >
                           <label class="pointer form-check-label" for="<?php echo $option;?>"><?php echo $option;?></label>
                        </div>
                        <?php } ?> 
                     </div>
                     <div id="emailNotificationFrequencyErr" class="col-sm-7  errBox <?php echo feedbackErrClass("emailNotificationFrequency"); ?> d-inline"><?php echo showFeedbackErrClass("emailNotificationFrequency");  ?></div>
                  </div>
                  <div class="form-group row">
                     <label for="phone" class="col-sm-2 col-form-label">Phone<span class="red"><?php echo REQUIRED; ?></span></label>
                     <div class="col-sm-3">
                        <input id="phone" class="form-control <?php echo showFeedbackInputClass("phone"); ?>" type="text" name="phone" value="<?php echo getFieldValue("phone"); ?>">
                     </div>
                     <div id="phoneErr" class="col-sm-7  errBox <?php echo feedbackErrClass("phone"); ?> d-inline"><?php echo showFeedbackErrClass("phone");  ?></div>
                  </div>
                  <div class="form-group row">
                     <label for="dob" class="col-sm-2 col-form-label">Date of Birth<span class="red"><?php echo REQUIRED; ?></span></label>
                     <div class="col-sm-3">
                        <input id="dob" class="form-control <?php echo showFeedbackInputClass("dob"); ?>" type="date" min="1900-02-18" name="dob" value="<?php echo getFieldValue("dob"); ?>">
                     </div>
                     <div id="dobErr" class="col-sm-7  errBox <?php echo feedbackErrClass("dob"); ?> d-inline"><?php echo showFeedbackErrClass("dob");  ?></div>
                  </div>
                  <div class="row form-group">
                     <div class="col-form-label col-sm-2 pt-0">Gender<span class="red"><?php echo REQUIRED; ?></span></div>
                     <div class="col-sm-3">
                        <?php foreach ($genderOptions as $option) { ?>
                        <div class="form-check">
                           <input class="pointer form-check-input" <?php echo (getFieldValue("gender")==$option)? "checked " : ''; ?> type="radio" name="gender" id="<?php echo $option;?>" value="<?php echo $option;?>" >
                           <label class="pointer form-check-label" for="<?php echo $option;?>"><?php echo $option;?></label>
                        </div>
                        <?php } ?> 
                     </div>
                     <div id="genderErr" class="col-sm-7  errBox <?php echo feedbackErrClass("gender"); ?> d-inline"><?php echo showFeedbackErrClass("gender");  ?></div>
                  </div>
                  <div class="form-group row">
                     <label for="address1" class="col-sm-2 col-form-label">Address1<span class="red"><?php echo REQUIRED; ?></span></label>
                     <div class="col-sm-3">
                        <input id="address1" class="form-control <?php echo showFeedbackInputClass("address1"); ?>" type="text" name="address1" value="<?php echo getFieldValue("address1"); ?>">
                     </div>
                     <div id="address1Err" class="col-sm-7  errBox <?php echo feedbackErrClass("address1"); ?> d-inline"><?php echo showFeedbackErrClass("address1");  ?></div>
                  </div>
                  <div class="form-group row">
                     <label for="address2" class="col-sm-2 col-form-label">Address2</label>
                     <div class="col-sm-3">
                        <input id="address2" class="form-control" type="text" name="address2" value="<?php echo getFieldValue("address2"); ?>">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="city" class="col-sm-2 col-form-label">City<span class="red"><?php echo REQUIRED; ?></span></label>
                     <div class="col-sm-3">
                        <input id="city" class="form-control <?php echo showFeedbackInputClass("city"); ?>" type="text" name="city" value="<?php echo getFieldValue("city"); ?>">
                     </div>
                     <div id="cityErr" class="col-sm-7  errBox <?php echo feedbackErrClass("city"); ?> d-inline"><?php echo showFeedbackErrClass("city");  ?></div>
                  </div>
                  <div class="form-group row">
                     <label for="state" class="col-sm-2">State<span class="red"><?php echo REQUIRED; ?></span></label>
                     <div class="col-sm-3">
                        <select id="state" class="custom-select <?php echo showFeedbackInputClass("state"); ?>" name="state">
                           <option value=""> -- Please Select --</option>
                           <?php while($row = $states->fetch_assoc()) { ?>
                           <option value="<?php echo $row['id']; ?>"  <?php echo ( isset($_POST['state']) && ($_POST['state'] == $row['id']) )? ' selected="selected" ':'' ?> >
                              <?php echo $row['name']; ?>
                           </option>
                           <?php } ?>
                        </select>
                     </div>
                     <div id="stateErr" class=" col-sm-7 errBox <?php echo feedbackErrClass("state"); ?> d-inline"><?php echo showFeedbackErrClass("state");  ?></div>
                  </div>
                  <div id="adw2" class="form-group row">
                     <label for="pin" class="col-sm-2 col-form-label">PIN<span class="red"><?php echo REQUIRED; ?></span></label>
                     <div class="col-sm-3">
                        <input id="pin" class="form-control <?php echo showFeedbackInputClass("pin"); ?>" type="text" name="pin" value="<?php echo getFieldValue("pin"); ?>">
                     </div>
                     <div id="pinErr" class="col-sm-7  errBox <?php echo feedbackErrClass("pin"); ?> d-inline"><?php echo showFeedbackErrClass("pin");  ?></div>
                  </div>
                  <div class="form-group row">
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
                  <div class="form-group row">
                     <label for="fName" class="col-sm-2 col-form-label">
                        Profile Picture<span class="red"><?php echo REQUIRED; ?></span>
                        <p id="fileConstraints"><strong>Max upload size=<?php echo MAX_FILE_SIZE/1048576 ?>MB, &nbsp;&nbsp;  File should be an image (
                         <?php echo implode(", ",EXTENSIONS); ?>
                        )</strong></p>
                     </label>
                     <div class="col-sm-3">
                        <input id="profileFile" class="form-control-file" accept="image/*" type="file" name="image" onchange="previewImage(event)">
                     </div>
                     <div id="fileErr" class="col-sm-2  errBox invalid-feedback d-inline"><?php echo showErrWithoutLooksGood("fileSize");  echo showErrWithoutLooksGood("fileExtension");  ?></div>
                     <div class="col-sm-2 d-inline"><img id="outputImage" src="" alt=""></div>
                  </div>
               </div>
               <div class="form-group row">
                  <div class=" col-sm-3">
                     <div class="form-check">
                        <input class="form-check-input <?php echo showFeedbackInputClass("tAndC"); ?>" type="checkbox" value="yes" name="tAndC" id="tAndC" <?php if (getFieldValue("tAndC")=="yes") echo "checked";?>>
                        <label class="form-check-label" for="tAndC">
                        Terms and Conditions apply<span class="red"><?php echo REQUIRED; ?></span>
                        </label>
                     </div>
                  </div>
                  <div id="tAndCErr" class="col-sm-7 errBox <?php echo feedbackErrClass("tAndC"); ?> d-inline"><?php echo showFeedbackErrClass("tAndC");  ?></div>
               </div>
             
               <div class="row">
                  <div class="submitButtonWrapper col-sm-1">
                     <input class="btn btn-primary " type="submit" name="submit" value="Submit">
                  </div>
                  <div class="resetButtonWrapper col-sm-1">
                     <input class="btn btn-primary" type="reset" name="reset" value="Reset">
                  </div>
                  <div class="resetButtonWrapper col-sm-1">
                     <a class="btn btn-primary" href='loginPage.php'>CANCEL</a>
                  </div>
               </div>
               <hr>
               <br>
            </form>
         </div>
         <script src="assets/javascript/registerValidation.js"></script>
         <script src="assets/javascript/common.js"></script>

         <?php include 'templates/footer.php'?>
      </div>
   </body>
</html>

