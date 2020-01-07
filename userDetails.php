<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'library/utils/loginCheck.php';

isLoggedOut();

include 'constants.php';
include 'models/dbConnection.php';
include 'templates/htmlHead.php';
include 'models/users.php';


if (empty($_GET['id'])) {
   header("Location:invalidUrl.php"); 
   exit();
} else {
   $userDetails = getUserDetails($_GET['id']);
   if ($userDetails==NULL) {
      header("Location:invalidUrl.php"); 
      exit();
   }
}


$labels = array(
   "f_name"=>"First Name",
   "m_name"=>"Middle Name",
   "l_name"=>"Last Name",
   "email"=>"Email",
   "email_frequency"=>"Email Notification Frequency",
   "phone"=>"Phone",   
   "dob"=>"Date of Birth",
   "gender"=>"gender",
   "address1"=>"Address1",
   "address2"=>"Address2",
   "city"=>"City",
   "name"=>"State",
   "pin"=>"PIN",
   "join_date"=>"Join Date"     
);

?>

<!DOCTYPE html>
<html>
   <?php htmlHead('user details','userDetails.css'); ?>
   <body>
      <?php include 'templates/navbar.php'; ?>
      <div class="container mt-sm-5"><img src="uploads/<?php echo $userDetails['img_path'];?>" alt="Not Found" onerror=this.src="smiley.jpg"></div>
      <br>
      <div class="container mt-sm-4">
         <?php foreach($userDetails as $field => $fieldValue) { if ($field == "img_path") { continue; } ?>
         <div class="form-group row">
            <label class="col-sm-3 col-form-label"><?php echo $labels[$field]; ?></label>
            <div class="col-sm-3">
               <?php echo ($field == 'email')? '<a href="mailto:'.$fieldValue.'">'.$fieldValue.'</a>' : $fieldValue; ?>
            </div>
         </div>
      <?php } ?>
      </div>


      <?php include 'templates/footer.php'?>

   </body>
</html>

