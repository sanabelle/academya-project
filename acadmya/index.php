<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/all.min.css">
    <link rel="stylesheet" href="./css/home.css">
    <title>Project Website</title>
</head>
<body>
    <nav>
        <img src="./media/WhatsApp Image 2024-04-26 at 04.19.19_c8aad5b3.png" alt="Logo">
        <div class="navgation">
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#Courses">Courses</a></li>
                <li><a href="#reqistration">Registration</a></li>
                <li><a href="#feedback">Feedback</a></li>
                <li><a href="#instructors">Instructors</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li><a href="dashboard.php"><i class="fas fa-user"></i></a></li>
                <?php else: ?>
                    <li><a href="login.html">Login</a></li>
                    <li><a href="signup.html">Signup</a></li>
                <?php endif; ?>
            </ul>
            <i class="fas fa-bars" id="menu" onclick="showMenu()"></i>
            <i class="fas fa-times" id="close" onclick="closeMenu()"></i>
        </div>
    </nav>

    <section id="home">
        <h2>Welcome to Our Course Platform</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quam velit, vulputate eu pharetra nec, mattis ac neque.</p>
        <div class="btn">
            <a href="#features">Explore Features</a>
        </div>
    </section>

    <section id="features">
        <h1>Features</h1>
        <div class="fea-base">
            <div class="fea-box">
                <i class="fas fa-user-shield"></i>
                <h3>Secure</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
            <div class="fea-box">
                <i class="fas fa-laptop-code"></i>
                <h3>Interactive</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
            <div class="fea-box">
                <i class="fas fa-cogs"></i>
                <h3>Customizable</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
        </div>
    </section>

    <section id="Courses">
        <h1>Courses</h1>
        <div class="courses-box">
            <div class="courses">
                <img src="./media/course1.jpg" alt="Course 1">
                <div class="details">
                    <h3>Course Title 1</h3>
                    <span><i class="fas fa-clock"></i> 10 weeks</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <div class="star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <div class="courses">
                <img src="./media/course2.jpg" alt="Course 2">
                <div class="details">
                    <h3>Course Title 2</h3>
                    <span><i class="fas fa-clock"></i> 8 weeks</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <div class="star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <div class="courses">
                <img src="./media/course3.jpg" alt="Course 3">
                <div class="details">
                    <h3>Course Title 3</h3>
                    <span><i class="fas fa-clock"></i> 12 weeks</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <div class="star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="reqistration">
        <div class="reminber">
            <div class="time">
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="data">
                    <h1>Registration Deadline</h1>
                    <span>25th December 2024</span>
                </div>
            </div>
            <a href="#register" class="blue">Register Now</a>
        </div>
    </section>

    <section id="feedback">
        <h1>Client Feedback</h1>
        <div class="client">
            <div class="cont">
                <div class="img">
                    <img src="./media/client1.jpg" alt="Client 1">
                    <h3>John Doe</h3>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quam velit, vulputate eu pharetra nec, mattis ac neque.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>
            <div class="cont">
                <div class="img">
                    <img src="./media/client2.jpg" alt="Client 2">
                    <h3>Jane Smith</h3>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quam velit, vulputate eu pharetra nec, mattis ac neque.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>
            <div class="cont">
                <div class="img">
                    <img src="./media/client3.jpg" alt="Client 3">
                    <h3>Sam Wilson</h3>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quam velit, vulputate eu pharetra nec, mattis ac neque.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>
        </div>
    </section>

    <section id="instructors">
        <h1>Our Instructors</h1>
        <div class="instr">
            <div class="instr-box">
                <img src="./media/profile.png" alt="Instructor 1">
                <div class="details">
                    <div class="name">
                        <h3>Emily Johnson</h3>
                        <span>Expert in Mathematics</span>
                    </div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <div class="instr-box">
                <img src="./media/profile2.png" alt="Instructor 2">
                <div class="details">
                    <div class="name">
                        <h3>Michael Brown</h3>
                        <span>Expert in Science</span>
                    </div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <div class="instr-box">
                <img src="./media/profile3.png" alt="Instructor 3">
                <div class="details">
                    <div class="name">
                        <h3>Sarah Williams</h3>
                        <span>Expert in Arts</span>
                    </div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer id="footer">
        <div class="cont">
            <div>
                <h3>About Us</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quam velit, vulputate eu pharetra nec, mattis ac neque.</p>
            </div>
            <div>
                <h3>Contact Us</h3>
                <p>Email: info@courseplatform.com<br>Phone: +123 456 7890</p>
            </div>
            <div class="social">
                <h3>Follow Us</h3>
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
        <p>&copy; 2024 Acadmya. All Rights Reserved.</p>
    </footer>

    <script src="./js/main.js"></script>
		<script>
        document.addEventListener("DOMContentLoaded", function() {
            const isLoggedIn = <?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>;
            if (isLoggedIn) {
                document.getElementById("profile-icon").style.display = "block";
                document.getElementById("login-btn").style.display = "none";
                document.getElementById("signup-btn").style.display = "none";
            }
        });

        function showMenu() {
            document.getElementById('menu').style.display = 'none';
            document.getElementById('close').style.display = 'block';
        }

        function closeMenu() {
            document.getElementById('menu').style.display = 'block';
            document.getElementById('close').style.display = 'none';
        }
    </script>
</body>
</html>
