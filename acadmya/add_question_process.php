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

$quizId = $_POST['quizId'];
$questionText = $_POST['questionText'];
$answer1 = $_POST['answer1'];
$answer2 = $_POST['answer2'];
$answer3 = $_POST['answer3'];
$answer4 = $_POST['answer4'];
$correctAnswer = $_POST['correctAnswer'];

$stmt = $pdo->prepare('INSERT INTO questions (quiz_id, question_text) VALUES (?, ?)');
if ($stmt->execute([$quizId, $questionText])) {
    $question_id = $pdo->lastInsertId();

    $answers = [$answer1, $answer2, $answer3, $answer4];
    foreach ($answers as $index => $answer) {
        $is_correct = ($index + 1 == $correctAnswer) ? 1 : 0;
        $stmt = $pdo->prepare('INSERT INTO answers (question_id, answer_text, is_correct) VALUES (?, ?, ?)');
        $stmt->execute([$question_id, $answer, $is_correct]);
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add question']);
}
?>
