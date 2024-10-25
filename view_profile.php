<?php
include 'config.php';
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Ambil data pengguna dari database
$user_id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM users WHERE id = $user_id");
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .navbar {
            width: 100%;
            background: #6495ED;
            color: white;
            padding: 15px 20px;
            text-align: left;
            position: fixed;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar img {
            width: 100px;
            vertical-align: middle;
        }
        .navbar .profile {
            display: flex;
            align-items: center;
        }
        .navbar .profile span {
            color: #333;
            font-size: 1em;
            margin-right: 20px;
        }
        .navbar .profile a {
            margin-right: 20px;
            padding: 10px 20px;
            background-color: #fff;
            color: #2575fc;
            border-radius: 25px;
            text-decoration: none;
            font-size: 1em;
            transition: background-color 0.3s, color 0.3s;
        }
        .navbar .profile a:hover {
            background-color: #2575fc;
            color: #fff;
        }
        .content {
            max-width: 600px;
            margin: 100px auto 50px;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: #333;
        }
        .content h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .content p {
            font-size: 1.2em;
            margin: 10px 0;
            text-align: left;
        }
        .content a {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #2575fc;
            text-align: center;
        }
        .content a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <img src="logo.png" alt="Logo">
        <div class="profile">
            <a href="logout.php">Logout</a>
            <span><?php echo $user['email']; ?></span>
        </div>
    </div>
    <div class="content">
        <h1>User Profile</h1>
        <p><strong>Name:</strong> <?php echo $user['name']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <p><strong>Phone:</strong> <?php echo $user['phone']; ?></p>
        <p><strong>Role:</strong> <?php echo $user['role']; ?></p>
        <a href="edit_profile.php">Edit Profile</a>
        <a href="index.php">Back to Home</a>
        <?php if ($_SESSION['role'] == 'admin' && $user['role'] != 'admin') { ?>
            <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete User</a>
        <?php } ?>
    </div>
</body>
</html>
