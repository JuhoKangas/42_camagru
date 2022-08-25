<?php
  require_once("auth.php");
  require_once("connection.php");


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
    <link rel="stylesheet" href="../styles/create.css" />
    <link rel="stylesheet" href="../styles/style.css" />
  </head>
  <body>
    <h1>Login to Camagru.</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <div class="form-container">

        <div class="control">
          <label for="username">Username</label>
          <input type="text" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>" placeholder="username" />
        </div>
        <div class="control">
          <label for="pwd">Password</label>
          <input type="password" name="pwd" value="<?php echo isset($_POST['pwd']) ? $_POST['pwd'] : '' ?>" placeholder="Password" />
        </div>

        <input type="submit" value="OK" name="submit">
      </div>
    </form>
    <?php auth($_POST['username'], $_POST['pwd']) ?>
	<a href="create.php">No user? Create one here</a>
  </body>
</html>