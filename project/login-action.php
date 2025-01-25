
<?php
session_start();
require_once __DIR__ . "/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    try {
        if ($role === "admin") {
            $query = $pdo->prepare('SELECT admin_id, admin_password FROM admin WHERE admin_username = :username');
        } else if ($role === "user") {
            $query = $pdo->prepare('SELECT pembeli_id, pembeli_password FROM pembeli WHERE pembeli_username = :username');
        } else {
            throw new Exception("Role tidak valid.");
        }

        $query->execute(['username' => $username]);
        $user = $query->fetch();

        error_log("User: " . print_r($user, true));
        if ($user && $password == ($user['admin_password'] ?? $user['pembeli_password'])) {
            // Ambil data lengkap pengguna atau admin
            if ($role === "admin") {
                $_SESSION['yanglogin'] = [
                    'id' => $user['admin_id'],
                    'nama' => 'admin',
                    'role' => 'admin'
                ];
                header("Location: admin.php");
            } else {
                $query = $pdo->prepare('SELECT pembeli_id, pembeli_nama, pembeli_email, pembeli_phone FROM pembeli WHERE pembeli_id = :id');
                $query->execute(['id' => $user['pembeli_id']]);
                $userData = $query->fetch();

                $_SESSION['yanglogin'] = $userData;
                header("Location: order.php");
            }
            exit;
        } else {
            $_SESSION['GagalLogin'] = "Username atau password salah.";
        }
    } catch (Exception $e) {
        $_SESSION['GagalLogin'] = "Terjadi kesalahan: " . $e->getMessage();
    }
}

header("Location: login.php");
exit;
?>
