<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

require_once("config.php");

// Connect to the database
$conn = new mysqli(servername, username, password, database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the questions and user answers from session
if (!isset($_SESSION['quiz_questions']) || !isset($_SESSION['user_answers'])) {
    echo "<h2>No quiz questions or answers available. Please try again.</h2>";
    exit;
}

$questions = $_SESSION['quiz_questions'];
$userAnswers = $_SESSION['user_answers'];

// Initialize score
$score = 0;

// Prepare to fetch correct answers from the database
$correctAnswers = [];

// Fetch correct answers for each question
foreach ($questions as $index => $question) {
    $questionID = $question['questionsID']; // Get question ID from the session
    $stmt = $conn->prepare("SELECT answer FROM questions WHERE questionsID = ?");
    $stmt->bind_param("i", $questionID); // Assuming questionsID is an integer
    $stmt->execute();
    $stmt->bind_result($correctAnswer);
    $stmt->fetch();
    $correctAnswers[$index] = $correctAnswer; // Store the correct answer
    $stmt->close();
}

// Calculate the score based on the user's answers
foreach ($correctAnswers as $index => $correctAnswer) {
    // Compare user's answer to the correct answer
    if (isset($userAnswers[$index]) && $userAnswers[$index] == $correctAnswer) {
        $score++; // Increment score for correct answers
    }
}

// Scale the score to be out of 5
$scaledScore = ($score / count($questions)) * 5; // Scale to out of 5

// Store the scaled score in the Attempts table
$userId = $_SESSION['UserID']; // Get the user's ID from the session
$stmt = $conn->prepare("INSERT INTO Attempts (UserID, timestamp, score) VALUES (?, NOW(), ?)");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("id", $userId, $scaledScore); // Binding as integer for UserID and decimal for score

if ($stmt->execute()) {
    echo "";
} else {
    echo "<h2>Error recording your score. Please try again later.</h2>";
}

$stmt->close();

// Clear the session questions and answers after processing
unset($_SESSION['quiz_questions']);
unset($_SESSION['user_answers']);
unset($_SESSION['current_question_index']); // Clear the current question index

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result</title>
    <style>
        body {
            background-color: whitesmoke;
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
        }

        .container {

            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 1000px;
            width: 90%;
            text-align: center;
            height: auto;

        }

        .quiz-container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            height: 150px;
            width: 100%;
            text-align: center;
        }

        .table-container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 800px;
            width: 100%;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
            color: #21d5d8;
        }

        p {
            font-size: 18px;
            margin: 20px 0;
            color: #5B2E91;
            font-weight: bold;
        }

        a {
            display: inline-block;
            background-color: #21d5d8;
            color: white;
            text-decoration: none;
            padding: 15px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            font-size: 16px;
        }

        a:hover {
            background-color: #67eff1;
        }

        .leaderboard {
            width: 1000px;
            padding: 20px;
        }

        .leaderboarddd {
            margin: 20px auto;
            /* Centering the leaderboard container */
            padding: 10px;
            /* Padding around the leaderboard */
            max-width: 1000px;
            /* Max width for large screens */
            width: 90%;
            /* Full width for small screens */
        }

        .leaderboard h2,
        .leaderboard h3 {
            text-align: center;
            /* Centering titles */
        }

        /* Responsive table styles */
        table {
            width: 100%;
            /* Full width for tables */
            border-collapse: collapse;
            /* Collapsing borders */
            margin-bottom: 20px;
            /* Space between tables */
        }

        th,
        td {
            border: 1px solid #ddd;
            /* Border for table cells */
            padding: 8px;
            /* Padding inside table cells */
            text-align: left;
            /* Left-align text */
        }

        th {
            background-color: #21d5d8;
            /* Header background color */
            color: white;
            /* Header text color */
        }

        /* Responsive adjustments for small screens */
        @media (max-width: 600px) {

            th,
            td {
                padding: 6px;
                /* Reduced padding for smaller screens */
                font-size: 14px;
                /* Smaller font size */
            }

            .leaderboard {
                overflow-x: auto;
                /* Allow horizontal scrolling */
            }
        }

        /* Feedback Form Styles */
        #feedback-form {
            background-color: #f9f9f9;
            /* Light gray background */
            border: 1px solid #ccc;
            /* Gray border */
            border-radius: 5px;
            /* Rounded corners */
            padding: 20px;
            /* Space inside the form */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Shadow effect */
            max-width: 400px;
            /* Maximum width of the form */
            margin: 20px auto;
            /* Center the form */
        }

        #feedback-form h3 {
            margin-bottom: 15px;
            /* Space below the heading */
        }

        #feedback-form label {
            font-weight: bold;
            /* Bold labels */
            margin-bottom: 5px;
            /* Space below labels */
            display: block;
            /* Make labels block elements */
        }

        #feedback-form input[type="text"],
        #feedback-form textarea,
        #feedback-form select {
            width: 100%;
            /* Full width */
            padding: 10px;
            /* Padding inside input fields */
            margin-bottom: 15px;
            /* Space below input fields */
            border: 1px solid #ccc;
            /* Gray border */
            border-radius: 4px;
            /* Rounded corners */
            font-size: 16px;
            /* Font size */
        }

        #feedback-form textarea {
            resize: vertical;
            /* Allow vertical resizing only */
        }

        #feedback-form button {
            background-color: #21d5d8;
            /* Blue background */
            color: white;
            /* White text */
            padding: 10px 15px;
            /* Padding inside buttons */
            border: none;
            /* Remove border */
            border-radius: 4px;
            /* Rounded corners */
            cursor: pointer;
            /* Pointer cursor */
            font-size: 16px;
            /* Font size */
        }

        #feedback-form button:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
        }

        #feedback-form #close-feedback {
            background-color: #dc3545;
            /* Red background for close button */
        }

        #feedback-form #close-feedback:hover {
            background-color: #c82333;
            /* Darker red on hover */
        }

        #feedback-button {
            display: inline-block;
            background-color: #21d5d8;
            color: white;
            text-decoration: none;
            padding: 15px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            font-size: 16px;
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
    <div class="container">
        <div class="quiz-container">
            <h1>Your Quiz Results</h1>
            <p>You scored <?php echo round($scaledScore, 2); ?> out of 5.</p>
            <a href="quiz.php">Take the Quiz Again</a>
        </div> <br><br>
        <div class="table-container">
            <?php
            // Database connection configuration
            require_once("config.php");

            // Connect to the database
            $conn = new mysqli(servername, username, password, database);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch the leaderboard data (userID, name, score, and completion_time)
            $sql = "SELECT users.username, attempts.score, attempts.timestamp
        FROM attempts
        JOIN users ON attempts.UserID = users.UserID
        ORDER BY attempts.score DESC, timestamp DESC";

            $result = $conn->query($sql);

            // Check if there are results
            if ($result->num_rows > 0) {
                echo '<div class="leaderboardd">
            <h3>Leaderboard Table</h3>
            <table class="leader">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Player Name</th>
                        <th>Score</th>
                        <th>Completed Time</th>
                    </tr>
                </thead>
                <tbody>';

                // Output the data row by row, generating the leaderboard
                $rank = 1;
                $seenUsernames = []; // Array to track seen usernames
                while ($row = $result->fetch_assoc()) {
                    $username = htmlspecialchars($row['username']);

                    // Only add the user if their username hasn't been added yet
                    if (!in_array($username, $seenUsernames)) {
                        echo '<tr>
                    <td>' . $rank . '</td>
                    <td>' . $username . '</td>
                    <td>' . htmlspecialchars($row['score']) . '</td>
                    <td>' . htmlspecialchars($row['timestamp']) . '</td>
                  </tr>';
                        $rank++; // Increment the rank
                        $seenUsernames[] = $username; // Mark this username as seen
                    }
                }

                echo '</tbody>
        </table>
        </div>';
            } else {
                echo '<p>No leaderboard data found.</p>';
            }

            // Close the database connection
            $conn->close();
            ?>


        </div><br><br>
        <button id="feedback-button">Leave Feedback</button>

        <!-- Feedback Form (initially hidden) -->
        <div id="feedback-form" style="display: none; margin-top: 20px;">
            <h3>Feedback Form</h3>
            <form action="submit_feedback.php" method="POST">
                <label for="feedback">Feedback:</label><br>
                <textarea id="feedback" name="feedback" rows="4" required></textarea><br><br>

                <label for="rating">Rating:</label><br>
                <select id="rating" name="rating" required>
                    <option value="5">5/5</option>
                    <option value="4">4/5</option>
                    <option value="3">3/5</option>
                    <option value="2">2/5</option>
                    <option value="1">1/5</option>
                </select><br><br>
                <label for="image">Upload Image:</label><br>
                <input type="file" id="image" name="image" accept="image/*"><br><br>

                <button type="submit">Submit Feedback</button>
                <button type="button" id="close-feedback">Close</button>
            </form>
        </div>

        <script>
            // Get the elements
            const feedbackButton = document.getElementById("feedback-button");
            const feedbackForm = document.getElementById("feedback-form");
            const closeFeedbackButton = document.getElementById("close-feedback");

            // Show the feedback form when "Leave Feedback" is clicked
            feedbackButton.addEventListener("click", function() {
                feedbackForm.style.display = "block";
            });

            // Close the feedback form when "Close" button is clicked
            closeFeedbackButton.addEventListener("click", function() {
                feedbackForm.style.display = "none";
            });
        </script>


    </div>
    </div>
    </div>

    <script>
        // JavaScript to handle feedback button click
        document.getElementById('feedback-button').onclick = function() {
            document.getElementById('feedback-form').style.display = 'block';
        };

        // JavaScript to handle close feedback button click
        document.getElementById('close-feedback').onclick = function() {
            document.getElementById('feedback-form').style.display = 'none';
        };
    </script>
    </div>
</body>

</html>