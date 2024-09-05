<?php
// Include TCPDF library
require_once('tcpdf/tcpdf.php');

// Start a PHP session
session_start();

// Check if the user is logged in and has the necessary role
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'Teacher') {
    // Redirect to the login page if the user is not logged in as a teacher
    header('Location: login.php');
    exit();
}

// Check if the attendance ID is provided in the query string
if (isset($_GET['aid'])) {
    // Retrieve the attendance ID from the query string
    $aid = $_GET['aid'];

    // Generate PDF content using TCPDF
    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, 'Attendance Report for ID: ' . $aid, 0, true, 'C');
    // Add more content as needed...

    // Output PDF as a download
    $pdf->Output('attendance_report_' . $aid . '.pdf', 'D');
} else {
    // Redirect back to the previous page if the attendance ID is not provided
    header('Location: index.php');
    exit();
}
?>
