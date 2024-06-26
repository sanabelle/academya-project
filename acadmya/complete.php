<?php
// completion.php
session_start();

if (!isset($_SESSION['student_id'])) {
    echo "Error: Student not logged in.";
    exit();
}

if (!isset($_GET['course_id'])) {
    echo "Error: Course ID not provided.";
    exit();
}

$student_id = $_SESSION['student_id'];
$course_id = $_GET['course_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'course_completion.php';
    check_course_completion($student_id, $course_id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Completion</title>
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
                <h5 class="card-title">Course Completion</h5>
                <form action="completion.php?course_id=<?php echo $course_id; ?>" method="post">
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Student ID:</label>
                        <input type="text" class="form-control" id="student_id" name="student_id" value="<?php echo $student_id; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="course_id" class="form-label">Course ID:</label>
                        <input type="text" class="form-control" id="course_id" name="course_id" value="<?php echo $course_id; ?>" readonly>
                    </div>
                    <button type="submit" class="btn btn-custom">Check Completion and Generate Certificate</button>
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
