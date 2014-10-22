<?php
  header('Content-type: application/json');
  require_once('connect.php');
  session_start();
  
  $toReturn = json_encode(array("success"=>false));

  $email = $_REQUEST['email'];
  $password = $_REQUEST['password'];

  //echo "email is " . $email . " and password " . $password;
  $usersQuerySql = "select * from users  where users_email = '" . mysql_real_escape_string($_REQUEST['email']) . "'";
  $usersQuery = mysql_query($usersQuerySql);
  
  if(mysql_errno()) {
    //echo "Error1: " . mysql_errno() . mysql_error();
  }
  else {
  //echo "rows: " . mysql_num_rows($usersQuery);
    if(mysql_num_rows($usersQuery) == 1) {
      if($usersQuery) {
        $user = mysql_fetch_array($usersQuery);
        //echo "user is " . $user;
        //echo "Password is " . $user['users_password'] . " and num_rows is " . mysql_num_rows();
    
        if(md5($password) == $user['users_password'])  {
          recordLogin($user['users_id']);
          $_SESSION['users_fullname'] = $user['users_fullname'];
          $_SESSION['users_id'] = $user['users_id'];
          $_SESSION['users_is_admin'] = $user['users_is_admin'];
          $_SESSION['users_units'] = $user['users_units'];
          $_SESSION['users_trip_delimiter'] = $user['users_trip_delimiter'];
          $toReturn =  json_encode(array("success"=>true));
        }
      }
    }        
  }
  
  echo $toReturn;
  
  function recordLogin($users_id) {
    $sql = "insert into leaflogs.loginlog (loginlog_users_id) values (" . $users_id . ")";
    $ret = mysql_query($sql);
  }
?>
