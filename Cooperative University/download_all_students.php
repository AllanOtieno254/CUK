<?php
// Include TCPDF library
require_once('tcpdf/tcpdf.php');

// Include database connection file
include_once 'database.php';

// Generate all students report PDF
function generateAllStudentsReport($conn) {
    // Create new TCPDF instance
    $pdf = new TCPDF();

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('All Students Report');
    $pdf->SetSubject('All Students Details');
    $pdf->SetKeywords('Students, Report');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Set content
    $content = '';

    // Retrieve all students from the database
    $sql = "SELECT * FROM student";
    $result = $conn->query($sql);

    // Check if there are students
    if ($result->num_rows > 0) {
        // Add table header
        $content .= '<table border="1">
                        <tr>
                            <th>Student ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Date of Birth</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Classroom</th>
                            <th>Parent</th>
                        </tr>';

        // Add table data
        while ($row = $result->fetch_assoc()) {
            $content .= '<tr>
                            <td>' . $row['sid'] . '</td>
                            <td>' . $row['fname'] . '</td>
                            <td>' . $row['lname'] . '</td>
                            <td>' . $row['bday'] . '</td>
                            <td>' . $row['gender'] . '</td>
                            <td>' . $row['address'] . '</td>
                            <td>' . $row['classroom'] . '</td>
                            <td>' . $row['parent'] . '</td>
                        </tr>';
        }

        // Close table
        $content .= '</table>';
    } else {
        // No students found
        $content .= '<p>No students found.</p>';
    }

    // Write content to PDF
    $pdf->writeHTML($content, true, false, true, false, '');

    // Output PDF as a download
    $pdf->Output('all_students_report.pdf', 'D');
}

// Call the function to generate and download the all students report
generateAllStudentsReport($conn);
?>
