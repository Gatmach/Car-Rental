<?php
// Start the session
session_start();

// Clear session variables
session_unset(); // Remove all session variables

// Destroy the session
session_destroy();

// Clear any session cookies (optional but good for security)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

// Send headers to prevent caching of this page (optional)
header("Cache-Control: no-cache, no-store, must-revalidate");  // Prevent caching of the page
header("Pragma: no-cache");
header("Expires: 0");

// Redirect to the login page
header("Location: SignIn.php");  // Redirect to login page
exit();
?>
