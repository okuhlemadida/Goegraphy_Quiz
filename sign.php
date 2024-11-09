<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
session_start();

if(isset($_REQUEST['submit'])){
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $email = $_REQUEST['email'];
    $user_type = $_REQUEST['user_type']; // Get the user type from the form

    // Database connection
    require_once("config.php");
    $conn = new mysqli(servername, username, password, database);

    if($conn->connect_error){
        die("<p class=\"error\"><strong>Connection failed:</strong> " . $conn->connect_error . "</p>");
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT UserID FROM users WHERE email = ?");
    if($stmt === false){
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0) {
        echo "<p class=\"error\"><strong>Error:</strong> Email is already registered. Please use a different email.</p>";
    } else {
        // Password hashing
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Use prepared statement to insert data, including user type
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, user_type) VALUES (?, ?, ?, ?)");
        
        if($stmt === false){
            die("Error preparing statement: " . $conn->error);
        }

        // Bind parameters to the SQL query (s for string)
        $stmt->bind_param("ssss", $username, $hashed_password, $email, $user_type); // Added user_type

        // Execute the prepared statement
        if($stmt->execute()){
            header("Location: login.php");
            exit();
        } else {
            echo "<p class=\"error\"><strong>Error:</strong> " . $stmt->error . "</p>";
        }
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}

?>
</body>
</html>

