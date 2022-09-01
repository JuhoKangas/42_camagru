<?php
  
  session_start();

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
    <nav>
      <div class="navbar">
        <img src="../../img/camagru-logo.svg" alt="camagru logo" />
        <div class="nav-btns">
          <a href="/src/login.php"><button class="btn btn-main">Log in</button></a>
          <a href="/src/create.php"><button class="btn">Sign up</button></a>
        </div>
      </div>
    </nav>