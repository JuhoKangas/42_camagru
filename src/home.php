<?php 
  require_once("includes/header.php");
  if (empty($_SESSION['logged_in_user'])) {
    header("location: login.php");
  }
?>
  <h1>Welcome to the fucking shitshow <?php echo $_SESSION['logged_in_user'] ?></h1>
  <a href="logout.php">logout</a>
<?php require_once("includes/footer.php") ?>