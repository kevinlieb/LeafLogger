<?php
  require_once('connect.php');
  require_once 'functions.php';

  session_start();  
  /* Not logged in: return blank data */
  if(!isset($_SESSION['users_id']) || $_SESSION['users_id'] == 0) {
    echo "date,SOC\n";
    die();
  }
  else {
    $tripInfoArray = findTripInfo($_SESSION['users_id']);
    echo json_encode($tripInfoArray);
  }
  
  
?>
