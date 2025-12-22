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
    <link rel="stylesheet" href="main_page.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>    
    <section class="nav">
        <div class="logo"><h1>Your Book Space</h1></div> 

        <div class="user-menu-wrapper">
            <img src="download (17).jpg" alt="User" style="border-radius: 50%; width: 50px; height: 50px;" id="info">
            <div id="dropdown-menu" class="dropdown-content">
                <?php if(isset($_SESSION['user_id'])) { ?>
                    <p style="padding:10px; color:green; text-align:center;">Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
                    <a href="../log-in form/login.php">Logout</a>
                    <?php } else { ?>
                        <a href="../log-in form/login.php">Log In</a>
                        <?php } ?>
                        <a href="../cart.php">🛒 View Cart</a>
                        <a href="../plans/plan.php">Upgrade</a>
                        <a href="../about/about_us.html">About</a>
                        <a href="../contact/contact.php">Contact</a>
            </div>
        </div>
    </section>


<section class="container">
    <div class="menu">
        <h1>New Arrivals</h1>
        <div class="new-arrivals-grid" style="display: flex; gap: 20px; padding: 10px; ">
            <?php
            $new_sql = "SELECT * FROM products ORDER BY id DESC LIMIT 4";
            $new_result = $conn->query($new_sql);
            if ($new_result->num_rows > 0) {
                while($new_row = $new_result->fetch_assoc()) {
            ?>
                <div class="new-arrival-item" style="text-align: center; min-width: 120px; ">
                    <a href="../book_preview/book_preview.php?title=<?php echo urlencode($new_row['title']); ?>&img=<?php echo urlencode($new_row['image']); ?>" >
                        <img src="<?php echo htmlspecialchars($new_row['image']); ?>" 
                            alt="New Book" 
                            style="width: 100px; height: 150px; object-fit: cover; border-radius: 5px;">
                        <p style="font-size: 14px; margin-top: 5px; text-decoration: none; color: black ; background-color: aliceblue; border-radius: 20px; padding: 5px; ;" >
                            <?php echo htmlspecialchars($new_row['title']); ?></p>
                    </a>
                </div>
            <?php
                }
            }
            else {
                echo "<p>Checking for new books...</p>";
            }
            ?>
        </div>
    </div>
</section>
    
<section class="header">
    <a href="main_page.php">All Books</a>
    <a href="main_page.php?category=best_seller">Best Seller</a>
    <a href="main_page.php?category=science_fiction">Science Fiction</a>
    <a href="main_page.php?category=fantasy">Fantasy</a>
    <a href="main_page.php?category=romance">Romance</a>
    <a href="main_page.php?category=horror">Horror</a>
    <a href="main_page.php?category=thriller">Thriller</a>
    <a href="main_page.php?category=mystery">Mystery</a>
    <a href="main_page.php?category=science">Science</a>
    <a href="main_page.php?category=biography">Biography</a>
    <a href="main_page.php?category=self_help">Self Help</a>
</section>

    
<section class="main">
    <?php
    // Get category from URL (if it exists)
    $category_filter = isset($_GET['category']) ? $_GET['category'] : '';

    if (!empty($category_filter)) {
        // Prepare query to show only selected category
        $stmt = $conn->prepare("SELECT * FROM products WHERE category = ?");
        $stmt->bind_param("s", $category_filter);
        $stmt->execute();
        $result = $stmt->get_result();
        echo "<h2 class='category-title'>Showing: " . htmlspecialchars(str_replace('_', ' ', $category_filter)) . "</h2>";
    } else {
        // Show all products if no category is clicked
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);
    }

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
    ?>
        <div class="card">
            <div class="card-content" onclick="window.location.href='../book_preview/book_preview.php?title=<?php echo urlencode($row['title']); ?>&img=<?php echo urlencode($row['image']); ?>'">
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
    } else { 
        echo "<p>No books found in this category.</p>"; 
    }
    ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="main page.js"></script>

    <script>
    $(document).ready(function () {
        // Create the popup element
        const $popup = $("<div>", { id: "logout-popup" }).css({
            "position": "fixed",
            "top": 0, "left": 0,
            "width": "100%", "height": "100%",
            "background": "rgba(0,0,0,0.6)",
            "display": "none", 
            "justify-content": "center",
            "align-items": "center",
            "z-index": 9999
        });

        // Insert the HTML content
        $popup.html(`
            <div style="background: white; padding: 25px; width: 300px; border-radius: 12px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
                <h3 style="color: black; margin-bottom: 20px;">Are you sure you want to logout?</h3>
                <button id="logout-yes" style="font-weight: bold; font-size: 16px; padding:10px 20px; margin:10px; border-radius:10px; border: none; background-color: #ff0000; color: white; cursor: pointer;">Yes</button>
                <button id="logout-no" style="font-weight: bold; padding:10px 20px; margin:10px; border-radius:10px; border: none; cursor: pointer;">Cancel</button>
            </div>
        `);

        // Append to the body
        $("body").append($popup);

        // Show popup ONLY when the logout link is clicked 
        // Note: Using the specific text or href to target only the Logout button
        $(document).on("click", 'a[href="../log-in form/login.php"]:contains("Logout")', function (e) {
            e.preventDefault();
            $popup.css("display", "flex").hide().fadeIn(200);
        });

        // Handle button clicks inside the popup
        $(document).on("click", "#logout-yes", function () {
            window.location.href = "../log-in form/login.php";
        });

        $(document).on("click", "#logout-no", function () {
            $popup.fadeOut(200);
        });
    });
    </script>

</body>
</html>
<?php $conn->close(); ?> 


