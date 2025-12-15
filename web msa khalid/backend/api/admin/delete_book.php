<?php
require_once '../../config.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Book ID is required']);
    exit();
}

$id = intval($data['id']);

// Delete all chapters first (cascade delete)
$conn->query("DELETE FROM chapters WHERE book_id=$id");

// Then delete the book
$sql = "DELETE FROM books WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Book and chapters deleted successfully']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $conn->error]);
}

$conn->close();
?>
