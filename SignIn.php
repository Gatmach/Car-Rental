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

$message = ''; // Initialize message variable
$username = ''; // Variable to store the user's username

// Handle form submission for sign-in
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_signin'])) {
    // Capture login data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Validate user credentials
    $query = $conn->prepare("SELECT password, email, role FROM users WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $query->store_result();
    
    if ($query->num_rows == 0) {
        $message = "No account found with that username.";
    } else {
        $query->bind_result($hashed_password, $email, $role);
        $query->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Store user details in session
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            $_SESSION['email'] = $email; // Store email in session
            $message = "Login successful!";

            // Redirect based on role
            if ($role == 'admin') {
                header("Location: admin_dashboard.php"); // Admin dashboard page
                exit();
            } else {
                header("Location: home.php"); // Home page for regular users
                exit();
            }
        } else {
            $message = "Incorrect password.";
        }
    }
    
    $query->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="Sign in style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <title>Sign In</title>
    <style>
      /* POPPINS FONT */
      @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

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
        overflow: hidden;
      }

      .wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 110vh;
        background: rgba(39, 39, 39, 0.4);
      }

      .auth-modal-content {
        background-color: #fff;
        border-radius: 10px;
        padding: 30px;
        width: 500px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
      }

      .auth-modal-content img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        margin-bottom: 20px;
      }

      .auth-form {
        display: flex;
        flex-direction: column;
      }

      .auth-form h2 {
        text-align: center;
        margin-bottom: 20px;
      }

      .auth-form label {
        font-weight: 500;
        margin-bottom: 8px;
      }

      .auth-form input {
        font-size: 16px;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
      }

      .auth-form button {
        padding: 10px;
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
        text-align: center;
        font-size: 14px;
      }

      .auth-form p a {
        text-decoration: none;
        color: #4CAF50;
        font-weight: 600;
      }

      .auth-form p a:hover {
        text-decoration: underline;
      }

      /* Optional - Close Button */
      .close-btn {
        background-color: transparent;
        border: none;
        font-size: 16px;
        color: #000;
        cursor: pointer;
      }
    </style>
</head>
<body>
  <div class="wrapper">
    <!-- Auth Modal -->
    <div id="auth-modal" class="auth-modal">
      <div class="auth-modal-content">
        <!-- Image inside the modal -->
        <img src="assets/car.jpeg" alt="Car" />
        <!-- Sign In Form -->
        <div id="sign-in-form" class="auth-form">
          <h2>Sign In</h2>

          <!-- Display message after form submission -->
          <?php if ($message): ?>
            <div class="<?php echo ($message === 'Login successful!') ? 'success' : 'error'; ?>">
              <?php echo $message; ?>
            </div>
          <?php endif; ?>

          <!-- Sign-in form -->
          <form id="sign-in" action="" method="post">
            <label for="signin-username">Username</label>
            <input type="text" id="signin-username" name="username" required placeholder="Enter your username" />
            <br />
            <label for="signin-password">Password</label>
            <input type="password" id="signin-password" name="password" required placeholder="Enter your password" />
            <br />
            <button type="submit" name="submit_signin">Sign In</button>
          </form>
          <p>Don't have an account? <a href="SignUp.php" id="to-sign-up">SignUp</a></p>
        </div>
        <button class="close-btn" id="close-modal">Close</button>
      </div>
    </div>
  </div>

  <!-- Optional JavaScript for Modal -->
  <script>
    // Close modal functionality
    const modal = document.getElementById('auth-modal');
    const closeModalBtn = document.getElementById('close-modal');
    closeModalBtn.addEventListener('click', function() {
      modal.style.display = 'none';
    });
  </script>
</body>
</html>
