<?php
// completion.php
include 'course_completion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    check_course_completion($student_id, $course_id);
}
?>
