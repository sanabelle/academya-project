<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['user_type'])) {
    header('Location: index.html');
    exit;
}

$user = $_SESSION['user'];
$user_type = $_SESSION['user_type'];
$course_id = $_GET['course_id'];

// Database connection setup
$dsn = 'mysql:host=localhost;dbname=academya';
$db_username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $db_username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Fetch course and instructor details
$stmt = $pdo->prepare('SELECT courses.*, instructor.instructor_email, instructor.instructor_username FROM courses INNER JOIN instructor ON courses.instructor_id = instructor.id WHERE course_id = ?');
$stmt->execute([$course_id]);
$course = $stmt->fetch();

if (!$course) {
    die('Course not found');
}

$instructor_email = $course['instructor_email'];
$instructor_username = $course['instructor_username'];
$student_username = $user['username']??$user['instructor_username']??'';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - <?php echo htmlspecialchars($course['Course Title']); ?></title>
    <link rel="stylesheet" href="css/chat.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container mt-4">
        <a href="dashboard.php" class="btn btn-outline-secondary mb-3"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        <h1 class="mb-4">Chat for <?php echo htmlspecialchars($course['Course Title']); ?></h1>
        <div id="chat-container" class="mb-3 border rounded p-3" style="height: 400px; overflow-y: scroll;">
            <!-- Chat messages will be displayed here -->
        </div>
        <form id="chat-form" action="send_message.php" method="POST" class="d-flex">
            <input type="hidden" id="course_id" name="course_id" value="<?php echo htmlspecialchars($course_id); ?>">
            <input type="hidden" name="instructor_email" value="<?php echo htmlspecialchars($instructor_email); ?>">
            <input type="hidden" name="sender" value="<?php echo htmlspecialchars($student_username); ?>">
            <input type="hidden" name="receiver" value="<?php echo htmlspecialchars(($user_type == 'student') ? $instructor_username : $student_username); ?>">
            <input type="text" id="message" name="message" placeholder="Type your message..." required class="form-control me-2">
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>
    <script src="js/chat.js"></script>
</body>
</html>