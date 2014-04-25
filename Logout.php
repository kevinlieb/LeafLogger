<?php

  /* Completely distroy the session */
  session_start();
  session_unset();
  session_destroy();

?>
