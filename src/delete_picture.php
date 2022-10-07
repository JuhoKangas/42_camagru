<?php
    session_start();
    require_once("functions.php");

    if (isset($_POST['delete_picture'])) {
        $img_id = $_POST['delete_picture'];

        try {
            $conn = connect();
            $stmt = $conn->prepare("DELETE FROM user_images WHERE id = :img_id");
            $stmt->bindParam(':img_id', $img_id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    if (isset($_SERVER['HTTP_REFERER']))
        header("location: " . $_SERVER['HTTP_REFERER']);
    else
        header('location: home.php');
?>