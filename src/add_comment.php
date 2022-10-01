<?php

	session_start();
	require_once("functions.php");

	if (!empty($_POST['post_comment'])) {
		$comment = $_POST['post_comment'];
		$user_id = $_SESSION['user_id'];
		$image_id = $_POST['image_id'];
		post_comment($comment, $user_id, $image_id);
	}
	header("location: home.php");

?>