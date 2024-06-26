<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "academya";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve quiz ID from the AJAX request
$quizID = $_GET['quizID'];

// Retrieve quiz questions from the database
$sql = "SELECT * FROM quiz_question WHERE quiz_id = $quizID";
$result = $conn->query($sql);

// Generate HTML for quiz questions
$questionsHTML = '';
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $questionsHTML .= '<label for="answer' . $row['quiz_question_id'] . '">' . $row['question_title'] . ':</label>';
        $questionsHTML .= '<input type="text" id="answer' . $row['quiz_question_id'] . '" name="answer' . $row['quiz_question_id'] . '" required><br><br>';
    }
} else {
    $questionsHTML = 'No questions found';
}

echo $questionsHTML;

$conn->close();
?>