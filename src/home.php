<?php 
  require_once("includes/header.php");
  // if (empty($_SESSION['logged_in_user'])) {
  //   header("location: login.php");
  // }
?>
  <div class="content px-4">

    <div class="card">
      <div class="card-top"></div>
      <div class="card-img"></div>
      <div class="card-likes"></div>
      <div class="card-comments-list"></div>
      <div class="card-comment"></div>
    </div>
    
    <a href="logout.php">logout</a>
  </div>
<?php require_once("includes/footer.php") ?>