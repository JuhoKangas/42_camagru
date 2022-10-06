<?php
require_once("includes/header.php");
require_once("functions.php");

$password_changed = false;
$errMsg = '';

if (!empty($_SESSION['logged_in_user'])) {
    header('location: logout.php');
}

if (isset($_GET['unique_token'])) {
    if (is_valid_token($_GET['unique_token'])) {
        $user = is_valid_token($_GET['unique_token']);
        $_SESSION['temp_token'] = $_GET['unique_token'];
    } else {
        $errMsg = 'Not a valid token';
    }
}

if (!empty($_SESSION['temp_token'])) {

    if (empty($user) && isset($_POST['new_password']) && isset($_POST['password_again'])) {
        if ($_POST['new_password'] != $_POST['password_again']) {
            $errMsg = "Passwords don't match";
        }
        
        if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{16,50}$/', $_POST['new_password'])) {
            $errMsg = 'New password does not meet the requirements!';
        }
    }

    if ($errMsg == '' && !empty($_POST['new_password']) && !empty($_POST['password_again'])) {
        $new_token = bin2hex(random_bytes(15));
        $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
        try {
            $conn = connect();
            $stmt = $conn->prepare("UPDATE userinfo SET `password` = :password WHERE unique_token = :token");
            $stmt->bindParam(':password', $new_password);
            $stmt->bindParam(':token', $_SESSION['temp_token']);
            $stmt->execute();

            // Refresh the unique token
            $stmt = $conn->prepare("UPDATE userinfo SET unique_token = :new_token WHERE unique_token = :old_token");
            $stmt->bindParam(':new_token', $new_token);
            $stmt->bindParam(':old_token', $_SESSION['temp_token']);
            $stmt->execute();
        } catch (PDOException $e) {
        echo $e->getMessage();
        }
        unset($_SESSION['temp_token']);
        header('location: login.php');
    }
}
?>

<div class="content align-center">
    <?php if (isset($user) || !empty($_SESSION['temp_token'])): ?>
        <h2>Set new password</h2>
        <form action="change_password.php" method="post">
            <div class="control d-flex d-column my-4">
                <input class="mb-3" type="password" name="new_password" id="" placeholder="New Password">
                <input type="password" name="password_again" id="" placeholder="Password Again">
                <button class="btn btn-main btn-big mt-5" type="submit">Change Password</button>
            </div>
        </form>
        <?php if($errMsg): ?>
          <small class="sub-text text-center text-warning mt-4 px-4"><?php echo $errMsg ?></small>
        <?php endif; ?>
    <?php else: ?>
        <h1>Nothing to see here</h1>
    <?php endif; ?>
</div>

<?php require_once("includes/footer.php"); ?>