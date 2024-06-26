<?php
// course_completion.php
include 'db_connect.php';
require 'fpdf.php';
session_start();

if (!isset($_SESSION['student_id']) || !isset($_GET['course_id'])) {
    echo "Error: Missing student ID or course ID.";
    exit();
}

$student_id = $_SESSION['student_id'];
$course_id = $_GET['course_id'];

function check_course_completion($student_id, $course_id) {
    global $conn;

    // Check if all lessons are completed
    $lessons_query = "SELECT COUNT(*) AS total_lessons FROM lessons WHERE course_id = $course_id";
    $completed_lessons_query = "SELECT COUNT(*) AS completed_lessons FROM students_lesson 
                                WHERE student_id = $student_id AND lesson_id IN (SELECT lesson_id FROM lessons WHERE course_id = $course_id)";

    $total_lessons_result = $conn->query($lessons_query);
    $completed_lessons_result = $conn->query($completed_lessons_query);

    if (!$total_lessons_result || !$completed_lessons_result) {
        echo "Error: " . $conn->error;
        return;
    }

    $total_lessons = $total_lessons_result->fetch_assoc()['total_lessons'];
    $completed_lessons = $completed_lessons_result->fetch_assoc()['completed_lessons'];

    // Debugging information
    echo "Total Lessons: $total_lessons<br>";
    echo "Completed Lessons: $completed_lessons<br>";

    // Check if the student has passed all quizzes
    $quizzes_query = "SELECT COUNT(*) AS total_quizzes FROM quizzes WHERE lesson_id IN (SELECT lesson_id FROM lessons WHERE course_id = $course_id)";
    $passing_score = 50; // Define passing score for quizzes
    $passed_quizzes_query = "SELECT COUNT(DISTINCT quiz_id) AS passed_quizzes FROM students_quiz_attempts 
                             WHERE student_id = $student_id AND quiz_id IN (SELECT quiz_id FROM quizzes WHERE lesson_id IN (SELECT lesson_id FROM lessons WHERE course_id = $course_id)) AND score >= $passing_score";

    $total_quizzes_result = $conn->query($quizzes_query);
    $passed_quizzes_result = $conn->query($passed_quizzes_query);

    if (!$total_quizzes_result || !$passed_quizzes_result) {
        echo "Error: " . $conn->error;
        return;
    }

    $total_quizzes = $total_quizzes_result->fetch_assoc()['total_quizzes'];
    $passed_quizzes = $passed_quizzes_result->fetch_assoc()['passed_quizzes'];

    // Debugging information
    echo "Total Quizzes: $total_quizzes<br>";
    echo "Passed Quizzes: $passed_quizzes<br>";

    if ($total_lessons == $completed_lessons && $total_quizzes == $passed_quizzes) {
        // Generate certificate
        generate_certificate($student_id, $course_id);
    } else {
        echo "Course not completed yet.";
    }
}

function generate_certificate($student_id, $course_id) {
    global $conn;

    // Generate a unique URL or file path for the certificate
    $certificate_url = "certificates/{$student_id}_{$course_id}.pdf";

    // Save the certificate record in the database
    $stmt = $conn->prepare("INSERT INTO students_certificates (student_id, course_id, certificate_url) VALUES (?, ?, ?)");
    if (!$stmt) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        return;
    }

    $stmt->bind_param("iis", $student_id, $course_id, $certificate_url);
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        return;
    }

    $stmt->close();

    // Generate the certificate PDF
    generate_certificate_pdf($student_id, $course_id, $certificate_url);

    echo "Certificate generated: <a href='$certificate_url'>Download Certificate</a>";
}

function generate_certificate_pdf($student_id, $course_id, $certificate_url) {
    global $conn;

    // Adjust these queries based on your actual database schema
    $student_query = "SELECT username FROM students WHERE student_id = $student_id";
    $course_query = "SELECT `Course Title` FROM courses WHERE course_id = $course_id";
    $student_result = $conn->query($student_query);
    $course_result = $conn->query($course_query);

    if (!$student_result || !$course_result) {
        echo "Error: " . $conn->error;
        return;
    }

    $student_name = $student_result->fetch_assoc()['username'];
    $course_name = $course_result->fetch_assoc()['Course Title'];

    // Ensure the directory exists
    $directory = dirname($certificate_url);
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }

    // Use FPDF to create a PDF certificate
    $pdf = new FPDF();
    $pdf->AddPage();

    // Set background image
    $pdf->Image('certification background/background_image.jpg', 0, 0, 210, 297); // A4 size

    // Set fonts and add text
    $pdf->SetFont('Arial', 'B', 24);
    $pdf->SetTextColor(0, 102, 204); // Blue color
    $pdf->Cell(0, 50, 'Certificate of Completion', 0, 1, 'C');

    $pdf->SetFont('Arial', 'I', 16);
    $pdf->SetTextColor(0, 0, 0); // Black color
    $pdf->Cell(0, 10, 'This certifies that', 0, 1, 'C');

    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(0, 10, $student_name, 0, 1, 'C');

    $pdf->SetFont('Arial', 'I', 16);
    $pdf->Cell(0, 10, 'has successfully completed the course', 0, 1, 'C');

    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(0, 10, $course_name, 0, 1, 'C');

    $pdf->SetFont('Arial', 'I', 16);
    $pdf->Cell(0, 10, 'on', 0, 1, 'C');

    $pdf->SetFont('Arial', 'B', 16);
    $completion_date = date('F j, Y');
    $pdf->Cell(0, 10, $completion_date, 0, 1, 'C');

    // Add signature image
    $pdf->Image('certification background/signature_image.png', 80, 220, 50, 20); // Position the signature

    // Add issuer name
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 30, 'Issuer Name', 0, 1, 'C');
    $pdf->Cell(0, 0, 'Position', 0, 1, 'C');

    // Output the PDF
    $pdf->Output('F', $certificate_url);
}

check_course_completion($student_id, $course_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Completion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Course Completion</h1>
        <?php
        if (isset($message)) {
            echo "<div class='alert alert-info'>$message</div>";
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
