<?php
  require_once('connect.php');
  require_once 'functions.php';

  session_start();  
  /* Not logged in: return blank data */
  if(!isset($_SESSION['users_id']) || $_SESSION['users_id'] == 0) {
    echo "Not logged in";
    die();
  }
  else {  
    $users_query_sql = "select * from users";
    $users_query  = mysql_query($users_query_sql);
  
    while($users = mysql_fetch_array($users_query)) {
      echo "User: " . $users['users_email'] . " (" . $users['users_fullname'] . ")<BR>";
      /* get all trip info for this user */
      $tripInfoArray = findTripInfo($users['users_id']);
      
      foreach($tripInfoArray as $theTrip) {
        echo "Trip: start" . $theTrip['start'] . " or end " . $theTrip['end'];
        /* if there is already a record in the db with this start date or end date then skip it */
        $checkQuery = "select trips_id from trips where trips_users_id = " . $users['users_id'] . " and trips_datetime_start = '" . $theTrip['start'] . "' or trips_datetime_end = '" . $theTrip['end'] . "'";
        $result = mysql_query($checkQuery);
        if(mysql_num_rows($result) > 0) {
          echo " Already Exists!<BR>";
        }
        else {
          $sqlQuery = "insert into trips (trips_users_id, trips_datetime_start, trips_datetime_end) values(" . 
                      $_SESSION['users_id'] . "," . 
                      "'" . $theTrip['start'] . "'," . 
                      "'" . $theTrip['end'] . "');";
          $ret = mysql_query($sqlQuery);
          if (!$ret) {
            echo "Insert of trip data failed";
          }
          else {
            echo " Inserted in DB<BR>";
          }
        }
      }
      echo "<hr>";
    }
  }
  
  
?>
