<!-- 
  CORRECT CARD WITHOUT FONTAWESOME
  PUT AS MANY AS YOU WANT INSIDE div.card-column
        <div class="card">
          <div class="card-header">
            <p class="card-username">username</p>
            <p class="card-time">39m ago</p>
          </div>
          <div class="card-img">
            <img src="../img/john-o-nolan-6f_ANCcbj3o-unsplash.jpg" alt="">
          </div>
          <div class="card-likes">
            <img src="../img/icons/heart_vector.svg" alt="heart">
            <p>256</p>
            <img src="../img/icons/comment-regular.svg" width="25" alt="">
            <p>9</p>
            <img src="../img/icons/share-nodes-solid.svg" width="25" alt="">
          </div>
          <div class="card-description">
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Harum unde molestias et veritatis ut illo, numquam culpa minima aliquam quaerat.</p>
          </div>
          <div class="card-comments-list">
            <div class="comment">
              <p class="card-username">username</p>
              <p>Lorem ipsum dolor sit amet.</p>
            </div>
            <div class="comment">
              <p class="card-username">username</p>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore, totam.</p>
            </div>
          </div>
          <div class="card-comment"></div>
        </div>

 -->

<?php 
  require_once("includes/header.php");
  require_once("functions.php");
  if (empty($_SESSION['logged_in_user'])) {
    header("location: login.php");
  }

  $images = fetch_all_images();
?>
  <div class="content">

    <div class="cards-container px-3">

    <?php foreach($images as $image): ?>
      <!-- HTML -->

      <div class="card">
        <div class="card-primary">
          <div class="card-header">
            <p class="card-username"><?php echo(get_username_by_id($image['uploader_id'])) ?></p>
            <p class="card-time"><?php echo($image['upload_time']) ?></p>
          </div>
          <div class="card-img">
            <img src="<?php echo("../img/uploads/" . $image['img_name']) ?>" alt="">
          </div>
        </div>
          <div class="card-secondary">
            <div class="card-likes">
              <img src="../img/icons/heart_vector.svg" alt="heart">
              <p>256</p>
              <img src="../img/icons/comment-regular.svg" width="25" alt="">
              <p>9</p>
              <img src="../img/icons/share-nodes-solid.svg" width="25" alt="">
            </div>
            <div class="card-description">
              <p><?php echo($image['img_desc']) ?></p>
            </div>
            <div class="card-comments-list">
              <?php
                $comments = get_post_comments($image['id']);
                foreach($comments as $comment):
              ?>
              <div class="comment">
                <p class="card-username"><?php echo(get_username_by_id($comment['user_id'])) ?></p>
                <p><?php echo($comment['comment']) ?></p>
              </div>
              <?php endforeach; ?>
            </div>
            <div class="card-comment"></div>

          </div>
        </div>
    <?php endforeach; ?>
    </div>
  </div>
  <script>
    console.log("<?php echo($_SESSION['logged_in_user']) ?>")
  </script>
<?php require_once("includes/footer.php") ?>