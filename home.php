<?php

session_start();

include 'constants.php';
include "library/utils/loginCheck.php";
include "templates/htmlHead.php";
isLoggedOut();
?>

<!DOCTYPE html>
<html>
   <?php htmlHead("Home","home.css"); ?>
   <body>
      <?php include 'templates/navbar.php'; ?>
      <div class="container minHeight">
         <p>Welcome- <?php echo $_SESSION['user']['f_name']."  ".$_SESSION['user']['m_name']."  ".$_SESSION['user']['l_name']; ?>
            
         </p>
      </div>
      <?php include 'templates/footer.php'?>      
   </body>
</html>

