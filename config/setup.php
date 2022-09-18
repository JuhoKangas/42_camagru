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
    username VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    activated BOOLEAN NOT NULL DEFAULT 0,
    notif_stat BOOLEAN NOT NULL DEFAULT 1,
    unique_token VARCHAR(255) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";
  $conn->exec($sql);
  echo "table created";
} catch(PDOException $e){
  echo $sql . "<br>" . $e->getMessage();
}

try {
  $sql = "CREATE TABLE IF NOT EXISTS user_images (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uploader_id INT(11) NOT NULL,
    img_path VARCHAR(255) NOT NULL,
    upload_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  )";
  $conn->exec($sql);
  echo "user_images created";
} catch (PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?> 