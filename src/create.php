<?php
  require_once("connection.php");

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

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Camagru</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../styles/style.css" />
  </head>
  <body>
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
  </body>
</html>