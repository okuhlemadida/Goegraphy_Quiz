<?php
// Include your database configuration file
require_once("config.php");

// Connect to the database
$conn = new mysqli(servername, username, password, database);
if ($conn->connect_error) {
    die("<p class=\"error\"><strong>Connection failed: Database Not available</strong></p>");
}

// Check if the feedback_id is set and is a valid integer
if (isset($_POST['feedback_id']) && !empty($_POST['feedback_id']) && is_numeric($_POST['feedback_id'])) {
    $feedback_id = intval($_POST['feedback_id']);

    // Prepare the delete SQL statement
    $sql = "DELETE FROM feedback WHERE feedbackID = ?";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $feedback_id);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<p class='message success'>Feedback deleted successfully!</p>";
        } else {
            echo "<p class='message error'>Error deleting feedback: " . htmlspecialchars($stmt->error) . "</p>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<p class='message error'>Error preparing statement: " . htmlspecialchars($conn->error) . "</p>";
    }
} else {
    echo "<p class='message error'>Invalid feedback ID.</p>";
}

// Close the database connection
$conn->close();
?>
