<?php
// mark_attendance.php

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

// Retrieve form data (student ID, course ID, and attendance status)
$studentID = $_POST['student_id'];
$courseID = $_POST['course_id'];
$attendanceStatus = $_POST['attendance_status']; // Assuming this is either 'present' or 'absent'

// Update attendance record in the database
$sql = "UPDATE enrolment SET attendance_status = '$attendanceStatus' WHERE student_id = $studentID AND course_id = $courseID";
$result = $conn->query($sql);

if ($result === TRUE) {
    if ($conn->affected_rows > 0) {
        echo "Attendance marked successfully";
    } else {
        echo "No rows affected. Check if the student_id and course_id exist.";
    }
} else {
    echo "Error updating attendance: " . $conn->error;
}

// Debugging: Output the SQL query
echo "<br>Executed SQL: $sql";

$conn->close();
?>