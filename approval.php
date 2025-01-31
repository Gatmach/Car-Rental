<?php
// Start session for user-based functionality
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // replace with your db username
$password = ""; // replace with your db password
$dbname = "ncrdb"; // replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the bookings table
$sql = "SELECT 
            b.id, 
            b.username, 
            b.RID,  -- Replacing location_id with RID
            b.booking_date, 
            b.pickup_date, 
            b.status, 
            r.location_name,  -- location_name now corresponds to RID
            b.payment_method, 
            b.payment_number, 
            b.amount_paid
        FROM bookings b
        JOIN rental_spots r ON b.RID = r.RID  -- Joining with rental_spots on RID instead of location_id
        WHERE b.status = 'Pending'"; // Only fetching pending bookings

$result = $conn->query($sql);

// Check if the query was successful and if there are any results
if ($result->num_rows > 0) {
    // Store the fetched data in the session for later use
    $_SESSION['bookings'] = [];
    while ($row = $result->fetch_assoc()) {
        $_SESSION['bookings'][] = $row;
    }
} else {
    $_SESSION['bookings'] = [];  // If no pending bookings, store empty array
}

// Handle approve/reject requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookingId = $_POST['id'];
    $status = $_POST['status'];

    // Update the booking status in the database
    $update_sql = "UPDATE bookings SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $status, $bookingId);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'bookingId' => $bookingId]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update booking status']);
    }
    
    exit;
}

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
            background-image: url("assets/experience1.png");
            background-size: cover;
            background-position: center;
            color: white;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 8px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        button {
            margin: 5px;
            padding: 5px 10px;
            cursor: pointer;
            background-color: #28a745;
            border: none;
            color: white;
            border-radius: 5px;
        }

        button:hover {
            background-color: #218838;
        }

        .return-btn {
            display: inline-block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
        }

        .return-btn:hover {
            background-color: #0056b3;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button-container a {
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <h1>Car Booking Approval</h1>

    <table id="bookingTable">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Customer Name</th>
                <th>Location</th>
                <th>Booking Date</th>
                <th>Pickup Date</th>
                <th>Status</th>
                <th>Payment Method</th>
                <th>Amount Paid</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['bookings'] as $booking): ?>
                <tr id="booking-<?php echo $booking['id']; ?>">
                    <td><?php echo $booking['id']; ?></td>
                    <td><?php echo $booking['username']; ?></td>
                    <td><?php echo $booking['location_name']; ?></td>
                    <td><?php echo $booking['booking_date']; ?></td>
                    <td><?php echo $booking['pickup_date']; ?></td>
                    <td id="status-<?php echo $booking['id']; ?>"><?php echo $booking['status']; ?></td>
                    <td><?php echo $booking['payment_method']; ?></td>
                    <td><?php echo $booking['amount_paid']; ?></td>
                    <td>
                        <button onclick="approveBooking(<?php echo $booking['id']; ?>)">Approve</button>
                        <button onclick="rejectBooking(<?php echo $booking['id']; ?>)">Reject</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="button-container">
        <a href="admin_dashboard.php" class="return-btn">Return to Dashboard</a>
    </div>

    <script>
        function approveBooking(bookingId) {
            updateBookingStatus(bookingId, 'Approved');
        }

        function rejectBooking(bookingId) {
            updateBookingStatus(bookingId, 'Rejected');
        }

        function updateBookingStatus(bookingId, status) {
            var xhr = new XMLHttpRequest();
            var params = "id=" + bookingId + "&status=" + status;

            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        var bookingRow = document.getElementById("booking-" + response.bookingId);
                        bookingRow.parentNode.removeChild(bookingRow);
                        alert('Booking ' + status);
                    }
                }
            };

            xhr.send(params);
        }
    </script>
</body>
</html>
