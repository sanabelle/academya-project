<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user_type'] != 'student' || !isset($_SESSION['quiz_score'])) {
    header('Location: index.html');
    exit;
}

$score = $_SESSION['quiz_score'];
$totalQuestions = $_SESSION['total_questions'];

// Clear the session variables
unset($_SESSION['quiz_score']);
unset($_SESSION['total_questions']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .result-container {
            text-align: center;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .result-container h1 {
            color: #4CAF50;
        }
        .result-container p {
            font-size: 1.2em;
        }
    </style>
    <script>
        setTimeout(function() {
            window.location.href = 'dashboard.php';
        }, 5000);
    </script>
</head>
<body>
    <div class="result-container">
        <h1>Quiz Completed!</h1>
        <p>You scored <?php echo $score; ?> out of <?php echo $totalQuestions; ?>.</p>
        <p>Redirecting to the dashboard in 5 seconds...</p>
    </div>
</body>
</html>
