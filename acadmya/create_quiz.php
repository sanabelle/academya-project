<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user_type'] != 'instructor') {
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quiz</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
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
        form {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="number"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[readonly] {
            background-color: #f9f9f9;
            cursor: not-allowed;
        }
        button {
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
        button:hover {
            background: #45A049;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="dashboard.php" style="color: #4caf50;text-decoration: none;margin-left: 10px;font-weight: bold;"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>

        <h1>Create a New Quiz</h1>
        <form id="quizForm">
            <input type="text" id="quizName" name="quizName" placeholder="Quiz Name" required>
            <input type="number" id="lessonId" name="lessonId" placeholder="Lesson ID" readonly required>
            <button type="submit">Create Quiz</button>
        </form>
        <div id="questionContainer"></div>
        <button id="addQuestionButton" style="display:none;">Add Question</button>
    </div>

    <script>
        // Function to get query parameters from the URL
        function getQueryParams() {
            let params = {};
            let queryString = window.location.search.substring(1);
            let regex = /([^&=]+)=([^&]*)/g;
            let m;
            while (m = regex.exec(queryString)) {
                params[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
            }
            return params;
        }

        // Set the lesson ID input field from URL parameter
        window.onload = function() {
            let params = getQueryParams();
            if (params.lesson_id) {
                document.getElementById('lessonId').value = params.lesson_id;
            }
        };

        document.getElementById('quizForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const quizName = document.getElementById('quizName').value;
            const lessonId = document.getElementById('lessonId').value;

            fetch('create_quiz_process.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ quizName, lessonId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Quiz created successfully');
                    document.getElementById('quizForm').style.display = 'none';
                    document.getElementById('addQuestionButton').style.display = 'block';
                    document.getElementById('addQuestionButton').setAttribute('data-quiz-id', data.quiz_id);
                } else {
                    alert('Error creating quiz');
                }
            });
        });

        document.getElementById('addQuestionButton').addEventListener('click', function() {
            const quizId = this.getAttribute('data-quiz-id');
            const questionContainer = document.getElementById('questionContainer');

            const questionForm = document.createElement('form');
            questionForm.innerHTML = `
                <textarea name="questionText" placeholder="Question Text" required></textarea>
                <input type="text" name="answer1" placeholder="Answer 1" required>
                <input type="text" name="answer2" placeholder="Answer 2" required>
                <input type="text" name="answer3" placeholder="Answer 3" required>
                <input type="text" name="answer4" placeholder="Answer 4" required>
                <input type="radio" name="correctAnswer" value="1" required> Answer 1
                <input type="radio" name="correctAnswer" value="2" required> Answer 2
                <input type="radio" name="correctAnswer" value="3" required> Answer 3
                <input type="radio" name="correctAnswer" value="4" required> Answer 4
                <button type="submit">Add Question</button>
            `;

            questionForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(questionForm);
                formData.append('quizId', quizId);

                fetch('add_question_process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Question added successfully');
                        questionForm.reset();
                    } else {
                        alert('Error adding question');
                    }
                });
            });

            questionContainer.appendChild(questionForm);
        });
    </script>
</body>
</html>
