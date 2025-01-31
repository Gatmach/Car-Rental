<?php
// Database connection
include('connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get car details from the POST request
    $car_model = $_POST['car_model'];
    $brand = $_POST['brand'];
    $image = $_POST['image'];
    $rating = $_POST['rating'];
    $people_capacity = $_POST['people_capacity'];
    $autopilot = isset($_POST['autopilot']) ? 1 : 0; // If checkbox is selected, set 1 for autopilot
    $range = $_POST['range'];
    $fuel_type = $_POST['fuel_type'];
    $price_per_day = $_POST['price_per_day'];
    $book_link = $_POST['book_link'];
    $is_booked = isset($_POST['is_booked']) ? 1 : 0; // If checkbox is selected, set 1 for booked

    // Insert the car details into the database
    $stmt = $conn->prepare("INSERT INTO cars_deals (car_model, brand, image, rating, people_capacity, autopilot, range, fuel_type, price_per_day, book_link, is_booked) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiissisii", $car_model, $brand, $image, $rating, $people_capacity, $autopilot, $range, $fuel_type, $price_per_day, $book_link, $is_booked);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Car details added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Car Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
        }

        input[type="text"], input[type="number"], input[type="checkbox"], select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h2>Add Car Details</h2>
<form action="" method="POST">
    <label for="car_model">Car Model:</label>
    <input type="text" id="car_model" name="car_model" required>

    <label for="brand">Brand:</label>
    <input type="text" id="brand" name="brand" required>

    <label for="image">Image URL:</label>
    <input type="text" id="image" name="image" required>

    <label for="rating">Rating (1-5):</label>
    <input type="number" id="rating" name="rating" min="1" max="5" required>

    <label for="people_capacity">People Capacity:</label>
    <input type="number" id="people_capacity" name="people_capacity" required>

    <label for="autopilot">Autopilot:</label>
    <input type="checkbox" id="autopilot" name="autopilot" value="1">

    <label for="range">Range (km):</label>
    <input type="number" id="range" name="range" required>

    <label for="fuel_type">Fuel Type:</label>
    <input type="text" id="fuel_type" name="fuel_type" required>

    <label for="price_per_day">Price per Day (Ksh):</label>
    <input type="number" id="price_per_day" name="price_per_day" required>

    <label for="book_link">Booking Link:</label>
    <input type="text" id="book_link" name="book_link" required>

    <label for="is_booked">Is Booked:</label>
    <input type="checkbox" id="is_booked" name="is_booked" value="1">

    <input type="submit" value="Add Car">
</form>

</body>
</html>
