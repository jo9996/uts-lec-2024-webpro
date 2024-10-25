<?php
include 'config.php';
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=registrations.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('User ID', 'Event ID'));

$registrations = $conn->query("SELECT user_id, event_id FROM registrations");
while ($row = $registrations->fetch_assoc()) {
    fputcsv($output, $row);
}
fclose($output);
?>
