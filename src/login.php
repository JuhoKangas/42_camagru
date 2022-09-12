<?php 
  require_once("includes/header.php");
  require_once("functions.php");
  
  $loginErr = '';

  if ($_POST['submit'] === 'OK') {
    if (find_by_username($_POST['username']) && !user_active($_POST['username'])) {
      $loginErr = 'This account has not yet been activated, please check your email!';
    } else if (login_user($_POST['username'], $_POST['pwd'])) {
      header("location: home.php");
    } else if (isset($_POST['username']) && isset($_POST['pwd'])) {
      $loginErr = 'Please check the password';
    }
  }
?>


<div class="content">
<h1 class="title text-center">Login to Camagru.</h1>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
  <div class="form-container">
    
    <div class="control">
      <label for="username">Username</label>
      <input type="text" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>" placeholder="username" required />
    </div>
    <div class="control">
      <label for="pwd">Password</label>
      <input type="password" name="pwd" value="<?php echo isset($_POST['pwd']) ? $_POST['pwd'] : '' ?>" placeholder="Password" required />
      <?php if($loginErr != ''): ?>
        <p class="sub-text text-center text-warning mt-4 px-4"><?php echo $loginErr ?></p>
      <?php endif; ?>
    </div>
    
    <button class="btn btn-main btn-big mt-4" type="submit" value="OK" name="submit">Login</button>
  </div>
</form>
</div>

<?php include_once("includes/footer.php") ?>