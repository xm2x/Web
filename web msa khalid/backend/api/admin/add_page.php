<?php
require_once '../config.php';

// Get JSON data
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['chapter_id']) || !isset($data['page_number']) || !isset($data['image_path'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'chapter_id, page_number, and image_path are required']);
    exit();
}

$chapter_id = intval($data['chapter_id']);
$page_number = intval($data['page_number']);
$image_path = $conn->real_escape_string($data['image_path']);

// Check if chapter exists
$checkSql = "SELECT id FROM chapters WHERE id = $chapter_id";
$checkResult = $conn->query($checkSql);
if (!$checkResult || $checkResult->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => 'Chapter not found']);
    exit();
}

$sql = "INSERT INTO book_pages (chapter_id, page_number, image_path) 
        VALUES ($chapter_id, $page_number, '$image_path')";

if ($conn->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Page added successfully', 'page_id' => $conn->insert_id]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>
