<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    echo "You must be logged in to leave feedback.";
    exit();
}

// Database connection
require_once('config.php');
$conn = new mysqli(servername, username, password, database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the feedback and rating from the form submission
    $feedback = $conn->real_escape_string($_POST['feedback']);
    $rating = intval($_POST['rating']); // Ensure rating is an integer

    // Get the userID from the session
    $userID = $_SESSION['UserID'];

    // Get the current date
    $date = date('Y-m-d H:i:s'); // Format: YYYY-MM-DD HH:MM:SS

    // Handle the file upload
    $imageURL = null; // Initialize the image URL variable
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];

        // Define the upload directory
        $uploadFileDir = 'uploads/'; // Ensure this directory exists and is writable
        $dest_path = $uploadFileDir . $fileName;

        // Move the file to the upload directory
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            // File is successfully uploaded
            $imageURL = $dest_path; // Store the path to the uploaded image
        } else {
            echo 'There was an error moving the uploaded file.';
            exit;
        }
    }

    // Insert the feedback, userID, rating, date, and image URL into the feedback table
    $sql = "INSERT INTO feedback (UserID, feedback, rating, date_submitted, image) VALUES ('$userID', '$feedback', $rating, '$date', '$imageURL')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Feedback submitted successfully!</p>";
        if ($imageURL) {
            echo 'Uploaded Image: <img src="' . htmlspecialchars($imageURL) . '" alt="Uploaded Image" width="200"><br>';
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "No feedback submitted.";
}
?>

