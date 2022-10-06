<?php
    require_once("includes/header.php");
    require_once("functions.php");
    	if ($_SESSION['logged_in_user'] == '') {
            header("location: home.php");
            exit;
        }
?>

<div class="content">

</div>

<?php require_once("includes/footer.php") ?>