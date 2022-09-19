<?php
	require_once("includes/header.php");
	require_once("functions.php");

	$data_url = $_POST['webcam_picture'];

	if ($data_url) {
		list($type, $data) = explode(';', $data_url);
		list(, $data) = explode(',', $data);
	
		$data = base64_decode($data);
		file_put_contents('../img/uploads/test.png', $data);
	} else {
		echo "empty pic";
	}
?>

<div class="content">
	<?php echo $data_url ?>
</div>

<?php require_once("includes/footer.php"); ?>