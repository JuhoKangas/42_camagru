<?php
  include('database.php');

  // Create Database camagru_db
try {
  $conn = new PDO($DB_HOST, $DB_USER, $DB_PASSWORD);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "CREATE DATABASE IF NOT EXISTS camagru_db";
  // use exec() because no results are returned
  $conn->exec($sql);
  echo "Database created successfully<br>";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;

// Create userinfo table
try {
  $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "CREATE TABLE IF NOT EXISTS userinfo(
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(500) NOT NULL,
    email VARCHAR(255) NOT NULL,
    `password` VARCHAR(60) NOT NULL,
    activated BOOLEAN NOT NULL DEFAULT 0,
    notif_stat BOOLEAN NOT NULL DEFAULT 1,
    unique_token VARCHAR(255) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";
  $conn->exec($sql);
  echo "table created";
} catch(PDOException $e){
  echo $sql . "</br>" . $e->getMessage();
}

// Create user_images table
try {
  $sql = "CREATE TABLE IF NOT EXISTS user_images (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uploader_id INT(11) NOT NULL,
    img_name VARCHAR(255) NOT NULL,
    img_desc VARCHAR(2000) NOT NULL,
    webcam BOOLEAN NOT NULL,
    upload_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  )";
  $conn->exec($sql);
  echo "user_images created </br>";
} catch (PDOException $e) {
  echo $sql . "</br>" . $e->getMessage();
}

// Create user_likes table
try {
  $sql = "CREATE TABLE IF NOT EXISTS user_likes (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    image_id INT(11) NOT NULL,
    `user_id` INT(11) NOT NULL
  )";
  $conn->exec($sql);
  echo "user_likes created </br>";
} catch (PDOException $e) {
  echo $sql . "</br>" . $e->getMessage();
}

// Create user_comments table
try {
  $sql = "CREATE TABLE IF NOT EXISTS user_comments (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    comment VARCHAR(2000) NOT NULL,
    image_id INT(11) NOT NULL,
    `user_id` INT (11) NOT NULL
  )";
  $conn->exec($sql);
  echo "user_comments created </br>";
} catch (PDOException $e) {
  echo $sql . "</br>" . $e->getMessage();
}

$conn = null;
?> 