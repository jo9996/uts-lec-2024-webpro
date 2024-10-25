<?php
include 'config.php';
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus semua registrasi yang terkait dengan event
    $conn->query("DELETE FROM registrations WHERE event_id = $id");

    // Hapus event
    if ($conn->query("DELETE FROM events WHERE id = $id") === TRUE) {
        header("Location: admin_dashboard.php");
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    header("Location: admin_dashboard.php");
}
?>
