<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ncrdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle feedback submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feedback_id'])) {
    // Sanitize and validate the feedback
    $feedback = mysqli_real_escape_string($conn, trim($_POST['feedback']));
    $feedback_id = (int)$_POST['feedback_id']; // Ensure feedback_id is an integer

    if (!empty($feedback)) {
        // Prepare SQL to prevent SQL injection
        $sql = "UPDATE contact_messages SET feedback = ? WHERE id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("si", $feedback, $feedback_id);
            if ($stmt->execute()) {
                echo "<script>alert('Feedback updated successfully!');</script>";
            } else {
                echo "<script>alert('Error updating feedback.');</script>";
            }
            $stmt->close();
        }
    } else {
        echo "<script>alert('Feedback cannot be empty!');</script>";
    }
}

// Fetch all complaints/messages
$sql = "SELECT * FROM contact_messages";
$result = $conn->query($sql);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Complaints & Feedback</title>
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("assets/experience1.png"); /* Background image */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        /* Container for the complain list */
        .section__container {
            max-width: 900px;
            margin: 0 auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.85);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .complaint {
            background-color: #fff;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .complaint p {
            font-size: 1rem;
            margin: 10px 0;
        }

        .form__group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            color: #333;
            background-color: #f9f9f9;
            resize: vertical;
            min-height: 80px;
        }

        .form__btn {
            padding: 12px 18px;
            background-color: #0056b3;
            color: white;
            font-size: 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form__btn:hover {
            background-color: #003d80;
        }

        .form__btn:active {
            background-color: #002b5c;
        }

        .return-btn {
            padding: 12px 18px;
            background-color: #0056b3;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            display: inline-block;
        }

        .return-btn:hover {
            background-color: #003d80;
        }
    </style>
</head>
<body>
    <section class="section__container">
        <h1>Complaints & Feedback</h1>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="complaint">
                    <p><strong>Name:</strong> <?= htmlspecialchars($row['name']) ?></p>
                    <p><strong>Message:</strong> <?= nl2br(htmlspecialchars($row['message'])) ?></p>
                    <?php if (empty($row['feedback'])): ?>
                        <!-- Only show feedback form if feedback is not provided yet -->
                        <form action="" method="post">
                            <input type="hidden" name="feedback_id" value="<?= $row['id'] ?>">
                            <div class="form__group">
                                <textarea name="feedback" placeholder="Provide feedback here..."></textarea>
                            </div>
                            <button type="submit" class="form__btn">Submit Feedback</button>
                        </form>
                    <?php else: ?>
                        <p><strong>Feedback:</strong> <?= nl2br(htmlspecialchars($row['feedback'])) ?></p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No complaints found.</p>
        <?php endif; ?>

        <a href="admin_dashboard.php" class="return-btn">Return to Admin Dashboard</a>
    </section>
</body>
</html>
