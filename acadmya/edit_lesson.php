<?php
session_start();

$dsn = 'mysql:host=localhost;dbname=academya';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lesson_id = filter_var($_POST['lessonId'], FILTER_VALIDATE_INT);
    $lesson_title = filter_var($_POST['lessonTitle'], FILTER_SANITIZE_STRING);
    $lesson_duration = filter_var($_POST['lessonDuration'], FILTER_VALIDATE_INT);
    $lesson_description = filter_var($_POST['lessonDescription'], FILTER_SANITIZE_STRING);

    $stmt = $pdo->prepare('UPDATE lessons SET `Lesson Title` = ?, `Lesson Duration` = ?, `Lesson Description` = ? WHERE lesson_id = ?');
    $result = $stmt->execute([$lesson_title, $lesson_duration, $lesson_description, $lesson_id]);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update lesson.']);
    }
}
?>
