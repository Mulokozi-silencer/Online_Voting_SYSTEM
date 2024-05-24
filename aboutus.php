<?php 
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Online Voting System</title>
    <link rel="stylesheet" href="styles.css">
    <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-image: url('images/background.jpeg');
    background-color: transparent; /* Light gray background */
}

header {
    text-align: center;
    padding: 20px;
    background-color: #333;
    color: #fff;
}

nav {
    background-color: #444;
    padding: 10px 0;
    text-align: center;
}

nav a {
    color: #fff;
    text-decoration: none;
    margin: 0 10px;
}

nav a:hover {
    text-decoration: underline;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #e4e4e4;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.section {
    margin-bottom: 20px;
}

.section h2 {
    color: #333;
}

.section p {
    color: #555;
}

.marquee-container {
            width: 100%;
            overflow: hidden;
            white-space: nowrap;
        }

       .marquee {
            display: inline-block;
            animation: marquee 30s linear infinite;
        }

        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }
        .marquee img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            margin: 10px;
        }

@media screen and (min-width: 768px) {
    .photos img {
        max-width: 400px;
    }
}

@media screen and (min-width: 1024px) {
    .photos img {
        max-width: 500px;
    }
}
</style>
</head>
<body>
    <header>
        <h1>About Us</h1>
    </header>
    <nav>
        <a href="index1.php">Home</a>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
    </nav>
    <div class="container">
        <div class="section">
            <h2 align="center">Who We Are</h2>
            <p>We are a team dedicated to providing an efficient and secure online voting system. Our goal is to make the voting process convenient and accessible to everyone.</p>
        </div>
        <div class="section">
            <h2>Our Services</h2>
            <p>Our services include:</p>
            <ul>
                <li>Online registration for voting</li>
                <li>Secure login and authentication</li>
                <li>User-friendly interface for casting votes</li>
                <li>Real-time monitoring of voting progress</li>
                <li>Accurate tallying and reporting of election results</li>
            </ul>
        </div>
        <div class="section">
            <h2 align="center">How to Contact Us</h2>
            <p>If you have any questions or inquiries, feel free to reach out to us:</p>
            <ul>
                <li>Email: mulokoziwillium@gmail.com</li>
                <li>Phone: +255 (688) 678-996 / +255 (655) 478-996</li>
                <li>Address: 131 P.O Box MUST, Mbeya, Tanzania</li>
            </ul>
        </div>
        <div class="section">
            <h2>Photos About Us</h2>
            <div class="marquee-container">
                <div class="marquee">
                    <img src="images/p1.jpeg" alt="Team Photo 1">
                    <img src="images/R.jpeg" alt="Team Photo 2">
                    <img src="images/th (1).jpeg" alt="Team Photo 3">
                    <img src="uploads/mulokozi.jpg" alt="">
                    <!-- Add more photos as needed -->
                </div>
            </div>
        </div>
        <div class="section">
        <h2>Send Us a Message</h2>
            <?php if (isset($_SESSION['message_status'])): ?>
                <?php if ($_SESSION['message_status'] === "success"): ?>
                    <p class="success">Message sent successfully.</p>
                <?php elseif ($_SESSION['message_status'] === "error"): ?>
                    <p class="error">Error sending message.</p>
                <?php elseif ($_SESSION['message_status'] === "invalid_request"): ?>
                    <p class="error">Invalid request method.</p>
                <?php endif; ?>
                <?php unset($_SESSION['message_status']); ?>
            <?php endif; ?>
            <form action="submit_message.php" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>

                <label for="message">Message:</label><br>
                <textarea id="message" name="message" rows="4" cols="50" required></textarea><br><br>

                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
    <footer>
        &copy; <?php echo date('Y'); ?> Online Voting System. All rights reserved.
    </footer>
</body>
</html>