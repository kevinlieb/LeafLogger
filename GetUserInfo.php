
<?php
  require_once('connect.php');

  session_start();  

  if(isset($_SESSION['users_fullname'])) {
    $toReturn['fullname'] = $_SESSION['users_fullname'];
  }
  else {
    $toReturn['error'] = "Please log in";
  }
  
  echo json_encode($toReturn);
?>
