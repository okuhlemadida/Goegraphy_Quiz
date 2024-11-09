


const questions = [
    {
        question: "What is the capital of France?",
        answer: "C",
        options: ["A. Berlin", "B. Madrid", "C. Paris", "D. Rome"]
    },
    {
        question: "What is 2 + 2?",
        answer: "A",
        options: ["A. 4", "B. 22", "C. 5", "D. 2"]
    },
    {
        question: "What is the color of the sky?",
        answer: "A",
        options: ["A. Blue", "B. Green", "C. Red", "D. Yellow"]
    },
];

let currentQuestionIndex = 0;
let score = 0;

function loadQuestion() {
    const quizTitle = document.getElementById('quiz-title');
    const questionElement = document.getElementById('question');
    const optionsElement = document.getElementById('options');
    const resultMessage = document.getElementById('resultMessage');
    const nextButton = document.getElementById('nextQuestionBtn');

    // Update the title
    quizTitle.textContent = `Quiz Question ${currentQuestionIndex + 1}`;

    // Update the question text
    questionElement.textContent = questions[currentQuestionIndex].question;

    // Clear previous options
    optionsElement.innerHTML = '';

    // Display options as radio buttons
    questions[currentQuestionIndex].options.forEach((option, index) => {
        const label = document.createElement('label');
        label.classList.add('option');

        const radioInput = document.createElement('input');
        radioInput.type = 'radio';
        radioInput.name = 'option'; // Name is the same for grouping
        radioInput.value = option.charAt(0); // Use first letter as value (A, B, C, D)

        label.appendChild(radioInput);
        label.appendChild(document.createTextNode(option));
        optionsElement.appendChild(label);
    });

    // Hide the next button initially
    nextButton.style.display = 'none';

    // Clear previous result message
    resultMessage.textContent = '';
    resultMessage.className = ''; // Reset the class for result message
}

document.getElementById('submitAnswerBtn').addEventListener('click', function () {
    const selectedOption = document.querySelector('input[name="option"]:checked');
    const resultMessage = document.getElementById('resultMessage');
    const nextButton = document.getElementById('nextQuestionBtn');
    const options = document.querySelectorAll('#options label');

    // Check if an option is selected
    if (!selectedOption) {
        resultMessage.textContent = 'Please select an answer!';
        return;
    }

    const answerInput = selectedOption.value; // Get selected option value

    // Check answer and update score
    if (answerInput === questions[currentQuestionIndex].answer) {
        score++;
        resultMessage.textContent = 'Correct! Your score: ' + score;
        resultMessage.classList.add('correct'); // Add correct class

        // Highlight correct answer
        options.forEach((label) => {
            if (label.textContent.charAt(0) === questions[currentQuestionIndex].answer) {
                label.classList.add('highlight');
            }
        });
    } else {
        resultMessage.textContent = 'Incorrect! The correct answer was ' + questions[currentQuestionIndex].answer + '.';
        resultMessage.classList.add('incorrect'); // Add incorrect class
    }

    // Show next button
    nextButton.style.display = 'block';
    document.querySelectorAll('input[name="option"]').forEach(radio => radio.disabled = true); // Disable all options
});

document.getElementById('nextQuestionBtn').addEventListener('click', function () {
    currentQuestionIndex++;

    // Check if there are more questions
    if (currentQuestionIndex < questions.length) {
        loadQuestion();
    } else {
        // End of quiz
        const quizContainer = document.getElementById('quiz-container');
        quizContainer.innerHTML = `<h1>Quiz Completed!</h1><p>Your final score is: ${score} out of ${questions.length}</p>`;
    }
});

// Load the first question
loadQuestion();



function displayBrowserInfo() {
    const browserInfo = document.getElementById("browser-info");
    const appName = navigator.appName; // Get the browser's name
    const appVersion = navigator.appVersion; // Get the browser's version
    const userAgent = navigator.userAgent; // Get the user agent string
    const platform = navigator.platform; // Get the platform
    const cookiesEnabled = navigator.cookieEnabled; // Check if cookies are enabled

    // Display the information
    browserInfo.innerHTML = `
        <h2>Browser Information</h2>
        <p><strong>Browser Name:</strong> ${appName}</p>
        <p><strong>Browser Version:</strong> ${appVersion}</p>
        <p><strong>User Agent:</strong> ${userAgent}</p>
        <p><strong>Platform:</strong> ${platform}</p>
        <p><strong>Cookies Enabled:</strong> ${cookiesEnabled ? 'Yes' : 'No'}</p>
    `;
}

// Function to toggle the navigation menu
function toggleNavMenu() {
    const navMenu = document.getElementById("navbar");
    navMenu.classList.toggle("active"); // Toggle active class to show/hide links
}

// Event listener for the toggle button
document.getElementById("toggleBtn").addEventListener("click", toggleNavMenu);

// Load the browser information on page load
window.onload = displayBrowserInfo;

//validate review
document.getElementById('reviewForm').addEventListener('submit', function (event) {
    const name = document.getElementById('name').value.trim();
    const opinion = document.getElementById('opinion').value.trim();

    if (!name || !opinion) {
        event.preventDefault(); // Prevent form submission
        alert('Please fill in all fields without leaving blank spaces.');
    }
});
//validate login
function validateForm(event) {
    // Get the input fields
    const username = document.getElementById('stud_number').value;
    const password = document.getElementById('pass').value;

    // Check if any field is empty
    if (!username || !password) {
        event.preventDefault(); // Prevent form submission
        alert('Please fill in all fields.'); // Notify user
    }
}
function validateForm() {
    // Get username and password values
    let username = document.forms["loginForm"]["username"].value;
    let password = document.forms["loginForm"]["password"].value;

    // Check if username is empty
    if (username == "") {
        alert("Username must be filled out");
        return false;  // Prevent form submission
    }

    // Check if password is empty
    if (password == "") {
        alert("Password must be filled out");
        return false;  // Prevent form submission
    }

    // If both fields are filled, allow form submission
    return true;
}

function validateSignupForm() {
    // Get form values
    let username = document.forms["signupForm"]["username"].value;
    let email = document.forms["signupForm"]["email"].value;
    let password = document.forms["signupForm"]["password"].value;
    let confirmPassword = document.forms["signupForm"]["confirm_password"].value;

    // Validate username
    if (username == "") {
        alert("Username must be filled out");
        return false;
    }

    // Validate email using a basic email regex pattern
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address");
        return false;
    }

    // Validate password is not empty
    if (password == "") {
        alert("Password must be filled out");
        return false;
    }

    // Check if password and confirm password match
    if (password !== confirmPassword) {
        alert("Passwords do not match");
        return false;
    }

    // If all validations pass, allow form submission
    return true;
}
document.getElementById('appName').textContent = 'App Name: ' + navigator.appName;
document.getElementById('appVersion').textContent = 'App Version: ' + navigator.appVersion;
document.getElementById('language').textContent = 'Language: ' + navigator.language;
document.getElementById('platform').textContent = 'Platform: ' + navigator.platform;
document.getElementById('userAgent').textContent = 'User Agent: ' + navigator.userAgent;

// Use the navigator.onLine method to check if the user is online or offline
if (!navigator.onLine) {
    alert('You are offline! Some features may not be available.');
}

// Check if the browser supports notifications
if (!("Notification" in window)) {
    alert('This browser does not support desktop notifications.');
} else if (Notification.permission === "granted") {
    // Use the navigator.geolocation method to get the user's location (if permission is granted)
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                // Send a notification indicating that location access was granted
                new Notification('Location Accessed', {
                    body: 'Your location has been accessed.',
                });
            },
            (error) => {
                console.warn('Error: ' + error.message);
            }
        );
    } else {
        alert('Geolocation is not supported by your browser.');
    }
} else {
    // Request notification permission
    Notification.requestPermission().then((permission) => {
        if (permission === "granted") {
            // Use the navigator.geolocation method to get the user's location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        // Send a notification indicating that location access was granted
                        new Notification('Location Accessed', {
                            body: 'Your location has been accessed.',
                        });
                    },
                    (error) => {
                        console.warn('Error: ' + error.message);
                    }
                );
            } else {
                alert('Geolocation is not supported by your browser.');
            }
        } else {
            alert('Notification permission denied.');
        }
    });
}

// Display a message if the user is on a mobile device
if (/Mobi|Android/i.test(navigator.userAgent)) {
    document.getElementById('mobileMessage').style.display = 'block';
}






