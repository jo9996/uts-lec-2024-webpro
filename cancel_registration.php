<?php
include 'config.php';
session_start();
if ($_SESSION['role'] != 'user') {
    header("Location: login.php");
}

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Hapus registrasi
    if ($conn->query("DELETE FROM registrations WHERE event_id = $event_id AND user_id = $user_id") === TRUE) {
        header("Location: user_dashboard.php");
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    header("Location: user_dashboard.php");
}
?>
