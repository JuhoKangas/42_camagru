<?php 
  require_once("includes/header.php");
  // if (empty($_SESSION['logged_in_user'])) {
  //   header("location: login.php");
  // }
?>
  <div class="content px-5">

    <div class="card mt-5">
      <div class="card-header py-2 px-2">
        <p class="card-username">username</p>
        <p class="card-time">39m ago</p>
      </div>
      <div class="card-img"></div>
        <img src="../img/john-o-nolan-6f_ANCcbj3o-unsplash.jpg" alt="" width="100%">
      <div class="card-likes">
        <i class="fa-regular fa-heart"></i>
        <i class="fa-solid fa-heart"></i>
        <i class="fa-regular fa-comment"></i>
        <i class="fa-solid fa-share-nodes"></i>
      </div>
      <div class="card-comments-list"></div>
      <div class="card-comment"></div>
    </div>
    
    <!-- <a href="logout.php">logout</a> -->
  </div>
<?php require_once("includes/footer.php") ?>