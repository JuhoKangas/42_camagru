<?php
	require_once("includes/header.php");
	require_once("functions.php");

	if (isset($_POST['canvas_picture'])) {
		$data_url = $_POST['canvas_picture'];
		$target_dir = "../img/uploads/";
		$img_id = uniqid("img_");
		$filename = $img_id . '.png';
		$target_file = $target_dir . $filename;
		$sticker1_path = $_POST['sticker1'];
		$sticker2_path = $_POST['sticker2'];
	
		if ($data_url) {
			
			list($type, $data) = explode(';', $data_url);
			list(, $data) = explode(',', $data);
		
			$data = base64_decode($data);
			file_put_contents($target_file, $data);
			uploadPicture($_SESSION['user_id'], $filename, "placeholder");

			$sticker = imagecreatefrompng($sticker1_path);
			$picture = imagecreatefrompng($target_file);

			$marge_r = 20;
			$marge_b = 20;
			$sx = imagesx($sticker);
			$sy = imagesy($sticker);

			imagecopy($picture, $sticker, imagesx($picture) - $sx - $marge_r, imagesy($picture) - $sy - $marge_b, 0, 0, imagesx($sticker), imagesy($sticker));
			
			if (!empty($sticker2_path)) {
				$sticker = imagecreatefrompng($sticker2_path);

				$marge_r = 350;
				$marge_b = 250;
				$sx = imagesx($sticker);
				$sy = imagesy($sticker);

				imagecopy($picture, $sticker, imagesx($picture) - $sx - $marge_r, imagesy($picture) - $sy - $marge_b, 0, 0, imagesx($sticker), imagesy($sticker));
			}
			
			imagepng($picture, $target_file);
			imagedestroy($picture);
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		} else {
			echo "empty pic";
		}
	}
?>

<div class="content">

</div>

<?php require_once("includes/footer.php"); ?>