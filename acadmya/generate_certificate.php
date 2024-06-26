<?php
session_start();

// Check if user is logged in as a student
if (!isset($_SESSION['user']) || $_SESSION['user_type'] != 'student') {
    header('Location: index.php');
    exit;
}

// Retrieve student details (you might adjust this based on your session structure)
$student_name = $_SESSION['user']['student_name'];
$course_name = 'Your Course Name'; // Replace with actual course name

// Output PDF as a download
require('fpdf/fpdf.php'); // Adjust the path as per your installation

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Certificate of Completion', 0, 1, 'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, "This certifies that $student_name has successfully completed the quiz for $course_name on " . date('F j, Y') . ".");
$pdf->Output('D', 'certificate.pdf'); // 'D' means force download, you can change it to 'I' to open in browser
