<?php
  require_once('connect.php');

  session_start();
  /* Not logged in: return blank data */
  if(!isset($_SESSION['users_id']) || $_SESSION['users_id'] == 0) {
    /* return nothing */ 
    die();
  }
  
  if(!isset($_SESSION['users_units']) || (isset($_SESSION['users_units']) && $_SESSION['users_units'] == "US")) {
    $speed_units = "mph";
    $distance_units = "miles";
    $miles_multiplier = 0.621371;
  }
  else {
    $speed_units = "km/h";
    $distance_units = "km";
    $miles_multiplier = 1;
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
  
  $queryResult = mysql_query("select min(leaflogs_timestamp) as start_timestamp, max(leaflogs_timestamp) as end_timestamp, min(leaflogs_odometer) as start_odometer, max(leaflogs_odometer) as end_odometer, avg(leaflogs_speed) as averageSpeed, min(leaflogs_gids) as min_gids, max(leaflogs_gids) as max_gids, min(leaflogs_soc) as min_soc, max(leaflogs_soc) as max_soc from leaflogs where leaflogs_user_id=" . $_SESSION['users_id'] . $startString . $endString . " order by leaflogs_timestamp");
  
  if(!$queryResult) {
    die("Query failed: " . mysql_error());
  }
  
  $record = mysql_fetch_array($queryResult, MYSQL_ASSOC);

  $toReturn = array();
  if($record) {
    $toReturn['trip_length'] = round((strtotime($record['end_timestamp']) - strtotime($record['start_timestamp'])) / 60, 0);
    $toReturn['start'] = round($record['start_odometer'] * $miles_multiplier, 1);
    $toReturn['end'] = round($record['end_odometer'] * $miles_multiplier, 1);
    $toReturn['trip'] = round(($record['end_odometer'] - $record['start_odometer']) * $miles_multiplier, 1);
    $toReturn['socDifference'] = round(abs(($record['max_soc'] - $record['min_soc']) / 10000), 1) + "%";
    $toReturn['gidsDifference'] = abs($record['max_gids'] - $record['min_gids']);
    $toReturn['averageSpeed'] = round($record['averageSpeed'], 1);
    $toReturn['speed_units'] = $speed_units;
    $toReturn['distance_units'] = $distance_units;
  }
  
  echo json_encode($toReturn);
?>

