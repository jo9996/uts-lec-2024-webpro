<?php
include 'config.php';
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
}

$id = $_GET['id'];

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
