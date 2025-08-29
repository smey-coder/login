<?php
require 'config.php';
$message = "";
$showMessage = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    // Basic validation
    if (strlen($username) < 3) {
        $message = "⚠️ Username must be at least 3 characters.";
        $showMessage = true;
    } elseif (strlen($password) < 6) {
        $message = "⚠️ Password must be at least 6 characters.";
        $showMessage = true;
    } else {
        // Check duplicate username
        $check = $conn->prepare("SELECT id FROM login WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "⚠️ Username already taken. Please choose another.";
            $showMessage = true;
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO login (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed_password);

            if ($stmt->execute()) {
                $message = "🎉 Registration successful. <a href='login.php'>Login here</a>";
            } else {
                $message = "⚠️ Something went wrong. Please try again.";
            }

            $showMessage = true;
            $stmt->close();
        }
        $check->close();
    }
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
            <button type="button" class="ok-button" onclick="this.parentElement.style.display='none'">OK</button>
        </div>
    <?php endif; ?>

    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" value="Register">
    <a href="login.php">Already have an account?</a>
</form>
