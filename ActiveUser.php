<?php
// Start the session
session_start();

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: sign_in.php");
    exit();
}

// Database connection parameters
$host = "localhost";
$user = "root";
$pass = "";
$db = "ncrdb";

// Establish database connection
$conn = new mysqli($host, $user, $pass, $db);

// Check for successful connection
if ($conn->connect_error) {
    die("Failed to connect to DB: " . $conn->connect_error);
}

// Handle deactivating a user
if (isset($_GET['action']) && $_GET['action'] === 'deactivate' && isset($_GET['UID'])) {
    $UID = $_GET['UID'];

    // SQL query to update the user status to 'inactive'
    $sql_deactivate = "UPDATE users SET status = 'inactive' WHERE UID = ?";
    $stmt = $conn->prepare($sql_deactivate);
    $stmt->bind_param("i", $UID);

    if ($stmt->execute()) {
        // Redirect back to the page after deactivating
        header("Location: active_users.php");
        exit();
    } else {
        echo "Error deactivating user.";
    }

    // Close the statement
    $stmt->close();
}

// Fetch active users from the database (assuming 'status' column in users table)
$sql_active_users = "SELECT UID, firstname, lastname, email, role FROM users WHERE status = 'active'";
$result_active_users = $conn->query($sql_active_users);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Users - AdminHub</title>

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("assets/experience1.png"); /* Background image */
            background-size: cover;  /* Ensure the image covers the entire page */
            background-position: center; /* Center the image */
            background-attachment: fixed; /* Fixed background when scrolling */
            background-color: #f0f0f0;  /* Fallback background color */
            color: #333; /* Text color for better readability */
        }

        #content {
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Transparent white background */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px; /* Rounded corners */
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .table-data {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }

        .return-btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            display: inline-block;
            text-align: center;
        }

        .return-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<!-- CONTENT -->
<section id="content">
    <h1>Active Users</h1>

    <div class="table-data">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $result_active_users->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $user['UID']; ?></td>
                        <td><?php echo $user['firstname']; ?></td>
                        <td><?php echo $user['lastname']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td>
                            <a href="edit_user.php?UID=<?php echo $user['UID']; ?>">Edit</a> |
                            <a href="active_users.php?action=deactivate&UID=<?php echo $user['UID']; ?>" onclick="return confirm('Are you sure you want to deactivate this user?')">Deactivate</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Return to Dashboard Button -->
    <a href="admin_dashboard.php" class="return-btn">Return to Dashboard</a>
</section>

<script src="script.js"></script>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
