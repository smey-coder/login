<?php
require 'config.php';
$message = "";
$showMessage = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO login (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        $message = "🎉 Registration successful. <a href='login.php'>Login here</a>";
    } else {
        $message = "⚠️ Error: " . $stmt->error;
    }

    $showMessage = true;
    $stmt->close();
}
?>

<link rel="stylesheet" href="style.css">
<style>
.message-box {
    border: 1px solid #ccc;
    background: #e7f3fe;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 5px;
    color: #333;
    position: relative;
    text-align: center;
}

.ok-button {
    margin-top: 10px;
    padding: 5px 15px;
    background: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.ok-button:hover {
    background: #45a049;
}
</style>

<form method="post">
    <h2>Register</h2>

    <?php if ($showMessage): ?>
        <div class="message-box">
            <?php echo $message; ?>
            <br>
            <button type="submit" name="dismiss" class="ok-button">OK</button>
        </div>
    <?php endif; ?>

    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" value="Register">
    <a href="login.php">Already have an account?</a>
</form>
