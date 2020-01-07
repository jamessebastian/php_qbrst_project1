  <?php 
      
    // Import the file where we defined the connection to Database.   
    include 'models/dbConnection.php'; 
  
    $limit = 10;  // Number of entries to show in a page. 
    // Look for a GET variable page if not found default is 1.      
    if (isset($_GET["page"])) {  
      $pn  = $_GET["page"];  
    }  
    else {  
      $pn=1;  
    };   
  
    $start_from = ($pn-1) * $limit;   
  
    $sql = "SELECT * FROM users LIMIT $start_from, $limit";   
    $rs_result = mysql_query ($sql);  
  
  ?> 

<!DOCTYPE html> 
<html> 
  <head> 
    <title>ProGeeks Cup 2.0</title> 
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
     <link rel="stylesheet" type="text/css" href="assets/bootstrap-4.3.1-dist/css/bootstrap.min.css" />
  </head> 
  <body> 
  <div class="container"> 
    <br> 
    <div> 
      <h1>ProGeeks Cup 2.0</h1> 
      <p>This page is just for demonstration of  
                 Basic Pagination using PHP.</p> 
     
      <ul class="pagination"> 
      <?php   
        $sql = "SELECT COUNT(*) FROM table1";   
        $rs_result = mysql_query($sql);   
        $row = mysql_fetch_row($rs_result);   
        $total_records = $row[0];   
          
        // Number of pages required. 
        $total_pages = ceil($total_records / $limit);   
        $pagLink = "";                         
        for ($i=1; $i<=$total_pages; $i++) { 
          if ($i==$pn) { 
              $pagLink .= "<li class='active'><a href='index.php?page="
                                                .$i."'>".$i."</a></li>"; 
          }             
          else  { 
              $pagLink .= "<li><a href='index.php?page=".$i."'> 
                                                ".$i."</a></li>";   
          } 
        };   
        echo $pagLink;   
      ?> 
      </ul> 
    </div> 
  </div> 
  </body> 
</html> 
