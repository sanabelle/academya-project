<?php
// view_grades.php

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

// Retrieve quiz scores for each student
$sql = "SELECT student_id, AVG(score_achieved) AS average_score FROM students_quiz_attempts GROUP BY student_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Student ID: " . $row["student_id"]. " - Average Score: " . $row["average_score"]. "<br>";
    }
} else {
    echo "No quiz scores found";
}

$conn->close();
?>