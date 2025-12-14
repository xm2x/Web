<?php
require_once 'config.php';

// Get all books for display
$sql = "SELECT id, title, author, description FROM books ORDER BY id DESC";
$booksResult = $conn->query($sql);
$books = [];
while ($row = $booksResult->fetch_assoc()) {
    $books[] = $row;
}
?>