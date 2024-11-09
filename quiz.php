<?php
session_start();


// Check if the user is already logged in or if the cookie exists
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    if (isset($_COOKIE['username'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $_COOKIE['username']; // Use the username from the cookie
    } else {
        header('Location: login.php'); // Redirect to login if not logged in
        exit;
    }
}

require_once("config.php");

// Connect to the database
$conn = new mysqli(servername, username, password, database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the questions from the database if not already in the session
if (!isset($_SESSION['quiz_questions'])) {
    $sql = "SELECT * FROM Questions ORDER BY RAND() LIMIT 5";
    $result = $conn->query($sql);

    $questions = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }
    }
    $_SESSION['quiz_questions'] = $questions; // Store questions in session
}

// Get current question index
$current_question_index = isset($_SESSION['current_question_index']) ? $_SESSION['current_question_index'] : 0;
$questions = $_SESSION['quiz_questions'];

// If the current index is greater than or equal to the number of questions, redirect to the submission page
if ($current_question_index >= count($questions)) {
    header('Location: submit_quiz.php');
    exit;
}

// Display the current question
$current_question = $questions[$current_question_index];
$options = json_decode($current_question['options'], true);

if (!is_array($options)) {
    echo "<p>Invalid question format.</p>";
    exit;
}

// Initialize score session if not set
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link rel="stylesheet" href="style.css">
    <script>
        let timeLeft = 10; // Timer duration

        function startTimer() {
            const timerElement = document.getElementById('timer');
            const formElement = document.querySelector('form');
            const timerExpiredInput = document.getElementById('timerExpired');

            // Timer countdown function
            let countdown = setInterval(function() {
                if (timeLeft <= 0) {
                    clearInterval(countdown); // Stop the timer
                    timerExpiredInput.value = '1'; // Set hidden field to indicate timer expired

                    // Check if it's the last question
                    const isLastQuestion = <?php echo json_encode($current_question_index >= count($questions) - 1); ?>;
                    if (isLastQuestion) {
                        formElement.submit(); // Submit the quiz on the last question
                    } else {
                        formElement.submit(); // Move to next question on non-last questions
                    }
                } else {
                    timerElement.innerHTML = timeLeft; // Update the timer display
                    timeLeft--;
                }
            }, 1000); 
        }
    </script>

</head>

<body onload="startTimer()">


    <div class="quiz-container">
        <h2>Question <?php echo $current_question_index + 1; ?> of <?php echo count($questions); ?></h2>
        <div id="timer" class="timer">10</div> <!-- Timer display element -->

        <h3><?php echo $current_question['question']; ?></h3>

        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>"> <!-- Stay on the same page -->
            <?php foreach ($options as $key => $option): ?>
                <div class="option">
                    <input type="radio" name="answer" value="<?php echo $option; ?>" required> <?php echo $option; ?><br>
                </div>
            <?php endforeach; ?>
            <input type="hidden" id="timerExpired" name="timerExpired" value="0">
            <?php if ($current_question_index < count($questions) - 1): ?>
                <button type="submit" name="next">Next Question</button>

            <?php else: ?>
                <button type="submit" name="submit">Submit Quiz</button>
            <?php endif; ?>
        </form>
        
        <?php
        // Handle the form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Save the answer if the user selected one
            if (isset($_POST['answer'])) {
                $_SESSION['user_answers'][$current_question_index] = $_POST['answer'];

                // Check if the answer is correct and update the score
                if ($_POST['answer'] == $current_question['correct_answer']) {
                    $_SESSION['score']++;
                }
            }

            // If the timer expired or the user clicked 'Next' or 'Submit'
            if (isset($_POST['timerExpired']) && $_POST['timerExpired'] == '1') {
                // Timer expired, check if it's the last question
                if ($current_question_index < count($questions) - 1) {
                    // Move to the next question
                    $_SESSION['current_question_index'] = $current_question_index + 1;

                    // Redirect to the same page to show the next question
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                } else {
                    // Timer expired on the last question, submit the quiz
                    header('Location: submit_quiz.php');
                    exit;
                }
            } elseif (isset($_POST['next'])) {
                // User clicked 'Next', move to the next question
                $_SESSION['current_question_index'] = $current_question_index + 1;

                // Redirect to the same page to show the next question
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            } elseif (isset($_POST['submit'])) {
                // User clicked 'Submit', submit the quiz
                header('Location: submit_quiz.php');
                exit;
            }
        }
        ?>


    </div>
</body>

</html>