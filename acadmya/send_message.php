<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['user_type'])) {
    header('Location: index.html');
    exit;
}

$user = $_SESSION['user'];
$user_type = $_SESSION['user_type'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_id = $_POST['course_id'];
    $instructor_email = $_POST['instructor_email'];
    $message = $_POST['message'];
    $sender = $_POST['sender'];
    $receiver = $_POST['receiver'];

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

    // Insert message into the database
    $stmt = $pdo->prepare('INSERT INTO messages (course_id, username, content, created_at, sender, receiver) VALUES (?, ?, ?, NOW(), ?, ?)');
    $stmt->execute([$course_id, $sender, $message, $sender, $receiver]);
print_r([$course_id, $sender, $message, $sender, $receiver]);
    // Send email notification to the receiver (instructor)
    $subject = "New Message in Course Chat";
    $body = "You have a new message in the course chat:\n\n" . htmlspecialchars($message);
    $headers = "From: no-reply@academya.com";

    mail($instructor_email, $subject, $body, $headers);

    header('Location: chat.php?course_id=' . $course_id);
    exit;
}
?>
