<?php
include 'config.php';

// Ambil data event dari database
$events = $conn->query("SELECT id, name, image FROM events WHERE status = 'open'");

// Fungsi untuk mencari event berdasarkan kata kunci
$search_keyword = '';
if (isset($_GET['search'])) {
    $search_keyword = $_GET['search'];
    $events = $conn->query("SELECT id, name, image FROM events WHERE status = 'open' AND name LIKE '%$search_keyword%'");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration System</title>
    <link rel="stylesheet" href="stylesindex.css">
    <style>
        /* Additional styles for the homepage */
        html, body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            width: 100%;
            background: #6495ED; /* Ubah warna navbar menjadi abu-abu terang */
            color: white;
            padding: 15px 20px;
            text-align: left;
            position: fixed;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar img {
            width: 100px;
            vertical-align: middle;
        }

        .navbar .actions {
            display: flex;
            align-items: center;
        }

        .navbar .actions a {
            margin-right: 20px;
            padding: 10px 20px;
            background-color: #fff;
            color: #2575fc;
            border-radius: 25px;
            text-decoration: none;
            font-size: 1em;
            transition: background-color 0.3s, color 0.3s;
        }

        .navbar .actions a:hover {
            background-color: #2575fc;
            color: #fff;
        }

        .search-bar {
            display: flex;
            align-items: center;
            margin-right: 35px;
        }

        .search-bar input[type="text"] {
            width: 200px;
            padding: 10px;
            border-radius: 25px;
            border: 1px solid #ccc;
            font-size: 1em;
            margin-right: 10px;
        }

        .search-bar button {
            padding: 10px 20px;
            border-radius: 25px;
            border: none;
            background-color: #2575fc;
            color: white;
            font-size: 1em;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #6a11cb;
        }

        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            text-align: center;
            padding: 20px;
            padding-top: 150px; /* Adjust for navbar */
        }

        .content h1 {
            font-size: 3em;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            animation: fadeIn 2s ease-in-out;
        }

        .content p {
            font-size: 1.2em;
            margin-bottom: 40px;
            animation: fadeIn 2s ease-in-out 1s;
        }

        .content a {
            display: inline-block;
            margin: 10px;
            padding: 15px 30px;
            background-color: #fff;
            color: #2575fc;
            border-radius: 25px;
            text-decoration: none;
            font-size: 1.2em;
            transition: background-color 0.3s, color 0.3s, transform 0.3s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            animation: fadeIn 2s ease-in-out 2s;
            z-index: 10; /* Tambahkan z-index */
            position: relative; /* Pastikan tombol berada di atas elemen lainnya */
        }

        .content a:hover {
            background-color: #2575fc;
            color: #fff;
            transform: scale(1.05);
        }

        .event-preview {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }

        .event-preview a {
            position: relative;
            margin: 10px;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
            background: white;
            text-decoration: none;
            color: black;
        }

        .event-preview a:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .event-preview img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .event-preview a:hover img {
            transform: scale(1.1);
        }

        .event-preview .event-info {
            padding: 15px;
            text-align: center;
        }

        .footer {
            background: #6495ED;
            color: white;
            text-align: center;
            padding: 20px 0;
            width: 100%;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <img src="logo.png" alt="Logo">
        <div class="actions">
            <a href="login.php">Login</a>
            <div class="search-bar">
                <form action="" method="GET">
                    <input type="text" name="search" placeholder="Search for events..." value="<?php echo htmlspecialchars($search_keyword); ?>">
                    <button type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
    <div class="content">
        <h1>Welcome to FunEvent</h1>
        <p>Discover and book tickets for the best events in town!</p>
        <a href="user_dashboard.php">Register Event</a> <!-- Tambahkan tombol Register Event -->
        <div class="event-preview">
            <?php while ($event = $events->fetch_assoc()) { ?>
                <a href="event_detail.php?id=<?php echo $event['id']; ?>">
                    <img src="uploads/<?php echo $event['image']; ?>" alt="<?php echo $event['name']; ?>" title="<?php echo $event['name']; ?>">
                    <div class="event-info">
                        <h3><?php echo $event['name']; ?></h3>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>
    <div class="footer">
        © 2024 FunEvent. All rights reserved.
    </div>
</body>
</html>
