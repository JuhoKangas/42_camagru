<?php
  require_once("functions.php");
  require_once("includes/header.php");
  
  $email = $_GET['email'];
  $unique_token = $_GET['unique_token'];

?>

<?php if(activate_user($email, $unique_token)): ?>
  <div class="content d-flex d-column align-center">
    <h1 class="title">You have now been verified!</h1>
    <p>Happy posting!</p>
  </div>
<?php else: ?>
    <div class="content d-flex align-center">
      <h1 class="title">This account can't be verified</h1>
    </div>
<?php endif; ?>

<?php require_once("includes/footer.php") ?>