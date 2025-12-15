<?php
// This is a DEBUG version to help us see what's happening
header('Content-Type: application/json');

// Log everything to help debug
$logFile = __DIR__ . '/../../upload_debug.log';

// Get request data
$data = json_decode(file_get_contents("php://input"), true);
$files = $_FILES;

// Log the request
$log = "\n\n=== NEW REQUEST ===\n";
$log .= date('Y-m-d H:i:s') . "\n";
$log .= "POST Data: " . json_encode($data) . "\n";
$log .= "FILES: " . json_encode($files) . "\n";

file_put_contents($logFile, $log, FILE_APPEND);

// Test database connection
require_once '../../config.php';

$log = "Database Connected: " . (isset($conn) ? "YES" : "NO") . "\n";

// Check if books table has the required columns
$result = $conn->query("DESCRIBE books");
$columns = [];
while ($row = $result->fetch_assoc()) {
    $columns[] = $row['Field'];
}

$log .= "Books table columns: " . json_encode($columns) . "\n";

// Check if required columns exist
$requiredColumns = ['file_content', 'file_name', 'file_extension', 'file_size'];
$missingColumns = [];
foreach ($requiredColumns as $col) {
    if (!in_array($col, $columns)) {
        $missingColumns[] = $col;
    }
}

$log .= "Missing columns: " . json_encode($missingColumns) . "\n";

file_put_contents($logFile, $log, FILE_APPEND);

// Return debug info
echo json_encode([
    'success' => false,
    'debug_info' => [
        'database_connected' => isset($conn),
        'books_columns' => $columns,
        'missing_columns' => $missingColumns,
        'post_data_received' => !empty($data),
        'file_received' => !empty($files)
    ],
    'error' => count($missingColumns) > 0 ? 'Missing database columns: ' . implode(', ', $missingColumns) : 'Check log file'
]);

$conn->close();
?>
