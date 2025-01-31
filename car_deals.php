<?php
include('connect.php');

// Query to get cars
$stmt = $conn->prepare("SELECT * FROM cars");
$stmt->execute();
$result = $stmt->get_result();

echo '<div class="car-list">';

while ($row = $result->fetch_assoc()) {
    // Display car details
    echo '<div class="car-card">';
    echo '<img src="' . $row['image'] . '" alt="' . $row['model'] . '">';
    echo '<h4>' . $row['model'] . '</h4>';
    echo '<p>Price: ' . $row['price'] . '</p>';
    echo '<p>Seats: ' . $row['seats'] . '</p>';
    echo '<p>Transmission: ' . $row['transmission'] . '</p>';
    echo '<p>Mileage: ' . $row['mileage'] . '</p>';
    echo '<p>Fuel Type: ' . $row['fuel_type'] . '</p>';

    // Select Button
    echo '<form action="ride.php" method="GET">
            <input type="hidden" name="car_id" value="' . $row['ID'] . '">
            <input type="hidden" name="car_model" value="' . $row['model'] . '">
            <input type="hidden" name="car_price" value="' . $row['price'] . '">
            <input type="hidden" name="car_seats" value="' . $row['seats'] . '">
            <input type="hidden" name="car_transmission" value="' . $row['transmission'] . '">
            <input type="hidden" name="car_mileage" value="' . $row['mileage'] . '">
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
