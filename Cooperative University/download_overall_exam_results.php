<?php
// Include TCPDF library
require_once('tcpdf/tcpdf.php');

// Include database connection file
include_once 'database.php';

// Generate overall exam results report PDF
function generateOverallExamResultsReport($conn) {
    // Create new TCPDF instance
    $pdf = new TCPDF();

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Overall Exam Results Report');
    $pdf->SetSubject('Overall Exam Results');
    $pdf->SetKeywords('Exam Results, Report');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Set content
    $content = '';

    // Retrieve overall exam results from the database
    $sql = "SELECT * FROM examresult";
    $result = $conn->query($sql);

    // Check if there are exam results
    if ($result->num_rows > 0) {
        // Add table header
        $content .= '<table border="1">
                        <tr>
                            <th>Exam ID</th>
                            <th>Student ID</th>
                            <th>Marks</th>
                            <th>Grade</th>
                        </tr>';

        // Add table data
        while ($row = $result->fetch_assoc()) {
            $content .= '<tr>
                            <td>' . $row['exam'] . '</td>
                            <td>' . $row['student'] . '</td>
                            <td>' . $row['marks'] . '</td>
                            <td>' . $row['grade'] . '</td>
                        </tr>';
        }

        // Close table
        $content .= '</table>';
    } else {
        // No exam results found
        $content .= '<p>No exam results found.</p>';
    }

    // Write content to PDF
    $pdf->writeHTML($content, true, false, true, false, '');

    // Output PDF as a download
    $pdf->Output('overall_exam_results_report.pdf', 'D');
}

// Call the function to generate and download the overall exam results report
generateOverallExamResultsReport($conn);
?>
