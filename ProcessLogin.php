<?php
  require('includes/application_top.php');
  require('includes/queries.php');
  require('includes/functions.php');

  $debug = 0;

// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled (or the session has not started)
  if ($session_started == false) {
    tep_redirect(tep_href_link(FILENAME_COOKIE_USAGE));
  }

  $submitaction = $_POST['submitaction'];

  $users_query = "select * from users";

  if($submitaction <> "") {
    $email     = ereg_replace("\|'\"| .*", "", $_POST['email']);
    $password  = ereg_replace("\|'\"| .*", "", $_POST['password']);

    //$sql_data = array("login_attempt_login"    => stripslashes($_POST['login']),
    //                  "login_attempt_datetime" => "now()");

    //tep_db_perform("login_attempt", $sql_data);

    // Grab the encrypted form of the password, using the md5 function...
    $cryptpass = md5($password);

    $users_query_sql = $users_query . " WHERE users_email = '" . $email . "' AND users_cryptpass = '" . $cryptpass . "' AND users_account_disabled = 0";
    $users_query = tep_db_query($users_query_sql);

    $users = tep_db_fetch_array($users_query);

    /* if the query returned results, do it again and make sure there are no results.  This ensures one and only */
    /* one record was returned for the login, which should always be the case.  If there is more than one record */
    /* returned there is a hacking attempt such as sql injection or the user is in the db more than once         */
    if($users) {
      $no_users = tep_db_fetch_array($users_query);
      if(count($no_users) != 1) {
        //echo "count is " . count($no_users) . " and query is " . $users_query_sql;
        $errors[] = "There is a problem with your account.  Please contact your administrator.";
      }
      else {
        $users_id = $users['users_id'];
        $name     = $users['users_fullname'];
        $email    = $users['users_email'];
        $is_admin = $users['users_is_admin'];

        $_SESSION['session_users_id']                 = $users_id;
        $_SESSION['session_name']                     = $name;
        $_SESSION['session_email']                    = $email;
        $_SESSION['session_isAdmin']                  = $is_admin;

        // This is used to force a pw change if necessary:
        $_SESSION['forcepasswordchange']  = $users['users_force_password_change'];

        // If the user has to change their password, then we'll redirect...
        if ($users['users_force_password_change'] == 1) {
          //@TODO: something more clever
          //http_redirect('changepassword.php');
          //header('location:changepassword.php');
        }

        echo "Authenticated!";

      }
    }
    else {
      $errors[] = "Invalid login or password";
    }
  }

  /* display errors if any */
  /* @TODO: something beter with errors! This is crap */
  if(count($errors) > 0) {
    foreach($errors as $error) {
      echo "<TR><td>&nbsp;</td>";
      echo "<TD colspan='5'>";
      echo "<font color='red'><B>" . $error . "</b></font><BR><BR>";
      echo "</td><tr>";
    }
  }
?>

