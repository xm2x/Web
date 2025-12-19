<?php
session_start();
$conn = new mysqli("localhost", "root", "", "bookstore_db");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// 1. Initialize Cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// 2. HANDLE: Add to Cart
if (isset($_POST['add_to_cart'])) {
    $pid = $_POST['product_id'];
    // If exists, add 1, else set to 1
    if (isset($_SESSION['cart'][$pid])) {
        $_SESSION['cart'][$pid]++;
    } else {
        $_SESSION['cart'][$pid] = 1;
    }
}

// 3. HANDLE: Remove from Cart
if (isset($_GET['remove'])) {
    $pid = $_GET['remove'];
    unset($_SESSION['cart'][$pid]);
}

// 4. HANDLE: Checkout (Create Order)
if (isset($_POST['checkout'])) {
    // Check if logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login/login.php?error=Please login to checkout");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $order_success = true;

    // Loop through cart and save to Database
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $sql = "INSERT INTO orders (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')";
        if (!$conn->query($sql)) {
            $order_success = false;
            echo "Error: " . $conn->error;
        }
    }

    if ($order_success) {
        $_SESSION['cart'] = []; // Clear cart
        $msg = "Order placed successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f1ea; padding: 20px; }
        .cart-container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        .btn-remove { color: red; text-decoration: none; font-weight: bold; }
        .btn-checkout { background: #28a745; color: white; padding: 15px; width: 100%; border: none; font-size: 18px; cursor: pointer; margin-top: 20px; }
        .btn-back { display: inline-block; margin-bottom: 20px; color: #555; text-decoration: none; }
    </style>
</head>
<body>

    <div class="cart-container">
        <a href="main page/main_page.php" class="btn-back">← Back to Shop</a>
        <h1>Your Shopping Cart</h1>

        <?php if(isset($msg)) echo "<p style='color:green; font-weight:bold;'>$msg</p>"; ?>

        <?php if (empty($_SESSION['cart'])) { ?>
            <p>Your cart is empty.</p>
        <?php } else { ?>
            
            <table>
                <tr>
                    <th>Book</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                <?php
                $total_cost = 0;
                // Fetch details for each item in cart
                foreach ($_SESSION['cart'] as $pid => $qty) {
                    $sql = "SELECT * FROM products WHERE id='$pid'";
                    $result = $conn->query($sql);
                    if ($row = $result->fetch_assoc()) {
                        $subtotal = $row['price'] * $qty;
                        $total_cost += $subtotal;
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td>$<?php echo $row['price']; ?></td>
                            <td><?php echo $qty; ?></td>
                            <td>$<?php echo number_format($subtotal, 2); ?></td>
                            <td><a href="cart.php?remove=<?php echo $pid; ?>" class="btn-remove">Remove</a></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <td colspan="3" style="text-align:right; font-weight:bold;">Grand Total:</td>
                    <td style="font-weight:bold;">$<?php echo number_format($total_cost, 2); ?></td>
                    <td></td>
                </tr>
            </table>

            <form method="POST">
                <button type="submit" name="checkout" class="btn-checkout">Place Order</button>
            </form>

        <?php } ?>
    </div>

</body>
</html>