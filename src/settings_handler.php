<?php
	session_start();
	require_once("functions.php");

	if ($_SESSION['logged_in_user'] == '') {
		header("location: home.php");
		exit;
	}

	$message = '';

	if (isset($_POST['email_notif'])) {
		$notif = $_POST['email_notif'] == 'yes' ? 1 : 0;
		try {
			$conn = connect();
			$stmt = $conn->prepare("UPDATE userinfo SET notif_stat = :notif WHERE id = :id");
			$stmt->bindParam(':notif', $notif);
			$stmt->bindParam(':id', $_SESSION['user_id']);
			$stmt->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		$conn = null;
		$message = "Your email notification status was updated";
	}
	
	if (isset($_POST['new_email']) && !empty($_POST['new_email'])) {
		if (strlen($_POST['new_email']) > 255) {
			$message = "email is too long, maxlength is 255";
		} else {
			$email = htmlspecialchars($_POST['new_email']);
			try {
				$conn = connect();
				$stmt = $conn->prepare("UPDATE userinfo SET email = :email WHERE id = :id");
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':id', $_SESSION['user_id']);
				$stmt->execute();
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
			$conn = null;
			$message = "Your email was updated to " . htmlspecialchars_decode($email) . "!";
		}
	}
	
	if (isset($_POST['new_username']) && !empty($_POST['new_username'])) {
		if (strlen($_POST['new_username']) > 50) {
			$message = "Your username is too long, maximum length is 50 characters";
		} else {
			$username = htmlspecialchars($_POST['new_username']);
			try {
				$conn = connect();
				$stmt = $conn->prepare("UPDATE userinfo SET username = :username WHERE id = :id");
				$stmt->bindParam(':username', $username);
				$stmt->bindParam(':id', $_SESSION['user_id']);
				$stmt->execute();
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
			$_SESSION['logged_in_user'] = $username;
			$conn = null;
			$message = "Your username was updated to " . htmlspecialchars_decode($username) . "!";
		}
	}

	if (isset($_POST['new_password'])) {
		if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{16,50}$/', $_POST['new_password'])) {
      $message = 'New password does not meet the requirements!';
    } else {
			$user = find_by_username($_SESSION['logged_in_user']);
			if (password_verify($_POST['old_password'], $user['password'])){
				$new_pwd = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
				try {
					$conn = connect();
					$stmt = $conn->prepare("UPDATE userinfo SET `password` = :password WHERE id = :id");
					$stmt->bindParam(':password', $new_pwd);
					$stmt->bindParam(':id', $_SESSION['user_id']);
					$stmt->execute();
				} catch (PDOException $e) {
					echo $e->getMessage();
				}
				$message = "Your password was updated!";
			} else {
				$message = "Your old password was not correct!";
			}
		}
	}
	header("location: settings.php?msg=" . $message);
?>

