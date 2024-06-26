<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
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

    // Get course_id from URL
    if (isset($_GET['course_id'])) {
        $course_id = intval($_GET['course_id']);
    } else {
        die("Course ID not provided.");
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO lessons (`Lesson Title`, `Lesson Duration`, `Lesson Description`, `The Order of lesson`, `video_url`, `file_url`, `course_id`) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissssi", $lesson_title, $lesson_duration, $lesson_description, $order_of_lesson, $video_url, $file_url, $course_id);

 $lesson_title = $_POST['lesson-title'];
    $lesson_duration = $_POST['lesson-duration'];
    $lesson_description = $_POST['lesson-description'];
    $order_of_lesson = $_POST['order-of-lesson'];

    // Handle file uploads
    $upload_directory = 'uploads/';
    $lesson_file = $_FILES['lesson-file']['name'];
    $lesson_file_temp = $_FILES['lesson-file']['tmp_name'];
    $lesson_video = $_FILES['lesson-video']['name'];
    $lesson_video_temp = $_FILES['lesson-video']['tmp_name'];

    // Move uploaded files to desired location
    move_uploaded_file($lesson_file_temp, $upload_directory . $lesson_file);
    move_uploaded_file($lesson_video_temp, $upload_directory . $lesson_video);

    // Set file URLs
    $file_url = $upload_directory . $lesson_file;
    $video_url = $upload_directory . $lesson_video;

    if ($stmt->execute()) {
        echo "<p>New lesson created successfully</p>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lesson Form</title>
    <link rel="stylesheet" href="css/LessonForm.css">
</head>
<body>
 <div class="container">
        <div class="form-container">
            <h1 class="heading">Important Information About Your Lesson
                <br><a href="dashboard.php"><i class="fas fa-arrow-left"></i> Back to Dashboard</a></h1>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="lesson-title">Lesson Title:</label>
                    <input type="text" id="lesson-title" name="lesson-title" required>
                </div>
                <div class="form-group">
                    <label for="lesson-duration">Lesson Duration:</label>
                    <input type="text" id="lesson-duration" name="lesson-duration" required>
                </div>
                <div class="form-group">
                    <label for="lesson-description">Lesson Description:</label>
                    <input type="text" id="lesson-description" name="lesson-description" required>
                </div>
                <div class="form-group">
                    <label for="order-of-lesson">The Order of Lesson:</label>
                    <input type="text" id="order-of-lesson" name="order-of-lesson" required>
                </div>
                <div class="form-group">
                    <label for="lesson-file">Import Your Lesson File:</label>
                    <input type="file" id="lesson-file" name="lesson-file" class="input-file" required>
                </div>
                <div class="form-group">
                    <label for="lesson-video">Import Your Lesson Video:</label>
                    <input type="file" id="lesson-video" name="lesson-video" class="input-file" required>
                </div>
                <button type="submit" class="submit-button">Submit</button>
            </form>
			</div>
    </div>
</body>
</html>
