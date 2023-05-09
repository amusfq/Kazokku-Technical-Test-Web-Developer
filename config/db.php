<?php
$DB_HOST = "localhost"; // 
$DB_NAME = "php";
$DB_USER = "root";
$DB_PASS = "";

try {
    $connection = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}
?>