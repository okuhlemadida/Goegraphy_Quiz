<?php
session_start();
require_once("config.php");

// Connect to the database
$conn = new mysqli(servername, username, password, database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Query to check if the username and password match
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // User exists, set session variables and redirect to quiz
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: quiz.php");
        exit;
    } else {
        // Invalid login
        echo "<p>Invalid username or password. <a href='login.php'>Try again</a></p>";
    }
}

$conn->close();
?>
