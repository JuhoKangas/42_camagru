<?php
  require_once("functions.php");

  $email = $_POST['email'];
  $username = $_POST['username'];
  $pwd = password_hash($_POST['pwd'], PASSWORD_BCRYPT);
  $pwdAgain = $_POST['pwdAgain'];

  if (empty($email) || empty($username) || empty($pwd) || empty($pwdAgain)) {
    echo "empty fields";
  } else {
    try {
      $conn = connect();

      $stmt = $conn->prepare("INSERT INTO userinfo (username, email, password)
      VALUES (:username, :email, :password)");
      $stmt->bindParam(':username', $username);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':password', $pwd);

      $stmt->execute();

      echo "user created";
    } catch(PDOException $e){
      echo "Error: " . $e->getMessage();
    }
    $conn = null;
  }
?>

<?php include_once("includes/header.php") ?>

<h1>Register to post on Camagru.</h1>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <div class="form-container">
        <div class="control">
          <label for="email">Email</label>
          <input type="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>" placeholder="Email" />
        </div>
        <div class="control">
          <label for="username">Username</label>
          <input type="text" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>" placeholder="username" />
        </div>
        <div class="control">
          <label for="pwd">Password</label>
          <input type="password" name="pwd" value="<?php echo isset($_POST['pwd']) ? $_POST['pwd'] : '' ?>" placeholder="Password" />
        </div>
        <div class="control">
          <label for="pwd_dub">Password again</label>
          <input type="password" name="pwdAgain" value="<?php echo isset($_POST['pwdAgain']) ? $_POST['pwdAgain'] : '' ?>" placeholder="Password again" />
        </div>
        <input type="submit" value="OK" name="submit">
      </div>
    </form>
    <a href="login.php">Go back to login</a>

  <?php include_once("includes/footer.php") ?>