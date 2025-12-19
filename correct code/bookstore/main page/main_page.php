<?php
session_start();

// === DATABASE CONNECTION ===
$conn = new mysqli("localhost", "root", "", "bookstore_db");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// === AUTO-LOGIN (COOKIE CHECK) ===
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_login'])) {
    $cookie_id = $conn->real_escape_string($_COOKIE['user_login']);
    $sql = "SELECT * FROM users WHERE id='$cookie_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['full_name'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main page.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Add styles for the new Add to Cart button */
        .btn-cart {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
            font-size: 14px;
            z-index: 10; /* Make sure it sits on top */
            position: relative;
        }
        .btn-cart:hover { background-color: #218838; }
        .card { cursor: default; } /* Reset cursor since we handle links manually now */
        .card-content { cursor: pointer; } /* Only image/title are clickable */
    </style>
</head>
<body>
    
    <section class="nav">
        <div class="logo"><h1>Your Book Space</h1></div> 
        <div class="search">
            <input type="text" placeholder="search...">
            <button type="submit">search</button>
        </div>
        <div class="user-menu-wrapper">
            <img src="download (17).jpg" alt="User" style="border-radius: 50%; width: 50px; height: 50px;" id="info">
            <div id="dropdown-menu" class="dropdown-content">
                <?php if(isset($_SESSION['user_id'])) { ?>
                    <p style="padding:10px; color:green; text-align:center;">Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
                    <a href="../info/info.html">Profile</a>
                    <a href="../login/logout.php">Logout</a>
                <?php } else { ?>
                    <a href="../login/login.php">Log In</a>
                <?php } ?>
                <a href="../cart.php" style="color: blue; font-weight:bold;">🛒 View Cart</a>
                <a href="main_page.php">Home</a>
                <a href="../about/about_us.html">About</a>
                <a href="../contact/contact.html">Contact</a>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="menu"><h1>Hello World</h1></div>
    </section>
    
    <section class="content-area">
        <section class="sidebar">
            <h2>Categories</h2>
            <select><option>E-Books</option></select>
        </section>
        
        <section class="main">
            <?php
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
            ?>
                <div class="card">
                    <div class="card-content" onclick="window.location.href='../book_preview/book_preview.html?title=<?php echo urlencode($row['title']); ?>&img=<?php echo urlencode('../main_page/'.$row['image']); ?>'">
                        <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p>$<?php echo htmlspecialchars($row['price']); ?></p>
                    </div>

                    <form method="POST" action="../cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="add_to_cart" class="btn-cart">Add to Cart</button>
                    </form>
                </div>

            <?php 
                }
            } else { echo "<p>No books found.</p>"; }
            ?>
        </section>
    </section>

    <footer><p>&copy; <?php echo date("Y"); ?> Your Book Space.</p></footer>
    
    <script src="main page.js"></script>
</body>
</html>
<?php $conn->close(); ?>