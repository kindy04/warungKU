<?php 
require_once __DIR__ . "/connection.php";

  $pdo->prepare('INSERT INTO contact (nama, email,contact_message) VALUES (:nama, :email, :contact_message);')->execute([
    "nama" => $_POST['name'],
    "email" => $_POST['email'],
    "contact_message" => $_POST["message"]
  ]);

  header("Location: contact.php");

?>
