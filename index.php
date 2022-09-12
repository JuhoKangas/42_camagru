<?php
  session_start();
  require_once("config/setup.php");

  if (isset($_SESSION['logged_in_user'])) {
    header("Location: ./src/home.php");
  } else {
    header('Location: ./src/login.php');
  }

?>
