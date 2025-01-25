<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WarungKu.com</title>

    <link rel="stylesheet" href="style/header.css">
    <link rel="stylesheet" href="style/footer.css">
    <link rel="stylesheet" href="style/Contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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


    <div class="contact-container animasiFade">
        <h1>Contact Us</h1>
        <p>If you have any questions or need assistance, feel free to reach out to us!</p>

        <div class="contact-form ">
            <form action="process_contact.php" method="POST">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message</label>
                <textarea id="message" name="message" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>

        <div class="social-media">
            <h2>Follow Us</h2>
            <p>Stay connected through our social media channels!</p>

            <div class="icons">
                <a href="https://www.instagram.com/kindyabdillah_" target="_blank" class="icon instagram">
                    <i class="fab fa-instagram"></i>

                </a>

                <a href="https://wa.me/6289677656696" target="_blank" class="icon whatsapp">
                    <i class="fab fa-whatsapp"></i>

                </a>
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