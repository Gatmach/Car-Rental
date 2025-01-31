<?php
$servername = "localhost";  // Server address (typically localhost for local development)
$username = "root";         // Default MySQL username in XAMPP
$password = "";             // Default password is empty in XAMPP
$dbname = "ncrdb";          // Name of the database to connect to (replace with your actual database)


// Create connection using MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);  // If the connection fails, it stops execution and shows the error
} else {
   // echo "Connected successfully to the database '$dbname'.";  // If the connection is successful, show a success message
}
?>
