<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "book_space_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get search query or category filter from the URL
$search = isset($_GET['query']) ? $_GET['query'] : '';
$cat = isset($_GET['category']) ? $_GET['category'] : '';

// Build the SQL Query
$sql = "SELECT * FROM books WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND (title LIKE '%$search%' OR author LIKE '%$search%')";
}
if (!empty($cat) && $cat != 'all') {
    $sql .= " AND category = '$cat'";
}

$result = $conn->query($sql);
?>

<section class="main">
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="card" 
                data-title="<?php echo $row['title']; ?>" 
                data-author="<?php echo $row['author']; ?>" 
                data-description="<?php echo $row['description']; ?>" 
                data-preview="preview.php?id=<?php echo $row['id']; ?>">
                <img src="images/<?php echo $row['image']; ?>" alt="book">
                <h3><?php echo $row['title']; ?></h3>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No books found.</p>
    <?php endif; ?>
</section>
