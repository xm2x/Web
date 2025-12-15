<?php
// Database Configuration
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'bookstore_db';

// Create connection
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]));
}

header('Content-Type: application/json');

// Array of SQL commands to run
$updates = [
    "ALTER TABLE books ADD COLUMN IF NOT EXISTS file_content LONGBLOB DEFAULT NULL",
    "ALTER TABLE books ADD COLUMN IF NOT EXISTS file_name VARCHAR(255) DEFAULT NULL",
    "ALTER TABLE books ADD COLUMN IF NOT EXISTS file_extension VARCHAR(10) DEFAULT NULL",
    "ALTER TABLE books ADD COLUMN IF NOT EXISTS file_size INT DEFAULT NULL",
    "ALTER TABLE chapters ADD COLUMN IF NOT EXISTS file_content LONGBLOB DEFAULT NULL",
    "ALTER TABLE chapters ADD COLUMN IF NOT EXISTS file_name VARCHAR(255) DEFAULT NULL",
    "ALTER TABLE chapters ADD COLUMN IF NOT EXISTS file_extension VARCHAR(10) DEFAULT NULL",
    "ALTER TABLE chapters ADD COLUMN IF NOT EXISTS file_size INT DEFAULT NULL"
];

$results = [];
$allSuccess = true;

foreach ($updates as $sql) {
    if ($conn->query($sql)) {
        $results[] = ['sql' => $sql, 'success' => true, 'message' => 'Column added or already exists'];
    } else {
        $allSuccess = false;
        $results[] = ['sql' => $sql, 'success' => false, 'error' => $conn->error];
    }
}

// Get columns to verify
$booksColumns = [];
$chaptersColumns = [];

$booksResult = $conn->query("SHOW COLUMNS FROM books");
if ($booksResult) {
    while ($row = $booksResult->fetch_assoc()) {
        $booksColumns[] = $row['Field'];
    }
}

$chaptersResult = $conn->query("SHOW COLUMNS FROM chapters");
if ($chaptersResult) {
    while ($row = $chaptersResult->fetch_assoc()) {
        $chaptersColumns[] = $row['Field'];
    }
}

$conn->close();

echo json_encode([
    'success' => $allSuccess,
    'updates' => $results,
    'verification' => [
        'books_table_columns' => $booksColumns,
        'chapters_table_columns' => $chaptersColumns,
        'has_file_content_books' => in_array('file_content', $booksColumns),
        'has_file_name_books' => in_array('file_name', $booksColumns),
        'has_file_extension_books' => in_array('file_extension', $booksColumns),
        'has_file_size_books' => in_array('file_size', $booksColumns),
        'has_file_content_chapters' => in_array('file_content', $chaptersColumns),
        'has_file_name_chapters' => in_array('file_name', $chaptersColumns),
        'has_file_extension_chapters' => in_array('file_extension', $chaptersColumns),
        'has_file_size_chapters' => in_array('file_size', $chaptersColumns)
    ]
]);
?>
