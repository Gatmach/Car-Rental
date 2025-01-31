<?php
// Start the session
session_start();

// Check if the user is logged in and is an admin
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

// Handle vehicle addition
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $car_model = $_POST['car_model'];
    $brand = $_POST['brand'];
    $rating = $_POST['rating'];
    $people_capacity = $_POST['people_capacity'];
    $autopilot = isset($_POST['autopilot']) ? 1 : 0;
    $range = $_POST['range'];
    $fuel_type = $_POST['fuel_type'];
    $price_per_day = $_POST['price_per_day'];
    $book_link = $_POST['book_link'];
    $is_booked = isset($_POST['is_booked']) ? 1 : 0;

    // Handle image upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = basename($_FILES['image']['name']);
                $image_path = 'uploads/' . $image_name;  // Assuming you have an "uploads" directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            $image = $image_path;
        } else {
            $error_message = "Failed to upload image.";
        }
    }

    // Validate data (you can add more validation here)
    if (empty($car_model) || empty($brand) || empty($rating) || empty($people_capacity) || empty($range) || empty($fuel_type) || empty($price_per_day) || empty($book_link)) {
        $error_message = "Please fill all required fields.";
    } else {
        // Insert data into the vehicles table
        $sql = "INSERT INTO cars_deals (car_model, brand, image, rating, people_capacity, autopilot, range_distance, fuel_type, price_per_day, book_link, is_booked) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        


        $stmt->bind_param("sssiisdsdsi", $car_model, $brand, $image, $rating, $people_capacity, $autopilot, $range, $fuel_type, $price_per_day, $book_link, $is_booked);

        if ($stmt->execute()) {
            $success_message = "Vehicle added successfully!";
        } else {
            $error_message = "Error adding vehicle. Please try again.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle - AdminHub</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("assets/experience1.png");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
        }

        #content {
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            width: 50%;
            margin: auto;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            margin-top: 20px;
            padding: 10px;
            background-color: #f8d7da;
            color: #721c24;
            border-radius: 5px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .return-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }

        .return-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<section id="content">
    <h1>Add New Vehicle</h1>

    <?php if (isset($error_message)): ?>
        <div class="message"><?php echo $error_message; ?></div>
    <?php elseif (isset($success_message)): ?>
        <div class="message success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <form method="POST" action="add_vehicle.php" enctype="multipart/form-data">
        <label for="car_model">Car Model</label>
        <input type="text" id="car_model" name="car_model" required>

        <label for="brand">Brand</label>
        <input type="text" id="brand" name="brand" required>

        <label for="image">Image</label>
        <input type="file" id="image" name="image" required>

        <label for="rating">Rating</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required>

        <label for="people_capacity">People Capacity</label>
        <input type="number" id="people_capacity" name="people_capacity" required>

        <label for="autopilot">Autopilot</label>
        <select id="autopilot" name="autopilot">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>

        <label for="range">Range (in km)</label>
        <input type="number" id="range" name="range" required>

        <label for="fuel_type">Fuel Type</label>
        <select id="fuel_type" name="fuel_type" required>
            <option value="Petrol">Petrol</option>
            <option value="Diesel">Diesel</option>
            <option value="Electric">Electric</option>
            <option value="Hybrid">Hybrid</option>
        </select>

        <label for="price_per_day">Price Per Day</label>
        <input type="number" id="price_per_day" name="price_per_day" required>

        <label for="book_link">Booking Link</label>
        <input type="url" id="book_link" name="book_link" required>

        <label for="is_booked">Is Booked</label>
        <select id="is_booked" name="is_booked">
            <option value="0">No</option>
            <option value="1">Yes</option>
        </select>

        <button type="submit">Add Vehicle</button>
    </form>

    <!-- Return to Dashboard Button -->
    <a href="admin_dashboard.php" class="return-btn">Return to Dashboard</a>
</section>

</body>
</html>

<?php
// Close the connection
$conn->close();
?>
