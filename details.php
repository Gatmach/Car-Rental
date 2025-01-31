<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please log in first!'); window.location.href = 'login.php';</script>";
    exit;
}

// Include database connection
include('connect.php');

// Fetch available rental locations (for location selection)
$locationsQuery = "SELECT * FROM rental_spots";
$locationsResult = $conn->query($locationsQuery);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data
    $location_name = $_POST['location_name'];  
    $pickup_date = $_POST['pickup_date'];
    $payment_method = $_POST['payment_method'];
    $payment_number = isset($_POST['payment_number']) ? $_POST['payment_number'] : null;
    $credit_card_number = isset($_POST['credit_card_number']) ? $_POST['credit_card_number'] : null;
    $username = $_SESSION['username'];

    // Validate required fields
    if (empty($location_name) || empty($pickup_date) || empty($payment_method)) {
        echo "<script>alert('Please fill all the required fields.'); window.location.href = 'bookings.php';</script>";
        exit;
    }

    // Ensure that payment number is provided when M-Pesa is selected
    if ($payment_method == 'M-Pesa' && empty($payment_number)) {
        echo "<script>alert('Please enter the M-Pesa number.'); window.location.href = 'bookings.php';</script>";
        exit;
    }

    // Step 1: Save the booking details in a temporary table (details table)
    $detailsQuery = "INSERT INTO details (username, location_name, pickup_date, payment_method, payment_number, credit_card_number)
                     VALUES (?, ?, ?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($detailsQuery)) {
        $stmt->bind_param("ssssss", $username, $location_name, $pickup_date, $payment_method, $payment_number, $credit_card_number);

        // Execute the query and check if successful
        if ($stmt->execute()) {
            // Step 2: Proceed to insert the booking into the 'bookings' table
            $bookingQuery = "INSERT INTO bookings (username, location_name, pickup_date, payment_method, payment_number, credit_card_number, is_booked)
                             VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $is_booked = 1; // Assume the booking is confirmed after submission

            if ($bookingStmt = $conn->prepare($bookingQuery)) {
                $bookingStmt->bind_param("sssssss", $username, $location_name, $pickup_date, $payment_method, $payment_number, $credit_card_number, $is_booked);
                if ($bookingStmt->execute()) {
                    echo "<script>alert('Booking successfully made!'); window.location.href = 'cars_deals.php';</script>";
                } else {
                    echo "<script>alert('Error occurred while processing your booking. Please try again later.'); window.location.href = 'bookings.php';</script>";
                }
                $bookingStmt->close();
            } else {
                echo "<script>alert('Error preparing the booking query.'); window.location.href = 'bookings.php';</script>";
            }
        } else {
            echo "<script>alert('Error occurred while saving your details. Please try again later.'); window.location.href = 'bookings.php';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing the details query.'); window.location.href = 'bookings.php';</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Your Rental</title>
    <style>
        /* Add background image and some basic styling */
        body {
            font-family: Arial, sans-serif;
            background-image: url('path/to/your/background-image.jpg');
            background-size: cover;
            background-position: center;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.6);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
            color: #ff8c00;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        select, input {
            padding: 10px;
            margin-bottom: 20px;
            font-size: 1rem;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        input[type="datetime-local"] {
            padding: 10px;
        }

        .button {
            background-color: #ff8c00;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 5px;
            font-size: 1.2rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            width: 100%;
        }

        .button:hover {
            background-color: #e77c00;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Book Your Rental</h2>

    <form action="bookings.php" method="POST">
        <label for="location">Select Location</label>
        <select name="location_name" id="location" required>
            <?php
            // Fetch and display locations from the database
            while ($row = $locationsResult->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($row['location_name']) . "'>" . htmlspecialchars($row['location_name']) . "</option>";
            }
            ?>
        </select>

        <label for="pickup_date">Select Pickup Date & Time</label>
        <input type="datetime-local" name="pickup_date" id="pickup_date" required>

        <label for="payment_method">Select Payment Method</label>
        <select name="payment_method" id="payment_method" required>
            <option value="M-Pesa">M-Pesa</option>
            <option value="Cash">Cash</option>
            <option value="Credit Card">Credit Card</option>
        </select>

        <label for="payment_number" id="payment_number_label" style="display: none;">Enter Payment Number (for M-Pesa)</label>
        <input type="text" id="payment_number" name="payment_number" placeholder="Enter payment number" style="display: none;">

        <label for="credit_card_number" id="credit_card_label" style="display: none;">Enter Credit Card Number</label>
        <input type="text" id="credit_card_number" name="credit_card_number" placeholder="Enter credit card number" style="display: none;">

        <button type="submit" class="button">Proceed to Hire</button>
    </form>
</div>

<script>
    // Show/Hide payment fields based on payment method selection
    document.getElementById('payment_method').addEventListener('change', function () {
        var paymentMethod = this.value;
        
        if (paymentMethod === 'M-Pesa') {
            document.getElementById('payment_number_label').style.display = 'block';
            document.getElementById('payment_number').style.display = 'block';
            document.getElementById('credit_card_label').style.display = 'none';
            document.getElementById('credit_card_number').style.display = 'none';
        } else if (paymentMethod === 'Credit Card') {
            document.getElementById('credit_card_label').style.display = 'block';
            document.getElementById('credit_card_number').style.display = 'block';
            document.getElementById('payment_number_label').style.display = 'none';
            document.getElementById('payment_number').style.display = 'none';
        } else {
            document.getElementById('payment_number_label').style.display = 'none';
            document.getElementById('payment_number').style.display = 'none';
            document.getElementById('credit_card_label').style.display = 'none';
            document.getElementById('credit_card_number').style.display = 'none';
        }
    });
</script>

</body>
</html>
