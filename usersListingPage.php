<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include 'library/utils/loginCheck.php';

include 'constants.php';
include 'models/dbConnection.php';
include 'models/users.php';
include 'controllers/listingController.php';
include "templates/pagination.php"; 
include "templates/htmlHead.php"; 

?>
<!DOCTYPE html>
<html>
   <?php htmlHead("Listing Page","userListingPage.css"); ?>
   <body>
    <div id="loaderDiv" class="myLoader text-center" style="display:none"><img id="loader" src="loader.gif"></div>
    <div id="fullWrapper">
      <?php include 'templates/navbar.php'; ?>
      <div class="mt-sm-5 container minHeight">
         <form onsubmit="return validate();" method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input hidden type="text" name="column" value="<?php echo $column;?>">
            <input hidden type="text" name="order" value="<?php echo $order;?>">

            <div class="form-group row">
               <div class="col-sm-6">
                  <input class="form-control mr-sm-2" type="search" placeholder="Please enter minimum 3 character" aria-label="Search" id="searchItem" name="search" value="<?php echo isset($_GET['search'])?$_GET['search']:''; ?>">
               </div>
               <div class="col-sm-6">
                  <button class="btn btn-primary my-2 my-sm-0" type="submit">Search Users</button>
               </div>
            </div>
         </form>
         <table class="table table-light table-hover table-striped ">
            <thead class="thead-dark">
               <tr>
                <?php generateTableHead($tableHeadDetails); ?>
                  <th scope="col">Action<a></th>
               </tr>
            </thead>
            <tbody>
            <?php if ($result->num_rows > 0) {
               while($row = $result->fetch_assoc()) { ?>
              <tr>
                <td><?php echo $row['f_name'].' '.$row['m_name'].' '.$row['l_name']; ?></td>
                <td> <a href="mailto:<?php echo $row['email']; ?>"><?php echo $row['email']; ?></a></td>
                <td><?php echo $row['dob']; ?></td>
                <td><?php echo $row['gender']; ?></td>
                <td><?php echo $row['date(creation_date)']; ?></td>
                <td>
                  <a class="btn btn-primary btn-sm" href="userDetails.php?id=<?php echo $row['id'];?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                  <a class="btn btn-primary btn-sm" href="userEdit.php?id=<?php echo $row['id'];?>"><i class="rounded-circle fas fa-edit"></i></a>
                  <a data-toggle="modal" data-target="#exampleModal" data-id="<?php echo $row['id']; ?>" class="btn btn-primary btn-sm delete" href="#"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </td>        
              </tr>
              <?php } } else { ?>
              <tr><td colspan="6">No Records found</td></tr>
              <?php } ?>
            </tbody>
         </table>
         <?php if ($totalPages>1) { pagination($paginationConstraints); } ?>  
      </div>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete?</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
              <button type="button" id="yes" class="btn btn-danger">Yes</button>
            </div>
          </div>
        </div>
      </div>

      <?php include 'templates/footer.php'?>
      
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script type="text/javascript" src="assets/javascript/usersListingPage.js"></script>
    <script type="text/javascript" src="assets/javascript/common.js"></script>

   </body>
</html>