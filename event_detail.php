<?php
include 'config.php';

// Check if the event ID is set in the URL
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // Prepare and execute the query to fetch event details
    $stmt = $conn->prepare("SELECT name, image, description, date, location FROM events WHERE id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the event exists
    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc();
    } else {
        echo "Event not found.";
        exit;
    }
} else {
    echo "No event ID provided.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($event['name']); ?> - Event Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .event-detail {
            background: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 600px;
            width: 100%;
        }

        .event-detail img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .event-detail h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .event-detail p {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .event-detail .event-info {
            margin-top: 20px;
            text-align: left;
        }

        .event-detail .event-info p {
            margin: 5px 0;
        }

        .event-detail a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #fff;
            color: #2575fc;
            border-radius: 25px;
            text-decoration: none;
            font-size: 1.2em;
            transition: background-color 0.3s, color 0.3s, transform 0.3s;
        }

        .event-detail a:hover {
            background-color: #2575fc;
            color: #fff;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="event-detail">
        <img src="uploads/<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['name']); ?>">
        <h1><?php echo htmlspecialchars($event['name']); ?></h1>
        <p><?php echo htmlspecialchars($event['description']); ?></p>
        <div class="event-info">
            <p><strong>Date:</strong> <?php echo htmlspecialchars($event['date']); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
            <p><strong>price: $100</p>
        </div>
        <a href="login.php?id=<?php echo $event_id; ?>">Login untuk booking!</a>
    </div>
</body>
</html>
