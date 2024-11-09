<?php
require_once("config.php");
$conn = new mysqli(servername, username, password, database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the name and review from the form
    $name = $_POST['name'];
    $review = $_POST['review'];
    $review_datetime = date('Y-m-d H:i:s'); // Current date and time

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO Review (name, review, Date) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $review, $review_datetime);

    // Execute the statement
    if ($stmt->execute()) {
        $message = "Review submitted successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css" />
    <title>Review</title>
</head>

<body>
    <div class="container">
        <div class="form-box">
            <h3>Leave a Review</h3>
            <?php if (isset($message)) : ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
            <form action="review.php" method="post"> <!-- Submit to the same page -->
                <div class="input-group">
                    <div class="input-field">
                        <input type="text" placeholder="Your name" id="name" name="name" required><br><br>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-field">
                        <textarea placeholder="Leave your opinion" id="review" name="review" required></textarea><br><br>
                    </div>
                </div>
                <div class="submit1">
                    <input type="submit" name="submit" value="Submit" required>
                </div>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>
