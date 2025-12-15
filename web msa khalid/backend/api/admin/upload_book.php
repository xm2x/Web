<?php
require_once '../../config.php';

// Check if file was uploaded
if (!isset($_FILES['file'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'No file uploaded']);
    exit();
}

$file = $_FILES['file'];
$fileName = basename($file['name']);
$fileError = $file['error'];
$fileTmpName = $file['tmp_name'];
$fileSize = $file['size'];

// Validate file
if ($fileError !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Upload error: ' . $fileError]);
    exit();
}

// Validate file size (max 100MB for books)
$maxSize = 100 * 1024 * 1024;
if ($fileSize > $maxSize) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'File size exceeds 100MB limit']);
    exit();
}

// Validate file type
$allowedExtensions = ['pdf', 'epub', 'txt'];
$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

if (!in_array($fileExtension, $allowedExtensions)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid file type. Allowed: PDF, EPUB, TXT']);
    exit();
}

// Read file content as binary
$fileContent = @file_get_contents($fileTmpName);

if ($fileContent === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Could not read file']);
    exit();
}

// Extract book title from filename (remove extension)
$bookTitle = pathinfo($fileName, PATHINFO_FILENAME);
$bookTitle = str_replace(['-', '_'], ' ', $bookTitle);

// Encode file content safely
$encodedContent = base64_encode($fileContent);

// Return response
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'book_title' => $bookTitle,
    'file_name' => $fileName,
    'file_size' => $fileSize,
    'file_content' => $encodedContent,
    'file_extension' => $fileExtension
]);

$conn->close();
?>
