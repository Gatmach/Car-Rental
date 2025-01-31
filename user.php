<?php
session_start();

// Regenerate session ID to prevent session fixation attacks
if (!isset($_SESSION['user_id'])) {
    // Redirect if the user is not logged in
    header('Location: login.php');  // Assuming login.php is the correct page for login
    exit();
}

// Check if the user has the correct role ('user')
if ($_SESSION['role'] !== 'user') {
    // Redirect to a page for unauthorized users, like an error page or login page
    header('Location: login.php');  // You might want to show an error message
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="dashboard-container">
    <h2>User Dashboard</h2>
    
    <?php
    // Check if username is set in the session before displaying it
    if (isset($_SESSION['username'])) {
        echo '<p>Welcome, ' . htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') . '!</p>';
    } else {
        echo '<p>Welcome, User!</p>';
    }
    ?>

    <p><a href="view_bookings.php">View Bookings</a></p>
    <p><a href="logout.php">Logout</a></p>
</div>

</body>
</html>
