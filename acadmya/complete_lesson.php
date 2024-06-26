<?php
// complete_lesson.php
include 'db_connect.php';

function mark_lesson_completed($student_id, $lesson_id) {
    global $conn;

    // Check if the lesson is already marked as completed
    $check_query = "SELECT * FROM students_lesson WHERE student_id = ? AND lesson_id = ?";
    $stmt = $conn->prepare($check_query);
    if (!$stmt) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        return;
    }

    $stmt->bind_param("ii", $student_id, $lesson_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Insert record to mark lesson as completed
        $completed_datetime = time(); // Current timestamp
        $insert_query = "INSERT INTO students_lesson (student_id, lesson_id, completed_datetime) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        if (!$stmt) {
            echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            return;
        }
        
        $stmt->bind_param("iii", $student_id, $lesson_id, $completed_datetime);
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            return;
        }

        echo "Lesson marked as completed.";
    } else {
        echo "Lesson already marked as completed.";
    }

    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $lesson_id = $_POST['lesson_id'];
    mark_lesson_completed($student_id, $lesson_id);
}
?>
