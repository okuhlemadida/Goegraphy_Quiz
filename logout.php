<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
</head>
<body>
    <?php
        session_start();

        // Check if the user is logged in
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            // Unset all session variables
            session_unset();
            // Destroy the session
            session_destroy();
            
            // Delete the cookie by setting its expiration time to the past
            setcookie("username", "", time() - 3600, "/");
        }

        // Redirect to the login page
        header("Location: login.php");
        exit; // Ensure no further code is executed
    ?>
</body>
</html>
