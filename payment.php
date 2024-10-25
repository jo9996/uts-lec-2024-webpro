<?php
include 'config.php';
session_start();
if ($_SESSION['role'] != 'user') {
    header("Location: login.php");
}

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Simulasi pembayaran
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $payment_method = $_POST['payment_method'];
        $ticket_quantity = $_POST['ticket_quantity'];
        $total_amount = $_POST['total_amount'];

        // Simpan informasi pembayaran dan update status pembayaran menjadi 'completed'
        $stmt = $conn->prepare("UPDATE registrations SET payment_status = 'completed', payment_method = ?, ticket_quantity = ?, total_amount = ? WHERE event_id = ? AND user_id = ?");
        $stmt->bind_param("siiii", $payment_method, $ticket_quantity, $total_amount, $event_id, $user_id);
        $stmt->execute();

        header("Location: user_dashboard.php");
    }
} else {
    header("Location: user_dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function calculateTotal() {
            const ticketPrice = 100; // Harga tiket per unit
            const quantity = document.getElementById('ticket_quantity').value;
            const total = ticketPrice * quantity;
            document.getElementById('total_amount').value = total;
            document.getElementById('total_display').innerText = 'Total: $' + total;
        }
    </script>
</head>
<body style="font-family: Arial, sans-serif; background: linear-gradient(to right, #ff7e5f, #feb47b); display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;">
    <div class="payment-container" style="background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); text-align: center;">
        <h1>Payment for Event</h1>
        <form method="POST" action="">
            <p>Please complete your payment to register for the event.</p>
            <label for="payment_method">Payment Method:</label>
            <select id="payment_method" name="payment_method" required>
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
                <option value="bank_transfer">Bank Transfer</option>
            </select>
            <br><br>
            <label for="ticket_quantity">Ticket Quantity:</label>
            <input type="number" id="ticket_quantity" name="ticket_quantity" min="1" value="1" required onchange="calculateTotal()">
            <br><br>
            <input type="hidden" id="total_amount" name="total_amount" value="100">
            <p id="total_display">Total: $100</p>
            <button type="submit" style="padding: 10px 20px; background-color: #ff7e5f; color: white; border: none; border-radius: 5px; font-size: 1em; cursor: pointer;">Pay Now</button>
        </form>
    </div>
</body>
</html>
