<?php 
  require_once __DIR__ . "/connection.php";

  $pdo->prepare('UPDATE pembeli SET pembeli_password = :pembeli_password WHERE pembeli_email = :pembeli_email AND pembeli_phone = :pembeli_phone;')->execute([
    "pembeli_password" => $_POST["new_password"],
    "pembeli_email" => $_POST["email"],
    "pembeli_phone" => $_POST["phone"]
  ]);

  header("Location: login.php");
  exit;
?>
