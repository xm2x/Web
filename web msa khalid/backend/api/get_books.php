<?php
require_once '../config.php';

// Get all books
$sql = "SELECT id, title, author, description, cover_image_path FROM books ORDER BY id DESC";
$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Query failed: ' . $conn->error]);
    exit();
}

$books = [];
while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}

echo json_encode(['success' => true, 'data' => $books]);
$conn->close();
?>
