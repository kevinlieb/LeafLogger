<?php
  require_once('connect.php');
  session_start(); 
  
  $start = $_REQUEST['start'];
  $end = $_REQUEST['end'];
  
  if(isset($start) && isset($end)) {
    $_SESSION['last_start_selected'] = $start;
    $_SESSION['last_end_selected'] = $end;
  }
  
?>