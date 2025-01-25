<?php
session_start();
if (isset($_SESSION['GagalLogin'])) {
    $message = addslashes($_SESSION['GagalLogin']);
    echo "<script>alert('$message');</script>";
    unset($_SESSION["GagalLogin"]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - WarungKu.com</title>

    <link rel="stylesheet" href="style/header.css">
    <link rel="stylesheet" href="style/footer.css">
    <link rel="stylesheet" href="style/login.css">
</head>

<body>
    <nav class="navbar">
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

    <div class="login-container">
        <div class="login-box animasiFade">
            <h2>Login</h2>
            <form action="login-action.php" method="POST">
                <div class="textbox">
                    <input type="text" placeholder="Username" name="username" required>
                </div>
                <div class="textbox">
                    <input type="password" placeholder="Password" name="password" required>
                </div>
                <div class="role-select">
                    <label for="role">Login as:</label>
                    <div class="role-selection">
                        <label>
                            <input type="radio" name="role" value="admin" required>
                            Admin
                        </label>
                        <label>
                            <input type="radio" name="role" value="user" required>
                            User
                        </label>
                    </div>
                </div>


                <input type="submit" class="btn" value="Login">

                <div class="forgot-password">
                    <p><a href="resetPassword.php">Forget Password?</a></p>
                </div>
                <div class="register-link">
                    <p>Don't have an account? <a href="register.php">Register</a></p>
                </div>
            </form>
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