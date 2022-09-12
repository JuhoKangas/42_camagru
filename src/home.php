<?php 
  require_once("includes/header.php");
  // if (empty($_SESSION['logged_in_user'])) {
  //   header("location: login.php");
  // }
?>
  <div class="content d-flex align-center d-column">
    <h1 class="title">Welcome to the fucking shitshow <?php echo $_SESSION['logged_in_user'] ?></h1>
    <br>
    <a href="logout.php">logout</a>
  </div>
  <?php require_once("includes/footer.php") ?>