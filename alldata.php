<?php
  require_once('connect.php');

  session_start();  
  /* Not logged in: return blank data */
  if(!isset($_SESSION['users_id']) || $_SESSION['users_id'] == 0) {
    echo "{\"aaData\": []}";
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
  
  $queryResult = mysql_query("select leaflogs_timestamp, leaflogs_lat, leaflogs_lon, leaflogs_elevation, leaflogs_speed, round(leaflogs_soc / 10000, 1), leaflogs_gids from leaflogs where leaflogs_user_id= " . $_SESSION['users_id'] . $startString . $endString . " order by leaflogs_timestamp");
  
  if(!$queryResult) {
    die("Query failed: " . mysql_error());
  }
  
  echo "{\"aaData\": [";
  $allResults = array();
  while($record = mysql_fetch_array($queryResult, MYSQL_ASSOC)) {
    $thisRecord = array();
    foreach($record as $field) {
      $thisRecord[] = "\"" . $field . "\"";
    }
    $allResults[] = $thisRecord;
  }

  for($n = 0; $n < count($allResults); $n ++) {
    echo "[" . ($n + 1) . "," . implode(",",$allResults[$n]) . "]";
    if($n < (count($allResults) - 1)) {
      echo ",";
    }
    
  }
  echo "]}";
  
/* function no longer used */  
function multi_implode($array, $glue) {
    $ret = '';

    foreach ($array as $item) {
        if (is_array($item)) {
            $ret .= multi_implode($item, $glue) . $glue;
        } else {
            $ret .= $item . $glue;
        }
    }

    $ret = substr($ret, 0, 0-strlen($glue));

    return $ret;
}
?>

