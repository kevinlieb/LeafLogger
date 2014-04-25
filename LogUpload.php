<?php
  require_once 'BatLogToDb.php';
  session_start();  
  
  //echo "<pre>";
  //print_r($_FILES);
  //print_r($_REQUEST);  
  //echo "</pre>";
  
  if(!isset($_SESSION['users_id'])) {
    echo json_encode(array("error"=>"You are not logged in"));  
  }
  else {
    if(isset($_FILES) && isset($_FILES['file']) && isset($_FILES['file']['name'])) {
      $target_path = "uploads/";
  
      $target_path = $target_path . basename( $_FILES['file']['name']); 

      if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
        //echo "The file ".  basename( $_FILES['file']['name']). " has been uploaded<BR><BR>";
        $retval = importBatLog($target_path, $_SESSION['users_id']);
        echo json_encode($retval);
      } else{
        echo json_encode(array("error"=>"There was an error uploading the file, please try again!"));  
      } 
    }
    else {
      echo json_encode(array("error"=>"Bad Upload"));  
    }
  }
?>
