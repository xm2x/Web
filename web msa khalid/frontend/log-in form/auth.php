<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "e book";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    // === REGISTER LOGIC ===
    if ($action == 'register') {
        $name = $_POST['full_name'];
        $email = $_POST['email'];
        // Hash the password for security
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Secure check if email exists
        $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) { // Check if email exists
            header("Location: login.php?error=Email already exists");
        } else { // Email doesn't exist, proceed with registration
            $stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $pass);
            
            if ($stmt->execute()) {
                header("Location: login.php?success=Account created! Please log in.");
            } else {
                header("Location: login.php?error=Error creating account");
            }
        }
    }

if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. Get the user from the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // 2. Verify the password
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: ../main page/main_page.html"); 
            exit();
        } else {
            // Password is incorrect
            header("Location: login.php?error=Invalid Credentials");
            exit();
        }
    }
}
}
$conn->close();

header("Location: login.php?error=Invalid Credentials");
exit();
?>
