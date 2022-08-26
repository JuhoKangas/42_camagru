<?php
$DB_DSN = 'mysql:host=localhost;dbname=camagru_db';
$DB_USER = 'root';
$DB_PASSWORD = '123123';

function connect(){
  global $DB_DSN, $DB_USER, $DB_PASSWORD;
  try {
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
  return $conn;
}

function auth($username, $password) {
  $res = null;
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM userinfo WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
      $res = $user;
    }
  } catch (PDOException $e) {
    echo "Verify Error: " . $e->getMessage();
  }
  return $res;
}

?>