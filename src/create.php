<?php
  require_once("includes/header.php");
  require_once("functions.php");

  $email = $_POST['email'];
  $username = $_POST['username'];
  $pwd = password_hash($_POST['pwd'], PASSWORD_BCRYPT);
  $errMsg = '';

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
    header("Location: /src/check_email.php");
  }

?>

<h1 class="title text-center">Sign up to post on<br>Camagru.</h1>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <div class="form-container">
        <div class="control">
          <label for="email">Email</label>
          <input type="email"
                  name="email"
                  value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>"
                  placeholder="a.honnold@climb.com" />
        </div>
        <div class="control">
          <label for="username">Username</label>
          <input type="text"
                  name="username"
                  value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>"
                  placeholder="assblaster69" />
        </div>
        <div class="control">
          <label for="pwd">Password</label>
          <input type="password"
                  name="pwd"
                  value="<?php echo isset($_POST['pwd']) ? $_POST['pwd'] : '' ?>"
                  placeholder="Pleaseusepassphrase" />
                  <div class="sub-text text-center px-4 py-2">
                    <p>Password must be N characters long and contain letters, numbers, and symbols.</p>
                  </div>
        </div>
        <div class="control">
          <label for="pwd_dub">Password again</label>
          <input type="password"
                  name="pwdAgain"
                  value="<?php echo isset($_POST['pwdAgain']) ? $_POST['pwdAgain'] : '' ?>"
                  placeholder="Password again" />
        </div>
        <?php if($errMsg): ?>
          <small><?php echo $errMsg ?></small>
        <?php endif; ?>
        <button class="btn btn-main btn-big mt-5" type="submit" value="OK" name="submit">Sign up</button>
      </div>
    </form>

  <?php include_once("includes/footer.php") ?>