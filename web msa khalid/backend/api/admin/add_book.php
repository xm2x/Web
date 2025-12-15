<?php
require_once '../../config.php';

header('Content-Type: application/json');

// Get JSON data
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid JSON data']);
    exit();
}

$title = isset($data['title']) ? trim($data['title']) : '';
$author = isset($data['author']) ? trim($data['author']) : '';
$description = isset($data['description']) ? trim($data['description']) : '';
$fileContent = isset($data['file_content']) ? $data['file_content'] : null;
$fileName = isset($data['file_name']) ? trim($data['file_name']) : '';
$fileExtension = isset($data['file_extension']) ? trim($data['file_extension']) : '';
$fileSize = isset($data['file_size']) ? intval($data['file_size']) : 0;

if (!$title || !$author) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Title and author are required']);
    exit();
}

// Escape strings
$title = $conn->real_escape_string($title);
$author = $conn->real_escape_string($author);
$description = $conn->real_escape_string($description);
$fileName = $conn->real_escape_string($fileName);
$fileExtension = $conn->real_escape_string($fileExtension);

// Handle file content - it's base64 encoded
$fileContentSQL = "NULL";
if ($fileContent && !empty($fileContent)) {
    $fileContent = $conn->real_escape_string($fileContent);
    $fileContentSQL = "'$fileContent'";
}

// Build SQL query carefully
$sql = "INSERT INTO books (title, author, description, file_content, file_name, file_extension, file_size) VALUES (
    '$title',
    '$author',
    '$description',
    $fileContentSQL,
    '$fileName',
    '$fileExtension',
    $fileSize
)";

if ($conn->query($sql) === TRUE) {
    echo json_encode([
        'success' => true,
        'message' => 'Book added successfully',
        'book_id' => $conn->insert_id
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $conn->error,
        'hint' => 'Make sure books table has: file_content, file_name, file_extension, file_size columns'
    ]);
}

$conn->close();
?>
