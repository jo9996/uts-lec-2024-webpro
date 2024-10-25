<?php
include 'config.php';
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
}

$id = $_GET['id'];
$event = $conn->query("SELECT * FROM events WHERE id = $id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = htmlspecialchars($_POST['location']);
    $description = htmlspecialchars($_POST['description']);
    $max_participants = $_POST['max_participants'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE events SET name = ?, date = ?, time = ?, location = ?, description = ?, max_participants = ?, status = ? WHERE id = ?");
    $stmt->bind_param("sssssis", $name, $date, $time, $location, $description, $max_participants, $status, $id);
    $stmt->execute();
    header("Location: admin_dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
</head>
<body style="font-family: Arial, sans-serif; background: linear-gradient(to right, #6a11cb, #2575fc); display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;">
    <div style="background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); text-align: center; max-width: 500px; width: 100%;">
        <h1 style="margin-bottom: 20px; color: #333; font-size: 2em;">Edit Event</h1>
        <form method="POST" action="" style="display: flex; flex-direction: column; align-items: center;">
            <input type="text" name="name" value="<?php echo $event['name']; ?>" required placeholder="Event Name" style="width: 100%; padding: 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1em; box-sizing: border-box;">
            <input type="date" name="date" value="<?php echo $event['date']; ?>" required style="width: 100%; padding: 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1em; box-sizing: border-box;">
            <input type="time" name="time" value="<?php echo $event['time']; ?>" required style="width: 100%; padding: 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1em; box-sizing: border-box;">
            <input type="text" name="location" value="<?php echo $event['location']; ?>" required placeholder="Location" style="width: 100%; padding: 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1em; box-sizing: border-box;">
            <textarea name="description" required placeholder="Description" style="width: 100%; padding: 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1em; box-sizing: border-box;"><?php echo $event['description']; ?></textarea>
            <input type="number" name="max_participants" value="<?php echo $event['max_participants']; ?>" required placeholder="Max Participants" style="width: 100%; padding: 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1em; box-sizing: border-box;">
            <select name="status" required style="width: 100%; padding: 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 1em; box-sizing: border-box;">
                <option value="open" <?php if ($event['status'] == 'open') echo 'selected'; ?>>Open</option>
                <option value="closed" <?php if ($event['status'] == 'closed') echo 'selected'; ?>>Closed</option>
                <option value="canceled" <?php if ($event['status'] == 'canceled') echo 'selected'; ?>>Canceled</option>
            </select>
            <button type="submit" style="width: 100%; padding: 15px; background: linear-gradient(to right, #6a11cb, #2575fc); color: white; border: none; border-radius: 5px; font-size: 1em; cursor: pointer; transition: background 0.3s;">Update Event</button>
        </form>
    </div>
</body>
</html>
