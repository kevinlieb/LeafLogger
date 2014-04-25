<?php
  require_once('connect.php');

  session_start();  
  /* Not logged in: return blank data */
  if(!isset($_SESSION['users_id']) || $_SESSION['users_id'] == 0) {
    echo "date,t1,t2,t3,t4,ambient\n";
    die();
  }

  if(!isset($_SESSION['users_units']) || (isset($_SESSION['users_units']) && $_SESSION['users_units'] == "US")) {
    $field_suffix = "_f";
  }
  else {
    $field_suffix = "_c";    
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
  
  $queryResult = mysql_query("select leaflogs_timestamp, leaflogs_pack_t1" . $field_suffix . ",leaflogs_pack_t2" . $field_suffix . ",leaflogs_pack_t3" . $field_suffix . ",leaflogs_pack_t4" . $field_suffix . ",leaflogs_ambient from leaflogs where leaflogs_user_id= " . $_SESSION['users_id'] . $startString . $endString . " order by leaflogs_timestamp");
  
  if(!$queryResult) {
    die("Query failed: " . mysql_error());
  }
  
  /* initialize thermal data */
  $thermaldata = array();
  
  /* initialize field names */
  $fieldnames[0] = "date";
  $fieldnames[1] = "t1";
  $fieldnames[2] = "t2";
  $fieldnames[3] = "t3";
  $fieldnames[4] = "t4";
  $fieldnames[5] = "ambient";
  
  $numRecords = mysql_num_rows($queryResult);
  /* take all database data and put it into arrays */
  while($record = mysql_fetch_array($queryResult)) {
    /* the date is always valid */
    $thermaldata[0][] = $record[0];
    
    /* blank out invalid temperature values */
    for($n = 1; $n <= 5; $n ++) {
      if($record[$n] < -90) {
        $record[$n] = "";
      }
      $thermaldata[$n][] = $record[$n];
    }
  }
  
  $removeBadCols = true;
  /* for all of the data: if all values for a field are exactly the same and are zero then disregard it */
  $validElements = array();
  $validElements[0] = 0;
  for($n = 1; $n <= 5; $n ++) {
    $unique = array_unique($thermaldata[$n]);
    if(count($unique) == 1 && $unique[0] == 0 && $removeBadCols == true) {
      /* this array element is crap */
      $fieldnames[$n] = "empty";
    }
    $validElements[] = $n;
  }
  
  /* show all the field names on the first row */
  foreach($validElements as $theElement) {
    echo $fieldnames[$theElement] . ",";
  }
  echo "\n";
  
  $counter = 0;
  for($recordNumber = 0; $recordNumber <= $numRecords; $recordNumber ++) {
    foreach($validElements as $thelement) {
      echo $thermaldata[$thelement][$counter] . ",";
    }
    echo "\n";
    $counter ++;
  }
      

?>

