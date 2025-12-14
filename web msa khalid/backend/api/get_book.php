<?php
require_once '../config.php';

// Get book by ID with chapters
$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$book_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Book ID is required']);
    exit();
}

// Get book details
$sql = "SELECT id, title, author, description, cover_image_path FROM books WHERE id = $book_id";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['error' => 'Book not found']);
    exit();
}

$book = $result->fetch_assoc();

// Get chapters for this book
$sql = "SELECT id, chapter_number, title FROM chapters WHERE book_id = $book_id ORDER BY chapter_number";
$result = $conn->query($sql);

$chapters = [];
while ($row = $result->fetch_assoc()) {
    $chapters[] = $row;
}

$book['chapters'] = $chapters;

echo json_encode(['success' => true, 'data' => $book]);
$conn->close();
?>
