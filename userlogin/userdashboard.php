<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['customerId'])) {
    header("Location: login.php");
    exit();
}

include "../includes/dbconnect.php";
$connection = connectDatabase();

$customerId = $_SESSION['customerId'];

// Fetch room bookings
$roomQuery = "SELECT * FROM room WHERE customerId = ?";
$roomStmt = $connection->prepare($roomQuery);
$roomStmt->bind_param("i", $customerId);
$roomStmt->execute();
$roomResults = $roomStmt->get_result();

// Fetch laundry orders
$laundryQuery = "SELECT * FROM laundry WHERE customerId = ?";
$laundryStmt = $connection->prepare($laundryQuery);
$laundryStmt->bind_param("i", $customerId);
$laundryStmt->execute();
$laundryResults = $laundryStmt->get_result();

// Fetch kitchen orders
$kitchenQuery = "SELECT * FROM kitchen WHERE customerId = ?";
$kitchenStmt = $connection->prepare($kitchenQuery);
$kitchenStmt->bind_param("i", $customerId);
$kitchenStmt->execute();
$kitchenResults = $kitchenStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h1>

        <h2>Your Room Bookings</h2>
        <?php if ($roomResults->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Room ID</th>
                        <th>Booking Date</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $roomResults->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['room_id']; ?></td>
                            <td><?php echo $row['booking_date']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No room bookings found.</p>
        <?php endif; ?>

        <h2>Your Laundry Orders</h2>
        <?php if ($laundryResults->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Items</th>
                        <th>Total Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $laundryResults->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['items']; ?></td>
                            <td><?php echo $row['total_cost']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No laundry orders found.</p>
        <?php endif; ?>

        <h2>Your Kitchen Orders</h2>
        <?php if ($kitchenResults->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Food Items</th>
                        <th>Total Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $kitchenResults->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['order_id']; ?></td>
                            <td><?php echo $row['food_items']; ?></td>
                            <td><?php echo $row['total_cost']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No kitchen orders found.</p>
        <?php endif; ?>

        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>

</html>