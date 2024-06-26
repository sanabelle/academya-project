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

// Retrieve form data
$answer1 = $_POST['answer1'];
$answer2 = $_POST['answer2'];

// Calculate scores (if needed)

// Store student answers in the database
$sql = "INSERT INTO students_quiz_attempts (answer1, answer2) VALUES ('$answer1', '$answer2')";

if ($conn->query($sql) === TRUE) {
    echo "Answers submitted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>