<?php
session_start();

$host = '127.0.0.1';
$db = 'academya';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    if ($user_type == 'student') {
        $stmt = $pdo->prepare('SELECT * FROM students WHERE username = ? AND password = ?');
    } else {
        $stmt = $pdo->prepare('SELECT * FROM instructor WHERE instructor_username = ? AND instructor_password = ?');
    }

    $stmt->execute([$username, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user'] = $user;
        $_SESSION['user_type'] = $user_type;
        if ($user_type == 'instructor') {
            $_SESSION['instructor_id'] = $user['id'];
        } else {
            $_SESSION['student_id'] = $user['student_id'];
        }
        header('Location: index.php');
        exit;
    } else {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("error-message").innerText = "Invalid username or password";
                document.getElementById("error-message").style.display = "block";
            });
        </script>';
    }
}
?>
