<?php
	require_once("includes/header.php");
	require_once("functions.php");

	if (isset($_GET['msg'])) {
		$msg = htmlspecialchars($_GET['msg']);
	}
?>

<div class="content">
	<?php if (!empty($msg)): ?>
		<p class="sub-text text-center mt-4 px-4"><?php echo $msg ?></p>
	<?php endif; ?>
	<h1 class="title text-center py-4">Change settings</h1>
	<div class="settings d-flex d-column align-center">
		
	<h2>Receive email notifications</h2>
		<form class="d-flex d-column my-3" action="settings_handler.php" method="post">
			<div class="p-2">
				<input type="radio" name="email_notif" id="notif_yes" value="yes" checked>
				<label for="notif_yes">please send me notifications</label>
			</div>
			<div class="p-2">
				<input type="radio" name="email_notif" id="notif_no" value="no">
				<label for="notif_no">please no more notifications</label>
			</div>
			<input class="btn btn-main mt-2" type="submit" value="submit">
		</form>
		
		<h2 class="mt-5 mb-3">Change Email</h2>
		<form action="settings_handler.php" method="post">
			<div class="control mt-2">
				<input class="mb-3" type="email" name="new_email" placeholder="New Email" maxlength="255" required>
				<button class="btn btn-main" type="submit">Submit</button>
			</div>
		</form>
		
		<h2 class="mt-5 mb-3">Change Username</h2>
		<form action="settings_handler.php" method="post">
			<div class="control mt-2">
				<input class="mb-3" type="text" name="new_username" placeholder="New Username" maxlength="50" required>
				<button class="btn btn-main" type="submit">Submit</button>
			</div>
		</form>
		
		<h2 class="mt-5 mb-3">Change Password</h2>
		<form action="settings_handler.php" method="post">
			<div class="control mt-2">
				<input class="mb-3" type="password" name="old_password" placeholder="Old password" maxlength="50" required>
				<input class="mb-3" type="password" name="new_password" placeholder="New password" maxlength="50" required>
				<button class="btn btn-main" type="submit">Submit</button>
			</div>
		</form>
	</div>
</div>

<?php require_once("includes/footer.php"); ?>