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

  $leaflogs_query_sql = "select leaflogs_timestamp,unix_timestamp(leaflogs_timestamp) as unixtime from leaflogs where leaflogs_ignore = 0 and leaflogs_user_id = " . $users_id . " order by leaflogs_timestamp asc";
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
    if(($leaflogs['unixtime'] - $previousTimestampUnix)  > $_SESSION['users_trip_delimiter'] * 60) {
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

function generateRandomString($length = 10) {
  $characters = '23456789abcdefghijkmnpqrstuvwxyz';
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, strlen($characters) - 1)];
  }
  return $randomString;
}

function sendWelcomeEmail($emailAddress, $password) {
  $theEmail = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/WelcomeEmail.template');
  
  $theEmail = str_replace("%%email%%", $emailAddress, $theEmail);
  $theEmail = str_replace("%%password%%", $password, $theEmail);
  
  $to      = $emailAddress;
  $subject = 'Welcome to LeafLogger.com';

  $headers = 'From: kevin@leaflogger.com' . "\r\n" .
             'bcc: kkevinl@yahoo.com' . "\r\n" .
             'Reply-To: kevin@leaflogger.com' . "\r\n" .
             'X-Mailer: PHP/' . phpversion();

  mail($to, $subject, $theEmail, $headers);
}

?>
