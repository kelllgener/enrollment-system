<?php
// Get the file path from the query string
if(isset($_GET['filepath'])) {
    $filepath = $_GET['filepath'];

    // Check if the file exists
    if(file_exists($filepath)) {
        // Set headers to force download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        // Read the file and output it to the browser
        readfile($filepath);
        exit;
    } else {
        // If the file does not exist, display an error message
        echo "The requested file does not exist.";
    }
} else {
    // If filepath parameter is not provided, display an error message
    echo "Filepath parameter is missing.";
}
?>
