<?php
// Start the session
session_start();

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "ncrdb";
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Failed to connect to DB: " . $conn->connect_error);
}

$message = '';

// Handle form submission for sign-up
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_signup'])) {
    // Capture form data
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Check if passwords match
    if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        // Check if username already exists
        $query = $conn->prepare("SELECT UID FROM users WHERE username = ? OR email = ?");
        $query->bind_param("ss", $username, $email);
        $query->execute();
        $query->store_result();

        if ($query->num_rows > 0) {
            $message = "Username or email already exists.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user data into the database
            $insert_query = $conn->prepare("INSERT INTO users (firstname, lastname, username, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
            $insert_query->bind_param("ssssss", $firstname, $lastname, $username, $email, $hashed_password, $role);
            if ($insert_query->execute()) {
                $message = "Sign up successful! You can now sign in.";
                header("Location: signin.php");
                exit();
            } else {
                $message = "Error: " . $insert_query->error;
            }
            $insert_query->close();
        }

        $query->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        /* Global Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-image: url("assets/car.jpeg");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: rgba(39, 39, 39, 0.5);
            width: 100%;
        }

        .auth-modal-content {
            background-color: #fff;
            border-radius: 10px;
            padding: 25px;
            width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .auth-form {
            display: flex;
            flex-direction: column;
        }

        .auth-form h2 {
            margin-bottom: 20px;
            font-size: 28px;
            color: #333;
        }

        .auth-form label {
            margin-bottom: 5px;
            font-weight: 500;
            color: #333;
        }

        .auth-form input, .auth-form select {
            font-size: 14px;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
        }

        .auth-form input:focus {
            border-color: #4CAF50;
        }

        .auth-form button {
            padding: 12px;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .auth-form button:hover {
            background-color: #45a049;
        }

        .auth-form p {
            font-size: 14px;
            color: #333;
        }

        .auth-form p a {
            color: #4CAF50;
            font-weight: 600;
            text-decoration: none;
        }

        .auth-form p a:hover {
            text-decoration: underline;
        }

        .error, .success {
            padding: 12px;
            margin: 10px 0;
            color: white;
            border-radius: 5px;
            font-size: 16px;
        }

        .error {
            background-color: #f44336;
        }

        .success {
            background-color: #4CAF50;
        }

        .close-btn {
            background-color: transparent;
            border: none;
            font-size: 16px;
            color: #000;
            cursor: pointer;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div id="auth-modal" class="auth-modal">
        <div class="auth-modal-content">
            <!-- Sign Up Form -->
            <div class="auth-form">
                <h2>Sign Up</h2>

                <!-- Display message after form submission -->
                <?php if ($message): ?>
                    <div class="error"><?php echo $message; ?></div>
                <?php endif; ?>

                <form action="" method="POST">
                    <input type="text" name="firstname" required placeholder="First Name" />
                    <input type="text" name="lastname" required placeholder="Last Name" />
                    <input type="text" name="username" required placeholder="Username" />
                    <input type="email" name="email" required placeholder="Email" />
                    <input type="password" name="password" required placeholder="Password" />
                    <input type="password" name="confirm_password" required placeholder="Confirm Password" />

                    <label for="role">Select Role:</label>
                    <select name="role" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>

                    <button type="submit" name="submit_signup">Sign Up</button>
                </form>

                <p>Already have an account? <a href="signin.php">Sign In</a></p>
            </div>
        </div>
    </div>
</div>

<script>
    // Close modal functionality (optional if you plan to have a modal)
    const modal = document.getElementById('auth-modal');
    const closeModalBtn = document.getElementById('close-modal');
    closeModalBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });
</script>

</body>
</html>
