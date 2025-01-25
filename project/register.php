<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - WarungKu.com</title>

    <link rel="stylesheet" href="style/header.css">
    <link rel="stylesheet" href="style/footer.css">
    <link rel="stylesheet" href="style/register.css">
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

    <div class="register-container animasiFade">
        <div class="register-box ">
            <h2>Register</h2>
            <form action="register-action.php" method="POST">
                <div class="textbox">
                    <input type="text" placeholder="Username" name="username" required>
                </div>
                <div class="textbox">
                    <input type="password" placeholder="Password" name="password" required>
                </div>
                <div class="textbox">
                    <input type="text" placeholder="Full Name" name="name" required>
                </div>
                <div class="textbox">
                    <input type="email" placeholder="Email" name="email" required>
                </div>
                <div class="textbox">
                    <input type="text" placeholder="Phone Number" name="phone" required>
                </div>
                <input type="submit" class="btn" value="Register">
                <div class="login-link">
                    <p>Already have an account? <a href="login.php">Login</a></p>
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