<?php
// Start the session
session_start();

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: sign_in.php");
    exit();
}

// Get the admin's name from the session (assuming 'username' holds the admin's name)
$admin_name = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('your-background-image.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            margin: 0;
        }

        .dashboard-container {
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            padding: 50px;
            border-radius: 10px;
            max-width: 500px;
            width: 100%;
        }

        .dashboard-container h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .get-started-btn {
            background-color: #007bff;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .get-started-btn:hover {
            background-color: #0056b3;
        }

        .logout-btn {
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            border-radius: 5px;
            margin-top: 20px;
            text-decoration: none;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <h1>Welcome, <?php echo htmlspecialchars($admin_name); ?>!</h1>
        <p>You're logged in as an admin. Get started with managing your platform.</p>
        <a href="get_started.php" class="get-started-btn">Get Started</a>
        <br><br>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

</body>
</html>
