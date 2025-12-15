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
$bookId = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;

// Validate book ID
if (!$bookId) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Book ID is required']);
    exit();
}

// Define upload directory for chapters
$uploadDir = '../../uploads/chapters/';

// Create directory if not exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Validate file
if ($fileError !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Upload error: ' . $fileError]);
    exit();
}

// Validate file size (max 500MB)
$maxSize = 500 * 1024 * 1024;
if ($fileSize > $maxSize) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'File size exceeds 500MB limit']);
    exit();
}

// Validate file type
$allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

if (!in_array($fileExtension, $allowedExtensions)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid file type. Allowed: PDF, JPG, PNG']);
    exit();
}

// Generate unique filename with book ID
$uniqueFileName = 'book_' . $bookId . '_' . time() . '_' . uniqid() . '.' . $fileExtension;
$destinationPath = $uploadDir . $uniqueFileName;

// Move uploaded file
if (move_uploaded_file($fileTmpName, $destinationPath)) {
    $relativePath = 'uploads/chapters/' . $uniqueFileName;
    
    echo json_encode([
        'success' => true,
        'message' => 'File uploaded successfully',
        'fileName' => $uniqueFileName,
        'file_path' => $relativePath
    ]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to save file']);
}

$conn->close();
?>
