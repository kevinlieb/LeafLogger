<?php      
  require_once('connect.php');
  
  session_start();  
  
  if(isset($_SESSION['users_id'])) {
    $sql = "delete from leaflogs.leaflogs where leaflogs_user_id=" . $_SESSION['users_id'];
    
    //echo $sql;
    $ret = mysql_query($sql);
    echo "All records deleted";
  }
  else {
    echo "Not logged in!";
  }
  
?>
