<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user_type'] != 'instructor') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$dsn = 'mysql:host=localhost;dbname=academya';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$quizName = $data['quizName'];
$lessonId = $data['lessonId'];

$stmt = $pdo->prepare('INSERT INTO quizzes (lesson_id, quiz_name) VALUES (?, ?)');
if ($stmt->execute([$lessonId, $quizName])) {
    $quiz_id = $pdo->lastInsertId();
    echo json_encode(['success' => true, 'quiz_id' => $quiz_id]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to create quiz']);
}
?>
