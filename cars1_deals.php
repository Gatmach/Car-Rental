<?php  
// Database connection
include('connect.php');

// Fetch available cars from the 'cars_deals' table (only available cars)
$sql = "SELECT car_model, price_per_day, rating FROM cars_deals WHERE is_booked = 0"; // Only show available cars
$result = $conn->query($sql);

// Handle the booking request if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_now'])) {
    // Get the car model and location_id from the form
    $car_model = $_POST['car_model']; // Get the car model from the hidden input
    $RID = $_POST['RID']; // Get the location_id (RID) from the hidden input

    $booking_date = date('Y-m-d'); // Set today's date as the booking date

    // Check if location_id (RID) is valid in rental_spots table
    $location_sql = "SELECT * FROM rental_spots WHERE RID = ?";
    $location_stmt = $conn->prepare($location_sql);
    $location_stmt->bind_param("i", $RID);
    $location_stmt->execute();
    $location_result = $location_stmt->get_result();

    if ($location_result->num_rows === 0) {
        echo "Error: Location ID is invalid!";
        exit;
    }

    // Insert booking details into the bookings table
    $booking_sql = "INSERT INTO bookings (car_model, RID, booking_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($booking_sql);
    $stmt->bind_param("sis", $car_model, $RID, $booking_date); // 's' for string (car_model), 'i' for integer (RID), 's' for string (booking_date)

    if ($stmt->execute()) {
        // Update the car's status to 'booked' in cars_deals
        $update_cars_deals_sql = "UPDATE cars_deals SET is_booked = 1 WHERE car_model = ?";
        $update_stmt = $conn->prepare($update_cars_deals_sql);
        $update_stmt->bind_param("s", $car_model); // Update the car with the car_model
        $update_stmt->execute();

        // Redirect to the bookings page after successful booking
        header("Location: bookings.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css" />
    <title>CARS</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("assets/experience1.png");
            background-size: cover;
            background-position: center;
            color: white;
        }
        header {
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 20px 0;
        }
        header nav {
            display: flex;
            justify-content: center;
        }
        .nav__logo a {
            text-decoration: none;
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .section__container {
            padding: 50px 20px;
            text-align: center;
        }
        .deals__card {
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-radius: 8px;
            display: inline-block;
            margin-right: 20px;
            width: 30%;
        }
        .deals__card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .deals__rating {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }
        .deals__rating span {
            margin-right: 5px;
            color: #f1c40f;
        }
        .deals__card h4 {
            font-size: 20px;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .deals__card__footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 18px;
            font-weight: bold;
        }
        .deals__card__footer h3 {
            color: #e74c3c;
        }
        .deals__card__footer button {
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .deals__card__footer button:hover {
            background-color: #e74c3c;
        }
        /* Form Styling for booking */
        .booking-form {
            margin-top: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
        }
        .booking-form input {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            font-size: 16px;
        }
        .booking-form button {
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .booking-form button:hover {
            background-color: #e74c3c;
        }
    </style>
</head>
<body>

<header>
  <nav>
    <div class="nav__logo">
        <a href="#">CARS</a>
    </div>
  </nav>
</header>

<section class="section__container Cars_deals__container" id="cars_deals">
  <h2>Available Cars for Booking</h2>
  <div class="cars_deals__grid">
    <?php while ($row = $result->fetch_assoc()) : ?>
        <div class="deals__card">
            <img src="assets/deals<?= strtolower($row['car_model']) ?>.png" alt="<?= htmlspecialchars($row['car_model']) ?> image" />
            <div class="deals__rating">
                <?php
                $rating = $row['rating'];
                for ($i = 0; $i < 5; $i++) {
                    echo $i < $rating ? "<span><i class='ri-star-fill'></i></span>" : "<span><i class='ri-star-line'></i></span>";
                }
                ?>
            </div>
            <h4><?= htmlspecialchars($row['car_model']) ?></h4>
            <div class="deals__card__footer">
                <h3>$<?= number_format($row['price_per_day'], 2) ?>/day</h3>
                <!-- Booking Form -->
                <form class="booking-form" action="" method="post">
                    <input type="hidden" name="car_model" value="<?= htmlspecialchars($row['car_model']) ?>" />
                    <input type="hidden" name="RID" value="<?= $row['RID'] ?>" />  <!-- Hidden input for location (RID) -->
                    <button type="submit" name="book_now">Book Now</button>
                </form>
            </div>
        </div>
    <?php endwhile; ?>
  </div>
</section>

</body>
</html>

<?php $conn->close(); ?>
