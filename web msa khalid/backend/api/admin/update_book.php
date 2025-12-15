<?php
require_once '../../config.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Book ID is required']);
    exit();
}

$id = intval($data['id']);
$title = $conn->real_escape_string($data['title'] ?? '');
$author = $conn->real_escape_string($data['author'] ?? '');
$description = $conn->real_escape_string($data['description'] ?? '');

$sql = "UPDATE books SET title='$title', author='$author', description='$description' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Book updated successfully']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $conn->error]);
}

$conn->close();
?>
