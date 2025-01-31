<?php
// Start the session to access session data
session_start();

// Database connection details
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "ncrdb"; // Your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle approval request
if (isset($_POST['approve'])) {
    $bookingId = $_POST['booking_id']; // Get the booking ID from the form submission
    $updateSql = "UPDATE bookings SET status = 'Approved' WHERE id = ?";
    
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param('i', $bookingId); // Bind the booking ID as an integer
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = "Booking approved successfully.";
    } else {
        $_SESSION['message'] = "Error updating booking status.";
    }
    $stmt->close();
}

// Query to fetch approved booking data from the database
$sql = "SELECT id, car_model, username, location_name, booking_date, pickup_date, status, payment_method, amount_paid FROM bookings WHERE status = 'Approved'";

// Execute the query
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Store results in the session
    $_SESSION['bookings'] = [];
    while ($row = $result->fetch_assoc()) {
        $_SESSION['bookings'][] = $row;
    }
} else {
    // Handle case if no approved bookings found
    $_SESSION['bookings'] = [];
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Car Booking Approval</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("assets/experience1.png"); /* Replace with your image URL */
            background-size: cover;
            background-position: center;
            color: white;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        h1 {
            text-align: center;
            font-size: 36px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: white;
            font-size: 18px;
        }

        td {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .return-btn {
            display: inline-block;
            margin: 20px;
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s;
        }

        .return-btn:hover {
            background-color: #0056b3;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button-container a {
            margin: 0 15px;
        }

        @media (max-width: 768px) {
            table {
                width: 95%;
            }

            th, td {
                font-size: 14px;
            }

            .return-btn {
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
    <h1>Approved Car Bookings</h1>

    <?php
    // Display message if there was an update to the approval status
    if (isset($_SESSION['message'])) {
        echo "<p style='color:green; text-align:center;'>{$_SESSION['message']}</p>";
        unset($_SESSION['message']);
    }
    ?>

    <table id="bookingTable">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Car</th>
                <th>Customer Name</th>
                <th>Location</th>
                <th>Booking Date</th>
                <th>Pickup Date</th>
                <th>Status</th>
                <th>Payment Method</th>
                <th>Amount Paid</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($_SESSION['bookings']) && count($_SESSION['bookings']) > 0): ?>
                <?php foreach ($_SESSION['bookings'] as $booking): ?>
                    <tr id="booking-<?php echo htmlspecialchars($booking['id']); ?>">
                        <td><?php echo htmlspecialchars($booking['id']); ?></td>
                        <td><?php echo htmlspecialchars($booking['car_model']); ?></td>
                        <td><?php echo htmlspecialchars($booking['username']); ?></td>
                        <td><?php echo htmlspecialchars($booking['location_name']); ?></td>
                        <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                        <td><?php echo htmlspecialchars($booking['pickup_date']); ?></td>
                        <td><?php echo htmlspecialchars($booking['status']); ?></td>
                        <td><?php echo htmlspecialchars($booking['payment_method']); ?></td>
                        <td><?php echo htmlspecialchars($booking['amount_paid']); ?></td>
                        <td>
                            <!-- Approval Button -->
                            <?php if ($booking['status'] !== 'Approved'): ?>
                                <form method="post" action="">
                                    <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                    <button type="submit" name="approve" class="return-btn">Approve</button>
                                </form>
                            <?php else: ?>
                                Approved
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">No approved bookings found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="button-container">
        <a href="admin_dashboard.php" class="return-btn">Return to Dashboard</a>
        <a href="approval.php" class="return-btn">Return to Approval</a>
    </div>

</body>
</html>
