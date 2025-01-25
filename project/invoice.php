<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $chartData = isset($_POST['chartData']) ? json_decode($_POST['chartData'], true) : [];
    $alamatPengiriman = isset($_POST['alamat']) ? $_POST['alamat'] : "Alamat tidak tersedia";
    $ongkir = 10000;
    $totalHarga = 0;

    foreach ($chartData as $item) {
        $totalHarga += $item['totalHarga'];
    }

    $grandTotal = $totalHarga + $ongkir;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - WarungKu.com</title>

    <link rel="stylesheet" href="style/header.css">
    <link rel="stylesheet" href="style/footer.css">
    <link rel="stylesheet" href="style/invoice.css">
</head>

<body>
    <nav class="navbar" style="top: 0;">
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

    <div class="invoice-container">
        <div class="invoice-header">
            <h1>Invoice Pembelian</h1>
            <p>ID Transaksi: #<?= rand(10000, 99999); ?></p>
        </div>

        <div class="invoice-details">
            <table>
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($chartData)) : ?>
                        <?php foreach ($chartData as $item) : ?>
                            <tr>
                                <td><?= htmlspecialchars($item['menu']); ?></td>
                                <td><?= htmlspecialchars($item['jumlah']); ?></td>
                                <td>Rp <?= number_format($item['totalHarga'], 0, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="3">Tidak ada item dalam pesanan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="invoice-summary">
                <p>Alamat Pengiriman: <?= htmlspecialchars($alamatPengiriman); ?></p>
                <p>Ongkir: Rp <?= number_format($ongkir, 0, ',', '.'); ?></p>
                <p><strong>Total Harga: Rp <?= number_format($grandTotal, 0, ',', '.'); ?></strong></p>

                <div class="payment-method">
                    <label for="payment-method">Pilih Metode Pembayaran:</label>
                    <select id="payment-method" name="payment-method">
                        <option value="cash">Cash</option>
                        <option value="qris">QRIS</option>
                        <option value="bca">Transfer Bank (BCA)</option>
                        <option value="bri">Transfer Bank (BRI)</option>
                    </select>

                    <div id="payment-info" class="payment-info">
                        <!-- Dynamic content will be added here -->
                    </div>
                </div>
            </div>

            <form action="invoice-action.php" method="POST">
                <input type="hidden" name="chartData" value='<?= htmlspecialchars(json_encode($chartData)); ?>'>
                <input type="hidden" name="alamat" value="<?= htmlspecialchars($alamatPengiriman); ?>">
                <input type="hidden" name="ongkir" value="<?= $ongkir; ?>">
                <input type="hidden" name="grandTotal" value="<?= $grandTotal; ?>">
                <button type="submit" class="confirm-btn">Konfirmasi Pembayaran</button>
            </form>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2024 My Website. All rights reserved.</p>
        <ul class="footer-links">

            <li><a href="/contact.php">Contact Us</a></li>
        </ul>
    </footer>

    <script>
        document.getElementById('payment-method').addEventListener('change', function() {
            var paymentMethod = this.value;
            var paymentInfoDiv = document.getElementById('payment-info');
            paymentInfoDiv.innerHTML = '';

            if (paymentMethod === 'cash') {
                paymentInfoDiv.innerHTML = 'Anda akan membayar cash sebesar Rp <?= number_format($grandTotal, 0, ',', '.'); ?>';
            } else if (paymentMethod === 'qris') {
                paymentInfoDiv.innerHTML = '<img src="asset/img/Qris.png" alt="QRIS" style="width: 200px; height: auto;">';
            } else if (paymentMethod === 'bca') {
                paymentInfoDiv.innerHTML = 'Nomor Rekening BCA: 1234567890';
            } else if (paymentMethod === 'bri') {
                paymentInfoDiv.innerHTML = 'Nomor Rekening BRI: 0987654321';
            }
        });
    </script>
</body>

</html>