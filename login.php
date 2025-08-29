<?php
session_start();
require 'config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        // Select by username only
        $stmt = $conn->prepare("SELECT id, username, password FROM login WHERE username = ?");
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($id, $db_username, $hashed_password);
                $stmt->fetch();

                // Verify hashed password
                if (password_verify($password, $hashed_password)) {
                    $_SESSION["username"] = $db_username;
                    $_SESSION["id"] = $id;
                    header("Location: welcome.php");
                    exit();
                } else {
                    $error = "Incorrect password.";
                }
            } else {
                $error = "User not found.";
            }
            $stmt->close();
        } else {
            $error = "Database error.";
        }
    }
}
?>
<link rel="stylesheet" href="style.css">
<form method="post">
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" value="Login">
    <a href="register.php">Create a new account</a>
</form>