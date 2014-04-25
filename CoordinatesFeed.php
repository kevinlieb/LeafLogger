<?php
  require_once('connect.php');

  session_start();
  //echo "_SESSION['users_id'] is " . $_SESSION['users_id'];
  /* Not logged in: return blank data */
  if(!isset($_SESSION['users_id']) || $_SESSION['users_id'] == 0) {
    /* return nothing */ 
    die();
  }
  
  $startString = "";
  $endString = "";
  
  $start = $_REQUEST['start'];
  $end = $_REQUEST['end'];
  
  if($start != null) {
    $startString = " and leaflogs_timestamp >= '" . $start . "'";
  }
  
  if($end != null) {
    $endString = " and leaflogs_timestamp <= '" . $end . "'";
  }
  
  $queryResult = mysql_query("select leaflogs_lat, leaflogs_lon from leaflogs where leaflogs_lat != 0 and leaflogs_user_id=" . $_SESSION['users_id'] . $startString . $endString . " order by leaflogs_timestamp");
  
  if(!$queryResult) {
    die("Query failed: " . mysql_error());
  }
  
  while($record = mysql_fetch_array($queryResult)) {
    echo $record[0] . "," . $record[1] . "\n";
  }

?>

