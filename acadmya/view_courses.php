<?php
session_start();

// Debugging: Check session values
error_log("Student ID in session: " . (isset($_SESSION['student_id']) ? $_SESSION['student_id'] : 'Not set'));

if (!isset($_SESSION['student_id'])) {
    die("Student ID not set in session.");
}

// Database connection
$servername = "localhost";
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "academya";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if instructor_id is passed in the URL
if (!isset($_GET['instructor_id'])) {
    die("Instructor ID is not specified.");
}

$instructor_id = intval($_GET['instructor_id']); // Get the instructor ID from the URL
$student_id = $_SESSION['student_id']; // Ensure student_id is also set correctly

// Enroll in course if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];

    // Check if the student is already enrolled in the course
    $check_query = "SELECT * FROM enrolment WHERE student_id = ? AND course_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ii", $student_id, $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('You are already enrolled in this course!');</script>";
    } else {
        // Enroll the student in the course
        $enrolment_datetime = time();
        $completed_datetime = 0; // Set to 0 or a default value as it is not yet completed

        $insert_query = "INSERT INTO enrolment (student_id, course_id, enrolment_datetime, completed_datetime, attendance_status) VALUES (?, ?, ?, ?, 'enrolled')";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("iiii", $student_id, $course_id, $enrolment_datetime, $completed_datetime);

        if ($stmt->execute()) {
            echo "<script>alert('You have been enrolled in the course!');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
    }
}

// Retrieve courses from the database based on instructor_id
$query = "SELECT * FROM courses WHERE instructor_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $instructor_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Courses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            transition: opacity 0.5s ease-out;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .course-section {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #f5f5f5;
        }
        .course-section h2 {
            font-size: 1.5em;
            margin-top: 0;
            color: #333;
        }
        .course-section p {
            margin: 5px 0;
            color: #666;
        }
        .enroll-btn {
            background-color: #ff7708;
            color: #fff;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
            display: block;
            width: 100%;
        }
        .enroll-btn:hover {
            background-color: #ff770880;
        }
        .back-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
            display: block;
            width: 100%;
        }
        .back-btn:hover {
            background-color: #007bff80;
        }
    </style>
    <script>
        function redirectToDashboard() {
            const container = document.querySelector('.container');
            container.style.opacity = '0'; // Start fading out

            setTimeout(() => {
                window.location.href = 'dashboard.php'; // Redirect after fade out
            }, 500); // 500ms to match the transition duration
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Available Courses</h1>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="course-section">
                <h2><?php echo htmlspecialchars($row['Course Title']); ?></h2>
                <p><strong>Duration:</strong> <?php echo htmlspecialchars($row['Course Duration']); ?> hours</p>
                <p><strong>Price:</strong> $<?php echo htmlspecialchars($row['Course Price']); ?></p>
                <p><strong>Lessons:</strong> <?php echo htmlspecialchars($row['Number of lessons']); ?></p>
                <p><strong>Quizzes:</strong> <?php echo htmlspecialchars($row['Number of Quizes']); ?></p>
                <p><strong>Track:</strong> <?php echo htmlspecialchars($row['Tracks']); ?></p>
                <form method="post" action="view_courses.php?instructor_id=<?php echo $instructor_id; ?>">
                    <input type="hidden" name="course_id" value="<?php echo $row['course_id']; ?>">
                    <button type="submit" class="enroll-btn">Enroll</button>
                </form>
            </div>
        <?php endwhile; ?>
        <button class="back-btn" onclick="redirectToDashboard()">Back to Dashboard</button>
    </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
