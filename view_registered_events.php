<?php
include 'config.php';
session_start();
if ($_SESSION['role'] != 'user') {
    header("Location: login.php");
}

$user_id = $_SESSION['user_id'];
$registrations = $conn->query("SELECT events.name, events.date, events.time, events.location, events.description FROM registrations JOIN events ON registrations.event_id = events.id WHERE registrations.user_id = $user_id");
?>
<h1>Registered Events</h1>
<table>
    <tr>
        <th>Event Name</th>
        <th>Date</th>
        <th>Time</th>
        <th>Location</th>
        <th>Description</th>
    </tr>
    <?php while ($event = $registrations->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $event['name']; ?></td>
        <td><?php echo $event['date']; ?></td>
        <td><?php echo $event['time']; ?></td>
        <td><?php echo $event['location']; ?></td>
        <td><?php echo $event['description']; ?></td>
    </tr>
    <?php } ?>
</table>
