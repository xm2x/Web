<?php
session_start();

// ==========================================
// 1. DATABASE CONNECTION
// ==========================================
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookstore_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ==========================================
// 2. AUTHENTICATION LOGIC
// ==========================================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // === REGISTER LOGIC ===
    if (isset($_POST['action']) && $_POST['action'] == 'register') {
        $name = $_POST['full_name'];
        $email = $_POST['email'];
        $password = $_POST['password']; 

        // Check if email already exists
        $checkEmail = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($checkEmail);

        if ($result->num_rows > 0) {
            header("Location: login.php?error=Email already exists");
        } else {
            // Insert user directly into DB (Simple/No Encryption)
            $sql = "INSERT INTO users (full_name, email, password) VALUES ('$name', '$email', '$password')";

            if ($conn->query($sql) === TRUE) {
                header("Location: login.php?success=Account created! Please log in.");
            } else {
                header("Location: login.php?error=Error creating account");
            }
        }
    }

    // === LOGIN LOGIC ===
    if (isset($_POST['action']) && $_POST['action'] == 'login') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Simple check: Find a user with this Email AND this Password
        $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // User found!
            $row = $result->fetch_assoc();
            
            // Start Session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['full_name'];
            
            // Go to main page (FIXED: changed .html to .php)
            header("Location: ../main page/main_page.php"); 
        } else {
            // No match found
            header("Location: login.php?error=Incorrect email or password");
        }
    }
}

$conn->close();
?>