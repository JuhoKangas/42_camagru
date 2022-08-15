<?php
  session_start();

  $_SESSION['logged_in_user'] = "";

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Camagru</title>
    <link rel="stylesheet" href="./styles/style.css" />
  </head>
  <body>
    <?php if ($_SESSION['logged_in_user'] != ""): ?>
      <h1>Hey what's up <?php echo $_SESSION['logged_in_user'] ?></h1>
    <?php else: ?>
      <h1>Hello Stranger</h1>
    <?php endif; ?>
  </body>
</html>
