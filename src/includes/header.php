<?php
  
  session_start();

?>

<?php if(isset($_SESSION['logged_in_user'])): ?>
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
      <!-- FONT AWESOME -->
    </head>
    <body>
      <nav>
        <div class="navbar">
          <a href="home.php"><img src="../img/camagru-logo.svg" alt="camagru logo" /></a>
          <div class="buttons-middle">
            <a href="home.php"><button class="btn btn-icon"><img src="../img/icons/home.svg" alt=""></button></a>
            <a href="upload_webcam.php"><button class="btn btn-icon"><img src="../img/icons/add_img.svg" alt=""></button></a>
            <a href="#"><button class="btn btn-icon"><img src="../img/icons/profile.svg" alt=""></button></a>
          </div>
          <div class="buttons-right">
            <a href="#"><button class="btn btn-icon"><img src="../img/icons/settings.svg" alt=""></button></a>
            <a href="logout.php"><button class="btn btn-icon"><img src="../img/icons/logout.svg" alt=""></button></a>
          </div>
        </div>
      </nav>
<?php else: ?>
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
      <!-- FONT AWESOME -->
      <script src="https://kit.fontawesome.com/f1f997944d.js" crossorigin="anonymous"></script>
    </head>
    <body>
      <nav>
        <div class="navbar">
          <a href="home.php"><img src="../img/camagru-logo.svg" alt="camagru logo" /></a>
          <div class="nav-btns">
            <a href="../src/login.php"><button class="btn btn-main">Log in</button></a>
            <a href="../src/create.php"><button class="btn">Sign up</button></a>
          </div>
        </div>
      </nav>
<?php endif; ?>