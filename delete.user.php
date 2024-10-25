<?php
include 'config.php';
session_start();

// Cek apakah pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Ambil ID user yang akan dihapus
$user_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($user_id) {
    // Ambil data user yang akan dihapus
    $result = $conn->query("SELECT * FROM users WHERE id = $user_id");
    $user = $result->fetch_assoc();

    // Cek apakah user yang akan dihapus bukan admin
    if ($user && $user['role'] != 'admin') {
        // Hapus user dari database
        $conn->query("DELETE FROM users WHERE id = $user_id");
        header('Location: index.php');
        exit();
    } else {
        echo "You cannot delete an admin user.";
    }
} else {
    echo "Invalid user ID.";
}
?>
