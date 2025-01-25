<?php
session_start();
require_once __DIR__ . "/connection.php";

// Ambil data dari form
$pembeli_id = $_SESSION["yanglogin"]["pembeli_id"];
$admin_id = 1;
$chartData = isset($_POST['chartData']) ? json_decode($_POST['chartData'], true) : [];
$alamatPengiriman = isset($_POST['alamat']) ? $_POST['alamat'] : 'Alamat tidak tersedia';
$ongkir = isset($_POST['ongkir']) ? (int)$_POST['ongkir'] : 0;
$grandTotal = isset($_POST['grandTotal']) ? (int)$_POST['grandTotal'] : 0;
// Debugging: Cek apakah data diterima

if (!empty($chartData)) {
    try {
        // Mulai transaksi database
        $pdo->beginTransaction();

        // Insert ke tabel transaksi (header)
        $stmt = $pdo->prepare("INSERT INTO transaksi (pembeli_id, admin_id, transaksi_tanggal, transaksi_jumlah, transaksi_alamat) VALUES (?, ?, NOW(), ?, ?)");
        $stmt->execute([$pembeli_id, $admin_id, $grandTotal, $alamatPengiriman]);

        // Ambil ID transaksi terakhir
        $transaksi_id = $pdo->lastInsertId();

        // Insert ke tabel dtrans (detail transaksi)
        $stmtDetail = $pdo->prepare("INSERT INTO dtrans (transaksi_id, menu_id, dtrans_qty, dtrans_subtotal) VALUES (?, ?, ?, ?)");
        foreach ($chartData as $item) {
            // Ambil `menu_id` dari database berdasarkan nama menu
            $menu_stmt = $pdo->prepare("SELECT menu_id FROM menu WHERE menu_name = ?");
            $menu_stmt->execute([$item['menu']]);
            $menu_id = $menu_stmt->fetchColumn();

            if ($menu_id) {
                $stmtDetail->execute([
                    $transaksi_id,
                    $menu_id,
                    $item['jumlah'],
                    $item['totalHarga']
                ]);
            } else {
                throw new Exception("Menu tidak ditemukan: " . $item['menu']);
            }
        }

        // Commit transaksi database
        $pdo->commit();

        echo "Pesanan berhasil disimpan!";

        // Redirect ke halaman konfirmasi/invoice
        header("Location: order.php");
        exit;

    } catch (Exception $e) {
        // Rollback jika terjadi kesalahan
        $pdo->rollBack();
        echo "Terjadi kesalahan: " . $e->getMessage();
    }
} else {
    echo "Keranjang belanja kosong!";
}
?>
