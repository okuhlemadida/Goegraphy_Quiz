<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link rel="stylesheet" href="dash.css" />




</head>

<body>
    <header class="header">
        <div class="header-nav">
            <a href="notification.php" title="Notifications" classs="notification-icon" id="notificationIcon"> </a>
            <a href="logout.php" title="Log-out"></a>
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
            <a href="dashboard.php"> Dashboard</a>
            <a href="profile.php"> Profile</a>
            <a href="logout.php">Log Out</a>

        </div>
    </div>

    </div>
    
    <div class="form-container">
        <h2>Add a New Quiz Question</h2>

        <form action="submit_question.php" method="POST">
            <label for="question">Question:</label><br>
            <textarea id="question" name="question" rows="4" required></textarea><br><br>

            <label for="options[]">Option 1:</label><br>
            <input type="text" name="options[]" required><br><br>

            <label for="options[]">Option 2:</label><br>
            <input type="text" name="options[]" required><br><br>

            <label for="options[]">Option 3:</label><br>
            <input type="text" name="options[]" required><br><br>

            <label for="options[]">Option 4:</label><br>
            <input type="text" name="options[]" required><br><br>

            <label for="answer">Correct Answer:</label><br>
            <input type="text" name="answer" required><br><br>

            <button type="submit">Submit Question</button>
        </form>



    </div>
    <?php
    // Include your database configuration file
    require_once("config.php");

    // Connect to the database
    $conn = new mysqli(servername, username, password, database);
    if ($conn->connect_error) {
        die("<p class=\"error\"><strong>Connection failed: Database Not available</strong></p>");
    }

    $sql = "SELECT feedbackID, users.Username, feedback.feedback, feedback.rating, feedback.date_submitted 
        FROM feedback 
        JOIN users ON feedback.UserID = users.UserID
        ORDER BY feedback.date_submitted DESC";

$result = $conn->query($sql);
?>

<h2>Feedback Table</h2>
<table class="feedback">
    <thead>
        <tr>
            <th>User Name</th>
            <th>Feedback</th>
            <th>Rating</th>
            <th>Date Submitted</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['Username']) . "</td>"; // Sanitize output
                echo "<td>" . htmlspecialchars($row['feedback']) . "</td>"; // Sanitize output
                echo "<td>" . htmlspecialchars($row['rating']) . "</td>"; // Sanitize output
                echo "<td>" . htmlspecialchars($row['date_submitted']) . "</td>"; // Sanitize output
                echo "<td>";
                // Form to delete feedback
                echo "<form action='delete_feedback.php' method='POST' style='display:inline;'>";
                echo "<input type='hidden' name='feedback_id' value='" . htmlspecialchars($row['feedbackID']) . "'>"; // Ensure feedbackID is passed
                echo "<button type='submit' onclick='return confirm(\"Are you sure you want to delete this feedback?\");'>Delete</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No feedback available.</td></tr>"; // Message when no feedback is found
        }
        ?>
    </tbody>
</table>

<?php
// Close the database connection
$conn->close();
?>
    </div>
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
    </script>

</body>

</html>