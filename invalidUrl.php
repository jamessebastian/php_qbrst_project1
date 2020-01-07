<?php
include 'constants.php';
include "templates/htmlHead.php";
?>
<!DOCTYPE html>
<html>
   <?php htmlHead("Invalid url","invalidUrl.css"); ?>
   <body>
      <nav class="p-4 navbar navbar-dark bg-dark justify-content-around">
         <span class="navbar-brand mb-0 h1">INVALID URL</span>
      </nav>
      <br>
      <br>
      <div class="container">
         <div class="row">
            <p><h2><strong>PLEASE ENTER A VALID URL</strong></h2></p>
         </div>
      </div>
      <?php include 'templates/footer.php'?>    
   </body>
</html>
