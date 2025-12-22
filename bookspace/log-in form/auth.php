<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookstore_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // === REGISTER LOGIC ===
    if (isset($_POST['action']) && $_POST['action'] == 'register') {
        $name = $conn->real_escape_string($_POST['full_name']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = $_POST['password']; 

        $checkEmail = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($checkEmail);

        if ($result->num_rows > 0) {
            header("Location: login.php?error=Email already exists");
        } else {
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
        $email = $conn->real_escape_string($_POST['email']);
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Set Session Variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['full_name'];
            $_SESSION['user_email'] = $row['email'];

            // === REDIRECT LOGIC ===
            // Check if the user is the admin
            if ($row['email'] === 'admin@gmail.com') {
                header("Location: ../admin/edit_book.php");
            } else {
                header("Location: ../main page/main_page.php");
            }
            exit(); 
        } else {
            header("Location: login.php?error=Incorrect email or password");
        }
    }
}
$conn->close();
?>