<?php
$conn = new mysqli("localhost", "root", "", "bookstore_db");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// === FIX: Check if ID is missing ===
if (!isset($_GET['id'])) {
    // If no ID is provided, redirect back to the manage page
    header("Location: manage_books.php");
    exit();
}

$id = $_GET['id'];
$row = [];

// 1. Fetch current data
$result = $conn->query("SELECT * FROM products WHERE id='$id'");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Book not found!";
    exit();
}

// 2. Handle Update
if (isset($_POST['update_book'])) {
    $title = $_POST['title'];
    $image = $_POST['image'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $sql = "UPDATE products SET title='$title', image='$image', price='$price', category='$category' WHERE id='$id'";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect with success message
        header("Location: manage_books.php?msg=Updated Successfully");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .form-container { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; max-width: 500px; margin: 0 auto; }
        input, select { width: 100%; padding: 8px; margin: 5px 0 15px 0; }
        button { background: blue; color: white; padding: 10px; border: none; cursor: pointer; width: 100%; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Edit Book</h2>
        <form method="POST">
            <label>Book Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>

            <label>Image Filename:</label>
            <input type="text" name="image" value="<?php echo htmlspecialchars($row['image']); ?>" required>

            <label>Price:</label>
            <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" required>

            <label>Category:</label>
            <input type="text" name="category" value="<?php echo htmlspecialchars($row['category']); ?>">

            <button type="submit" name="update_book">Update Book</button>
        </form>
        <br>
        <a href="manage_books.php">Cancel</a>
    </div>

</body>
</html>