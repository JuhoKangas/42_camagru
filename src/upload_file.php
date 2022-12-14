<?php
  require_once('includes/header.php');
  require_once('functions.php');

  if (empty($_SESSION['logged_in_user'])) {
    header("location: home.php");
    exit;
  }

  $imgID = uniqid("img_");
  $uploadDir = "../img/uploads/";
  $uploadOk = 1;
  $errMsg = "";
  if (isset($_FILES['fileToUpload'])) {
    $fileType = strtolower(pathinfo($_FILES['fileToUpload']['full_path'], PATHINFO_EXTENSION));
    $filename = "$imgID.$fileType";
    $targetFile = $uploadDir . $filename;
  }

  if(isset($_POST['submit']) && !empty($_FILES["fileToUpload"]["tmp_name"])) {
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

    if (empty($_POST['description'])) {
      $uploadOk = 0;
      $errMsg = "Description is mandatory";
    } 

    if (!empty($_POST['description'])) {
      if (strlen($_POST['description']) < 255) {
        $description = htmlspecialchars($_POST['description']);
      } else {
        $uploadOk = 0;
        $errMsg = "Image description is too long";
      }
    }
  
    if($uploadOk === 0) {
      echo $errMsg;
    } else {
      // Resize the image before uploading
      $maxDim = 1000;
      $file_name = $_FILES['fileToUpload']['tmp_name'];
      list($width, $height, $type, $attr) = getimagesize($file_name);

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

      if (isset($_POST['canvas_picture'])) {
        $stickers = $_POST['canvas_picture'];
      } else {
        $stickers = '';
      }
      if ($stickers) {
        list($type, $data_url) = explode(';', $stickers);
        list(, $data_url) = explode(',', $data_url);
        $decoded_url = base64_decode($data_url);
        $src = imagecreatefromstring($decoded_url);
        imagecopy($dst, $src, 0, 0, 0, 0, $new_width, $new_height);
      }

      if ($fileType === 'jpg' || $fileType === 'jpeg') {
        imagejpeg($dst, $targetFile);
      } else if ($fileType === 'png') {
        imagepng($dst, $targetFile);
      }
      imagedestroy($dst);
      
      uploadPicture($_SESSION['user_id'], $filename, $description, 0);
      header("location: home.php");
    }

  }

  unset($_POST['submit']);
?>

<div class="content">

  <div class="webcam-container">
  
    <p>Select a sticker (choose wisely as you can't unselect a sticker)</p>

    <div class="stickers">
      <img class="sticker" src="../img/stickers/bee_sticker.png" alt="" id="sticker1">
      <img class="sticker" src="../img/stickers/best-mom_sticker.png" alt="" id="sticker2">
      <img class="sticker" src="../img/stickers/corgi_sticker.png" alt="" id="sticker3">
      <img class="sticker" src="../img/stickers/dontworry_sticker.png" alt="" id="sticker4">
      <img class="sticker" src="../img/stickers/yass_sticker.png" alt="" id="sticker5">
    </div>

    <form class="d-flex d-column align-center" action="upload_file.php" method="post" enctype="multipart/form-data">
      <input id="canvas-picture" type="hidden" name="canvas_picture" value="">
      <div class="preview">
        <img class="d-none" id="picture">
        <img id="picture-preview">
        <canvas class="d-none" id="canvas" width="0" height="0"></canvas>
      </div>
      <input class="mt-4" accept="image/*" type="file" name="fileToUpload" id="fileToUpload" required >
      <input type="text" name="description" id="picture-description" placeholder="Max. 255 characters" maxlength="255" required>
      <br>
      <input class="btn btn-main my-4" name="submit" type="submit" value="Submit">
      <button class="btn mt-4 d-none" id="clear-img">Clear Selection</button>
    </form>
    <a style="width: fit-content;" href="upload_webcam.php">Upload with webcam!</a>
  </div>


</div>

<script>
const canvas = document.querySelector("#canvas");
const stop_button = document.querySelector("#clear-img");
const canvas_picture = document.querySelector('#canvas-picture');
const file_input = document.querySelector("#fileToUpload");
const picture = document.querySelector("#picture");
const picture_preview = document.querySelector("#picture-preview");

const sticker = document.querySelectorAll(".sticker");

for (let i=0; i<sticker.length; i++) {
	sticker[i].addEventListener('click', e => {
    if (picture.src != "") {
      addSticker(e.target.id);
      e.target.classList.add("active");
    }
	})
}

const addSticker = (sticker) => {
	let selectedSticker = document.getElementById(sticker);
	let ctx = canvas.getContext("2d");

	switch (sticker) {
		case "sticker1":
			ctx.drawImage(selectedSticker, (canvas.width / 4) * 1, (canvas.height / 4) * 3, selectedSticker.width, selectedSticker.height)
			break;
		case "sticker2":
			ctx.drawImage(selectedSticker, (canvas.width / 4) * 2, (canvas.height / 4) * 2, selectedSticker.width, selectedSticker.height)
			break;
		case "sticker3":
			ctx.drawImage(selectedSticker, (canvas.width / 4) * 3, (canvas.height / 4) * 1, selectedSticker.width, selectedSticker.height)
			break;
		case "sticker4":
			ctx.drawImage(selectedSticker, (canvas.width / 4) * 3, (canvas.height / 4) * 3, selectedSticker.width, selectedSticker.height)
			break;
		case "sticker5":
			ctx.drawImage(selectedSticker, (canvas.width / 4) * 1, (canvas.height / 4) * 1, selectedSticker.width, selectedSticker.height)
			break;
	
		default:
			break;
	}
			let image_data_url = canvas.toDataURL();
			canvas_picture.value = image_data_url;
}

file_input.onchange = () => {
  stop_button.classList.remove("d-none");
	const [file] = file_input.files;
	if (file) {
		picture.src = URL.createObjectURL(file);
		picture_preview.src = URL.createObjectURL(file);
		
		// We have to give it some time to think
		setTimeout(() => {
			let maxDim = 1000;
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
		}, 50);
	}
}

stop_button.addEventListener('click', () => {
	location.reload();
})
</script>

<?php require_once('includes/footer.php'); ?>