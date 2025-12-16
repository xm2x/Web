<?php
session_start(); // Initialize the session

// Unset all of the session variables.
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page with a success message
header("Location: login.php?success=You have been logged out successfully.");
exit();
?>