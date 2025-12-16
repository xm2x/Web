<?php
require_once '../config.php';

// Get pages for a specific chapter
$chapter_id = isset($_GET['chapter_id']) ? intval($_GET['chapter_id']) : 0;

if (!$chapter_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Chapter ID is required']);
    exit();
}

// Get pages for this chapter
$sql = "SELECT id, page_number, image_path FROM book_pages WHERE chapter_id = $chapter_id ORDER BY page_number";
$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Query failed: ' . $conn->error]);
    exit();
}

$pages = [];
while ($row = $result->fetch_assoc()) {
    $pages[] = $row;
}

echo json_encode(['success' => true, 'data' => $pages]);
$conn->close();
?>