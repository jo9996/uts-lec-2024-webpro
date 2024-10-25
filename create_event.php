<?php
include 'config.php';
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = htmlspecialchars($_POST['location']);
    $description = htmlspecialchars($_POST['description']);
    $max_participants = $_POST['max_participants'];
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);

    $stmt = $conn->prepare("INSERT INTO events (name, date, time, location, description, max_participants, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssis", $name, $date, $time, $location, $description, $max_participants, $image);
    $stmt->execute();
    header("Location: admin_dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
</head>
<body style="font-family: Arial, sans-serif; background: linear-gradient(to right, #6a11cb, #2575fc); display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;">
    <div style="background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); text-align: center; max-width: 500px; width: 100%;">
        <h1 style="margin-bottom: 20px; color: #333; font-size: 2em;">Create Event</h1>
        <form method="POST" action="" enctype="multipart/form-data" style="display: flex; flex-direction: column; align-items: center;">
            <input type="text" name="name" required placeholder="Event Name" style="width: 100%; padding: 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1em; box-sizing: border-box;">
            <input type="date" name="date" required style="width: 100%; padding: 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1em; box-sizing: border-box;">
            <input type="time" name="time" required style="width: 100%; padding: 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1em; box-sizing: border-box;">
            <input type="text" name="location" required placeholder="Location" style="width: 100%; padding: 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1em; box-sizing: border-box;">
            <textarea name="description" required placeholder="Description" style="width: 100%; padding: 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1em; box-sizing: border-box;"></textarea>
            <input type="number" name="max_participants" required placeholder="Max Participants" style="width: 100%; padding: 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1em; box-sizing: border-box;">
            <input type="file" name="image" required style="width: 100%; padding: 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1em; box-sizing: border-box;">
            <button type="submit" style="width: 100%; padding: 15px; background: linear-gradient(to right, #6a11cb, #2575fc); color: white; border: none; border-radius: 5px; font-size: 1em; cursor: pointer; transition: background 0.3s;">Create Event</button>
        </form>
    </div>
</body>
</html>
