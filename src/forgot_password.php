<?php
require_once("includes/header.php");
require_once("functions.php");

$email_sent = false;

if (isset($_POST['email'])) {
    send_password_reset($_POST['email']);
    $email_sent = true;
}

?>

<div class="content align-center">
    <?php if ($email_sent): ?>
        <h1 class="title">Go check your email!</h1>
    <?php else: ?>
        <h2>Please give your email and we'll send you a unique code to change the password</h2>
        <form class="forgot-password" action="forgot_password.php" method="post">
            <div class="control d-flex d-column my-4">
                <input class="mb-3" type="email" name="email" id="" placeholder="Your email">
                <button class="btn btn-main btn-big mt-5" type="submit">Send email</button>
            </div>
        </form>
    <?php endif; ?>
    </div>

<?php require_once("includes/footer.php"); ?>