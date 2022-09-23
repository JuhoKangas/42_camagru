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
      // Resize the image before uploading
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

        $stickers = $_POST['canvas_picture'];
        if ($stickers) {
          list($type, $data_url) = explode(';', $stickers);
          list(, $data_url) = explode(',', $data_url);
          $decoded_url = base64_decode($data_url);
          $src = imagecreatefromstring($decoded_url);
          imagecopy($dst, $src, 0, 0, 25, 30, 700, 500);
        }

        if ($fileType === 'jpg' || $filetype === 'jpeg') {
          imagejpeg($dst, $targetFile);
        } else if ($fileType === 'png') {
          imagepng($dst, $targetFile);
        }
        imagedestroy($dst);
      } else {
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
      }
      uploadPicture($_SESSION['user_id'], $filename);
      }

  }

  function resizeImg($image, $maxDim) {

  }

  unset($_POST['submit']);
?>

<div class="content">

  <form action="upload_file.php" method="post" enctype="multipart/form-data">
    <input name="submit" type="submit" value="Submit">
    <input id="canvas-picture" type="hidden" name="canvas_picture" value="">
    <div class="preview">
      <img id="picture">
      <canvas id="canvas" width="0" height="0"></canvas>
    </div>
    <input accept="image/*" type="file" name="fileToUpload" id="fileToUpload">
  </form>
  <div class="clear">
    <button id="clear-img">Clear Selection</button>
  </div>

	<a href="upload_webcam.php">upload with webcam</a>

  <div class="stickers">
    <img class="sticker" src="../img/stickers/bee_sticker.png" alt="" id="sticker1">
    <img class="sticker" src="../img/stickers/best-mom_sticker.png" alt="" id="sticker2">
    <img class="sticker" src="../img/stickers/corgi_sticker.png" alt="" id="sticker3">
    <img class="sticker" src="../img/stickers/dontworry_sticker.png" alt="" id="sticker4">
    <img class="sticker" src="../img/stickers/yass_sticker.png" alt="" id="sticker5">
  </div>
</div>

<script>
const canvas = document.querySelector("#canvas");
const stop_button = document.querySelector("#clear-img");
const canvas_picture = document.querySelector('#canvas-picture');
const file_input = document.querySelector("#fileToUpload");
const picture = document.querySelector("#picture");

const sticker = document.querySelectorAll(".sticker");

for (let i=0; i<sticker.length; i++) {
	sticker[i].addEventListener('click', e => {
		addSticker(e.target.id);
	})
}

const addSticker = (sticker) => {
	let selectedSticker = document.getElementById(sticker);
	let ctx = canvas.getContext("2d");

	switch (sticker) {
		case "sticker1":
			ctx.drawImage(selectedSticker, 30, 40, selectedSticker.width, selectedSticker.height)
			break;
		case "sticker2":
			ctx.drawImage(selectedSticker, 500, 40, selectedSticker.width, selectedSticker.height)
			break;
		case "sticker3":
			ctx.drawImage(selectedSticker, 30, 500, selectedSticker.width, selectedSticker.height)
			break;
		case "sticker4":
			ctx.drawImage(selectedSticker, 250, 250, selectedSticker.width, selectedSticker.height)
			break;
		case "sticker5":
			ctx.drawImage(selectedSticker, 500, 500, selectedSticker.width, selectedSticker.height)
			break;
	
		default:
			break;
	}
			let image_data_url = canvas.toDataURL();
			canvas_picture.value = image_data_url;
}

file_input.onchange = () => {
	const [file] = file_input.files;
	if (file) {
		picture.src = URL.createObjectURL(file);
		
		// We have to give it some time to think
		setTimeout(() => {
			let maxDim = 1000;
			if (picture.width > maxDim || picture.height > maxDim) {
					let ratio = picture.width/picture.height;
					if( ratio > 1) {
							picture.width = maxDim;
							picture.height = maxDim/ratio;
							canvas.height = maxDim/ratio;
							canvas.width = maxDim;
						} else {
							picture.width = maxDim*ratio;
							picture.height = maxDim;
							canvas.width = maxDim*ratio;
							canvas.height = maxDim;
					}
				}
				// canvas.getContext('2d').drawImage(picture, 0, 0, picture.width, picture.height);
				// let image_data_url = canvas.toDataURL();
				// canvas_picture.value = image_data_url;
		}, 50);
	}
}

stop_button.addEventListener('click', () => {
	canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
	canvas_picture.value = "";
})
</script>

<?php require_once('includes/footer.php'); ?>