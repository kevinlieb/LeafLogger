<?php


function findTripInfo($users_id) {

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

  $leaflogs_query_sql = "select leaflogs_timestamp,unix_timestamp(leaflogs_timestamp) as unixtime from leaflogs where leaflogs_user_id = " . $users_id . " order by leaflogs_timestamp asc";
  $leaflogs_query = mysql_query($leaflogs_query_sql);
  
  $previousTimestampUnix = 0;
  $previousTimestampMysql = "";
  $theStart = array();
  $theEnd = array();
  $recordNumber = 0;
  
  $recordsInSet = array();
  $recordsInSetCounter = 0;
  
  while($leaflogs = mysql_fetch_array($leaflogs_query)) {
    //echo $leaflogs['leaflogs_timestamp'] . " is " . $leaflogs['unixtime'] . "<BR>";
    
    /* more than a 10 min gap... */
    if(($leaflogs['unixtime'] - $previousTimestampUnix)  > 1200) {
      //echo "End! " . $leaflogs['unixtime']  . " minus " .  $previousTimestampUnix . "<BR>";
      $theStart[] = $leaflogs['leaflogs_timestamp'];
      if($recordNumber > 0) {
        $theEnd[] = $previousTimestampMysql;
        $recordsInSet[] = $recordsInSetCounter;
        $recordsInSetCounter = 0;
      }
      
    }
    $previousTimestampUnix = $leaflogs['unixtime'];
    $previousTimestampMysql = $leaflogs['leaflogs_timestamp'];
    
    $recordNumber ++;
    $recordsInSetCounter ++;
  }
  
  /* add in the last timeperiod read */
  $theEnd[] = $previousTimestampMysql;
  $recordsInSet[] = $recordsInSetCounter;
  
  $resultsArray = array();
  for($n = 0; $n < count($theStart); $n ++) {
    //echo "start: " . $theStart[$n] . " end: " . $theEnd[$n] . "( " . $recordsInSet[$n] . " records)<BR>";
    $resultsArray[] = array("start"=>$theStart[$n],
                            "end"=>$theEnd[$n],
                            "records"=>$recordsInSet[$n]);
  }
    
  return($resultsArray);
}
  
?>
