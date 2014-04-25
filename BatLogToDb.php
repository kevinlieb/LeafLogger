<?php      
  require_once('connect.php');
  

  function importBatLog($filename, $users_id) {
    require_once('fields.php');
    $errorStrings = array();
    
    //$db = mysql_connect("localhost", "leaflogs", "nothing123");
    if(!db) {
      $errorStrings[] = "Error connecting to DB";
    }
    else {
      if (($handle = fopen($filename, "r")) !== FALSE) {
        $row = 0;
        $dups = 0;
        $errors = 0;
        while (($data = fgetcsv($handle, 1500, ",")) !== FALSE) {
          $dateOfRecord = 0;
          $sql_data['leaflogs_user_id'] = $users_id;
      
          /* skip row 0 with the col names in it */
          if($row > 0) {
            /* If there are less fields in the data than specified just read the fields that exist.  */
            /* otherwise don't read more fields than are specified */
            //echo "data count is " . count($data) . " and field count is " .  count($fields);
            if(count($data) < count($fields)) {
              $max = count($data);
            }
            else {
              $max = count($fields);
            }
            //for($col = 0; $col < count($data); $col ++) {
            for($col = 0; $col < ($max - 2); $col ++) {
              $theField = $fields[$col + 2];
          
              /* if lat or lon not set put in a zero (perhaps make this null going forward */
              if($theField == 'leaflogs_lat' || $theField == 'leaflogs_lon') {
                if($data[$col] == "") {
                  $theValue = 0;
                }
                else {
                  $theValue = funkyCoordinatesToRegular($data[$col]);
                }
              }
              else {
                if($theField == "leaflogs_timestamp") {
                  //echo "Date is " . $data[$col] . "<BR>";
                  $unixEpochTimestamp = strtotime($data[$col]);
                  $theValue = "'" . date("Y-m-d H:i:s", $unixEpochTimestamp) . "'";
                  $dateOfRecord = $theValue;
                }
                else {
                /* Strip the V out of battery voltage */
                  if($theField == "leaflogs_batvolt") {
                    $theValue = str_replace("V","",$data[$col]);
                  }
                  else {
                    if($theField == "leaflogs_vin") {
                      $theValue = "'" . $data[$col] . "'";
                    }

                    else {
                      /* temperature values are now "none" if there is no sensor for this year */
                      if($data[$col] == "none") {
                        $theValue = '';
                      }
                      else {
                        $theValue = $data[$col];
                      }
                    }
                  }
                }
              }
      
              /* offset by 2: we skip the first two fields (id and user id of the uploader */
              if(strlen($theValue) > 0) {
                $sql_data[$fields[$col + 2]] = $theValue;
              }
            }
 
            $checkExistenceQuery = "select count(*) as thecount from leaflogs where leaflogs_user_id = " . $users_id . " and leaflogs_timestamp = " . $dateOfRecord;
            $queryResult = mysql_query($checkExistenceQuery);
            if(!$queryResult) {
              //echo "query: " . $checkExistenceQuery;
              $errorStrings[] ='Invalid query while checking record existence: ' . mysql_error();
            }
            $result = mysql_fetch_array($queryResult);

            if($result['thecount'] == 0) {
              $sql = "insert into leaflogs.leaflogs (" . implode(",", array_keys($sql_data)) . ") values (" . implode(",",$sql_data) . ");";
    
              $ret = mysql_query($sql);
              if (!$ret) {
                //echo "Insert query: " . $sql;
                //die('Invalid query: ' . mysql_error());
                file_put_contents('logs/UploadFailures.log', "failed up insert into database for user " . $users_id . ": " . $sql . " " . mysql_error(), FILE_APPEND);
                $errorStrings[] = "Unable to insert record for: " . $dateOfRecord;
                //echo $sql . "<BR>";
                $errors ++;
              }
              unset($sql_data);
            }
            else {
              $dups ++;
            }
          }
          $row ++;
        } /* end while */
        fclose($handle);
        $retval = array("processed"=> $row - 1,
                        "dups"=>$dups,
                        "errors"=>$errors,
                        "inserted"=>($row - $dups - $errors - 1),
                        "errorStrings"=>$errorStrings);
        //echo "\n" . $row - 1 .  " records processed.  " . $dups . " dups ignored, " . $errors . " errors skipped.  " . ($row - $dups - $errors - 1) . " new records inserted\n";
      }
      else {
        $retval = array("errorStrings"=>array("Could not open " . $filename));
      }
    }
    return($retval);
  }
  

function funkyCoordinatesToRegular($funkyString) {
  $pos = explode(":", $funkyString);
  if($pos[0] > 0) {
    return($pos[0] + ($pos[1] / 60));
  }
  else {
    return(-(abs($pos[0]) + ($pos[1] / 60)));
  }
}
?>
