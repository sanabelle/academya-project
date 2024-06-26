<?php
$dsn = 'mysql:host=localhost;dbname=academya';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

if (!isset($_GET['lesson_id'])) {
    echo json_encode(['success' => false, 'message' => 'Lesson ID not provided.']);
    exit;
}

$lesson_id = filter_var($_GET['lesson_id'], FILTER_VALIDATE_INT);
$stmt = $pdo->prepare('SELECT * FROM lessons WHERE lesson_id = ?');
$stmt->execute([$lesson_id]);
$lesson = $stmt->fetch(PDO::FETCH_ASSOC);

if ($lesson) {
    echo json_encode(['success' => true, 'lesson_title' => $lesson['Lesson Title'], 'lesson_duration' => $lesson['Lesson Duration'], 'lesson_description' => $lesson['Lesson Description'], 'lesson_id' => $lesson['lesson_id']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Lesson not found.']);
}
?>
