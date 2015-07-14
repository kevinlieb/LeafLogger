<?php
  require_once('connect.php');
  session_start(); 

  if(isset($_SESSION['last_start_selected']) && $_SESSION['last_end_selected']) {
    $toReturn = array('start'=>$_SESSION['last_start_selected'],
                      'end'=>$_SESSION['last_end_selected']);
    echo(json_encode($toReturn));
  }
  else {
    echo json_encode(array());
  }
?>
