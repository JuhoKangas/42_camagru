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
    <link rel="stylesheet" href="../styles/login.css" />
    <link rel="stylesheet" href="../styles/style.css" />
  </head>
  <body>
    <h1>Register to post on Camagru.</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <div class="form-container">
        <div class="control">
          <label for="email">Email</label>
          <input type="text" name="email" placeholder="Email" />
        </div>
        <div class="control">
          <label for="username">Username</label>
          <input type="text" name="username" placeholder="Username" />
        </div>
        <div class="control">
          <label for="pwd">Password</label>
          <input type="password" name="pwd" placeholder="Password" />
        </div>
        <div class="control">
          <label for="pwd_dub">Password again</label>
          <input type="password" name="pwd_dub" placeholder="Password again" />
        </div>
        <input type="submit" value="OK" name="submit">
      </div>
    </form>
  </body>
</html>

<?php
  var_dump($_POST);
?>