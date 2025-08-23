<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, password FROM login WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION["password"] = $password;
            $_SESSION["username"] = $username;
            header("Location: welcome.php");
            exit;
        } else {
            echo "<p>Incorrect password.</p>";
        }
    } else {
        echo "<p>User not found.</p>";
    }
    $stmt->close();
}
?>

<link rel="stylesheet" href="style.css">
<form method="post">
    <h2>Login</h2>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" value="Login">
    <a href="register.php">Create a new account</a>
</form>
