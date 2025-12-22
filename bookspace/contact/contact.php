<?php
// 1. DATABASE CONNECTION SETTINGS
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "bookstore_db";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// Check if connection works
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. PHP LOGIC TO PROCESS FORM
$message_status = "";

if (isset($_POST['submit'])) {
    // Sanitize inputs
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $user_msg = $conn->real_escape_string($_POST['message']);

    // Prepare SQL Statement
    $sql = "INSERT INTO CONTACT_MESSAGES (name, email, message) VALUES ('$name', '$email', '$user_msg')";

    if ($conn->query($sql) === TRUE) {
        $message_status = "<p style='color: green; font-weight: bold;'>Thank you! Your message has been sent successfully.</p>";
    } else {
        $message_status = "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Your Book Space</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #ffffffff; margin: 0; }
        .nav { display: flex; justify-content: space-between; align-items: center; background: #eb6a6a; color: white; padding: 10px 5%; }
        .dropdown-content { display: none; position: absolute; background: white; min-width: 160px; box-shadow: 0px 8px 16px rgba(0,0,0,0.2); z-index: 1; right: 5%; }
        .dropdown-content a { color: black; padding: 12px 16px; text-decoration: none; display: block; }
        .user-menu-wrapper:hover .dropdown-content { display: block; }
        
        .contact-section { max-width: 600px; margin: 40px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        h1 { color: #000000ff; text-align: center; }
        form { display: flex; flex-direction: column; }
        label { margin-top: 15px; font-weight: 600; color: #555; }
        input, textarea { padding: 12px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
        button { margin-top: 20px; padding: 12px; background: #eb6a6a; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
        button:hover { background: #2980b9; }
        .contact-info { margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px; }
        .social-media { list-style: none; padding: 0; display: flex; gap: 15px; }
        .social-media a { text-decoration: none; color: #3498db; }
    </style>
</head>
<body>

    <section class="nav">
        <div class="logo">
            <h1>your book Space</h1>
        </div> 
        <div class="user-menu-wrapper">
            <img src="../main page/download (17).jpg" alt="User" style="border-radius: 50%; width: 50px; height: 50px; cursor: pointer;">
            <div id="dropdown-menu" class="dropdown-content">
                <a href="../main page/main_page.php">Home</a>
                <a href="../about/about_us.html">About</a>
                <a href="../cart.php">🛒 View Cart</a>
                <a href="../plans/plan.php">Upgrade</a>
            </div>
        </div>
    </section>

    <div class="contact-section">
        <h1>Contact Us</h1>
        
        <?php echo $message_status; ?>

        <form action="contact.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required placeholder="Enter your full name">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="Enter your email address">

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required placeholder="Enter your message"></textarea>

            <button type="submit" name="submit">Submit Message</button>
        </form>

        <div class="contact-info">
            <h2>Our Details</h2>
            <p><strong>📍 Address:</strong> 123 Book St, Readville, BK 45678</p>
            <p><strong>📞 Phone:</strong> (123) 456-7890</p>
            <p><strong>✉️ Email:</strong> support@bookspace.com</p>
            <ul class="social-media">
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Twitter</a></li>
                <li><a href="#">Instagram</a></li>
            </ul>
        </div>
    </div>

</body>
</html>