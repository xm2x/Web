<?php
require_once '../config.php';

// Get JSON data
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['book_id']) || !isset($data['chapter_number']) || !isset($data['title'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'book_id, chapter_number, and title are required']);
    exit();
}

$book_id = intval($data['book_id']);
$chapter_number = intval($data['chapter_number']);
$title = $conn->real_escape_string($data['title']);

// Check if book exists
$checkSql = "SELECT id FROM books WHERE id = $book_id";
$checkResult = $conn->query($checkSql);
if (!$checkResult || $checkResult->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => 'Book not found']);
    exit();
}

$sql = "INSERT INTO chapters (book_id, chapter_number, title) 
        VALUES ($book_id, $chapter_number, '$title')";

if ($conn->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Chapter added successfully', 'chapter_id' => $conn->insert_id]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>
