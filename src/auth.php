<?php
  require_once("connection.php");

  function auth($username, $password) {
    $res = null;
    try {
      $conn = connect();
      $stmt = $conn->prepare("SELECT * FROM userinfo WHERE username = ?");
      $stmt->execute([$username]);
      $user = $stmt->fetch();

      if ($user && password_verify($password, $user['password'])) {
        echo "right password";
        $res = $user;
      } else {
        echo "Wrong password";
      }
    } catch (PDOException $e) {
      echo "Verify Error: " . $e->getMessage();
    }
    return $res;
  }
?>