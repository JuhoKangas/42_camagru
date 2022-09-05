<?php
  session_start();
  require_once("config/setup.php");

  if (isset($_SESSION['logged_in_user'])) {
    echo '<h1>Here we are</h1>';
  } else {
    header('Location: /src/login.php');
  }

?>
