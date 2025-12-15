<?php
require_once '../../config.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
    exit();
}

$bookId = intval($data['book_id'] ?? 0);
$chapterNumber = intval($data['chapter_number'] ?? 0);
$title = $conn->real_escape_string($data['title'] ?? '');
$fileContent = $data['file_content'] ?? null;
$fileName = $conn->real_escape_string($data['file_name'] ?? '');
$fileExtension = $conn->real_escape_string($data['file_extension'] ?? '');

if (!$bookId || !$chapterNumber || !$title) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Book ID, chapter number, and title are required']);
    exit();
}

// Verify book exists
$checkBook = $conn->query("SELECT id FROM books WHERE id=$bookId");
if ($checkBook->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => 'Book not found']);
    exit();
}

// Insert chapter
$sql = "INSERT INTO chapters (book_id, chapter_number, title, file_content, file_name, file_extension) 
        VALUES ($bookId, $chapterNumber, '$title', " . ($fileContent ? "'" . $conn->real_escape_string($fileContent) . "'" : "NULL") . ", '$fileName', '$fileExtension')";

if ($conn->query($sql) === TRUE) {
    $chapterId = $conn->insert_id;
    echo json_encode([
        'success' => true,
        'message' => 'Chapter added successfully',
        'chapter_id' => $chapterId
    ]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $conn->error]);
}

$conn->close();
?>
