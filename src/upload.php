<?php
  require_once('includes/header.php');
  require_once('functions.php');

  $imgID = uniqid("img_");
  $uploadDir = "../img/uploads/";
  if ($_FILES) {
    $fileType = strtolower(pathinfo($_FILES['fileToUpload']['name'],PATHINFO_EXTENSION));
    $filename = "$imgID.$fileType";
    $targetFile = $uploadDir . $filename;
  }
  $uploadOk = 1;
  $errMsg = "";

  if(isset($_POST['submit'])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
      $uploadOk = 1;
    } else {
      $errMsg = "File is not an image.";
      $uploadOk = 0;
    }
    
    if($fileType != 'jpg' && $fileType != 'png' && $fileType != 'jpeg') {
      $errMsg = "Wrong filetype, only jpg/jpeg/png allowed";
      $uploadOk = 0;
    }
  
    if($uploadOk === 0) {
      echo $errMsg;
    } else {
      // Resize the image before uploading, Do i need this?
      $maxDim = 800;
      $file_name = $_FILES['fileToUpload']['tmp_name'];
      list($width, $height, $type, $attr) = getimagesize($file_name);
      if ($width > $maxDim || $height > $maxDim) {
          $ratio = $width/$height;
          if( $ratio > 1) {
              $new_width = $maxDim;
              $new_height = $maxDim/$ratio;
          } else {
              $new_width = $maxDim*$ratio;
              $new_height = $maxDim;
          }
        $src = imagecreatefromstring(file_get_contents($file_name));
        $dst = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        imagedestroy($src);
        if ($fileType === 'jpg' || $filetype === 'jpeg') {
          imagejpeg($dst, $targetFile); // adjust format as needed
        } else if ($fileType === 'png') {
          imagepng($dst, $targetFile);
        }
        imagedestroy( $dst );
      }
      uploadPicture($_SESSION['user_id'], $filename);
      }

  }

  unset($_POST['submit']);
?>

<div class="content">

  <div class="web-photo">
    <button id="start-camera">Start Camera</button>
    <video id="video" width="500" height="375" autoplay></video>
    <button id="click-photo">Click Photo</button>
    
    <form action="upload_webcam.php" method="post" enctype="multipart/form-data">
      <input name="upload-button" type="submit" value="Submit">
      <input id="webcam-picture" type="hidden" name="webcam_picture" value="">
    </form>
    
    <button id="stop-webcam">Stop webcam</button>
    <img id="picture">
    <canvas id="canvas" width="500" height="375"></canvas>
  </div>
  
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" >
    <input accept="image/*" type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload picture" name="submit">
  </form>

  <div class="stickers">
    <img class="sticker" src="../img/stickers/bee_sticker.png" alt="" id="sticker1">
    <img class="sticker" src="../img/stickers/best-mom_sticker.png" alt="" id="sticker2">
    <img class="sticker" src="../img/stickers/corgi_sticker.png" alt="" id="sticker3">
    <img class="sticker" src="../img/stickers/dontworry_sticker.png" alt="" id="sticker4">
    <img class="sticker" src="../img/stickers/yass_sticker.png" alt="" id="sticker5">
  </div>
</div>

<?php require_once('includes/footer.php'); ?>