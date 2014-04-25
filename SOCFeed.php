<?php
  require_once('connect.php');

  session_start();  
  /* Not logged in: return blank data */
  if(!isset($_SESSION['users_id']) || $_SESSION['users_id'] == 0) {
    echo "date,SOC\n";
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
  
  $queryResult = mysql_query("select leaflogs_timestamp, leaflogs_soc,leaflogs_gids from leaflogs where leaflogs_user_id= " . $_SESSION['users_id'] . $startString . $endString . " order by leaflogs_timestamp");
  
  if(!$queryResult) {
    die("Query failed: " . mysql_error());
  }
  
  echo "date,SOC,gids\n";
  while($record = mysql_fetch_array($queryResult)) {
    echo $record[0] . "," . $record[1]/10000 . "," . $record[2] . "\n";
  }

?>

