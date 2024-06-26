<?php
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

// Get course ID from URL
$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch course data
$sql = "SELECT * FROM courses WHERE course_id = $course_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $course = $result->fetch_assoc();
} else {
    echo "Course not found";
    exit;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .title {
            text-align: center;
            font-size: 32px;
            margin-bottom: 20px;
        }
        .course-detail {
            text-align: center;
        }
        .course-img img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .course-info {
            text-align: left;
        }
        .course-title {
            font-size: 28px;
            margin-bottom: 10px;
        }
        .course-description {
            margin-bottom: 15px;
            color: #666;
        }
        .course-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .course-meta div {
            display: flex;
            align-items: center;
            font-size: 14px;
        }
        .course-meta i {
            margin-right: 5px;
            color: #ff7708;
        }
        .course-actions a {
            display: inline-block;
            padding: 10px 20px;
            background: #ff7708;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .course-actions a:hover {
            background: #ff770880;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Course Details</h1>
        <div class="course-detail">
            <div class="course-img">
                <img src="path/to/course/image.jpg" alt="Course Image">
            </div>
            <div class="course-info">
                <h2 class="course-title"><?php echo htmlspecialchars($course['Course Title']); ?></h2>
                <p class="course-description"><?php echo htmlspecialchars($course['Course Description']); ?></p>
                <div class="course-meta">
                    <div>
                        <i class="fas fa-clock"></i>
                        <span><?php echo htmlspecialchars($course['Course Duration']); ?> hours</span>
                    </div>
                    <div>
                        <i class="fas fa-dollar-sign"></i>
                        <span><?php echo htmlspecialchars($course['Course Price']); ?></span>
                    </div>
                </div>
                <div class="course-actions">
                    <a href="#">Enroll Now</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
