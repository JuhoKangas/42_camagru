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

function createUser($username, $email, $pwd) {
  try {
    $conn = connect();

    $unique_token = hash("md5", $username);

    $stmt = $conn->prepare("INSERT INTO userinfo (username, email, password, unique_token)
    VALUES (:username, :email, :password, :unique_token)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $pwd);
    $stmt->bindParam(':unique_token', $unique_token);

    $stmt->execute();

    echo "user created";
  } catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
}

function usernameAvailable($username) {
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT username FROM userinfo WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
      return FALSE;
    } else {
      return TRUE;
    }
  } catch (PDOException $e) {
    echo "usernameAvailable Error: " . $e->getMessage();
  }
  $conn = null;
}

function emailAvailable($email) {
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT email FROM userinfo WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
      return FALSE;
    } else {
      return TRUE;
    }
  } catch (PDOException $e) {
    echo "emailAvailable Error: " . $e->getMessage();
  }
  $conn = null;
}

?>