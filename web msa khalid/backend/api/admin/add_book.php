<?php
require_once '../../config.php';

// Get JSON data
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
    exit();
}

$title = $conn->real_escape_string($data['title'] ?? '');
$author = $conn->real_escape_string($data['author'] ?? '');
$description = $conn->real_escape_string($data['description'] ?? '');
$fileContent = $data['file_content'] ?? null;
$fileName = $conn->real_escape_string($data['file_name'] ?? '');
$fileExtension = $conn->real_escape_string($data['file_extension'] ?? '');
$fileSize = $data['file_size'] ?? 0;

if (!$title || !$author) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Title and author are required']);
    exit();
}

// Decode file content from base64
$fileContentBinary = null;
if ($fileContent) {
    $fileContentBinary = base64_decode($fileContent);
}

// Insert book into database
$sql = "INSERT INTO books (title, author, description, file_content, file_name, file_extension, file_size) 
        VALUES ('$title', '$author', '$description', " . ($fileContent ? "'" . $conn->real_escape_string($fileContent) . "'" : "NULL") . ", '$fileName', '$fileExtension', $fileSize)";

if ($conn->query($sql) === TRUE) {
    $bookId = $conn->insert_id;
    echo json_encode([
        'success' => true,
        'message' => 'Book added successfully',
        'book_id' => $bookId
    ]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $conn->error]);
}

$conn->close();
?>
