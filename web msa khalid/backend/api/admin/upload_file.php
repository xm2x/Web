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

// Define upload directory
$uploadDir = '../../uploads/';
$uploadPath = realpath($uploadDir);

// Create directory if not exists
if (!is_dir($uploadPath)) {
    mkdir($uploadPath, 0755, true);
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
$allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'epub'];
$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

if (!in_array($fileExtension, $allowedExtensions)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid file type. Allowed: PDF, JPG, PNG, EPUB']);
    exit();
}

// Generate unique filename
$uniqueFileName = time() . '_' . uniqid() . '.' . $fileExtension;
$destinationPath = $uploadPath . $uniqueFileName;

// Move uploaded file
if (move_uploaded_file($fileTmpName, $destinationPath)) {
    // Extract book info from filename (optional - can be used for auto-categorization)
    // For now, we'll just store it as a file reference
    
    $relativePath = 'uploads/' . $uniqueFileName;
    
    // Insert book record or update if needed
    // This assumes books are created via direct insertion
    $title = pathinfo($fileName, PATHINFO_FILENAME);
    $author = 'Unknown';
    
    $title = $conn->real_escape_string($title);
    $author = $conn->real_escape_string($author);
    $relativePath = $conn->real_escape_string($relativePath);
    
    // Check if book with similar title already exists
    $checkSql = "SELECT id FROM books WHERE title LIKE '%$title%' LIMIT 1";
    $checkResult = $conn->query($checkSql);
    
    if ($checkResult && $checkResult->num_rows > 0) {
        // Book exists, just return success
        echo json_encode([
            'success' => true,
            'message' => 'File uploaded successfully',
            'fileName' => $uniqueFileName,
            'path' => $relativePath
        ]);
    } else {
        // Create new book entry
        $sql = "INSERT INTO books (title, author, cover_image_path) 
                VALUES ('$title', '$author', '$relativePath')";
        
        if ($conn->query($sql)) {
            $bookId = $conn->insert_id;
            echo json_encode([
                'success' => true,
                'message' => 'File uploaded and book created successfully',
                'fileName' => $uniqueFileName,
                'path' => $relativePath,
                'book_id' => $bookId
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Database error: ' . $conn->error]);
        }
    }
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to save file']);
}

$conn->close();
?>
