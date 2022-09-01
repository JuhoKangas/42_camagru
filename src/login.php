<?php 
  require_once("includes/header.php");
  require_once("functions.php");
  
  $passwordErr = '';

  if (auth($_POST['username'], $_POST['pwd'])) {
    header("location: home.php");
    $_SESSION['logged_in_user'] = $_POST['username'];
  } else if (isset($_POST['username']) && isset($_POST['pwd']))
    $passwordErr = 'Wrong password';
  ?>


<h1 class="title">Login to Camagru.</h1>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
  <div class="form-container">
    
    <div class="control">
      <label for="username">Username</label>
      <input type="text" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>" placeholder="username" />
      <?php if($passwordErr != ''): ?>
        <p>Wrong Password</p>
      <?php endif; ?>
    </div>
    <div class="control">
      <label for="pwd">Password</label>
      <input type="password" name="pwd" value="<?php echo isset($_POST['pwd']) ? $_POST['pwd'] : '' ?>" placeholder="Password" />
    </div>
    
    <input type="submit" value="OK" name="submit">
  </div>
</form>

<?php include_once("includes/footer.php") ?>