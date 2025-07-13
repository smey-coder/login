<?php
$conn = new mysqli("localhost", "SmeyKh", "hello123(*)", "test_php");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
