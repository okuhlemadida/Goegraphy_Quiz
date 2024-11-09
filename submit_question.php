<?php
session_start();

// Check if the user is logged in (optional)
if (!isset($_SESSION['UserID'])) {
    echo "You must be logged in to add a question.";
    exit();
}

// Database connection
require_once('config.php');

// Create a connection to the database
$conn = new mysqli(servername, username, password, database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the question from the form submission
    $question = $conn->real_escape_string($_POST['question']);
    
    // Get the options as an array and JSON encode it
    $options = $_POST['options'];
    $options_json = json_encode($options); // Save as JSON in the database

    // Get the correct answer index (0, 1, 2, or 3)
    $correct_answer = intval($_POST['answer']); // Store as an integer

    // Insert the question, options, and correct answer into the database
    $sql = "INSERT INTO questions (question, options, answer) 
            VALUES ('$question', '$options_json', $correct_answer)";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php?success=1");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "No data submitted.";
}
?>
