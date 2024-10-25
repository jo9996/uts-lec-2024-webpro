<?php
include 'config.php';
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Ambil data pengguna dari database
$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM users WHERE id = $user_id");
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $hashed_password, $user_id);

    if ($stmt->execute()) {
        header("Location: view_profile.php");
        exit();
    } else {
        echo "Error updating profile: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
</head>
<body style="font-family: Arial, sans-serif; background: linear-gradient(to right, #6a11cb, #2575fc); display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;">
    <div style="background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); text-align: center; max-width: 500px; width: 100%;">
        <h1 style="margin-bottom: 20px; color: #333; font-size: 2em;">Edit Profile</h1>
        <form method="POST" action="" style="display: flex; flex-direction: column; align-items: center;">
            <input type="text" name="name" value="<?php echo $user['name']; ?>" required placeholder="Name" style="width: 100%; padding: 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1em; box-sizing: border-box;">
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required placeholder="Email" style="width: 100%; padding: 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1em; box-sizing: border-box;">
            <input type="password" name="password" required placeholder="New Password" style="width: 100%; padding: 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1em; box-sizing: border-box;">
            <button type="submit" style="width: 100%; padding: 15px; background: linear-gradient(to right, #6a11cb, #2575fc); color: white; border: none; border-radius: 5px; font-size: 1em; cursor: pointer; transition: background 0.3s;">Update Profile</button>
        </form>
    </div>
</body>
</html>
