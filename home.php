<?php
// Start the session
session_start();

// Include the database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "ncrdb";

// Create a connection to the database
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Failed to connect to DB: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_booking'])) {
    $location = $_POST['location'];
    $start = $_POST['start'];
    $stop = $_POST['stop'];

    // Insert the booking data into the database
    $stmt = $conn->prepare("INSERT INTO bookings (location, start_date, end_date) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $location, $start, $stop);
    if ($stmt->execute()) {
        $message = "Booking successful!";
    } else {
        $message = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="styles.css" />
    <title>NAKS CAR RENTAL</title>
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f7f7f7;
            color: #333;
            font-size: 16px;
            line-height: 1.6;
        }

        /* Header Styles */
        header {
            background-color: #1a1a1a;
            color: white;
            padding: 30px 0;
            text-align: center;
            position: relative;
            z-index: 10;
        }

        header .nav__header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        header .nav__logo a {
            color: white;
            font-size: 28px;
            text-decoration: none;
            font-weight: bold;
        }

        header .nav__menu__btn i {
            font-size: 28px;
            color: white;
            cursor: pointer;
        }

        header .nav__links {
            list-style: none;
            display: flex;
            justify-content: center;
            padding: 20px 0;
        }

        header .nav__links li {
            margin: 0 20px;
        }

        header .nav__links a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        header .nav__btn .btn {
            background-color: #ff9800;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
        }

        header .header__container {
            padding: 50px 20px;
            text-align: center;
        }

        header h1 {
            font-size: 60px;
            margin-bottom: 30px;
            color: white;
        }

        header form {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
        }

        .form__group {
            margin-bottom: 20px;
        }

        input[type="text"], input[type="date"] {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
            background-color: #f9f9f9;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #ff9800;
        }

        button[type="submit"] {
            background-color: #ff9800;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 18px;
        }

        button[type="submit"]:hover {
            background-color: #e68900;
        }

        p {
            margin-top: 20px;
            color: green;
            font-weight: bold;
        }

        /* Scroll Down Icon */
        .scroll__down {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 30px;
            color: white;
            text-decoration: none;
        }

        .scroll__down i {
            animation: bounce 1.5s infinite;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            header h1 {
                font-size: 48px;
            }

            header .nav__links {
                flex-direction: column;
            }

            header .nav__links li {
                margin: 10px 0;
            }

            header .nav__btn .btn {
                padding: 10px 25px;
                font-size: 16px;
            }

            form {
                padding: 25px;
            }
        }

        @media (max-width: 480px) {
            header h1 {
                font-size: 36px;
            }

            header .nav__links {
                flex-direction: column;
                padding: 20px;
            }

            header .nav__links li {
                margin: 10px 0;
            }

            header .nav__menu__btn i {
                font-size: 30px;
            }

            header .nav__btn .btn {
                font-size: 14px;
                padding: 12px 25px;
            }
        }

        /* Story Grid Styles */
        .story__container {
            padding: 50px 20px;
            background-color: #fff;
        }

        .story__header {
            text-align: center;
            font-size: 36px;
            margin-bottom: 30px;
            color: #333;
        }

        .story__grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }

        .story__card {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .story__date {
            background-color: #ff9800;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .story__card img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-top: 15px;
        }

        .story__card h4 {
            font-size: 22px;
            margin: 10px 0;
        }

        .story__card p {
            font-size: 16px;
            color: #555;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="nav__header">
                <div class="nav__logo">
                    <a href="#">NAKS CAR RENTAL</a>
                </div>
                <div class="nav__menu__btn" id="menu-btn">
                    <i class="ri-menu-line"></i>
                </div>
            </div>
            <ul class="nav__links" id="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="details.php"> YOUR DETAILS</a></li>
                <li><a href="cars_deals.php">CARS</a></li>
                <li><a href="bookings.php">BOOKINGS</a></li>
                <li><a href="contact.php">CONTACT</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="SignIn.php">Sign In</a></li>
                    <li><a href="SignUp.php">Sign Up</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
            <div class="nav__btn">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <button class="btn">Go to Dashboard</button>
                <?php else: ?>
                    <a href="details.php">
            <button class="btn">Get Started</button>
        </a>
                <?php endif; ?>
            </div>
        </nav>

        <div class="header__container" id="home">
            <h1>NAKS CAR RENTAL</h1>
            <?php if (isset($message)) echo "<p>$message</p>"; ?>
            <img src="assets/header.png" alt="header" />
        </div>

        <a href="#about" class="scroll__down">
            <i class="ri-arrow-down-s-line"></i>
        </a>
    </header>

    <section class="section__container story__container">
        <h2 class="story__header">STORIES BEHIND THE WHEEL</h2>
        <div class="story__grid">
            <div class="story__card">
                <div class="story__date">
                    <span>12</span>
                    <div>
                        <p>January</p>
                        <p>2025</p>
                    </div>
                </div>
                <h4>Adventures on the Open Road</h4>
                <p>
                    Join us as we dive into the exhilarating stories of travelers who
                    embarked on unforgettable journeys with Naks CAR RENTAL.
                </p>
                <img src="assets/story-1.jpg" alt="story" />
            </div>
            <div class="story__card">
                <div class="story__date">
                    <span>04</span>
                    <div>
                        <p>March</p>
                        <p>2024</p>
                    </div>
                </div>
                <h4>Luxury and Comfort: Experiences</h4>
                <p>
                    In this series, we highlight the luxurious touches, unparalleled
                    comfort, and exceptional service that make every ride.
                </p>
                <img src="assets/story-2.jpg" alt="story" />
            </div>
            <div class="story__card">
                <div class="story__date">
                    <span>18</span>
                    <div>
                        <p>June</p>
                        <p>2024</p>
                    </div>
                </div>
                <h4>Cars that Adapt to Your Lifestyle</h4>
                <p>
                    Read about how our versatile vehicles have seamlessly integrated
                    into the lives of professionals and families alike.
                </p>
                <img src="assets/story-3.jpg" alt="story" />
            </div>
        </div>
    </section>
</body>
</html>
