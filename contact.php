<?php
// Database connection
$servername = "localhost"; // Database server
$username = "root"; // Database username
$password = ""; // Database password (usually empty for local development)
$dbname = "ncrdb"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Insert data into the database
    $sql = "INSERT INTO contact_messages (name, message) VALUES ('$name', '$message')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Message sent successfully!');</script>";
        // Redirect to admin dashboard after sending the message
        header("Location: admin_dashboard.php"); // Adjust the dashboard URL as needed
        exit(); // Ensure no further code execution after redirection
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <title>Contact</title>
    <style>
      /* General body styling */
      body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        background-image: url("\assets\story-1.jpg"); /* Add your background image */
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
      }

      /* Container for the contact section */
      .section__container {
        max-width: 900px;
        margin: 0 auto;
        padding: 30px 20px;
        background-color: rgba(255, 255, 255, 0.85);
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }

      /* Section header styling */
      .section__header {
        text-align: center;
        font-size: 1.5rem;
        color: #333;
        margin-bottom: 20px;
        font-weight: bold;
      }

      /* Contact section styling */
      .contact {
        text-align: center;
        margin-bottom: 40px;
      }

      .contact h1 {
        font-size: 2rem;
        color: #333;
        margin-bottom: 10px;
      }

      .contact p {
        font-size: 1rem;
        color: #555;
        margin-bottom: 30px;
      }

      /* Contact details layout */
      .contact-details {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
        gap: 20px;
      }

      .detail {
        text-align: center;
        flex: 1;
      }

      .detail i {
        font-size: 2.5rem;
        color: #0056b3;
        margin-bottom: 10px;
      }

      .detail h2 {
        font-size: 1.2rem;
        color: #333;
        margin-bottom: 5px;
      }

      .detail p {
        font-size: 1rem;
        color: #555;
      }

      /* Form container */
      form {
        display: flex;
        flex-direction: column;
        gap: 20px;
      }

      /* Styling for form inputs */
      .form__group {
        display: flex;
        flex-direction: column;
        gap: 8px;
      }

      label {
        font-size: 1rem;
        color: #555;
        font-weight: bold;
      }

      input[type="text"],
      textarea {
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
        color: #333;
        background-color: #f9f9f9;
        width: 100%;
        box-sizing: border-box;
      }

      textarea {
        resize: vertical;
        min-height: 120px;
      }

      input:focus,
      textarea:focus {
        border-color: #0056b3;
        outline: none;
      }

      /* Button styling */
      .form__btn {
        padding: 12px 18px;
        background-color: #0056b3;
        color: white;
        font-size: 1rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s;
      }

      .form__btn:hover {
        background-color: #003d80;
      }

      .form__btn:active {
        background-color: #002b5c;
      }

      /* Footer styling */
      footer {
        background-color: #333;
        color: white;
        padding: 40px 20px;
        text-align: center;
      }

      .footer__content {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 40px;
        margin-bottom: 20px;
      }

      .footer__col h4 {
        font-size: 1.2rem;
        margin-bottom: 15px;
      }

      .footer__links {
        list-style: none;
        padding: 0;
        margin: 0;
      }

      .footer__links li {
        margin-bottom: 8px;
      }

      .footer__links a {
        color: #ccc;
        text-decoration: none;
        font-size: 1rem;
      }

      .footer__links a:hover {
        color: #fff;
      }

      .footer__socials {
        list-style: none;
        padding: 0;
        display: flex;
        gap: 15px;
      }

      .footer__socials a {
        color: #ccc;
        font-size: 1.5rem;
      }

      .footer__socials a:hover {
        color: #fff;
      }

      /* Footer bar */
      .footer__bar {
        background-color: #222;
        padding: 15px;
        text-align: center;
      }

      .footer__bar p {
        font-size: 1rem;
        color: #bbb;
      }

      /* Responsive Design */
      @media (max-width: 768px) {
        .contact-details {
          flex-direction: column;
        }

        .footer__content {
          flex-direction: column;
          gap: 20px;
        }

        .footer__col {
          text-align: center;
          width: 100%;
        }

        .footer__socials {
          justify-content: center;
        }
      }
    </style>
  </head>
  <body>
    <header>
      <nav>
        <div class="nav__header">
          <div class="nav__logo">
          </div>
        </div>
      </nav>
    </header>

    <section class="section__container contact__container" id="contact">
      <!-- Contact Info Section -->
      <div class="contact">
        <h1>Contact Us</h1>
        <p>We’re here to cater for all your inquiries.</p>

        <!-- Contact Details -->
        <div class="contact-details">
          <div class="detail">
            <i class="fa fa-map-marker"></i>
            <h2>Address</h2>
            <p>Baringo road, Nakuru City, Kenya</p>
          </div>
          <div class="detail">
            <i class="fa fa-phone"></i>
            <h2>Phone</h2>
            <p>+254-712-345-567</p>
          </div>
          <div class="detail">
            <i class="fa fa-envelope"></i>
            <h2>Email</h2>
            <p>info@nakurucarrental.com</p>
          </div>
          <div class="detail">
            <i class="fa fa-clock"></i>
            <h2>Operating Hours</h2>
            <p>Monday - Sunday: 12:00 AM - 12:00 PM</p>
          </div>
        </div>
      </div>

      <!-- Contact Form Section -->
      <h2 class="section__header">Send Us a Message</h2>
      <form action="" method="post">
        <div class="form__group">
          <label for="name">Full Name</label>
          <input type="text" id="name" name="name" required />
        </div>
        <div class="form__group">
          <label for="message">Message</label>
          <textarea id="message" name="message" required></textarea>
        </div>
        <button type="submit" class="form__btn">Send Message</button>
      </form>
    </section>

    <!-- Footer Section -->
    <footer>
      <div class="footer__content">
        <div class="footer__col">
          <h4>Resources</h4>
          <ul class="footer__links">
            <li><a href="#">Installation Manual</a></li>
            <li><a href="#">Release Note</a></li>
            <li><a href="#">Community Help</a></li>
          </ul>
        </div>
        <div class="footer__col">
          <h4>Company</h4>
          <ul class="footer__links">
            <li><a href="#">About Us</a></li>
            <li><a href="#">Career</a></li>
            <li><a href="#">Press</a></li>
            <li><a href="#">Support</a></li>
          </ul>
        </div>
        <div class="footer__col">
          <h4>Product</h4>
          <ul class="footer__links">
            <li><a href="#">Demo</a></li>
            <li><a href="#">Security</a></li>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Features</a></li>
          </ul>
        </div>
        <div class="footer__col">
          <h4>Follow Us</h4>
          <ul class="footer__socials">
            <li><a href="#"><i class="ri-facebook-fill"></i></a></li>
            <li><a href="#"><i class="ri-twitter-fill"></i></a></li>
            <li><a href="#"><i class="ri-linkedin-fill"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="footer__bar">
        <p>© 2024 NAKS CAR RENTAL. All rights reserved.</p>
      </div>
    </footer>

    <script src="scripts.js"></script>
  </body>
</html>
