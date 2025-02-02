<?php
include('connect.php');

// Query to get cars
$stmt = $conn->prepare("SELECT * FROM cars_deals");
$stmt->execute();
$result = $stmt->get_result();

echo '<div class="car-list">';

while ($row = $result->fetch_assoc()) {
    // Display car details
    echo '<div class="car-card">';
    echo '<img src="' . $row['image'] . '" alt="' . $row['car_model'] . '">';
    echo '<h4>' . $row['car_model'] . '</h4>';
    echo '<p>Price: ' . $row['price_per_day'] . '</p>';
    echo '<p>Seats: ' . $row['people_capacity'] . '</p>';
    // echo '<p>Transmission: ' . $row['transmission'] . '</p>';
    echo '<p>Mileage: ' . $row['range_distance'] . '</p>';
    echo '<p>Fuel Type: ' . $row['fuel_type'] . '</p>';

    // Select Button
    echo '<form action="ride.php" method="GET"><h1> hello<h1/>
            <input type="hidden" name="car_id" value="' . $row['ID'] . '">
            <input type="hidden" name="car_model" value="' . $row['car_model'] . '">
            <input type="hidden" name="car_price" value="' . $row['price_per_day'] . '">
            <input type="hidden" name="car_seats" value="' . $row['people_capacity'] . '">
           
            <input type="hidden" name="car_mileage" value="' . $row['range_distance'] . '">
            <input type="hidden" name="car_fuel_type" value="' . $row['fuel_type'] . '">
            <button type="submit">Select</button>
          </form>';

    echo '</div>';
}

echo '</div>';

// Close statement and connection
$stmt->close();
$conn->close();
?>
