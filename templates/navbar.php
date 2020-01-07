<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$menuItemsList = array(
  array("url" => "home.php","title" => "Home" ),
  array("url" => USERS_LISTING_PAGE,"title" => "Users" ),
  array("url" => "#","title" => "Features2" )
);

/**
 * checks whether current link or not.Returns 'active' if the link is current link
 *
 * @param string $link link
 *
 * @return string 
 */
function whetherCurrentLink($link = '') 
{
   return (strpos($_SERVER['REQUEST_URI'],$link) !== false) ? 'active':'';
}

?>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
   <div class="container">
      <a class="navbar-brand" href="home.php">MySite</a>
      <div class="collapse navbar-collapse" id="navbarNav">
         <ul class="navbar-nav">
              <?php for($x = 0; $x < count($menuItemsList); $x++) { ?>
            <li class="nav-item <?php echo whetherCurrentLink($menuItemsList[$x]["url"]); ?>">
               <a class="nav-link" href="<?php echo $menuItemsList[$x]["url"];?>"><?php echo $menuItemsList[$x]["title"];?></a>
            </li>
         <?php } ?>
         </ul>
         
         <ul class=" navbar-nav ml-auto">
            <div class="dropdown mr-2">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                My Profile
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="userEdit.php">Edit profile</a>
                <a class="dropdown-item" href="changePassword.php">Change Password</a>
              </div>
            </div>        
            <li class="nav-item">
               <a  class="btn btn-primary" href="logout.php"> Logout</a> 
            </li>
         </ul>
      </div>
   </div>
</nav>

    