<?php
$conn = new mysqli("localhost", "root", "", "bookstore_db");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

if (!isset($_GET['id'])) {
    header("Location: manage_books.php");
    exit();
}

$id = $_GET['id'];
$row = [];

$result = $conn->query("SELECT * FROM products WHERE id='$id'");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Book not found!";
    exit();
}

if (isset($_POST['update_book'])) {
    $title = $_POST['title'];
    $image = $_POST['image'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $sql = "UPDATE products SET title='$title', image='$image', price='$price', category='$category' WHERE id='$id'";
    
    if ($conn->query($sql) === TRUE) {
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
        input, select { width: 100%; padding: 8px; margin: 5px 0 15px 0; box-sizing: border-box; }
        button { background: blue; color: white; padding: 10px; border: none; cursor: pointer; width: 100%; }
        .error-msg { color: red; font-size: 0.8em; display: none; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Edit Book</h2>
        <form id="editBookForm" method="POST">
            <label>Book Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>

            <label>Image Filename:</label>
            <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($row['image']); ?>" required>

            <label>Price:</label>
            <p id="priceError" class="error-msg">Price must be a positive number.</p>
            <input type="number" step="0.01" id="price" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" required>

            <label>Category:</label>
            <input type="text" name="category" value="<?php echo htmlspecialchars($row['category']); ?>">

            <button type="submit" name="update_book">Update Book</button>
        </form>
        <br>
        <a href="manage_books.php">Cancel</a>
    </div>

    <script>
        document.getElementById('editBookForm').onsubmit = function(e) {
            const price = document.getElementById('price').value;
            const title = document.getElementById('title').value;
            const priceError = document.getElementById('priceError');

            // 1. Client-side Validation: Ensure price is not negative
            if (parseFloat(price) <= 0) {
                e.preventDefault(); // Stop form submission
                priceError.style.display = 'block';
                return false;
            } else {
                priceError.style.display = 'none';
            }

            // 2. Interaction: Confirmation Dialogue
            const confirmUpdate = confirm(`Are you sure you want to update "${title}"?`);
            if (!confirmUpdate) {
                e.preventDefault(); // Stop if user clicks 'Cancel'
                return false;
            }
        };

        // 3. UI Feedback: Change button text on click to prevent double-submissions
        document.querySelector('button[name="update_book"]').onclick = function() {
            if(document.getElementById('editBookForm').checkValidity()) {
                this.innerText = "Updating...";
                this.style.background = "#555";
            }
        };
    </script>
</body>
</html>