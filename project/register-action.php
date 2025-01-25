<?php 
require_once __DIR__ . "/connection.php";

$pdo-> prepare('INSERT INTO pembeli (pembeli_username, pembeli_password, pembeli_nama, pembeli_email, pembeli_phone) VALUES (:pembeli_username, :pembeli_password, :pembeli_nama, :pembeli_email, :pembeli_phone);')->execute([
    "pembeli_username"=> $_POST['username'],
    "pembeli_password"=> $_POST['password'],
    "pembeli_nama"=> $_POST["name"],
    "pembeli_email"=> $_POST["email"],
    "pembeli_phone"=> $_POST["phone"]
]);

header("Location: login.php");
exit;
?>
