<?php

if (!isset($_SESSION)){
  session_start();
}

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
  $activation_link = "http://localhost:8080/camagru/src/auth.php?email=$email&unique_token=$unique_token";

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
    $stmt = $conn->prepare("SELECT * FROM userinfo WHERE username=:username");
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

      //prevent session fixation attack
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
  $conn = null;
}

function uploadPicture(int $user_id, string $img_path, string $img_desc = "I forgot a description", int $webcam = 1) {
  try {
    $conn = connect();
    $stmt = $conn->prepare("INSERT INTO user_images (uploader_id, img_name, img_desc, webcam) VALUES (:uploader_id, :img_name, :img_desc, :webcam)");
    $stmt->bindParam(':uploader_id', $user_id);
    $stmt->bindParam(':img_name', $img_path);
    $stmt->bindParam(':img_desc', $img_desc);
    $stmt->bindParam(':webcam', $webcam);

    $stmt->execute();
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
}

function fetch_all_images() {
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM user_images ORDER BY id DESC");
    $stmt->execute();
    $images = $stmt->fetchAll();

    return $images;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function fetch_images(int $first, int $amount) {
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM user_images ORDER BY id DESC LIMIT $first, $amount");

    $stmt->execute();

    return $stmt->fetchAll();
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function get_username_by_id($id){
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT username FROM userinfo WHERE `id` = :userid");
    $stmt->bindParam(':userid', $id);
    $stmt->execute();

    $user = $stmt->fetch();
    return $user['username'];
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
}

function get_post_comments(int $id) {
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT comment, user_id FROM user_comments WHERE image_id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    return $stmt->fetchAll();
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
}

function get_post_likes(int $id) {
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM user_likes WHERE image_id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->rowCount();
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
}

function user_liked_post(int $id, int $user_id): bool {
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM user_likes WHERE image_id = :id AND user_id = :user_id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    return $stmt->rowCount() != 0 ? true : false;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
}

function unlike_post($post_id, $user_id) {
  try{
    $conn = connect();
    $stmt = $conn->prepare("DELETE FROM user_likes WHERE image_id = :id AND user_id = :user_id");
    $stmt->bindParam(':id', $post_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
}

function like_post($image_id, $user_id) {
  try {
    $conn = connect();
    $stmt = $conn->prepare("INSERT INTO user_likes (image_id, user_id) VALUES (:image_id, :user_id)");
    $stmt->bindParam(':image_id', $image_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
}

function post_comment($comment, $user_id, $image_id) {
  try {
    $conn = connect();
    $stmt = $conn->prepare("INSERT INTO user_comments (comment, image_id, user_id) VALUES (:comment, :image_id, :user_id)");
    $stmt->bindParam(':comment', $comment);
    $stmt->bindParam(':image_id', $image_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
}

function fetch_user_webcam_images($user_id) {
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT img_name FROM user_images WHERE uploader_id = :id AND webcam = 1 ORDER BY id DESC");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();

    return $stmt->fetchAll();
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
}

function can_send_notifications($user_id) {
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT notif_stat FROM userinfo WHERE id = :id");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $status = $stmt->fetch();

    return $status['notif_stat'];
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
}

// Notif_type 1 is commenting picture, 2 is for likes
function notify_user($image_id, $notif_type, $message = '') {
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT uploader_id FROM user_images WHERE id = :id");
    $stmt->bindParam(':id', $image_id);
    $stmt->execute();
    $user_id = $stmt->fetch();
    $user_id = $user_id['uploader_id'];

    // Find email
    $stmt = $conn->prepare("SELECT email FROM userinfo WHERE id = :id");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $email = $stmt->fetch();
    $email = $email['email'];
    $username = get_username_by_id($user_id);
    
    if (can_send_notifications($user_id)) {
      if ($notif_type == 1) {
        $headers = 'From: no-reply@camagru.com';
        $subject = "Someone commented on your picture!";
        $commenter = $_SESSION['logged_in_user'];
        $body = "Hey $username! $commenter said \"$message\" on your picture, go check it out here http://localhost:8080/camagru/src/home.php";
  
        mail($email, $subject, $body, $headers);
      } else if ($notif_type == 2) {
        $headers = 'From: no-reply@camagru.com';
        $subject = "Someone liked your picture!";
        $liker = $_SESSION['logged_in_user'];
        $body = "Hey $username! $liker liked your picture, go check it out here http://localhost:8080/camagru/src/home.php";
  
        mail($email, $subject, $body, $headers);
      }
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
}

function is_valid_token($token) {
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT unique_token, username, id FROM userinfo WHERE unique_token = :token");
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    if ($user = $stmt->fetch()) {
      return $user;
    } else {
      return false;
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
}

function get_user_by_email($email) {
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM userinfo WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    return $stmt->fetch();
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
}

function send_password_reset($email) {
  $user = get_user_by_email($email);
  
  $headers = 'From: no-reply@camagru.com';
  $subject = "Your password reset link!";
  $username = $user['username'];
  $token = $user['unique_token'];
  $body = "Hey $username! You can change your password here: http://localhost:8080/camagru/src/change_password.php?unique_token=$token";
  
  mail($email, $subject, $body, $headers);
}

function fetch_all_user_images($username) {
  $user = find_by_username($username);
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM user_images WHERE uploader_id = :user_id");
    $stmt->bindParam(":user_id", $user['id']);
    $stmt->execute();

    return $stmt->fetchAll();
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
}

function fetch_user_images($username, $first, $amount) {
  $user = find_by_username($username);
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM user_images WHERE uploader_id = :user_id ORDER BY id DESC LIMIT $first, $amount");
    $stmt->bindParam('user_id', $user['id']);
    $stmt->execute();

    return $stmt->fetchAll();
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
}

function get_img_path_by_id($id) {
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT img_name FROM user_images WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $path = $stmt->fetch();
    return $path['img_name'];
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
}

function img_by_user($img_id, $user_id) {
  try {
    $conn = connect();
    $stmt = $conn->prepare("SELECT uploader_id FROM user_images WHERE id = :id AND uploader_id = :user_id");
    $stmt->bindParam(':id', $img_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    if ($stmt->fetch()) {
      return true;
    }
    return false;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
}

?>