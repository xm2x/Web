<?php
require_once '../config.php';

// Get JSON data
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Chapter ID is required']);
    exit();
}

$chapter_id = intval($data['id']);

$sql = "DELETE FROM chapters WHERE id = $chapter_id";

if ($conn->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Chapter deleted successfully']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>
