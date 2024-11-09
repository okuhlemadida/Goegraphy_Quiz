<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once("config.php");
    
    // Get form inputs
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    // Validate inputs
    if (!empty($username) && !empty($password)) {
        // Connect to the database
        $conn = new mysqli(servername, username, password, database);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the SQL statement to fetch UserID, password, and user_type
        $sql = "SELECT UserID, password, user_type FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                // Password is correct, log the user in
                $_SESSION['UserID'] = $row['UserID']; // Store the UserID in session
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;

                // Check user type and redirect accordingly
                if ($row['user_type'] === 'admin') {
                    header('Location: dashboard.php'); // Redirect to admin dashboard
                } else {
                    header('Location: quiz.php'); // Redirect to quiz page for regular users
                }
                exit;
            } else {
                $error_message = "Invalid username or password.";
            }
        } else {
            $error_message = "Invalid username or password.";
        }

        $stmt->close();
        $conn->close();
    } else {
        $error_message = "Please enter both username and password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css" />
    <script src="index.js" defer></script>
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h2>Please enter your login credentials</h2>
            <form name="loginForm" action="login.php" method="post" onsubmit="return validateForm()">
                <div class="input-group">
                    <div class="input-field">
                        <input type="text" id="login-username" name="username" placeholder="Username" required>
                    </div>
                </div>
                <br>
                <div class="input-group">
                    <div class="input-field">
                        <input type="password" id="login-password" name="password" placeholder="Password" required>
                    </div>
                </div>
                <div class="input-group">
                    <button type="submit">Login</button>
                </div>
                <div class="input-group">
                    <p>Don't have an account? <a href="signup.html">Click here</a></p>
                </div>
            </form>
            <?php
            // Display any error messages
            if (isset($error_message)) {
                echo "<p style='color: red;'>$error_message</p>";
            }
            ?>
        </div>
    </div>
</body>
<script src="script.js"></script>
</html>
