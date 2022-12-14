<?php
  require_once("includes/header.php");
  require_once("functions.php");
  
    if (!(isset($_GET['email']) && isset($_GET['unique_token']))) {
      header('location: home.php');
      exit;
    }
  
  $email = $_GET['email'];
  $unique_token = $_GET['unique_token'];
?>

<?php if(activate_user($email, $unique_token)): ?>
  <div class="content d-flex d-column align-center">
    <img src="../img/office2.png" width="250" alt="">
    <h1 class="title py-2">You have been verified!</h1>
    <p class="my-4">Thanks for confirming your account! You can now start posting on Camagru.</p>
    <a href="login.php"><div class="btn btn-main btn-big mt-5">Log in!</div></a>
  </div>
<?php else: ?>
    <div class="content d-flex align-center">
      <h1 class="title">This account can't be verified</h1>
    </div>
<?php endif; ?>

<?php require_once("includes/footer.php") ?>