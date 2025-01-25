<?php
session_start();

if (!isset($_SESSION["yanglogin"])) {
    header("Location: login.php");
    exit();
}
$admin_name = $_SESSION["yanglogin"]["nama"];
require_once __DIR__ . "/connection.php";
$queri = $pdo->prepare('SELECT * from menu');
$queri->execute();
$menus = $queri->fetchAll();

$queri = $pdo->prepare("select t.transaksi_id, p.pembeli_nama, a.admin_nama, t.transaksi_tanggal, t.transaksi_jumlah, t.transaksi_status, t.transaksi_alamat from transaksi t join pembeli p on p.pembeli_id = t.pembeli_id join admin a on a.admin_id = t.admin_id;");
$queri->execute();
$transactions = $queri->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - WarungKu</title>
    <link rel="stylesheet" href="style/admin.css">
    <link rel="stylesheet" href="style/footer.css">
    <link rel="stylesheet" href="style/header.css">
</head>

<body>

    <nav style="top:0" class="navbar">
        <div class="navbar-img">
            <img style="width: 50px;" src="asset/icon/iftar.png" alt="">
        </div>
        <div class="navbar-logo">WarungKu.com</div>

        <ul class="navbar-links">

            <li><a href="homePage.php">Home</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>

    <div style="margin-top :10%" class="admin-container">
        <div class="buttons">
            <a href="logOut.php">Log Out</a>

        </div>
        <h1>Welcome, <?php echo $admin_name; ?>!</h1>

        <div class="content">
            <div class="menu-forms">
                <div class="form-container">
                    <h2>Tambah Menu</h2>
                    <form action="process_admin.php" method="POST" enctype="multipart/form-data">
                        <label for="menu_name">Nama Menu</label>
                        <input type="text" id="menu_name" name="menu_name" required>

                        <label for="menu_price">Harga</label>
                        <input type="number" id="menu_price" name="menu_price" required>

                        <label for="menu_status">Status</label>
                        <select id="menu_status" name="menu_status" required>
                            <option value="Ready">Ready</option>
                            <option value="Out of Stock">Out of Stock</option>
                        </select>

                        <label for="menu_image">Gambar Menu</label>
                        <input type="file" id="menu_image" name="menu_image" accept="image/*" onchange="previewMenuImage(event)">

                        <div id="previewContainer">
                            <img id="imagePreview" src="#" alt="Pratinjau Gambar" style="display: none; max-width: 100px; margin-top: 10px;">
                        </div>

                        <button type="submit" name="add_menu">Tambah Menu</button>
                    </form>
                </div>

                <div class="form-container">
                    <h2>Edit Menu</h2>
                    <form action="process_admin.php" method="POST">
                        <label for="edit_menu_id">ID Menu</label>
                        <input type="number" id="edit_menu_id" name="edit_menu_id" required>
                        <label for="edit_menu_name">Nama Menu</label>
                        <input type="text" id="edit_menu_name" name="edit_menu_name">
                        <label for="edit_menu_price">Harga</label>
                        <input type="number" id="edit_menu_price" name="edit_menu_price">
                        <label for="edit_menu_status">Status</label>
                        <select id="edit_menu_status" name="edit_menu_status">
                            <option value="Ready">Ready</option>
                            <option value="Out of Stock">Out of Stock</option>
                        </select>
                        <button type="submit" name="edit_menu">Edit Menu</button>
                    </form>
                </div>

                <div class="form-container">
                    <h2>Hapus Menu</h2>
                    <form action="process_admin.php" method="POST">
                        <label for="delete_menu_id">ID Menu</label>
                        <input type="number" id="delete_menu_id" name="delete_menu_id" required>
                        <button type="submit" name="delete_menu">Hapus Menu</button>
                    </form>
                </div>
            </div>

            <div class="existing-menus">
                <h2>Daftar Menu</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Menu</th>
                            <th>Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($menus as $menu): ?>
                            <tr>
                                <td><?php echo $menu['menu_id']; ?></td>
                                <td><?php echo $menu['menu_name']; ?></td>
                                <td>Rp <?php echo number_format($menu['menu_price'], 0, ',', '.'); ?></td>
                                <td class="status-<?php echo strtolower(str_replace(' ', '-', $menu['menu_status'])); ?>">
                                    <?php echo $menu['menu_status']; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="transaction-section">
            <div class="transaction-form">
                <h2>Update Transaksi</h2>
                <form action="process_admin.php" method="POST">
                    <label for="transaction_id">ID Transaksi</label>
                    <input type="number" id="transaction_id" name="transaction_id" required>
                    <!-- 
                    <label for="customer_name">Nama Pemesan</label>
                    <input type="text" id="customer_name" name="customer_name" required>

                    <label for="menu_name">Nama Menu</label>
                    <input type="text" id="menu_name" name="menu_name" required>

                    <label for="quantity">Jumlah Pesanan</label>
                    <input type="number" id="quantity" name="quantity" required>

                    <label for="address">Alamat Antar</label>
                    <textarea id="address" name="address" required></textarea> -->

                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="Menunggu Konfirmasi Pembayaran">Menunggu Konfirmasi Pembayaran</option>
                        <option value="Pesanan Sedang Diproses">Pesanan Sedang Diproses</option>
                        <option value="Pesanan Sedang Diantar">Pesanan Sedang Diantar</option>
                        <option value="Pesanan Diterima">Pesanan Diterima</option>
                    </select>

                    <button type="submit" name="update_transaction">Update Transaksi</button>
                </form>
            </div>

            <div class="existing-transactions">
                <h2>Daftar Transaksi</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID Transaksi</th>
                            <th>Nama Pemesan</th>
                            <th>Alamat</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $transaction): ?>
                            <tr>
                                <td><?php echo $transaction['transaksi_id']; ?></td>
                                <td><?php echo $transaction['pembeli_nama']; ?></td>
                                <td><?php echo $transaction['transaksi_alamat']; ?></td>
                                <td><?php echo $transaction['transaksi_tanggal']; ?></td>
                                <td><?php echo $transaction['transaksi_jumlah']; ?></td>
                                <td><?php echo $transaction['transaksi_status']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <footer class=" footer">
        <p>&copy; 2024 My Website. All rights reserved.</p>
        <ul class="footer-links">

            <li><a href="contact.php">Contact</a></li>
        </ul>
    </footer>

</body>

</html>