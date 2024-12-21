<?php
include "../includes/dbconnect.php";

// Fetch data from the database (only declare this function if it's not already declared)
if (!function_exists('fetchData')) {
    function fetchData($connection)
    {
        // Updated SQL query to get the room data and join with the user_login table
        $sql = "SELECT r.room_id, r.user_id, r.room_type, r.num_guest, r.event_date, r.additional_request, r.customerId, r.is_available, u.name 
                FROM room r 
                JOIN user_login u ON r.user_id = u.customerId 
                ORDER BY r.event_date ASC, r.user_id ASC"; // FIFO logic based on order
        $result = $connection->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}

$connection = connectDatabase();
$infoData = fetchData($connection);
$connection->close();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Room Booking Status</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="p-3 m-0 border-0 bd-example m-0 border-0">
    <div class="container mt-2" id="customer">
        <h3 class="mb-3">Room Booking Status</h3>
        <table class="table table-hover col-12">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Room Type</th>
                    <th>Number of Guests</th>
                    <th>Date</th>
                    <th>Availability</th>
                    <th>Username</th>
                    <th>Operation</th>
                    <th>Info</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $bookedRooms = []; // To track booked rooms by date
                foreach ($infoData as $row):
                    $roomKey = $row['room_type'] . $row['event_date'];
                    // Check if the room and date combination already exists
                    if (isset($bookedRooms[$roomKey])) {
                        $availability = "Not Available"; // Subsequent bookings are not available
                    } else {
                        $availability = "Available"; // First booking is available
                        $bookedRooms[$roomKey] = true; // Mark this room and date as booked
                    }
                ?>
                    <tr>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['room_type']; ?></td>
                        <td><?php echo $row['num_guest']; ?></td>
                        <td><?php echo $row['event_date']; ?></td>
                        <td><?php echo $availability; ?></td>
                        <td><?php echo $row['name']; ?></td> <!-- Show user name -->
                        <td><a href="#">Approve</a> || <a href="#">Failed</a></td>
                        <td><a href="#">View</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add.php" type="button" class="btn btn-dark">Add New Customer</a>
    </div>
</body>

</html>