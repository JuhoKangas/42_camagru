<?php
    require_once("includes/header.php");
    require_once("functions.php");
    
    if ($_SESSION['logged_in_user'] == '') {
        header("location: home.php");
        exit;
    }

    $results_per_page = 5;

    $number_of_results = count(fetch_all_user_images($_SESSION['logged_in_user']));
    $number_of_pages = ceil($number_of_results / $results_per_page);
  
    if (!isset($_GET['page'])) {
      $page = 1;
      $spage = 1;
    } else {
      if ($_GET['page'] < 1 || $_GET['page'] > $number_of_pages) {
        header('location: profile.php');
      } else {
        $page = $_GET['page'];
        $spage = $_GET['page'];
      }
    }
  
    $first_post = ($page - 1) * $results_per_page;
    $images = fetch_user_images($_SESSION['logged_in_user'], $first_post, $results_per_page);
  ?>
    <div class="content">
  
      <div class="cards-container px-3">
  

    <div class="hero-text">
        <h1 class="title">This is your profile page and here you an see all your pictures</h1>
        <p>We call this 'The better feed' as you don't have to watch pictures of lesser people</p>
    </div>
  
      <?php foreach($images as $image): ?>
        <!-- HTML -->
  
        <div class="card pb-3">
          <div class="card-primary">
            <div class="card-header">
              <p class="card-username"><?php echo(get_username_by_id($image['uploader_id'])) ?></p>
              <form action="delete_picture.php" method="post">
                <input type="hidden" name="delete_picture" value="<?php echo $image['id']?> ">
                <button type="submit" class="btn delete-button">Delete Picture</button>
              </form>
              <p class="card-time"><?php echo(date_format(date_create($image['upload_time']), "M jS H:i")) ?></p>
            </div>
            <div class="card-img">
              <img src="<?php echo("../img/uploads/" . $image['img_name']) ?>" alt="">
            </div>
          </div>
            <div class="card-secondary">
              <div class="card-likes">
                <form id="<?php echo($image['id']) ?>" action="like_post.php" method="post">
                  <?php if($_SESSION['logged_in_user'] && user_liked_post($image['id'], $_SESSION['user_id'])): ?>
                      <img data="<?php echo($image['id']) ?>" id="like_post" src="../img/icons/heart_filled.svg" alt="heart">
                      <input class="like_input" type="hidden" name="unlike" value="<?php echo($image['id']) ?>">
                  <?php else: ?>
                      <img data="<?php echo($image['id']) ?>"  id="like_post" src="../img/icons/heart_vector.svg" alt="heart">
                      <input class="like_input" type="hidden" name="like" value="<?php echo($image['id']) ?>">
                  <?php endif; ?>
                </form>
                <p><?php echo(get_post_likes($image['id'])) ?></p>
                <img src="../img/icons/comment-regular.svg" width="25" alt="">
                <p><?php echo(count(get_post_comments($image['id']))) ?></p>
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
                  <p class="image-comment"><?php echo($comment['comment']) ?></p>
                </div>
                <?php endforeach; ?>
              </div>
                <form id="comment_<?php echo $image['id'] ?>" action="add_comment.php" method="post">
                  <div class="card-comment">
                    <input class="comment-input" type="text" name="post_comment" id="post_comment" placeholder="Max 255 characters" maxlength="255" value="">
                    <input type="hidden" name="image_id" value="<?php echo($image['id']) ?>">
                    <img data="<?php echo $image['id'] ?>" class="comment-icon" src="../img/icons/comment_icon.svg" alt="comment post">
                  </div>
                </form>
  
            </div>
          </div>
      <?php endforeach; ?>
      </div>
      <div class="pagination mt-5">
        <?php for ($page = 1; $page <= $number_of_pages; $page++): ?>
            <?php if ($page == $spage): ?>
              <a class="page-active" href="profile.php?page=<?php echo $page ?>"> <?php echo $page ?> </a>
            <?php else: ?>
              <a href="profile.php?page=<?php echo $page ?>"> <?php echo $page ?> </a>
            <?php endif; ?>
        <?php endfor; ?>
      </div>
    </div>
  
    <script>
     const like_post = document.querySelectorAll("#like_post");
     const comment = document.querySelectorAll(".comment-icon");
     const page_active = document.querySelector(".page-active");
     let user = "<?php echo $_SESSION['logged_in_user'] ?>"
  
     if (user){
       for (let i = 0 ; i < like_post.length; i++) {
        like_post[i].style.cursor = "pointer";
        like_post[i].addEventListener("click", (e) => {
           document.getElementById(e.target.attributes.data.value).submit();
         })
       }
     }
  
     for (let j = 0; j < comment.length; j++) {
      comment[j].addEventListener("click", e => {
        document.getElementById("comment_" + e.target.attributes.data.value).submit();
      })
     }
  
    </script>
  <?php require_once("includes/footer.php") ?>