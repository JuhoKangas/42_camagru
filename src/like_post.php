<?php
	session_start();
	require_once("functions.php");

	if (isset($_POST['like'])) {
		like_post($_POST['like'], $_SESSION['user_id']);
	} else if (isset($_POST['unlike'])) {
		unlike_post($_POST['unlike'], $_SESSION['user_id']);
	}

	header("location: home.php");
?>