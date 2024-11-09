<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css" />

    <title>Web</title>
</head>

<body>
    <header>
        <div class="top">

            <div class="logo">
                <a href="index.html" class="logoo">
                    Geo Trivia
                </a>
                <button class="menu-button" id="menuButton" onclick="toggleSidebar()">☰</button>
                <div id="navbar" class="navmenu">
                    <a href="index.php">Home</a>
                    <a href="#about">About</a>
                    <a href="#developers">Team</a>
                    <a href="#contact">Contact</a>

                </div>

            </div>

        </div>



        <div class="carousel">
            <div class="carousel-slide active">
                <img class="home-background" src="CoolRubrik.jpg" alt="background">
                <div class="home-title">
                    <h1>Challenge Your Brain with Exciting Quizzes</h1>
                    <div class="decorative-line"></div>
                    <p class="textt">Welcome to Trivia Trails, the ultimate destination for quiz enthusiasts.
                        Explore our wide range of engaging quizzes and put your knowledge to the test</p>
                    <a href="login.php"><button class="getstarted-btn">Get Started</button></a>


                </div>
            </div>
            <div class="carousel-slide">
                <img class="home-background" src="Screenshot (148).png" alt="background">
                <div class="home-title">
                    <h1>Challenge Your Brain with Exciting Quizzes</h1>
                    <div class="decorative-line"></div>
                    <p class="textt">Welcome to Trivia Trails, the ultimate destination for quiz enthusiasts.
                        Explore our wide range of engaging quizzes and put your knowledge to the test</p>
                    <a href="login.php"><button class="getstarted-btn">Get Started</button></a>

                </div>
            </div>
            <div class="carousel-controls">
                <span class="prev" onclick="moveSlide(-1)">&#10094;</span>
                <span class="next" onclick="moveSlide(1)">&#10095;</span>
            </div>
        </div>

    </header>
    <script>
        // JavaScript to highlight the current div in the header
        const divs = document.querySelectorAll('div');
        const navLinks = document.querySelectorAll('#navbar a');

        function changeActiveLink() {
            let scrollPosition = window.scrollY;

            divs.forEach(div => {
                const divTop = div.offsetTop;
                const divHeight = div.clientHeight;

                if (scrollPosition >= divTop && scrollPosition < divTop + divHeight) {
                    navLinks.forEach(link => {
                        link.classList.remove('active'); // Remove active class from all links
                        if (link.getAttribute('href') === '#' + div.id) {
                            link.classList.add('active'); // Add active class to the current link
                        }
                    });
                }
            });
        }

        window.addEventListener('scroll', changeActiveLink);
    </script>

    <div class="sidebar" id="sidebar">

        <div class="sidebar-menu">
            <span class="close-button" id="closeButton" onclick="toggleSidebar()">✖</span>
            <a href="#about">About</a>
            <a href="#developers">Team</a>
            <a href="#contact">Contact</a>
        </div>
    </div>
    <script>
        let slideIndex = 0;
        const slides = document.querySelectorAll('.carousel-slide');

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.style.opacity = i === index ? '1' : '0';
            });
        }

        function moveSlide(step) {
            slideIndex = (slideIndex + step + slides.length) % slides.length;
            showSlide(slideIndex);
        }

        // Auto-play slides every 5 seconds
        setInterval(() => {
            moveSlide(1);
        }, 5000);

        // Show the first slide initially
        showSlide(slideIndex);

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
        // Function to handle the active state for each menu link
        function setActiveLink() {
            const sections = document.querySelectorAll("section"); // Assuming you have sections with ids that match the navbar links
            const navLinks = document.querySelectorAll(".navmenu a");

            let currentSection = "";

            // Iterate through each section to determine which one is in the viewport
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 50; // Adjust offset as needed
                const sectionHeight = section.offsetHeight;
                if (window.scrollY >= sectionTop && window.scrollY < sectionTop + sectionHeight) {
                    currentSection = section.getAttribute("id"); // Get the id of the current section
                }
            });

            // Remove "active" class from all links and then add to the current one
            navLinks.forEach(link => {
                link.classList.remove("active");
                if (link.getAttribute("href").substring(1) === currentSection) {
                    link.classList.add("active");
                }
            });
        }

        // Call the function on scroll and when the page is loaded
        window.addEventListener("scroll", setActiveLink);
        window.addEventListener("load", setActiveLink);
    </script>

    <section id="about">
        <div class="about">
            <div class="about-title">
                <h2>About <span>Trivia Trails</span></h2>
            </div>

            <div class="about-content">

                <div class="text-section">

                    <p>Our interactive geography quiz is designed to challenge and expand your knowledge of the world's
                        countries, capitals, landmarks, and physical geography. Whether you're a geography enthusiast or
                        just starting to explore the world, this quiz offers questions of varying difficulty, covering
                        continents, borders, and famous sites.</p>
                    <ul>
                        <li>Log in</li>
                        <li>Start the quiz</li>
                        <li>10 seconds on each question</li>
                        <li>Submit the Quiz and get your score</li>
                    </ul>
                </div>

                <iframe class="vid" width="400" height="400" src="https://www.youtube.com/embed/RXFm4zcrpUg"
                    title="World Geography Quiz | 100 Questions -  How Many Can You Answer? | Best Ultimate Quiz"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    </section>
    <h1 class="sample">Sample Quiz</h1>
    <div id="quiz-container">
        <h2 id="quiz-title">Sample Quiz!</h2>
        <p id="question">What is the capital of France?</p>
        <div id="question"></div>
        <div id="options"></div><br>
        <button id="submitAnswerBtn">Submit Answer</button>
        <p id="resultMessage"></p>
        <button id="nextQuestionBtn"
            style="display:none; color: #fff; background-color: #21d5d8; border: none; border-radius: 5px; padding: 10px 15px; cursor: pointer;">Next
            Question</button>

    </div><br><br>


    <div class="link-container">
        <a href="review.php" class="review">Review</a>
    </div>

    <section id="developers">
        <div class="developers">
            <div class="about-title">


            </div>

            <div class="about-title">
                <h2>Meet Our Team</h2>
                <div class="decorative-line"></div>
            </div>
            <div class="pictures">
                <div class="member1">
                    <h4>Supreme Madida</h4>
                    <div><img class="home-background" src="NKULLY.jpg" alt="background"></div>
                    <div class="in-categories" style="background-color:#21d5d8;">
                        <p class="category">UI/UX Designer <br> Designs the user interface and experience of Trivia
                            Trails.</p>
                    </div>
                </div>
                <div class="member2">
                    <h3>Sinethemba Ndwandwe</h3>
                    <div><img class="home-background" src="snette.jpg" alt="background"></div>
                    <div class="in-categories" style="background-color:#21d5d8;">
                        <p class="category">Quality Assurance Lead <br> Leads the testing of Trivia Trails to identify
                            and fix bugs.</p>
                    </div>
                </div>
            </div>
    </section>
    <section id="contact" class="contact">
        <div class="about-title">
            <h1>Contact</h1>
            <p> Contact us for more information,concerns, or inquiries</p>
        </div>
        <div class="containerr">
            <div class="info-wrap">
                <div class="row">
                    <div class="info">
                        <h5><i class="mapp"><svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                        d="m3.5 5.5 7.893 6.036a1 1 0 0 0 1.214 0L20.5 5.5M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                                </svg></i></h5>
                        <h4>Email:</h4>
                        <p>geotrivia@gmail.com</p>
                    </div>

                    <div class="info">
                        <h5><i class="mapp"><svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M18.427 14.768 17.2 13.542a1.733 1.733 0 0 0-2.45 0l-.613.613a1.732 1.732 0 0 1-2.45 0l-1.838-1.84a1.735 1.735 0 0 1 0-2.452l.612-.613a1.735 1.735 0 0 0 0-2.452L9.237 5.572a1.6 1.6 0 0 0-2.45 0c-3.223 3.2-1.702 6.896 1.519 10.117 3.22 3.221 6.914 4.745 10.12 1.535a1.601 1.601 0 0 0 0-2.456Z" />
                                </svg></i></h5>
                        <h4>Call:</h4>
                        <p>+27 89 2345 5112</p>
                    </div>
                    <div class="info">
                        <h5>
                            <i class="mapp">
                                <a href="https://www.facebook.com/yourprofile">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z"
                                            clip-rule="evenodd" />
                                    </svg></a>
                            </i>

                        </h5>
                        <h4>Facebook <br></h4>
                    </div>
                    <div class="info">
                        <h5><i class="mapp">
                                <a href="https://twitter.com/yourprofile" target="_blank">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M23.953 4.57c-.885.392-1.83.654-2.825.775a4.935 4.935 0 0 0 2.163-2.724 9.867 9.867 0 0 1-3.127 1.195A4.92 4.92 0 0 0 16.616 3c-2.736 0-4.95 2.224-4.95 4.97 0 .39.045.765.126 1.124C7.691 8.087 4.066 6.13 1.64 3.161c-.422.724-.666 1.56-.666 2.475 0 1.71.87 3.213 2.188 4.093a4.897 4.897 0 0 1-2.24-.616v.062c0 2.38 1.693 4.373 3.946 4.83a4.935 4.935 0 0 1-2.24.085c.634 1.975 2.475 3.413 4.653 3.453A9.867 9.867 0 0 1 0 19.54a13.933 13.933 0 0 0 7.548 2.211c9.056 0 14.004-7.496 14.004-13.986 0-.213 0-.426-.015-.637A10.003 10.003 0 0 0 24 4.59a9.878 9.878 0 0 1-2.847.775 4.935 4.935 0 0 0 2.163-2.724z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a></i>
                        </h5>
                        <h4>Twitter</h4>
                    </div>
                    <div class="info">
                        <h5>
                            <i class="mapp">
                                <a href="https://www.instagram.com/yourprofile" target="_blank">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M12 2.163c3.206 0 3.593.012 4.86.07 1.263.058 2.06.27 2.54.57.486.303.822.7 1.125 1.125.3.48.512 1.277.57 2.54.058 1.267.07 1.654.07 4.86s-.012 3.593-.07 4.86c-.058 1.263-.27 2.06-.57 2.54-.303.486-.7.822-1.125 1.125-.48.3-1.277.512-2.54.57-1.267.058-1.654.07-4.86.07s-3.593-.012-4.86-.07c-1.263-.058-2.06-.27-2.54-.57-.486-.303-.822-.7-1.125-1.125-.3-.48-.512-1.277-.57-2.54C2.175 12.593 2.163 12.206 2.163 9s.012-3.593.07-4.86c.058-1.263.27-2.06.57-2.54.303-.486.7-.822 1.125-1.125.48-.3 1.277-.512 2.54-.57C8.407 2.175 8.794 2.163 12 2.163zm0-2.163C8.736 0 8.326.012 7.054.07 5.755.129 4.86.38 4.045.73 3.2 1.08 2.553 1.67 2.045 2.18c-.51.51-1.1 1.155-1.45 2.055C.12 5.326 0 5.736 0 9s.012 3.593.07 4.86c.058 1.263.27 2.06.57 2.54.303.486.7.822 1.125 1.125.48.3 1.277.512 2.54.57 1.267.058 1.654.07 4.86.07s3.593-.012 4.86-.07c1.263-.058 2.06-.27 2.54-.57.486-.303.822-.7 1.125-1.125.3-.48.512-1.277.57-2.54.058-1.267.07-1.654.07-4.86s-.012-3.593-.07-4.86c-.058-1.263-.27-2.06-.57-2.54-.303-.486-.7-.822-1.125-1.125-.48-.3-1.277-.512-2.54-.57-1.267-.058-1.654-.07-4.86-.07zm0 6.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11zm0 9a3.5 3.5 0 1 1 0-7 3.5 3.5 0 0 1 0 7zm5.5-9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a></i>
                        </h5>
                        <h4>Instagram <br></h4>
                    </div>
                </div>
            </div>
        </div>
        <?php

        // Database connection
        require_once('config.php');
        $conn = new mysqli(servername, username, password, database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to fetch feedback with associated usernames
        $sql = "SELECT users.Username, feedback.feedback, feedback.rating, feedback.date_submitted, feedback.image 
        FROM feedback  
        JOIN users ON feedback.UserID = users.UserID
        ORDER BY feedback.date_submitted DESC";

        $result = $conn->query($sql);
        ?>

<div class="testimonials section-title" data-aos="fade-up">
    <div class="testmons">
    <h2>Reviews</h2>
    <p>What they're saying about us</p>
    </div>
</div>

<div class="testimonials" data-aos="fade-up" data-aos-delay="100">
    <div class="swiper init-swiper" data-speed="600" data-delay="5000">
        <script type="application/json" class="swiper-config">
            {
                "loop": true,
                "speed": 600,
                "autoplay": {
                    "delay": 5000
                },
                "slidesPerView": 1,
                "pagination": {
                    "el": ".swiper-pagination",
                    "type": "bullets",
                    "clickable": true
                },
                "breakpoints": {
                    "320": {
                        "slidesPerView": 1,
                        "spaceBetween": 40
                    },
                    "768": {
                        "slidesPerView": 2,
                        "spaceBetween": 20
                    },
                    "1200": {
                        "slidesPerView": 3,
                        "spaceBetween": 20
                    }
                }
            }
        </script>
        <div class="swiper-wrapper">

        <?php
            // Initialize an array to keep track of displayed usernames
            $displayedUsernames = array();

            if ($result->num_rows > 0) {
                // Loop through the results and create a slide for each testimonial
                while ($row = $result->fetch_assoc()) {
                    $username = htmlspecialchars($row['Username']);
                    $feedbackText = htmlspecialchars($row['feedback']);
                    $rating = intval($row['rating']); // Get the rating and convert it to an integer
                    
                    // Check if the username has already been displayed
                    if (!in_array($username, $displayedUsernames)) {
                        // If not displayed, add to the array and output the testimonial
                        $displayedUsernames[] = $username; // Store the username to avoid duplicates
                        ?>
                        <div class="swiper-slide">
                            <div class="testimonial-card">
                                <p>
                                    <i class="bi bi-quote quote-icon-left"></i>
                                    <span><?php echo $feedbackText; ?></span>
                                    <i class="bi bi-quote quote-icon-right"></i>
                                </p>
                                <h3><?php echo $username; ?></h3>
                                <h4><?php echo str_repeat('⭐', $rating); ?></h4> <!-- Displaying stars based on rating -->
                            </div>
                        </div><!-- End testimonial card -->
                        <?php
                    }
                }
            } else {
                echo "<p>No testimonials available.</p>";
            }
            ?>

        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>

<?php
// Close the database connection
$conn->close();
?>



    </section><br><br>
    <hr><br>
    <div id="browser-info"></div>
    <footer class="footer-section">
        <div class="containerr">
            <div class="footer-columns">
                <div class="footer-column">
                    <h3>About Us</h3>
                    <p>GoeTrivia where we offer exciting quizzes to relax your brain and have fun.
                        It's questions from science to celebrities to global events, whatever mood you are in, we provide
                        the best.</p>
                </div>
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#developers">Team</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Contact Info</h3>
                    <ul>
                        <li><i class="fas fa-phone-alt"></i> +27(0) 31 456 7890</li>
                        <li><i class="fas fa-envelope"></i> geotrivia@gmail.com</li>
                        <li><i class="fas fa-map-marker-alt"></i> Hamilton Building, Prince Alfred St,
                            Grahamstown, Makhanda, 6139</li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Follow Us</h3>
                    <ul class="social-links">
                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="decorative-line"></div>
        <div class="footer-bottom">
            <p>&copy; 2024 MindUnits. All Rights Reserved.</p>
        </div>
    </footer>


    <script src="script.js"></script>

</body>


</html>