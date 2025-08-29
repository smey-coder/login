<?php
// Development only: show mysqli errors as exceptions
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";
$user = "SmeyKh";
$pass = "hello123(*)";
$db   = "test_php";

try {
    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset("utf8mb4"); // support Unicode
} catch (Exception $e) {
    // Log error to file (do not show sensitive info to users)
    error_log("Database connection error: " . $e->getMessage());
    die("⚠️ Sorry, we are experiencing technical issues. Please try again later.");
}
?>
