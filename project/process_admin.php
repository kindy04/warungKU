<?php
require_once __DIR__ . "/connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST['add_menu'])) {
    if (isset($_FILES['menu_image']) && $_FILES['menu_image']['error'] === 0) {
      $uploadDir = 'asset/img/';
      $fileName = basename($_FILES['menu_image']['name']);
      $targetFilePath = $uploadDir . $fileName;
      if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
      }

      if (move_uploaded_file($_FILES['menu_image']['tmp_name'], $targetFilePath)) {
        $uploadedImage = $targetFilePath;
        $pdo->prepare('INSERT INTO menu (menu_name, menu_price, menu_status, menu_gambar) VALUES (:menu_name, :menu_price, :menu_status, :menu_gambar)')->execute([
          "menu_name" => $_POST["menu_name"],
          "menu_price" => $_POST["menu_price"],
          "menu_status" => $_POST["menu_status"],
          "menu_gambar" => $uploadedImage
        ]);

        header("Location: admin.php");
        exit;
      } else {
        echo "Gagal mengunggah gambar.";
        header("Location: admin.php");
      }
    } else {
      echo "Tidak ada file yang diunggah atau terjadi kesalahan.";
    }
  }

  if (isset($_POST["edit_menu"])) {
    $pdo->prepare("UPDATE menu SET menu_name = :menu_name, menu_price = :menu_price, menu_status = :menu_status where menu_id = :menu_id")->execute([
      "menu_name" => $_POST["edit_menu_name"],
      "menu_price" => $_POST["edit_menu_price"],
      "menu_status" => $_POST["edit_menu_status"],
      "menu_id" => $_POST["edit_menu_id"]
    ]);
    header("Location: admin.php");
  }

  if (isset($_POST["delete_menu"])) {
    $pdo->prepare("DELETE FROM menu where menu_id = :menu_id")->execute([
      "menu_id" => $_POST["delete_menu_id"]
    ]);
    header("Location: admin.php");
  }

  if (isset($_POST["update_transaction"])) {
    $pdo->prepare("UPDATE transaksi set transaksi_status = :transaksi_status where transaksi_id = :transaksi_id")->execute([
      "transaksi_status" => $_POST['status'],
      "transaksi_id" => $_POST['transaction_id']
    ]);
    header("Location: admin.php");
    
  }
}
