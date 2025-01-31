<?php
include 'connect.php'; // Include your database connection file

// SignUp functionality
if (isset($_POST['SignUp'])) {
    // Sanitize input (though prepared statements already prevent SQL injection)
    $FirstName = $_POST['fname'];
    $LastName = $_POST['lname'];
    $Email = $_POST['email'];
    $Password = $_POST['password'];
    
    // Hash the password using password_hash() for secure storage
    $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

    // Check if email already exists in the database
    $checkemail = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($checkemail);
    $stmt->bind_param("s", $Email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email Address Already Exists!";
    } else {
        // Corrected insert query using prepared statements
        $insertQuery = "INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssss", $FirstName, $LastName, $Email, $hashedPassword);

        if ($stmt->execute()) {
            // Redirect to SignIn page or a success page after successful registration
            header("Location: SignIn.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Close the statement
    $stmt->close();
}

// SignIn functionality
if (isset($_POST['SignIn'])) {
    // Sanitize input to prevent SQL injection
    $Email = $_POST['email'];
    $Password = $_POST['password'];
    
    // Check user credentials using prepared statement
    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $Email);  // 's' means the parameter is a string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user data
        $row = $result->fetch_assoc();

        // Verify the hashed password with password_verify
        if (password_verify($Password, $row['password'])) {
            // Start a session and store user data
            session_start();
            $_SESSION['email'] = $row['email'];
            header("Location: home.php");  // Redirect to the homepage
            exit();
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "Email not found!";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
