<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance System</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2176615f54.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            transition: margin-left 0.3s;
            overflow-x: hidden;
            display: flex;
            /* Prevent horizontal scroll */
        }

        .header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            background-color: rgba(34, 34, 34, 0.9);
            padding: 10px;
            position: fixed;
            width: 100%;
            height: 40px;
            top: 0;
            left: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .doodle {
            /*header animated doodle*/
            width: 40px;
            height: auto;
            margin-right: 10px;
        }

        .header-nav {
            display: flex;
            gap: 20px;
            margin-left: auto;
            /*1100px;*/
            margin-right: 20px;
        }

        .header-nav a {
            color: rgb(255, 255, 255);
            text-decoration: none;
            font-size: 20px;
            margin: 0 10px;
            font-weight: bold;
            transition: color 0.3s;
        }

        /* Responsive styling for small screens */
        @media (max-width: 600px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-nav {
                justify-content: flex-start;
                width: 100%;
                margin-bottom: 10px;
            }

            .search-container {
                width: 100%;
                margin-bottom: 10px;
            }

            .icon-button-link {
                align-self: flex-end;
                margin-bottom: 10px;
            }
        }

        .icon-button-link {
            text-decoration: none;

        }

        .icon-button {
            display: flex;
            align-items: center;
            background-color: transparent;
            border: none;
            cursor: pointer;
            font-size: 24px;
            margin-left: 150px;
        }

        .icon-button__badge {
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            margin-left: 5px;
        }

        .log-out {
            margin-right: 80px;


        }

        .material-icons {
            font-size: 24px;
        }

        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 55px;
            left: -250px;
            /* Hide the sidebar initially */
            background-color: gray;
            color: white;
            transition: left 0.3s;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            overflow-y: auto;
            margin-top: 9px;
        }

        .sidebar-header {
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
            background-color: gray;
            text-align: center;
            border-bottom: 1px solid #37475a;
            position: relative;
        }

        .sidebar-header .close-button {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 20px;
            cursor: pointer;
            display: none;
            /* Hidden by default */
        }

        .sidebar-menu {
            flex: 1;
        }

        .sidebar-menu a {
            display: block;
            padding: 15px 20px;
            text-decoration: none;
            color: white;
            font-size: 18px;
            transition: background-color 0.3s;
            border-bottom: 1px solid #37475a;
        }

        .sidebar-menu a:hover {
            background-color: #37475a;
        }

        .sidebar-menu a:active {
            background-color: whitesmoke;
            color: whitesmoke;
        }

        .menu-button {
            font-size: 24px;
            margin-top: 1.5em;
            cursor: pointer;
            background-color: #131921;
            color: white;
            border: none;
            padding: 15px;
            position: fixed;
            top: 30px;
            left: 20px;
            z-index: 1001;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.3s;
        }

        .menu-button:hover {
            background-color: #232f3e;
            transform: scale(1.05);
        }

        .user-info {
            text-align: center;
            padding: 20px;
            height: 210px;
            border-bottom: 1px solid #37475a;
            background-color: lightgrey;
        }

        .user-icon {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            margin-bottom: -50px;
        }

        .user-name {
            font-size: 18px;
            font-weight: bold;
            color: white;
        }

        .user-id {
            font-size: 16px;
            color: white;
        }


        .content {
            margin-left: 0;
            margin-top: 4em;
            display: flex;
            justify-content: center;
            transition: margin-left 0.3s;
            background-color: whitesmoke;
            height: auto;
            width: 100%;
        }

        .profile-card {
            background-color: whitesmoke;
            width: 100%;
            max-width: 1100px;
            margin-top: 4em;
            margin-bottom: 2em;
            height: 1300px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;


        }

        .profile-header {
            background-color: gray;
            padding: 30px;
            color: white;
            display: flex;
            align-items: center;
            position: relative;
        }

        .profile-header img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            margin-right: 20px;
            border: 4px solid #fff;
        }

        .profile-header h2 {
            font-size: 28px;
            margin: 0;
            color: #21d5d8;
        }

        .profile-header p {
            margin: 5px 0 0;
            font-size: 16px;
        }

        .profile-details {
            padding: 30px;
        }


        .profile-info {
            width: 800px;
            height: 500px;
            padding: 20px;
            background-color: whitesmoke;
            border-radius: 8px;
            font-family: Arial, sans-serif;
        }

        .profile-info p {
            font-size: 24px;
            line-height: 1.6;
            margin: 10px 0;
        }

        .profile-info strong {
            font-weight: bold;
            color: black;
        }

        .profile-info span {
            font-weight: normal;
            color: black;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px 10px;
            margin-top: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            display: inline-block;
        }

        .button-container {
            margin-top: 20px;
            width: 100%;
        }

        .edit-button,
        .save-button {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #21d5d8;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .edit-button:hover,
        .save-button:hover {
            background-color: #0056b3;
        }

        .edit-button:active,
        .save-button:active {
            background-color: #003d7a;
        }

        .save-button {
            background-color: #28a745;
        }

        .save-button:hover {
            background-color: #218838;
        }

        .save-button:active {
            background-color: #1e7e34;
        }

        /* Hides inputs by default */
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            display: none;
        }

        /* Makes sure buttons are aligned properly */
        .button-container button {
            margin: 10px;
        }

        .profile-header input[type="file"] {
            display: none;
        }

        .edit-icon {
            cursor: pointer;
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 24px;
            color: #fff;
            background-color: #21d5d8;
            border-radius: 50%;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #profilePicture {
            background-color: #ccc;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background-color: rgba(34, 34, 34, 0.9);
            color: white;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        .footer-quick-links {
            display: flex;
            justify-content: center;
            /* Center the links horizontally */
            margin: 10px 0;
            list-style-type: none;
            padding: 0;
            /* Remove padding for better spacing */
        }

        .footer-quick-links li {
            margin: 0 15px;
            /* Add horizontal spacing between links */
        }

        .footer-quick-links a {
            color: rgb(255, 255, 255);
            text-decoration: none;
            padding: 10px;
            transition: color 0.3s, font-size 0.3s;
            /* Smooth transition for hover effects */
        }

        .footer-quick-links a:hover {
            cursor: pointer;
            color: #f0c14b;
            font-size: 1.1em;
            /* Enlarge font size on hover */
        }

        .log-out {
            margin-right: 80px;


        }

        body {
            display: flex;
            flex-direction: column;
            /* Stack elements vertically */
        }

        .userEmail span {
            color: #21d5d8;
        }

        .content {
            flex-grow: 1;
            /* This makes the content expand to fill the available space */
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="header-nav">
            <a href="notification.php" title="Notifications" classs="notification-icon" id="notificationIcon"> </a>
            <a href="../login_p/logout.php" title="Log-out"></a>
        </div>
    </header>

    <button class="menu-button" id="menuButton" onclick="toggleSidebar()">☰</button>
    <?php


    require_once("config.php");

    // Check if the user ID is set in the session
    if (!isset($_SESSION['UserID'])) {
        die("<p class=\"error\"><strong>User is not logged in.</strong></p>");
    }

    // Get the user ID from the session
    $userID = $_SESSION['UserID'];

    // Create a new database connection
    $conn = new mysqli(servername, username, password, database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT UserID, Username, email FROM users WHERE UserID = ?");
    $stmt->bind_param("i", $userID); // Assuming UserID is an integer

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if the query executed successfully
    if ($result === FALSE) {
        die("<p class=\"error\"><strong>Query failed to execute</strong></p>");
    }

    // Check if exactly one result was returned
    if ($result->num_rows == 1) {
        // Fetch the result row
        $row = $result->fetch_assoc();
        $Name = $row['Username'];
        $email = htmlspecialchars($row['email']); // Sanitize email
        $fetchedUserID = $row['UserID'];

        // Store the wardenID in the session (not necessary since it's the same)
        // $_SESSION['UserID'] = $fetchedUserID; // Uncomment if needed
    } else {
        echo "<p>No profile found for this user.</p>";
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
    ?>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            GoeTrivia
            <span class="close-button" id="closeButton" onclick="toggleSidebar()">✖</span>
        </div>

        <div class="user-info">
            <img src="https://www.iconpacks.net/icons/2/free-icon-user-3296.png" alt="User Icon">
            <p class="user-name"><?php echo $Name ?></p>
            <p class="user-id"><?php echo $email ?></p>

        </div>
        <div class="sidebar-menu">
            <a href="index.php"> Home</a>
            <a href="profile.php"> Profile</a>
            <a href="logout.php">Log Out</a>

        </div>
    </div>
    <div class="content" id="content">
        <div class="profile-card">

            <div class="profile-header">
                <img src="https://www.iconpacks.net/icons/2/free-icon-user-3296.png" alt="User Icon">
                <div>
                    <h2 id="userName"><?php echo $Name; ?></h2>
                    <p id="userEmail">Email: <?php echo $email; ?></p>
                </div>
            </div>
            <div class="profile-details">
                <h1>Personal Information</h1>
                <div class="profile-info">
                    <form action="profile.php" method="POST">
                        <div>
                            <p><strong>Username: </strong>
                                <span id="userFirstName"><?php echo $Name; ?></span>
                                <input type="text" id="fullNameInput" name="fullNameInput" value="<?php echo $Name; ?>" style="display:none;">
                            </p>



                            <p><strong>Email: </strong>
                                <span id="userEmail"><?php echo $email; ?></span>
                                <input type="email" id="emailInput" name="emailInput" value="<?php echo $email; ?>" style="display:none;">
                            </p>

                            <p><strong>Password: </strong>
                                <span id="oldPasswordSpan">*********</span>
                                <input type="password" id="oldPasswordInput" name="oldPasswordInput" placeholder="Enter old password" style="display:none;">
                                <input type="checkbox" id="toggleOldPassword" onclick="togglePasswordVisibility('oldPasswordInput', 'oldPasswordSpan', this)"> Show Password
                            </p>

                            <div id="passwordSection" style="display:none;">
                                <p><strong>New Password: </strong>
                                    <input type="password" id="newPasswordInput" name="newPasswordInput" placeholder="Enter new password" style="display:none;">
                                    <input type="checkbox" id="toggleNewPassword" onclick="togglePasswordVisibility('newPasswordInput', 'newPasswordSpan', this)"> Show Password
                                </p>

                                <p><strong>Confirm New Password: </strong>
                                    <input type="password" id="confirmPasswordInput" name="confirmPasswordInput" placeholder="Confirm new password" style="display:none;">
                                    <input type="checkbox" id="toggleConfirmPassword" onclick="togglePasswordVisibility('confirmPasswordInput', 'confirmPasswordSpan', this)"> Show Password
                                </p>
                            </div>
                            <br>

                            <div class="button-container">
                                <button type="button" class="edit-button" id="editButton" onclick="editProfile()">Edit Profile</button>
                                <button type="submit" class="edit-button save-button" id="saveButton" style="display:none;">Save Changes</button>
                                <button type="button" class="edit-button cancel-button" id="cancelButton" onclick="cancelEdit()" style="display:none;">Cancel</button>
                            </div>
                            <div id="messageArea"></div>

                            <?php
                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                // Fetch form inputs
                                $newEmail = isset($_POST['emailInput']) ? trim($_POST['emailInput']) : null;
                                $newPassword = isset($_POST['newPasswordInput']) ? trim($_POST['newPasswordInput']) : null;
                                $oldPassword = isset($_POST['oldPasswordInput']) ? trim($_POST['oldPasswordInput']) : null;
                                $confirmPassword = isset($_POST['confirmPasswordInput']) ? trim($_POST['confirmPasswordInput']) : null;
                                $newName = isset($_POST['fullNameInput']) ? trim($_POST['fullNameInput']) : null;
                                $userID = $_SESSION['UserID'];

                                // Database connection
                                $conn = new mysqli(servername, username, password, database);

                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Fetch the hashed password from the database
                                $sql = "SELECT password FROM users WHERE UserID=?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $userID);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $currentPasswordHashed = $row['password'];

                                    // Initialize a flag for profile updates
                                    $profileUpdated = false;

                                    // Verify old password
                                    if (password_verify($oldPassword, $currentPasswordHashed)) {
                                        // Update the password if new password matches confirmation and is different from the old one
                                        if ($newPassword !== "" && $newPassword === $confirmPassword && !password_verify($newPassword, $currentPasswordHashed)) {
                                            $newPasswordHashed = password_hash($newPassword, PASSWORD_DEFAULT);
                                            $updatePasswordSql = "UPDATE users SET password = ? WHERE UserID = ?";
                                            $stmt = $conn->prepare($updatePasswordSql);
                                            $stmt->bind_param("si", $newPasswordHashed, $userID);

                                            if ($stmt->execute()) {
                                                echo "<p>Password changed successfully!</p>";
                                            } else {
                                                echo "<p>Error updating password!</p>";
                                            }
                                        } elseif ($newPassword === $oldPassword) {
                                            echo "<p>New password cannot be the same as the old password!</p>";
                                        } elseif ($newPassword !== $confirmPassword) {
                                            echo "<p>New password and confirmation do not match!</p>";
                                        }
                                    } else {
                                        echo "<p>Incorrect old password!</p>";
                                    }

                                    // Profile update logic (name, email)
                                    if (!empty($newName) || !empty($newEmail)) {
                                        $updateProfileSql = "UPDATE users SET Username = ?, email = ? WHERE UserID = ?";
                                        $stmt = $conn->prepare($updateProfileSql);
                                        $stmt->bind_param("ssi", $newName, $newEmail, $userID);

                                        if ($stmt->execute()) {
                                            echo "<p class='success'>Profile updated successfully!</p>";
                                            $profileUpdated = true;
                                        } else {
                                            echo "<p>Error updating profile!</p>";
                                        }
                                    }

                                    // Optionally notify the user if neither the password nor profile was updated
                                    if (!$profileUpdated && empty($newPassword)) {
                                        echo "<p>No changes made to profile or password.</p>";
                                    }
                                } else {
                                    echo "<p>User not found!</p>";
                                }

                                // Close the database connection
                                $stmt->close();
                                $conn->close();
                            }
                            ?>

                    </form>

                </div>


                <script>
                    function toggleSidebar() {
                        const sidebar = document.getElementById('sidebar');
                        const content = document.getElementById('content');
                        const menuButton = document.getElementById('menuButton');
                        const closeButton = document.getElementById('closeButton');

                        if (sidebar.style.left === '0px') {
                            sidebar.style.left = '-250px';
                            content.style.marginLeft = '0';
                            menuButton.style.display = 'block'; // Show the menu button
                            closeButton.style.display = 'none'; // Hide the close button
                        } else {
                            sidebar.style.left = '0px';
                            content.style.marginLeft = '250px';
                            menuButton.style.display = 'none'; // Hide the menu button
                            closeButton.style.display = 'block'; // Show the close button
                        }
                    }

                    function togglePasswordVisibility(inputId, spanId, checkbox) {
                        const input = document.getElementById(inputId);
                        const span = document.getElementById(spanId);
                        input.type = checkbox.checked ? 'text' : 'password';
                        span.style.display = checkbox.checked ? 'none' : 'block';
                    }

                    // Function to switch to edit mode
                    function editProfile() {
                        document.getElementById('passwordSection').style.display = 'block';

                        document.getElementById('userFirstName').style.display = 'none';
                        document.getElementById('fullNameInput').style.display = 'block';

                        document.getElementById('userEmail').style.display = 'none';
                        document.getElementById('emailInput').style.display = 'block';

                        document.getElementById('oldPasswordSpan').style.display = 'none';
                        document.getElementById('oldPasswordInput').style.display = 'block';

                        document.getElementById('newPasswordInput').style.display = 'block';
                        document.getElementById('confirmPasswordInput').style.display = 'block';

                        document.getElementById('saveButton').style.display = 'block';
                        document.getElementById('cancelButton').style.display = 'block';
                        document.getElementById('editButton').style.display = 'none';
                    }

                    // Function to cancel editing and return to view mode
                    function cancelEdit() {
                        document.getElementById('passwordSection').style.display = 'none';

                        document.getElementById('fullNameInput').style.display = 'none';
                        document.getElementById('userFirstName').style.display = 'block';

                        document.getElementById('emailInput').style.display = 'none';
                        document.getElementById('userEmail').style.display = 'block';

                        document.getElementById('oldPasswordSpan').style.display = 'block';
                        document.getElementById('oldPasswordInput').style.display = 'none';

                        document.getElementById('newPasswordInput').style.display = 'none';
                        document.getElementById('confirmPasswordInput').style.display = 'none';

                        document.getElementById('saveButton').style.display = 'none';
                        document.getElementById('cancelButton').style.display = 'none';
                        document.getElementById('editButton').style.display = 'block';
                    }

                    // Function to handle saving the profile
                    function saveProfile() {
                        // Perform any validation if needed
                        // Example: Check if passwords match or fields are filled correctly
                        document.querySelector('form').submit(); // Submit the form
                    }

                    // Make sure to remove the old cancelEdit function defined at the bottom
                    // It duplicates the previous function
                </script>


</body>

</html>