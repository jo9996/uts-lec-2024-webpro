<?php
include 'config.php';
session_start();
if ($_SESSION['role'] != 'user') {
    header("Location: login.php");
}

$user_id = $_SESSION['user_id'];
$events = $conn->query("SELECT * FROM events WHERE status = 'open'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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
        .dashboard a {
            display: inline-block;
            margin: 5px;
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
            background: linear-gradient(to right, #6a11cb, #2575fc);
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
        <h1>-User Dashboard-</h1>
        <table>
            <tr>
                <th>Event Name</th>
                <th>Date</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php while ($event = $events->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $event['name']; ?></td>
                <td><?php echo $event['date']; ?></td>
                <td>
                    <img src="uploads/<?php echo $event['image']; ?>" alt="<?php echo $event['name']; ?>" width="100">
                </td>
                <td>
                    <?php
                    $registration = $conn->query("SELECT payment_status FROM registrations WHERE event_id = " . $event['id'] . " AND user_id = " . $user_id);
                    if ($registration->num_rows > 0) {
                        $reg = $registration->fetch_assoc();
                        if ($reg['payment_status'] == 'pending') {
                            echo '<a href="payment.php?id=' . $event['id'] . '">Complete Payment</a>';
                        } else {
                            echo '<a href="cancel_registration.php?id=' . $event['id'] . '">Cancel Registration</a>';
                        }
                    } else {
                        echo '<a href="register_event.php?id=' . $event['id'] . '">Register</a>';
                    }
                    ?>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
