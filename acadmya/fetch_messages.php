<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['user_type'])) {
    header('Location: index.html');
    exit;
}

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

// Fetch messages for this course
$stmt = $pdo->prepare('SELECT * FROM messages WHERE course_id = ? ORDER BY created_at ASC');
$stmt->execute([$course_id]);
$messages = $stmt->fetchAll();

foreach ($messages as $message) {
    $sender_name = htmlspecialchars($message['sender']);
    echo '<div class="message">';
    echo '<p><strong>' . $sender_name . ':</strong> ' . htmlspecialchars($message['content']) . '</p>';
    echo '</div>';
}
?>
