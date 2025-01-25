<?php
$host = "localhost";
$port = "3306";
$dbname = "warungku";
$username = "root";
$password = "";

try {
  $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
