<?php
// Start the session
session_start();

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    // Redirect non-admin users to the homepage or login page
    header("Location: sign_in.php");
    exit();
}

// Get the admin's name from the session (assuming 'username' holds the admin's name)
$admin_name = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Dashboard</title>

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    
    <!-- Google Fonts: Changing the font to 'Roboto' -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="style.css">

    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Apply the custom font (Roboto) to the whole page */
        body {
            font-family: 'Roboto', sans-serif; /* Changed font */
            background: url("assets/experience1.png") no-repeat center center fixed; /* Background image */
            background-size: cover;
            display: flex;
            min-height: 100vh;
            flex-direction: row;
            color: white; /* Ensure the text is readable on the background */
        }

        /* Sidebar Styling */
        #sidebar {
            width: 250px;
            position: fixed;
            height: 100%;
            background: #1a1a1a; /* Updated sidebar background color */
            color: white;
            padding-top: 50px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        #sidebar .brand {
            display: flex;
            align-items: center;
            padding: 20px;
            font-size: 24px;
            color: white;
        }

        #sidebar .side-menu {
            list-style: none;
            margin-top: 30px;
        }

        #sidebar .side-menu li {
            padding: 15px;
            font-size: 18px;
        }

        #sidebar .side-menu li a {
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
        }

        #sidebar .side-menu li a .bx {
            margin-right: 10px;
        }

        /* Content Section */
        #content {
            margin-left: 250px;
            padding: 20px;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .main-content {
            text-align: center;
            font-size: 24px;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent white background */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            color: #333; /* Set text color inside the main content */
        }

        .main-content h1 {
            font-size: 32px;
            margin-bottom: 20px;
        }

        .button-box {
            margin-top: 20px;
        }

        .button-box button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button-box button:hover {
            background-color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            #sidebar {
                width: 200px;
                padding-top: 20px;
            }

            #content {
                margin-left: 200px;
            }
        }

        @media (max-width: 480px) {
            #sidebar {
                width: 150px;
            }

            #content {
                margin-left: 150px;
            }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<section id="sidebar">
    <a href="#" class="brand">
        <i class="bx bxs-smile"></i>
        <span class="text">AdminHub</span>
    </a>
    <ul class="side-menu top">
        <li class="active">
            <a href="dashboard.php">
                <i class="bx bxs-dashboard"></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="ActiveUser.php">
                <i class="bx bxs-group"></i>
                <span class="text">Active Users</span>
            </a>
        </li>
        <li>
            <a href="approval.php">
                <i class="bx bxs-bookmark"></i>
                <span class="text">Approval</span>
            </a>
        </li>
        <li>
            <a href="booking_details.php"> <!-- Added link for vehicles -->
                <i class="bx bxs-car"></i>
                <span class="text">Booking Details</span>
            </a>
        </li>
        <li>
            <a href="complain.php"> <!-- Corrected link to contacts.php -->
                <i class="bx bxs-contact"></i>
                <span class="text">Complain</span>
            </a>
        </li>
        <li>
            <a href="add_vehicle.php"> <!-- Added link for vehicles -->
                <i class="bx bxs-car"></i>
                <span class="text">AddVehicle</span>
            </a>
        </li>
        <li>
            <a href="logout.php"> <!-- Added link for log out -->
                <i class="bx bxs-log-out"></i>
                <span class="text">Log Out</span>
            </a>
        </li>
    </ul>
</section>
<!-- SIDEBAR -->

<!-- CONTENT -->
<section id="content">
    <div class="main-content">
        <h1>Welcome, <?php echo $admin_name; ?>!</h1>
        <p>This is your dashboard where you can manage users, view active users, and more.</p>

        <div class="button-box">
            <button onclick="location.href='ActiveUser.php'">View Active Users</button>
            <button onclick="location.href='approval.php'">View Approval</button>
            <button onclick="location.href='booking_details.php'">Booking Details</button>
            <button onclick="location.href='complain.php'">Complain</button>
            <button onclick="location.href='add_vehicle.php'">Add Vehicle</button>
            <button onclick="location.href='logout.php'">LogOut</button>
        </div>
    </div>
</section>
<!-- CONTENT -->

<script src="script.js"></script>
</body>
</html>
