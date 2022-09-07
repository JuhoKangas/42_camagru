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

function send_activation_email (string $email, string $unique_token) {
  $activation_link = "http://localhost:8080/src/auth.php?email=$email&unique_token=$unique_token";

  $subject = "Please activate your account";
  $body = "Hey! Please follow this link to verify your email! " . PHP_EOL . $activation_link;

  mail($email, $subject, $body);
}

function createUser(string $username, string $email, string $pwd): void {
  try {
    $conn = connect();

    $unique_token = bin2hex(random_bytes(15));

    $stmt = $conn->prepare("INSERT INTO userinfo (username, email, password, unique_token)
    VALUES (:username, :email, :password, :unique_token)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $pwd);
    $stmt->bindParam(':unique_token', $unique_token);

    $stmt->execute();

    send_activation_email($email, $unique_token);

  } catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
}

function usernameAvailable(string $username): bool {
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

function emailAvailable(string $email): bool {
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

function find_by_username(string $username) {
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT username, password, email, activated FROM userinfo WHERE username=:username");
    $stmt->bindValue(":username", $username);
    $stmt->execute();
  
    return $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo "find_by_username Error: " . $e->getMessage();
  }
  $conn = null;
}

function user_active(string $username) {
  $user = find_by_username($username);
  return (int)$user['activated'] === 1;
}

function login_user(string $username, string $password): bool {
  try {
    $user = find_by_username($username);

    if ($user && password_verify($password, $user['password'])) {
      // Prevent session fixation attack
      session_regenerate_id();

      $_SESSION['logged_in_user'] = $user['username'];
      $_SESSION['user_id'] = $user['id'];

      return true;
    }

    return false;
  } catch (PDOException $e) {
    echo "Login Error: " . $e->getMessage();
  }
}

function activate_user($email, $unique_token) {
  try {
    $conn = connect();
    $stmt = $conn->prepare("UPDATE userinfo SET activated=1 WHERE email=:email AND unique_token=:unique_token");
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':unique_token', $unique_token);
    $stmt->execute();

    return $stmt->rowCount();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

?>