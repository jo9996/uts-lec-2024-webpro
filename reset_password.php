<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_GET['token'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE reset_token = ?");
    $stmt->bind_param("ss", $password, $token);
    $stmt->execute();

    echo "Your password has been reset.";
}
?>
<form method="POST" action="">
    <input type="password" name="password" required placeholder="New Password">
    <button type="submit">Reset Password</button>
</form>
