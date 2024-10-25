<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);
    $token = bin2hex(random_bytes(50));

    $stmt = $conn->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
    $stmt->bind_param("ss", $token, $email);
    $stmt->execute();

    $reset_link = "http://yourwebsite.com/reset_password.php?token=$token";
    mail($email, "Password Reset", "Click here to reset your password: $reset_link");

    echo "Password reset link has been sent to your email.";
}
?>
<form method="POST" action="">
    <input type="email" name="email" required placeholder="Email">
    <button type="submit">Send Reset Link</button>
</form>
