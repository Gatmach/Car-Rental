<?php
session_start();

// Regenerate session ID to prevent session fixation attacks (done after login)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');  // Redirect to login if not logged in or not admin
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="dashboard-container">
    <h2>Admin Dashboard</h2>
    
    <?php
    // Check if the 'username' session variable is set and sanitize it for safe output
    if (isset($_SESSION['username'])) {
        echo '<p>Welcome, ' . htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') . '!</p>';
    } else {
        echo '<p>Welcome, Admin!</p>';
    }
    ?>
    
    <p><a href="manage_users.php">Manage Users</a></p>
    <p><a href="logout.php">Logout</a></p>
</div>

</body>
</html>
