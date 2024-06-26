<?php
// mark_lesson.php
include 'db_connect.php'; // Assuming this file contains your database connection logic
session_start();

if (!isset($_SESSION['student_id'])) {
    echo "Error: Student not logged in.";
    exit();
}

if (!isset($_GET['lesson_id'])) {
    echo "Error: Lesson ID not provided.";
    exit();
}

$student_id = $_SESSION['student_id'];
$lesson_id = $_GET['lesson_id'];
$completed_datetime = time(); // Current Unix timestamp

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $query = "INSERT INTO students_lesson (student_id, lesson_id, completed_datetime) VALUES (?, ?, ?)
              ON DUPLICATE KEY UPDATE completed_datetime = VALUES(completed_datetime)";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        exit();
    }

    $stmt->bind_param("iii", $student_id, $lesson_id, $completed_datetime); // Bind the parameters
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        exit();
    }

    $stmt->close();
    $conn->close();

    echo "<div class='alert alert-success'>Lesson marked as completed.</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Lesson</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            background-color: #ff9800;
            color: white;
            transition: background-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #e68900;
        }
        .btn-back {
            background-color: #ff9800;
            color: white;
            transition: background-color 0.3s ease, opacity 0.3s ease;
        }
        .btn-back:hover {
            background-color: #e68900;
            opacity: 0.8;
        }
        .fade-out {
            opacity: 0;
            transition: opacity 0.5s ease;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Complete Lesson</h5>
                <form action="mark_lesson.php?lesson_id=<?php echo $lesson_id; ?>" method="post">
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Student ID:</label>
                        <input type="text" class="form-control" id="student_id" name="student_id" value="<?php echo $student_id; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="lesson_id" class="form-label">Lesson ID:</label>
                        <input type="text" class="form-control" id="lesson_id" name="lesson_id" value="<?php echo $lesson_id; ?>" readonly>
                    </div>
                    <button type="submit" class="btn btn-custom">Mark Lesson as Completed</button>
                </form>
                <br>
                <button onclick="redirectToDashboard()" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </button>
            </div>
        </div>
    </div>
    <script>
        function redirectToDashboard() {
            document.body.classList.add('fade-out');
            setTimeout(() => {
                window.location.href = 'dashboard.php';
            }, 500);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
