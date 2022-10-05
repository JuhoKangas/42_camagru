<?php
  require_once("includes/header.php");
  require_once("functions.php");

  $errMsg = '';
  if ($_POST) {
    $email = htmlspecialchars($_POST['email']);
    $username = htmlspecialchars($_POST['username']);
    $pwd = password_hash($_POST['pwd'], PASSWORD_BCRYPT);
  
    if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{16,50}$/', $_POST['pwd'])) {
      $errMsg = 'the password does not meet the requirements!';
    }
    
    if ($_POST['submit'] === 'OK' && $_POST['pwd'] !== $_POST['pwdAgain']) {
      $errMsg = "Passwords don't match";
    }
    
    if ($_POST['submit'] === 'OK' && !(usernameAvailable($username))) {
      $errMsg = "Username is taken";
    }
    
    if ($_POST['submit'] === 'OK' && !(emailAvailable($email))) {
      $errMsg = "Email is already in use";
    }
    
    if ($_POST['submit'] === 'OK' && $errMsg === '') {
      createUser($username, $email, $pwd);
      header("Location: ./check_email.php");
    }
  }

?>

<div class="content">
<h1 class="title text-center">Sign up to post on<br>Camagru.</h1>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <div class="form-container">
        <div class="control">
          <label for="email">Email</label>
          <input type="email"
                  name="email"
                  value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>"
                  placeholder="a.honnold@climb.com"
                  required
                  maxlength="255" />
        </div>
        <div class="control">
          <label for="username">Username</label>
          <input type="text"
                  name="username"
                  value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>"
                  placeholder="assblaster69"
                  required
                  maxlength="50"
                  />
        </div>
        <div class="control">
          <label for="pwd">Password</label>
          <input type="password"
                  name="pwd"
                  value="<?php echo isset($_POST['pwd']) ? $_POST['pwd'] : '' ?>"
                  placeholder="Pleaseusepassphrase"
                  required 
                  maxlength="50"/>
                  <div class="sub-text text-center px-4 py-3">
                    <!-- 16 character long password would take approximately 1511681941489 years to brute force so it's safe -->
                    <p>Password must be between 16 and 50 characters long and has to contain letters and numbers</p>
                  </div>
        </div>
        <div class="control">
          <label for="pwd_dub">Password again</label>
          <input type="password"
                  name="pwdAgain"
                  value="<?php echo isset($_POST['pwdAgain']) ? $_POST['pwdAgain'] : '' ?>"
                  placeholder="Password again"
                  required />
        </div>
        <?php if($errMsg): ?>
          <small class="sub-text text-center text-warning mt-4 px-4"><?php echo $errMsg ?></small>
        <?php endif; ?>
        <button class="btn btn-main btn-big mt-5" type="submit" value="OK" name="submit">Sign up</button>
      </div>
    </form>
</div>

  <?php include_once("includes/footer.php") ?>