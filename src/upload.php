<?php
  require_once('includes/header.php');
  require_once('functions.php');

  $imgID = bin2hex(random_bytes(5));
  $uploadDir = "../img/uploads/";
  $fileType = strtolower(pathinfo($_FILES['fileToUpload']['name'],PATHINFO_EXTENSION));
  $filename = "$imgID.$fileType";
  $targetFile = $uploadDir . $filename;
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
      if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile)) {
        echo "picture uploaded";
        uploadPicture($_SESSION['user_id'], $filename);
      }
      else {
        echo "There was a problem uploading the picture";
      }
    }

  }

  unset($_POST['submit']);
?>

<div class="content">

  <div class="web-photo">
    <button id="start-camera">Start Camera</button>
    <video id="video" width="320" height="240" autoplay></video>
    <button id="click-photo">Click Photo</button>

    <form action="upload_webcam.php" method="post" enctype="multipart/form-data">
      <input name="upload-button" type="submit" value="Submit">
      <input id="webcam-picture" type="hidden" name="webcam_picture" value="">
    </form>

    <button id="stop-webcam">Stop webcam</button>
    <canvas id="canvas" width="320" height="240"></canvas>
  </div>
  
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" >
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload picture" name="submit">
  </form>
</div>

<?php require_once('includes/footer.php'); ?>