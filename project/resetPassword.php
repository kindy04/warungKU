<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - WarungKu.com</title>

    <link rel="stylesheet" href="style/header.css">
    <link rel="stylesheet" href="style/footer.css">
    <link rel="stylesheet" href="style/resetPassword.css">
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

    <div class="reset-password-container">
        <div class="reset-password-box">
            <h2>Reset Password</h2>
            <form action="resetPassword-action.php" method="POST">
                <div class="textbox">
                    <input type="email" placeholder="Enter your email" name="email" required>
                </div>
                <div class="textbox">
                    <input type="text" placeholder="Enter your phone number" name="phone" required>
                </div>
                <div class="textbox">
                    <input type="password" placeholder="Enter new password" name="new_password" required>
                </div>
                <input type="submit" class="btn" value="Reset Password">
            </form>
            <div class="login-link">
                <p>Remember your password? <a href="login.php">Login</a></p>
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