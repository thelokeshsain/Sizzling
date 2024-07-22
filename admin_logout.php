<?php
// Start or resume the admin session
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to admin login page after logout
header("Location: admin.html");
exit;
?>
