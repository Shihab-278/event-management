<?php
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}




function generateCsv($data, $filename) {
    if (!is_array($data) || empty($data)) {
        die("No data available to generate CSV.");
    }

    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '.csv"');

    // Open output stream
    $output = fopen('php://output', 'w');

    // Add CSV headers (first row of data)
    $headers = array_keys($data[0]); // Get column names from the first row
    fputcsv($output, $headers);

    // Add data rows
    foreach ($data as $row) {
        fputcsv($output, $row);
    }

    // Close the output stream
    fclose($output);
    exit;
}
?>