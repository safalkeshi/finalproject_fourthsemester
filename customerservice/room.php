<?php
// Include database connection
include "../includes/dbconnect.php";
$connection = connectDatabase();

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    $customerId = htmlspecialchars(trim($_POST['customerId']));
    $password = htmlspecialchars(trim($_POST['password']));
    $roomType = htmlspecialchars(trim($_POST['roomType']));
    $guests = htmlspecialchars(trim($_POST['guests']));
    $eventDate = htmlspecialchars(trim($_POST['eventDate']));
    $request = htmlspecialchars(trim($_POST['request']));

    if (empty($customerId) || empty($password)) {
        die("CustomerId and password are required.");
    }

    // Validate login
    $sql = "SELECT customerId FROM user_login WHERE customerId = ? AND password = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $customerId, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['customerId'];

        // Insert into room table
        $sql_insert = "INSERT INTO room (user_id, room_type, num_guest, event_date, additional_request)
                       VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $connection->prepare($sql_insert);
        $stmt_insert->bind_param("isiss", $user_id, $roomType, $guests, $eventDate, $request);
        if ($stmt_insert->execute()) {
            header("Location: ../reception/mainpage.php");
            exit;
        } else {
            echo "Error: " . $stmt_insert->error;
        }
    } else {
        echo "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Booking</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Card image styling to maintain same size and aspect ratio */
        .room-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            /* Ensures the images fill the space without stretching */
        }

        .room-card .btn {
            background-color: #2c3e50;
            color: white;
            width: 100%;
            font-size: 16px;
            border-radius: 5px;
            padding: 10px;
        }

        .room-card .btn:hover {
            background-color: #34495e;
        }

        .room-card .card-body {
            text-align: center;
        }

        .room-card .card-body h5 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .room-card .card-body p {
            font-size: 14px;
            color: #7f8c8d;
        }

        .room-card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            margin-bottom: 20px;
        }

        /* Custom styling for the form */
        .room-form {
            background-color: #ecf0f1;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .room-form input,
        .room-form select,
        .room-form textarea {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .room-form textarea {
            resize: vertical;
            height: 80px;
        }

        .room-form button {
            background-color: #2c3e50;
            color: white;
            border: none;
            cursor: pointer;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            margin-top: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .room-form button:hover {
            background-color: #34495e;
        }
    </style>
</head>

<body>

    <!-- Room Images Section -->
    <div class="container mt-5">
        <div class="row">
            <!-- Master Bedroom Card -->
            <div class="col-md-4 mb-4">
                <div class="card room-card">
                    <img src="../customerservice/images/deluxebed.jpg" class="card-img-top" alt="Master Bedroom">
                    <div class="card-body">
                        <h5 class="card-title">Master Bedroom</h5>
                        <p class="card-text">A luxurious experience</p>
                        <button class="btn" data-bs-toggle="modal" data-bs-target="#bookingModal" data-roomtype="master">Book Now</button>
                    </div>
                </div>
            </div>

            <!-- Double Bedroom Card -->
            <div class="col-md-4 mb-4">
                <div class="card room-card">
                    <img src="../customerservice/images/doublebed.jpg" class="card-img-top" alt="Double Bedroom">
                    <div class="card-body">
                        <h5 class="card-title">Double Bedroom</h5>
                        <p class="card-text">A comfortable stay</p>
                        <button class="btn" data-bs-toggle="modal" data-bs-target="#bookingModal" data-roomtype="double">Book Now</button>
                    </div>
                </div>
            </div>

            <!-- King Bedroom Card -->
            <div class="col-md-4 mb-4">
                <div class="card room-card">
                    <img src="../customerservice/images/kingbed.jpg" class="card-img-top" alt="King Bedroom">
                    <div class="card-body">
                        <h5 class="card-title">King Bedroom</h5>
                        <p class="card-text">A royal stay awaits</p>
                        <button class="btn" data-bs-toggle="modal" data-bs-target="#bookingModal" data-roomtype="king">Book Now</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2nd Row with remaining rooms -->
        <div class="row">
            <!-- Single Bedroom Card -->
            <div class="col-md-4 mb-4">
                <div class="card room-card">
                    <img src="../customerservice/images/singlebed.jpg" class="card-img-top" alt="Single Bedroom">
                    <div class="card-body">
                        <h5 class="card-title">Single Bedroom</h5>
                        <p class="card-text">Simple & cozy</p>
                        <button class="btn" data-bs-toggle="modal" data-bs-target="#bookingModal" data-roomtype="single">Book Now</button>
                    </div>
                </div>
            </div>

            <!-- Queen Bedroom Card -->
            <div class="col-md-4 mb-4">
                <div class="card room-card">
                    <img src="../customerservice/images/queenbed.jpg" class="card-img-top" alt="Queen Bedroom">
                    <div class="card-body">
                        <h5 class="card-title">Queen Bedroom</h5>
                        <p class="card-text">Fit for a queen</p>
                        <button class="btn" data-bs-toggle="modal" data-bs-target="#bookingModal" data-roomtype="queen">Book Now</button>
                    </div>
                </div>
            </div>

            <!-- Double Bedroom Card -->
            <div class="col-md-4 mb-4">
                <div class="card room-card">
                    <img src="../customerservice/images/doublebed.jpg" class="card-img-top" alt="Double Bedroom">
                    <div class="card-body">
                        <h5 class="card-title">Double Bedroom</h5>
                        <p class="card-text">Double the comfort</p>
                        <button class="btn" data-bs-toggle="modal" data-bs-target="#bookingModal" data-roomtype="double">Book Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Form Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Book Your Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="room.php" method="post" enctype="multipart/form-data">
                        <!-- Customer ID -->
                        <input type="text" name="customerId" class="form-control" placeholder="CustomerId" required><br>

                        <!-- Password -->
                        <input type="password" name="password" class="form-control" placeholder="Password" required><br>

                        <!-- Room Type (Hidden initially) -->
                        <input type="text" name="roomType" id="roomType" class="form-control" placeholder="Room Type" readonly><br>

                        <!-- Number of Guests -->
                        <input type="number" name="guests" class="form-control" placeholder="Number of Guests" required><br>

                        <!-- Event Date -->
                        <input type="date" name="eventDate" class="form-control" required><br>

                        <!-- Additional Request -->
                        <textarea name="request" class="form-control" placeholder="Add any special request"></textarea><br>

                        <!-- Submit Button -->
                        <button class="btn btn-primary" type="submit">Submit Room Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Handle setting the room type based on the clicked room
        var modal = document.getElementById('bookingModal');
        modal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var roomType = button.getAttribute('data-roomtype'); // Extract info from data-* attributes
            var roomTypeInput = modal.querySelector('#roomType');
            roomTypeInput.value = roomType;
        });
    </script>
</body>

</html>