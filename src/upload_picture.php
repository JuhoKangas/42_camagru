<?php
	require_once("includes/header.php");
	require_once("functions.php");

	if (isset($_POST['submit'])) {
		$data_url = $_POST['canvas_picture'];
		$target_dir = "../img/uploads/";
		$img_id = uniqid("img_");
		$filename = $img_id . '.png';
		$target_file = $target_dir . $filename;
	
		if ($data_url) {
			list($type, $data) = explode(';', $data_url);
			list(, $data) = explode(',', $data);
		
			$data = base64_decode($data);
			file_put_contents($target_file, $data);
			uploadPicture($_SESSION['user_id'], $filename);
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		} else {
			echo "empty pic";
		}
	}
?>

<div class="content">
	<?php echo $data_url ?>
</div>

<?php require_once("includes/footer.php"); ?>