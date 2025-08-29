<?php
session_start();

// Clear session data
$_SESSION = [];
session_unset();
session_destroy();

// Prevent session fixation
session_regenerate_id(true);

// Redirect to login with a message
header("Location: login.php?logged_out=1");
exit;
?>
