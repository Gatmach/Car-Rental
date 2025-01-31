<?php
// Start the session to access session data
session_start();

// Check if a booking ID is passed through the URL
if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

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

    // Query to fetch booking details by booking ID
    $sql = "SELECT b.id, b.car_model, b.username, b.location_name, b.pickup_date, b.payment_method, b.amount_paid, b.status, r.location_name 
            FROM bookings b
            JOIN rental_spots r ON b.RID = r.RID
            WHERE b.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();

    if ($booking) {
        // Store booking details in session if needed
        $_SESSION['booking'] = $booking;
    } else {
        // Redirect to home if the booking is not found
        header('Location: home.php');
        exit();
    }
    $conn->close();
} else {
    // Redirect to home if no booking ID is provided
    header('Location: home.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('assets/experience1.png'); /* Replace with your image URL */
            background-size: cover;
            background-position: center;
            color: white;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 80%;
            background-color: rgba(0, 0, 0, 0.7); /* Transparent background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .booking-details {
            margin: 20px 0;
            font-size: 18px;
        }

        .button-container {
            margin-top: 20px;
        }

        .return-btn {
            display: inline-block;
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

        @media (max-width: 768px) {
            .container {
                width: 95%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thank You for Booking With Us!</h1>

        <div class="booking-details">
            <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($booking['id']); ?></p>
            <p><strong>Car Model:</strong> <?php echo htmlspecialchars($booking['car_model']); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($booking['location_name']); ?></p>
            <p><strong>Pickup Date:</strong> <?php echo htmlspecialchars(date('l, F j, Y', strtotime($booking['pickup_date']))); ?></p>
            <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($booking['payment_method']); ?></p>
            <p><strong>Amount Paid:</strong> <?php echo htmlspecialchars($booking['amount_paid']); ?> Ksh</p>
        </div>

        <div class="button-container">
            <a href="home.php" class="return-btn">Return to Home</a>
            <a href="logout.php" class="return-btn">Log Out</a>
        </div>
    </div>
</body>
</html>
