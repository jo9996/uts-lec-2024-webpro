<?php
include 'config.php';
session_start();
if ($_SESSION['role'] != 'user') {
    header("Location: login.php");
}

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Tambahkan registrasi dengan status pembayaran 'pending'
    $stmt = $conn->prepare("INSERT INTO registrations (event_id, user_id, payment_status) VALUES (?, ?, 'pending')");
    $stmt->bind_param("ii", $event_id, $user_id);
    $stmt->execute();

    // Arahkan ke halaman pembayaran
    header("Location: payment.php?id=$event_id");
} else {
    header("Location: user_dashboard.php");
}
?>
