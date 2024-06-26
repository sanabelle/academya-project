<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Form</title>
    <link rel="stylesheet" href="css/CourseForm.css">
</head>

<body>

    <div class="container">
        <!-- Background Image -->
        <img class="background-image" src="./media/instructorcover.jpg" alt="Background Image">

        <!-- Form Container -->
        <div class="form-container">
            <!-- Heading -->
            <h1 class="heading">Important Information About Your Course</h1>

            <!-- Course Form -->
            <form method="post">
                <h2>Enter Your Course Information:</h2>

                <label for="course-title">Course Title:</label>
                <input type="text" id="course-title" name="course-title" required>

                <label for="course-duration">Course Duration:</label>
                <input type="text" id="course-duration" name="course-duration" required>

                <label for="course-price">Course Price:</label>
                <input type="text" id="course-price" name="course-price" required>

                <label for="number-of-lessons">Number of Lessons:</label>
                <input type="text" id="number-of-lessons" name="number-of-lessons" required>

                <label for="number-of-quizzes">Number of Quizzes:</label>
                <input type="text" id="number-of-quizzes" name="number-of-quizzes" required>

                <!-- Dropdown List -->
                <label for="tracks">Tracks:</label>
                <select id="tracks" name="tracks" required>
                    <option value="Frontend">Frontend</option>
                    <option value="Backend">Backend</option>
                </select>

                <!-- Submit Button -->
                <input type="submit" value="Submit">
            </form>

<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'instructor') {
    echo "Error: Instructor not logged in.";
    exit;
}

$instructor_id = $_SESSION['instructor_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "academya";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO courses (`Course Title`, `Course Duration`, `Course Price`, `Number of lessons`, `Number of Quizes`, `Tracks`, `is_progress`, `instructor_id`) VALUES (?, ?, ?, ?, ?, ?, 0, ?)");
    $stmt->bind_param("siiissi", $course_title, $course_duration, $course_price, $number_of_lessons, $number_of_quizzes, $tracks, $instructor_id);

    // Set parameters and execute
    $course_title = $_POST['course-title'];
    $course_duration = $_POST['course-duration'];
    $course_price = $_POST['course-price'];
    $number_of_lessons = $_POST['number-of-lessons'];
    $number_of_quizzes = $_POST['number-of-quizzes'];
    $tracks = $_POST['tracks'];
    $stmt->execute();

    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Course Created</title>
        <style>
            .message {
                font-size: 20px;
                text-align: center;
                margin-top: 50px;
                opacity: 0;
                transition: opacity 2s;
            }
            .message.visible {
                opacity: 1;
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var message = document.querySelector('.message');
                message.classList.add('visible');
                setTimeout(function() {
                    window.location.href = 'dashboard.php';
                }, 3000); // 3 second delay before redirect
            });
        </script>
    </head>
    <body>
        <div class='message'>New record created successfully. Redirecting to dashboard...</div>
    </body>
    </html>";

    $stmt->close();
    $conn->close();
    exit;
}
?>


        </div>
    </div>

</body>

</html>
