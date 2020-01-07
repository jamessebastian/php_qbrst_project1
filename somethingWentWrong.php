<?php
include 'constants.php';
include "templates/htmlHead.php";
?>
<!DOCTYPE html>
<html>
   <?php htmlHead("oops","invalidUrl.css"); ?>
   <body>
      <nav class="p-4 navbar navbar-dark bg-dark justify-content-around">
         <span class="navbar-brand mb-0 h1">SOMETHING WENT WRONG</span>
      </nav>
      <br>
      <br>
      <div class="container">
         <div class="row">
            <p><h2><strong>PLEASE CONTACT XYZ</strong></h2></p>
         </div>
      </div>
      <?php include 'templates/footer.php'?>    
   </body>
</html>
