<?php
include 'config.php';
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$events = $conn->query("SELECT * FROM events");
$users = $conn->query("SELECT * FROM users");

if (isset($_GET['export']) && isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];
    $registrations = $conn->query("SELECT users.email, registrations.ticket_quantity, registrations.total_amount FROM registrations JOIN users ON registrations.user_id = users.id WHERE registrations.event_id = $event_id");

    $filename = "registrants_event_$event_id.csv";
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    $output = fopen('php://output', 'w');
    fputcsv($output, array('Email', 'Ticket Quantity', 'Total Amount'));

    while ($row = $registrations->fetch_assoc()) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
        }
        .dashboard {
            width: 100%;
            max-width: 800px;
            margin: 20px;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .dashboard h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .dashboard a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .dashboard a:hover {
            background: linear-gradient(to right, #2575fc, #6a11cb);
        }
        .dashboard table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .dashboard table, .dashboard th, .dashboard td {
            border: 1px solid #ddd;
        }
        .dashboard th, .dashboard td {
            padding: 10px;
            text-align: left;
        }
        .dashboard th {
            background-color: #f2f2f2;
        }
        .registrants {
            margin-top: 10px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .logout {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
            float: right;
        }
        .logout:hover {
            background: linear-gradient(to right, #2575fc, #6a11cb);
        }
        .profile-button {
            position: absolute;
            top: 55px;
            left: 380px;
            padding: 10px 20px;
            background: linear-gradient(to right, #2575fc, #6a11cb);
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .profile-button:hover {
            background: linear-gradient(to right, #2575fc, #6a11cb);
        }
    </style>
</head>
<body>
    <a href="view_profile.php" class="profile-button">My Profile</a>
    <div class="dashboard">
        <a href="logout.php" class="logout">Logout</a>
        <h1>-Admin Dashboard-</h1>
        <a href="create_event.php">Create New Event</a>
        <table>
            <tr>
                <th>Event Name</th>
                <th>Date</th>
                <th>Registrants</th>
                <th>Capacity</th>
                <th>Actions</th>
            </tr>
            <?php while ($event = $events->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $event['name']; ?></td>
                <td><?php echo $event['date']; ?></td>
                <td>
                    <?php
                    $registrations = $conn->query("SELECT users.email, registrations.ticket_quantity, registrations.total_amount FROM registrations JOIN users ON registrations.user_id = users.id WHERE registrations.event_id = " . $event['id']);
                    echo $registrations->num_rows;
                    if ($registrations->num_rows > 0) {
                        echo "<div class='registrants'>";
                        while ($registration = $registrations->fetch_assoc()) {
                            echo "Email: " . $registration['email'] . "<br>";
                            echo "Tickets: " . $registration['ticket_quantity'] . "<br>";
                            echo "Total: $" . $registration['total_amount'] . "<br><br>";
                        }
                        echo "</div>";
                    }
                    ?>
                </td>
                <td><?php echo $event['max_participants']; ?></td>
                <td>
                    <a href="edit_event.php?id=<?php echo $event['id']; ?>">Edit</a>
                    <a href="delete_event.php?id=<?php echo $event['id']; ?>">Delete</a>
                    <a href="?export=true&event_id=<?php echo $event['id']; ?>">Export CSV</a>
                </td>
            </tr>
            <?php } ?>
        </table>
        <h2>Manage Users</h2>
        <table>
            <tr>
                <th>User Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php while ($user = $users->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td>
                    <a href="view_profile.php?id=<?php echo $user['id']; ?>">View Profile</a>
                    <a href="delete_user.php?id=<?php echo $user['id']; ?>">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
