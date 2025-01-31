<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    // Redirect to login page if not logged in
    header("Location: SignIn.php");
    exit();
}

// Include the database connection (optional if you need data on the dashboard)
$host = "localhost";
$user = "root";
$pass = "";
$db = "ncrdb";
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Failed to connect to DB: " . $conn->connect_error);
}

// Example of fetching data (optional)
$sql = "SELECT COUNT(*) AS user_count FROM users";
$result = $conn->query($sql);
$data = $result->fetch_assoc();
$user_count = $data['user_count'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .welcome-message {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .card {
            display: inline-block;
            width: 250px;
            padding: 20px;
            margin: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .card h3 {
            margin-bottom: 10px;
        }
        .card p {
            font-size: 16px;
            color: #555;
        }
        .logout-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .logout-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <h1 class="welcome-message">Welcome, Admin!</h1>

    <div class="card">
        <h3>Total Users</h3>
        <p><?php echo $user_count; ?> users registered.</p>
    </div>

    <a href="logout.php" class="logout-btn">Logout</a>
</div>

</body>
</html>

<?php
$conn->close();
?>
