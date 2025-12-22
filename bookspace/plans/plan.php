<?php
// 1. DATABASE CONNECTION & SESSION START
session_start();

$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "bookstore_db";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. LOGIC: HANDLE PLAN SELECTION
if (isset($_GET['plan_id'])) {
    // For this to work, the user MUST be logged in. 
    // We check if a session user_id exists.
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Please log in first!'); window.location.href='../log-in form/login.php';</script>";
        exit();
    }

    $name = $_GET['plan_id'];
    $price = $_GET['plan_id'];
    $user_id = $_SESSION['user_id'];
    $product_id = $_GET['plan_id'];

    // Insert the selection into the subscriptions table
    $stmt = $conn->prepare("INSERT INTO subscription (name, price) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $price);

    if ($stmt->execute()) {
        echo "<script>alert('Plan activated successfully!'); window.location.href='../main page/main_page.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Book Space - Plans</title>
    <style>
        /* CSS STYLES */
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        
        .nav { background: #eb6a6a; color: white; padding: 15px 50px; display: flex; justify-content: space-between; align-items: center; position: relative; }
        .logo h1 { margin: 0; font-size: 24px; }
        
        .user-menu-wrapper { position: relative; }
        #info { border-radius: 50%; width: 50px; height: 50px; cursor: pointer; border: 2px solid #fff; }
        
        .dropdown-content { display: none; position: absolute; right: 0; top: 60px; background: white; min-width: 160px; box-shadow: 0 8px 16px rgba(0,0,0,0.2); z-index: 1000; border-radius: 5px; }
        .dropdown-content a { color: black; padding: 12px 16px; text-decoration: none; display: block; border-bottom: 1px solid #eee; }
        .dropdown-content a:hover { background-color: #f1f1f1; }
        .show { display: block; }

        .plans-container { display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; padding: 50px 20px; }
        .plan-card { background: white; border: 1px solid #ddd; border-radius: 10px; width: 280px; padding: 30px; text-align: center; transition: 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .plan-card:hover { transform: translateY(-10px); box-shadow: 0 10px 20px rgba(0,0,0,0.15); }
        .plan-card h2 { color: #2c3e50; }
        .price { font-size: 24px; font-weight: bold; color: #27ae60; margin: 15px 0; }
        ul { list-style: none; padding: 0; text-align: left; margin: 20px 0; }
        ul li { padding: 8px 0; border-bottom: 1px solid #eee; font-size: 14px; }
        
        .select-btn { display: inline-block; background-color: #3498db; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; transition: 0.3s; }
        .select-btn:hover { background-color: #2980b9; }
    </style>
</head>
<body>

    <section class="nav">
        <div class="logo"><h1>your book Space</h1></div>
        <div class="user-menu-wrapper">
            <img src="download (17).jpg" alt="User" id="info">
            <div id="dropdown-menu" class="dropdown-content">
                <a href="../main page/main_page.php">Home</a>
                <a href="../log-in form/login.php">Logout</a>
                <a href="../cart.php">🛒 View Cart</a>
            </div>
        </div>
    </section>

    <h1 style="text-align:center; margin-top: 40px;">Upgrade Your Reading Experience</h1>

    <section class="plans-container">
        <div class="plan-card">
            <h2>Basic Plan</h2>
            <p class="price">$9.99/mo</p>
            <ul>
                <li>Read 1 book per month</li>
                <li>Access to basic library</li>
                <li>No voice-over feature</li>
            </ul>
            <a href="?plan_id=8" class="select-btn">Select Plan</a>
        </div>

        <div class="plan-card">
            <h2>Premium Plan</h2>
            <p class="price">$19.99/mo</p>
            <ul>
                <li>Read unlimited books</li>
                <li>Voice-over narration</li>
                <li>Early access to new releases</li>
            </ul>
            <a href="?plan_id=9" class="select-btn">Select Plan</a>
        </div>

        <div class="plan-card">
            <h2>Premium-Plus</h2>
            <p class="price">$49.99/mo</p>
            <ul>
                <li>All Premium features</li>
                <li>Exclusive author Q&A</li>
                <li>Offline reading mode</li>
            </ul>
            <a href="?plan_id=10" class="select-btn">Select Plan</a>
        </div>

        <div class="plan-card">
            <h2>Family Plan</h2>
            <p class="price">$29.99/mo</p>
            <ul>
                <li>Up to 5 family members</li>
                <li>Individual profiles</li>
                <li>Parental controls</li>
            </ul> 
            <a href="?plan_id=11" class="select-btn">Select Plan</a>
        </div>
    </section>

    <script>
        // Dropdown toggle
        const infoBtn = document.getElementById('info');
        const menu = document.getElementById('dropdown-menu');

        infoBtn.addEventListener('click', function(e) {
            menu.classList.toggle('show');
            e.stopPropagation();
        });

        document.addEventListener('click', function() {
            menu.classList.remove('show');
        });
    </script>

</body>
</html>