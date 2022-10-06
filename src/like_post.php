<?php
	session_start();
	require_once("functions.php");

	if (isset($_POST['like'])) {
		$image_id = $_POST['like'];
		like_post($image_id, $_SESSION['user_id']);
		notify_user($image_id, 2);
	} else if (isset($_POST['unlike'])) {
		unlike_post($_POST['unlike'], $_SESSION['user_id']);
	}

	if (isset($_SERVER['HTTP_REFERER'])) {
		header("location: " . $_SERVER['HTTP_REFERER']);
	} else {
		header("location: home.php");
	}
?>