<?php
session_start();
require_once __DIR__ . "/connection.php";
$status = "ready";
$username = $_SESSION["yanglogin"]["pembeli_nama"];

$queri = $pdo->prepare('select t.transaksi_id, a.admin_nama, t.transaksi_tanggal, t.transaksi_jumlah, t.transaksi_status, transaksi_alamat from transaksi t join admin a on a.admin_id = t.admin_id where pembeli_id = :pembeli_id;');
$queri->execute([
    'pembeli_id' => $_SESSION['yanglogin']['pembeli_id']
]) ;
$riwayat_transaksi = $queri->fetchAll();
$queri = $pdo->prepare('SELECT * from menu where menu_status = "ready"');
$queri->execute();
$menu_items = $queri->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WarungKu.com</title>
    <link rel="stylesheet" href="style/header.css">
    <link rel="stylesheet" href="style/footer.css">
    <link rel="stylesheet" href="style/order.css">
    <script>
        let chartItems = [];

        function addToChart() {
            const menuElement = document.getElementById('menu');
            const menu = menuElement.value;
            const harga = parseInt(menuElement.options[menuElement.selectedIndex].getAttribute('data-harga'));
            const jumlah = parseInt(document.getElementById('jumlah').value);

            if (isNaN(jumlah) || jumlah <= 0) {
                alert("Jumlah harus lebih besar dari 0!");
                return;
            }

            const totalHarga = harga * jumlah;

            if (isNaN(harga) || harga <= 0) {
                alert("Harga tidak valid untuk menu yang dipilih.");
                return;
            }

            chartItems.push({
                menu,
                jumlah,
                harga,
                totalHarga
            });
            renderChart();
        }



        function renderChart() {
            const chartTable = document.getElementById('chartTable');
            chartTable.innerHTML = '';
            let totalBiaya = 0;
            chartItems.forEach((item, index) => {
                totalBiaya += item.totalHarga;
                chartTable.innerHTML += `
            <tr>
                <td>${index + 1}</td>
                <td>${item.menu}</td>
                <td>${item.jumlah}</td>
                <td>Rp ${item.harga.toLocaleString()}</td>
                <td>Rp ${item.totalHarga.toLocaleString()}</td>
            </tr>
        `;
            });
            document.getElementById('totalBiaya').innerText = 'Rp ' + totalBiaya.toLocaleString();

            document.getElementById('menu').selectedIndex = 0; // 
            document.getElementById('jumlah').value = '';
            document.getElementById('no_hp').value = '';
            document.getElementById('alamat').value = '';
        }
    </script>
</head>

<body>
    <nav style="top:0" class="navbar">
        <div class="navbar-img">
            <img style="width: 50px;" src="asset/icon/iftar.png" alt="">
        </div>
        <div class="navbar-logo">WarungKu.com</div>
        <ul class="navbar-links">
            <li><a href="order.php">Order</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="welcome">
            <h2>Welcome, <?php echo $username; ?>!</h2>
        </div>

        <div class="buttons">
            <a href="logOut.php">Log Out</a>
        </div>

        <div class="transaction-history">
            <h3>Transaction History</h3>
            <?php foreach ($riwayat_transaksi as $transaksi) { ?>
                <div class="transaction-item">
                    <p><strong>ID Transaksi:</strong> <?php echo $transaksi['transaksi_id']; ?></p>
                    <p><strong>Nama Admin:</strong> <?php echo $transaksi['admin_nama']; ?></p>
                    <p><strong>Alamat:</strong> <?php echo $transaksi['transaksi_alamat']; ?></p>
                    <p><strong>Tanggal:</strong> <?php echo $transaksi['transaksi_tanggal']; ?></p>
                    <p><strong>Biaya Pengiriman:</strong> Rp 10.000,00</p>
                    <p><strong>Total Harga:</strong> <?php echo 'Rp ' . number_format($transaksi['transaksi_jumlah'], 0, ',', '.'); ?></p>
                    <p><strong>Status:</strong> <span class="status"><?php echo $transaksi['transaksi_status']; ?></span></p>
                </div>
            <?php } ?>
        </div>

        <div class="menu">
            <h3>Menu</h3>
            <div class="menu-container">
                <?php
                foreach ($menu_items as $item) {
                    echo "
                    <div class='menu-item'>
                        <img src='{$item['menu_gambar']}' alt='{$item['menu_name']}'>
                        <div class='menu-details'>
                            <p class='menu-name'>{$item['menu_name']}</p>
                            <p>Rp " . number_format($item['menu_price'], 0, ',', '.') . "</p>
                            <p class='status'>{$item['menu_status']}</p>
                        </div>
                    </div>";
                }
                ?>
            </div>
        </div>

        <div class="order-and-chart">
            <div class="order-form">
                <h3>Place Your Order</h3>
                <form onsubmit="event.preventDefault(); addToChart();">
                    <label for="menu">Menu</label>
                    <select id="menu" name="menu">
                        <?php foreach ($menu_items as $item) : ?>
                            <option value="<?= htmlspecialchars($item['menu_name']); ?>" data-harga="<?= htmlspecialchars($item['menu_price']); ?>">
                                <?= htmlspecialchars($item['menu_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>


                    <label for="jumlah">Jumlah</label>
                    <input type="number" id="jumlah" name="jumlah" required>


                    <button type="submit">Add To Chart</button>
                </form>
            </div>

            <div class="chart-section">
                <h3>Chart</h3>
                <table border="1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Makanan</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody id="chartTable"></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4"><strong>Total Biaya</strong></td>
                            <td id="totalBiaya">Rp 0</td>
                        </tr>
                    </tfoot>
                </table>

                <form action="invoice.php" method="POST">
                    <input type="hidden" name="chartData" id="chartData"><br>
                    <label for="no_hp">No HP Penerima</label><br>
                    <input class="nomor" type="text" id="no_hp" name="no_hp" required>
                    <br>

                    <label for="alamat">Alamat Penerima</label><br>
                    <textarea class="alamat" id="alamat" name="alamat" required></textarea>
                    <button type="submit" onclick="document.getElementById('chartData').value = JSON.stringify(chartItems)">Check Out</button>
                </form>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2024 My Website. All rights reserved.</p>
        <ul class="footer-links">

            <li><a href="/contact.php">Contact Us</a></li>
        </ul>
    </footer>
</body>

</html>