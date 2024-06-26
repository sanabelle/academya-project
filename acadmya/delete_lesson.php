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

    $stmt = $pdo->prepare('DELETE FROM lessons WHERE lesson_id = ?');
    $result = $stmt->execute([$lesson_id]);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete lesson.']);
    }
}
?>
