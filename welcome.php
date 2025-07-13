<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}
?>

<link rel="stylesheet" href="style.css">
<div style="text-align:center;">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h2>
    <a href="logout.php">Logout</a>
</div>
