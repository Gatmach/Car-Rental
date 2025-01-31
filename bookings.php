<?php
session_start();
include('connect.php'); // Include your database connection file

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
$locationsQuery = "SELECT * FROM rental_spots";
$locationsResult = $conn->query($locationsQuery);

// Initialize error and success messages
$errorMessage = '';
$successMessage = '';

// Handle booking submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $location_name = $_POST['location_name'];
    $pickup_date = $_POST['pickup_date'];
    $payment_method = $_POST['payment_method'];

    // Sanitize and validate inputs
    if (empty($location_name) || empty($pickup_date) || empty($payment_method)) {
        $errorMessage = "Please fill all required fields.";
    } else {
        // Validate the date format for the pickup date (optional)
        $pickup_date_timestamp = strtotime($pickup_date);
        if ($pickup_date_timestamp === false) {
            $errorMessage = "Invalid pickup date.";
        } else {
            // Insert into database
            $query = "INSERT INTO bookings (username, location_name, pickup_date, payment_method) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssss", $username, $location_name, $pickup_date, $payment_method);
            if ($stmt->execute()) {
                $successMessage = "Booking successfully made!";
            } else {
                $errorMessage = "Error making booking: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

// Handle booking cancellation
if (isset($_GET['cancel_booking_id']) && is_numeric($_GET['cancel_booking_id'])) {
    $cancel_booking_id = $_GET['cancel_booking_id'];
    $deleteQuery = "DELETE FROM bookings WHERE id = ? AND username = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param('is', $cancel_booking_id, $username);
    if ($stmt->execute()) {
        header('Location: home.php?cancel_success=true');
        exit();
    } else {
        $errorMessage = "Error deleting booking: " . $stmt->error;
    }
}

// Handle booking confirmation
if (isset($_GET['confirm_booking_id']) && is_numeric($_GET['confirm_booking_id'])) {
    $confirm_booking_id = $_GET['confirm_booking_id'];
    $updateQuery = "UPDATE bookings SET status = 'confirmed' WHERE id = ? AND username = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('is', $confirm_booking_id, $username);
    if ($stmt->execute()) {
        $successMessage = "Booking confirmed successfully!";
    } else {
        $errorMessage = "Error confirming booking: " . $stmt->error;
    }
}

// Fetch bookings for the logged-in user
$bookingsQuery = "
    SELECT b.id, b.car_model, b.RID, b.pickup_date, b.payment_method, b.location_name, b.status
    FROM bookings b
    WHERE b.username = ?
";
$stmt = $conn->prepare($bookingsQuery);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$noBookingsMessage = ($result->num_rows === 0) ? "<p>You have no bookings yet. Please make a booking.</p>" : "";

// HTML Structure
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-image: url('your-image-url.jpg'); /* Add your image URL here */
            background-size: cover;
            background-position: center;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.6); /* Transparent black background for readability */
            border-radius: 10px;
        }

        .section_container {
            margin-top: 20px;
        }

        .section_header {
            font-size: 2em;
            margin-bottom: 20px;
            color: #fff;
            text-align: center;
            font-weight: bold;
        }

        .booking_card {
            background-color: rgba(0, 0, 0, 0.8); /* Transparent black background for cards */
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #444;
            color: #fff;
        }

        td {
            background-color: #555;
        }

        .button {
            background-color: #4CAF50; /* Green background */
            color: white;
            padding: 10px 15px;
            border: none;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .button:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        .car-details {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .car-details table {
            margin-top: 20px;
        }

        input[type="date"], input[type="text"], input[type="number"], input[type="submit"] {
            padding: 10px;
            width: 100%;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #4CAF50; /* Green background */
            color: white;
            cursor: pointer;
            border: none;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

    </style>
</head>
<body>

<div class="container">
    <h2 class="section_header">Booking Form</h2>
    
    <?php if (!empty($successMessage)) echo "<p style='color:green;'>$successMessage</p>"; ?>
    <?php if (!empty($errorMessage)) echo "<p style='color:red;'>$errorMessage</p>"; ?>

    <form method="POST">
        <select name="location_name" required>
            <option value="">Select Location</option>
            <?php while ($row = $locationsResult->fetch_assoc()) {
                echo "<option value='".htmlspecialchars($row['location_name'])."'>".htmlspecialchars($row['location_name'])."</option>";
            } ?>
        </select>
        <input type="datetime-local" name="pickup_date" required>
        <select name="payment_method" required>
            <option value="M-Pesa">M-Pesa</option>
            <option value="Cash">Cash</option>
            <option value="Credit Card">Credit Card</option>
        </select>
        <button type="submit">Proceed to Hire</button>
    </form>

    <h2 class="section_header">Your Bookings</h2>
    <?php if ($noBookingsMessage): ?>
        <?php echo $noBookingsMessage; ?>
    <?php else: ?>
        <?php while ($booking = $result->fetch_assoc()): ?>
            <div class="booking_card">
                <h3>Booking #<?php echo htmlspecialchars($booking['id']); ?></h3>
                <table>
                    <tr><th>Car Model</th><td><?php echo htmlspecialchars($booking['car_model']); ?></td></tr>
                    <tr><th>Location</th><td><?php echo htmlspecialchars($booking['location_name']); ?></td></tr>
                    <tr><th>Pickup Date</th><td><?php echo htmlspecialchars(date('l, F j, Y, g:i A', strtotime($booking['pickup_date']))); ?></td></tr>
                    <tr><th>Payment Method</th><td><?php echo htmlspecialchars($booking['payment_method']); ?></td></tr>
                    <tr><th>Status</th><td><?php echo htmlspecialchars($booking['status']); ?></td></tr>
                </table>
                <a href="?cancel_booking_id=<?php echo htmlspecialchars($booking['id']); ?>" class="button">Cancel Booking</a>
                <a href="?confirm_booking_id=<?php echo htmlspecialchars($booking['id']); ?>" class="button">Confirm Booking</a>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
