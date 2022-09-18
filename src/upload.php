<?php
  require_once('includes/header.php');
  require_once('functions.php');

  $imgID = bin2hex(random_bytes(4));
  $uploadDir = "../img/uploads/";
  $fileType = strtolower(pathinfo($_FILES['fileToUpload']['name'],PATHINFO_EXTENSION));
  $targetFile = $uploadDir . $imgID . ".$fileType";
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
        uploadPicture($_SESSION['user_id'], $targetFile);
      }
      else {
        echo "There was a problem uploading the picture";
      }
    }

  }

  unset($_POST['submit']);
?>

<div class="content">

  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" >
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload picture" name="submit">
  </form>

</div>

<?php require_once('includes/footer.php'); ?>