<?php
session_start();

// Check if user is logged in as a student
if (!isset($_SESSION['user']) || $_SESSION['user_type'] != 'student') {
    header('Location: index.html');
    exit;
}

$dsn = 'mysql:host=localhost;dbname=academya';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

$lesson_id = $_GET['lesson_id']; // Assuming lesson_id is passed via GET

$stmt = $pdo->prepare('SELECT * FROM quizzes WHERE lesson_id = ?');
$stmt->execute([$lesson_id]);
$quiz = $stmt->fetch();

if (!$quiz) {
    die('Quiz not found.');
}

$quiz_id = $quiz['quiz_id'];

$stmt = $pdo->prepare('SELECT * FROM questions WHERE quiz_id = ?');
$stmt->execute([$quiz_id]);
$questions = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $score = 0;
    $total_questions = count($questions);
    
    // Ensure student_id is properly retrieved from session
    $student_id = $_SESSION['user']['student_id'];

    foreach ($questions as $question) {
        $question_id = $question['question_id'];
        $user_answer = $_POST['question_' . $question_id]; // Assuming form fields are properly named
        
        $stmt = $pdo->prepare('SELECT * FROM answers WHERE question_id = ? AND is_correct = 1');
        $stmt->execute([$question_id]);
        $correct_answer = $stmt->fetch();

        if ($correct_answer && $correct_answer['answer_id'] == $user_answer) {
            $score++;
        }
    }

    $percentage_score = ($score / $total_questions) * 100;

    // Insert quiz attempt into database
    $stmt = $pdo->prepare('INSERT INTO students_quiz_attempts (student_id, quiz_id, score) VALUES (?, ?, ?)');
    $stmt->execute([$student_id, $quiz_id, $percentage_score]);

    // Display results
    echo "<div style='text-align:center; margin-top:20px;'>
            <h2>Your Results</h2>
            <p>You scored $score out of $total_questions.</p>
            <p>Your percentage score is $percentage_score%.</p>
          </div>";

    // Redirect to dashboard after 5 seconds
    echo "<script>
            setTimeout(function() {
                window.location.href = 'dashboard.php';
            }, 5000);
          </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Quiz</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .quiz-container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #4CAF50;
        }
        .question {
            margin-bottom: 20px;
        }
        .question h2 {
            margin: 0 0 10px;
            font-size: 1.2em;
        }
        .answers label {
            display: block;
            margin-bottom: 10px;
            cursor: pointer;
            padding: 10px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: background 0.3s;
        }
        .answers input[type="radio"] {
            display: none;
        }
        .answers input[type="radio"]:checked + label {
            background: #4CAF50;
            color: #fff;
        }
        .submit-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1em;
            cursor: pointer;
            transition: background 0.3s;
        }
        .submit-btn:hover {
            background: #45A049;
        }
        .result {
            text-align: center;
            margin-top: 20px;
        }
        .result h2 {
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="quiz-container">
        <h1>Take Quiz</h1>
        <form method="post">
            <?php foreach ($questions as $question): ?>
                <div class="question">
                    <h2><?= htmlspecialchars($question['question_text']) ?></h2>
                    <div class="answers">
                        <?php
                        $stmt = $pdo->prepare('SELECT * FROM answers WHERE question_id = ?');
                        $stmt->execute([$question['question_id']]);
                        $answers = $stmt->fetchAll();
                        foreach ($answers as $answer):
                        ?>
                            <input type="radio" id="answer_<?= $answer['answer_id'] ?>" name="question_<?= $question['question_id'] ?>" value="<?= $answer['answer_id'] ?>" required>
                            <label for="answer_<?= $answer['answer_id'] ?>"><?= htmlspecialchars($answer['answer_text']) ?></label>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="submit-btn">Submit Quiz</button>
        </form>
    </div>
</body>
</html>
