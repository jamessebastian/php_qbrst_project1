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
include 'controllers/userEditController.php';
include "templates/htmlHead.php";
//var_dump($userInfo);
?>

<!DOCTYPE html>
<html>
   <?php htmlHead("Edit","userEdit.css"); ?>
   <body>
      <div id="loaderDiv" class="myLoader text-center" style="display:none"><img id="loader" src="loader.gif"></div>
         <div id="fullWrapper">
            <?php include 'templates/navbar.php'; ?>
            <div class="container">
               <?php if (isset($flag)) { ?>
               <div class="jumbotron mt-sm-4">
                 <div class="container">
                     <h2><i class="fa fa-check green" aria-hidden="true"></i>
                         User details has been updated successfully
                     </h2>
                 </div>
               </div>
               <?php } ?>

               <form onsubmit="return validate();" enctype = "multipart/form-data" name="regForm" class="mb-5 mt-2" method="post" <?php if (isset($_GET['id'])) { ?>action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?id=<?php echo $_GET['id'];?>" <?php } else { ?> action="userEdit.php" <?php } ?> >
                  <div>
                     <div id="useless" class="d-none"></div>
                     <div class="form-group row">
                        <label for="fName" class="col-sm-2 col-form-label">First Name<span class="red"><?php echo REQUIRED; ?></span></label>
                        <div class="col-sm-3">
                           <input id="fName" class="form-control <?php echo showFeedbackInputClass("fName"); ?>" type="text" name="fName" value="<?php echo (isset($_POST['fName']))?$_POST['fName']:$userInfo['f_name']; ?>">
                        </div>
                        <div id="fNameErr" class="col-sm-7  errBox <?php echo feedbackErrClass("fName"); ?> d-inline"><?php echo showFeedbackErrClass("fName");  ?></div>
                     </div>
                     <div class="form-group row">
                        <label for="mName" class="col-sm-2 col-form-label">Middle name</label>
                        <div class="col-sm-3">
                           <input id="mName" class="form-control <?php echo showFeedbackInputClassWithoutTickMark("mName"); ?>" type="text" name="mName" value="<?php echo (isset($_POST['mName']))?$_POST['mName']:$userInfo['m_name']; ?>">
                        </div>
                        <div id="mNameErr" class="col-sm-7  errBox <?php echo feedbackErrClass("mName"); ?> d-inline"><?php echo showErrWithoutLooksGood("mName"); ?></div>
                     </div>
                     <div class="form-group row">
                        <label for="lName" class="col-sm-2 col-form-label">Last name<span class="red"><?php echo REQUIRED; ?></span></label>
                        <div class="col-sm-3">
                           <input id="lName" class="form-control <?php echo showFeedbackInputClass("lName"); ?>" type="text" name="lName" value="<?php echo (isset($_POST['lName']))?$_POST['lName']:$userInfo['l_name']; ?>">
                        </div>
                        <div id="lNameErr" class="col-sm-7  errBox <?php echo feedbackErrClass("lName"); ?> d-inline"><?php echo showFeedbackErrClass("lName");  ?></div>
                     </div>
                     <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email<span class="red"><?php echo REQUIRED; ?></span></label>
                        <div class="col-sm-3">
                           <?php if (!isset($_GET['id'])) { ?>
                           <input id="email" class="form-control <?php echo showFeedbackInputClass("email"); ?>" type="text" name="email" value="<?php echo (isset($_POST['email']))?$_POST['email']:$userInfo['email']; ?>">                 
                           <?php } else { echo $userInfo['email']; } ?>
                        </div>
                        <?php if (!isset($_GET['id'])) { ?>
                        <div id="emailErr" class="col-sm-7 errBox <?php echo feedbackErrClass("email"); ?> d-inline"><?php echo showFeedbackErrClass("email");  ?></div>
                        <?php } ?>
                     </div>
                     <div class="row form-group">
                        <div class="col-form-label col-sm-2 pt-0">Email notification frequency<span class="red"><?php echo REQUIRED; ?></span></div>
                        <div class="col-sm-3">
                           <?php foreach ($emailOptions as $option) { ?>
                           <div class="form-check">
                              <input class="pointer form-check-input" <?php echo (getFieldValue("emailNotificationFrequency")==$option)? "checked " : ''; if(!isset($_POST["emailNotificationFrequency"])) {echo ($userInfo['email_frequency']==$option)?'checked':'';}?> type="radio" name="emailNotificationFrequency" id="<?php echo $option;?>" value="<?php echo $option;?>" >
                              <label class="pointer form-check-label" for="<?php echo $option;?>"><?php echo $option;?></label>
                           </div>
                           <?php } ?> 
                        </div>
                        <div id="emailNotificationFrequencyErr" class="col-sm-7  errBox <?php echo feedbackErrClass("emailNotificationFrequency"); ?> d-inline"><?php echo showFeedbackErrClass("emailNotificationFrequency");  ?></div>
                     </div>
                     <div class="form-group row">
                        <label for="phone" class="col-sm-2 col-form-label">Phone<span class="red"><?php echo REQUIRED; ?></span></label>
                        <div class="col-sm-3">
                           <input id="phone" class="form-control <?php echo showFeedbackInputClass("phone"); ?>" type="text" name="phone" value="<?php echo (isset($_POST['phone']))?$_POST['phone']:$userInfo['phone']; ?>">
                        </div>
                        <div id="phoneErr" class="col-sm-7  errBox <?php echo feedbackErrClass("phone"); ?> d-inline"><?php echo showFeedbackErrClass("phone");  ?></div>
                     </div>
                     <div class="form-group row">
                        <label for="dob" class="col-sm-2 col-form-label">Date of Birth<span class="red"><?php echo REQUIRED; ?></span></label>
                        <div class="col-sm-3">
                           <input id="dob" class="form-control <?php echo showFeedbackInputClass("dob"); ?>" type="date" min="1900-02-18" name="dob" value="<?php echo (isset($_POST['dob']))?$_POST['dob']:$userInfo['dob']; ?>">
                        </div>
                        <div id="dobErr" class="col-sm-7  errBox <?php echo feedbackErrClass("dob"); ?> d-inline"><?php echo showFeedbackErrClass("dob");  ?></div>
                     </div>
                     <div class="row form-group">
                        <div class="col-form-label col-sm-2 pt-0">Gender<span class="red"><?php echo REQUIRED; ?></span></div>
                        <div class="col-sm-3">
                           <?php foreach ($genderOptions as $option) { ?>
                           <div class="form-check">
                              <input class="pointer form-check-input" <?php echo (getFieldValue("gender")==$option)? "checked " : '';  if(!isset($_POST['gender'])) {echo ($userInfo['gender']==$option)?'checked':'';}?> type="radio" name="gender" id="<?php echo $option;?>" value="<?php echo $option;?>" >
                              <label class="pointer form-check-label" for="<?php echo $option;?>"><?php echo $option;?></label>
                           </div>
                           <?php } ?> 
                        </div>
                        <div id="genderErr" class="col-sm-7  errBox <?php echo feedbackErrClass("gender"); ?> d-inline"><?php echo showFeedbackErrClass("gender");  ?></div>
                     </div>
                     <div class="form-group row">
                        <label for="address1" class="col-sm-2 col-form-label">Address1<span class="red"><?php echo REQUIRED; ?></span></label>
                        <div class="col-sm-3">
                           <input id="address1" class="form-control <?php echo showFeedbackInputClass("address1"); ?>" type="text" name="address1" value="<?php echo (isset($_POST['address1']))?$_POST['address1']:$userInfo['address1']; ?>">
                        </div>
                        <div id="address1Err" class="col-sm-7  errBox <?php echo feedbackErrClass("address1"); ?> d-inline"><?php echo showFeedbackErrClass("address1");  ?></div>
                     </div>
                     <div class="form-group row">
                        <label for="address2" class="col-sm-2 col-form-label">Address2</label>
                        <div class="col-sm-3">
                           <input id="address2" class="form-control" type="text" name="address2" value="<?php echo (isset($_POST['address2']))?$_POST['address2']:$userInfo['address2']; ?>">
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="city" class="col-sm-2 col-form-label">City<span class="red"><?php echo REQUIRED; ?></span></label>
                        <div class="col-sm-3">
                           <input id="city" class="form-control <?php echo showFeedbackInputClass("city"); ?>" type="text" name="city" value="<?php echo (isset($_POST['city']))?$_POST['city']:$userInfo['city']; ?>">
                        </div>
                        <div id="cityErr" class="col-sm-7  errBox <?php echo feedbackErrClass("city"); ?> d-inline"><?php echo showFeedbackErrClass("city");  ?></div>
                     </div>
                     <div class="form-group row">
                        <label for="state" class="col-sm-2">State<span class="red"><?php echo REQUIRED; ?></span></label>
                        <div class="col-sm-3">
                           <select id="state" class="custom-select <?php echo showFeedbackInputClass("state"); ?>" name="state">
                              <option value=""> -- Please Select --</option>
                              <?php while($row = $states->fetch_assoc()) { ?>
                              <option value="<?php echo $row['id']; ?>"  <?php echo ( isset($_POST['state']) && ($_POST['state'] == $row['id']) )? ' selected="selected" ':''; if (!isset($_POST['state'])) {echo ($userInfo['state']== $row['id'])?'selected':''; } ?> >
                                 <?php echo $row['name']; ?>
                              </option>
                              <?php } ?>
                           </select>
                        </div>
                        <div id="stateErr" class=" col-sm-7 errBox <?php echo feedbackErrClass("state"); ?> d-inline"><?php echo showFeedbackErrClass("state");  ?></div>
                     </div>
                     <div class="form-group row">
                        <label for="pin" class="col-sm-2 col-form-label">PIN<span class="red"><?php echo REQUIRED; ?></span></label>
                        <div class="col-sm-3">
                           <input id="pin" class="form-control <?php echo showFeedbackInputClass("pin"); ?>" type="text" name="pin" value="<?php echo (isset($_POST['pin']))?$_POST['pin']:$userInfo['pin']; ?>">
                        </div>
                        <div id="pinErr" class="col-sm-7  errBox <?php echo feedbackErrClass("pin"); ?> d-inline"><?php echo showFeedbackErrClass("pin");  ?></div>
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
                        <div class="col-sm-2 d-inline"><img id="outputImage" src="uploads/<?php echo (isset($_POST['imgPath']))?$_POST['imgPath']:$userInfo['img_path']; ?>" alt=""></div>
                     </div>
                  </div>
                
                  <div class="row">
                     <div class="submitButtonWrapper col-sm-1">
                        <input class="btn btn-primary " type="submit" name="submit" value="Submit">
                     </div>
                     <div class="resetButtonWrapper col-sm-1">
                        <a class="btn btn-primary" href='usersListingPage.php'>Cancel</a>
                     </div>

                  </div>
                  <hr>
                  <br>
               </form>
            </div>
            <?php include 'templates/footer.php'?>
         </div>
      <script src="assets/javascript/userEditValidation.js"></script>
      <script src="assets/javascript/common.js"></script>
   </body>
</html>

