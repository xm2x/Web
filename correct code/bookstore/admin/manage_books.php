<?php
session_start();
// Connect to DB
$conn = new mysqli("localhost", "root", "", "bookstore_db");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// === 1. HANDLE ADD BOOK (CREATE) ===
if (isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    
    // --- FILE UPLOAD LOGIC ---
    $image_filename = ""; // Default if empty

    // Check if a file was uploaded
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
        
        // 1. Get the file details
        $file_name = $_FILES['image_file']['name'];
        $file_tmp = $_FILES['image_file']['tmp_name'];
        
        // 2. Decide where to save it (In your main_page folder)
        // Note: We go back one folder (..) then into main_page
        $target_dir = "../main page/";
        $target_file = $target_dir . basename($file_name);

        // 3. Move the file from temporary space to your folder
        if (move_uploaded_file($file_tmp, $target_file)) {
            // Success! We save JUST the filename to the database
            $image_filename = $file_name;
        } else {
            $error = "Failed to upload image.";
        }
    }

    // Only insert if we have a filename (or you can allow empty)
    if (!empty($image_filename)) {
        $sql = "INSERT INTO products (title, image, price, category) VALUES ('$title', '$image_filename', '$price', '$category')";
        if ($conn->query($sql) === TRUE) {
            $msg = "New book added successfully!";
        } else {
            $error = "Database Error: " . $conn->error;
        }
    } else {
        $error = "Please upload an image.";
    }
}

// === 2. HANDLE DELETE BOOK (DELETE) ===
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM products WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        $msg = "Book deleted successfully!";
    } else {
        $error = "Error deleting record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Books - Admin</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background-color: #f4f4f4; }
        
        /* Form Styling */
        .form-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); max-width: 500px; margin: 0 auto; }
        input[type="text"], input[type="number"], select { width: 100%; padding: 10px; margin: 5px 0 15px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;}
        button { background: #28a745; color: white; padding: 12px; border: none; cursor: pointer; width: 100%; border-radius: 5px; font-size: 16px; }
        button:hover { background: #218838; }

        /* Drag & Drop Zone Styling */
        .drop-zone {
            width: 100%;
            height: 150px;
            border: 2px dashed #007bff;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #007bff;
            margin-bottom: 15px;
            cursor: pointer;
            background-color: #f8faff;
            transition: 0.3s;
            position: relative;
        }
        
        .drop-zone:hover, .drop-zone.dragover {
            background-color: #e0edff;
            border-color: #0056b3;
        }

        .drop-zone p { pointer-events: none; margin: 0; padding: 10px; }
        .drop-zone input { display: none; } /* Hide the real checkbox */
        .preview-img { max-height: 100%; max-width: 100%; display: none; position: absolute; }

        /* Table Styling */
        table { width: 100%; border-collapse: collapse; margin-top: 30px; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #333; color: white; }
        .btn-delete { background: #dc3545; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; }
        .btn-edit { background: #007bff; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; }
        .msg { color: green; font-weight: bold; text-align: center; }
        .err { color: red; font-weight: bold; text-align: center; }
    </style>
</head>
<body>

    <h1 style="text-align:center;">Admin: Manage Books</h1>
    <div style="text-align:center; margin-bottom: 20px;">
        <a href="../main page/main_page.php" style="text-decoration:none; color:#007bff;">&larr; Go Back to Website</a>
    </div>

    <?php if(isset($msg)) { echo "<p class='msg'>$msg</p>"; } ?>
    <?php if(isset($error)) { echo "<p class='err'>$error</p>"; } ?>

    <div class="form-container">
        <h3 style="margin-top:0;">Add New Book</h3>
        
        <form method="POST" enctype="multipart/form-data">
            
            <label>Book Title:</label>
            <input type="text" name="title" required placeholder="Enter book title">

            <label>Upload Image:</label>
            <div class="drop-zone" id="dropZone">
                <p>Drag & Drop Image Here<br>or Click to Browse</p>
                <input type="file" name="image_file" id="fileInput" accept="image/*" required>
                <img id="preview" class="preview-img">
            </div>

            <label>Price ($):</label>
            <input type="number" step="0.01" name="price" required placeholder="0.00">

            <label>Category:</label>
            <select name="category">
                <option value="General">General</option>
                <option value="Fiction">Fiction</option>
                <option value="Sci-Fi">Sci-Fi</option>
                <option value="Business">Business</option>
                <option value="Design">Design</option>
                <option value="Art">Art</option>
            </select>

            <button type="submit" name="add_book">Add Book</button>
        </form>
    </div>

    <h3>Existing Books</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM products ORDER BY id DESC");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                // Display image from main_page folder
                echo "<td><img src='../main_page/" . htmlspecialchars($row['image']) . "' width='50' style='border-radius:4px;'></td>";
                echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                echo "<td>$" . htmlspecialchars($row['price']) . "</td>";
                echo "<td>
                        <a href='edit_book.php?id=" . $row['id'] . "' class='btn-edit'>Edit</a>
                        <a href='manage_books.php?delete_id=" . $row['id'] . "' class='btn-delete' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const preview = document.getElementById('preview');
        const promptText = dropZone.querySelector('p');

        // 1. Click to Open
        dropZone.addEventListener('click', () => fileInput.click());

        // 2. Drag Over (Add visual effect)
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });

        // 3. Drag Leave (Remove visual effect)
        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('dragover');
        });

        // 4. Drop File
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');

            // Get the dropped files
            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files; // Assign to hidden input
                showPreview(e.dataTransfer.files[0]);
            }
        });

        // 5. Normal File Selection
        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) {
                showPreview(fileInput.files[0]);
            }
        });

        // Helper to show the image preview
        function showPreview(file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.style.display = 'block';
                promptText.style.display = 'none'; // Hide text
            };
            reader.readAsDataURL(file);
        }
    </script>

</body>
</html>