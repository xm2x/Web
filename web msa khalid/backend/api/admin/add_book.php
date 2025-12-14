<?php
require_once '../config.php';

// Get JSON data
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['title']) || !isset($data['author'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Title and Author are required']);
    exit();
}

$title = $conn->real_escape_string($data['title']);
$author = $conn->real_escape_string($data['author']);
$description = isset($data['description']) ? $conn->real_escape_string($data['description']) : '';
$cover_path = isset($data['cover_image_path']) ? $conn->real_escape_string($data['cover_image_path']) : '';

$sql = "INSERT INTO books (title, author, description, cover_image_path) 
        VALUES ('$title', '$author', '$description', '$cover_path')";

if ($conn->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Book added successfully', 'book_id' => $conn->insert_id]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>
