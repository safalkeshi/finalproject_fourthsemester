<?php
// Include database connection
include "../includes/dbconnect.php";
$connection = connectDatabase();

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form data
    $event_type = isset($_POST['event_type']) ? htmlspecialchars(trim($_POST['event_type'])) : '';
    $num_guests = isset($_POST['num_guests']) ? htmlspecialchars(trim($_POST['num_guests'])) : '';
    $event_date = isset($_POST['event_date']) ? htmlspecialchars(trim($_POST['event_date'])) : '';
    $additional_request = isset($_POST['additional_request']) ? htmlspecialchars(trim($_POST['additional_request'])) : '';
    $user_id = isset($_POST['user_id']) ? htmlspecialchars(trim($_POST['user_id'])) : '';
    $user_password = isset($_POST['password']) ? htmlspecialchars(trim($_POST['password'])) : '';

    // Check for missing values
    if (empty($event_type) || empty($num_guests) || empty($event_date) || empty($user_id) || empty($user_password)) {
        die("All fields are required.");
    }

    // Validate user login credentials
    $sql = "SELECT customerId FROM user_login WHERE customerId = ? AND password = ?";
    $stmt = $connection->prepare($sql);

    if (!$stmt) {
        die("Query preparation failed: " . $connection->error);
    }

    $stmt->bind_param("is", $user_id, $user_password); // Assuming user_id is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $customerId = $row['customerId']; // Fetch the correct customerId

        // Insert banquet data if user is valid
        $sql_insert = "INSERT INTO banquet (user_id, event_type, num_guests, event_date, additional_request, customerId)
                       VALUES (?, ?, ?, ?, ?, ?)";

        $stmt_insert = $connection->prepare($sql_insert);

        if (!$stmt_insert) {
            die("Insert query preparation failed: " . $connection->error);
        }

        $stmt_insert->bind_param("isisss", $customerId, $event_type, $num_guests, $event_date, $additional_request, $customerId);

        if ($stmt_insert->execute()) {
            // Redirect to main page on success
            header("Location: ../reception/mainpage.php");
            exit();
        } else {
            echo "Error submitting banquet request: " . $stmt_insert->error;
        }

        $stmt_insert->close();
    } else {
        echo "Invalid credentials, please try again.";
    }

    $stmt->close();
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banquet Booking</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Banquet Section Styling */
        #banquetsection {
            background-color: #ecf0f1;
            border-radius: 10px;
            padding: 30px;
            width: 80%;
            max-width: 500px;
            margin: 40px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            text-align: left;
        }

        #banquetsection label {
            font-size: 16px;
            color: #2c3e50;
            display: block;
            margin-top: 15px;
        }

        #banquetsection select,
        #banquetsection input[type="number"],
        #banquetsection input[type="date"],
        #banquetsection textarea,
        #banquetsection input[type="text"],
        #banquetsection input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            background-color: #fff;
            color: #2c3e50;
            font-size: 16px;
        }

        #banquetsection select:focus,
        #banquetsection input[type="number"]:focus,
        #banquetsection input[type="date"]:focus,
        #banquetsection textarea:focus,
        #banquetsection input[type="text"]:focus,
        #banquetsection input[type="password"]:focus {
            border-color: #3498db;
            outline: none;
        }

        #banquetsection textarea {
            height: 80px;
            resize: vertical;
        }

        #banquetsection button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #banquetsection button:hover {
            background-color: #34495e;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            #banquetsection {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <center>
        <div id="banquetsection" class="container mt-5">
            <label for="">Our hotel offers a variety of banquet options for your events:</label>
            <form action="" method="post" enctype="multipart/form-data">
                <!-- Select Banquet Event Type -->
                <div class="form-group">
                    <label for="event_type">Select Event Type:</label>
                    <select class="form-control" name="event_type" id="event_type">
                        <option value="wedding">Wedding Receptions</option>
                        <option value="corporate">Corporate Meetings</option>
                        <option value="birthday">Birthday Parties</option>
                        <option value="conferences">Conferences</option>
                        <option value="other">Other Special Events</option>
                    </select>
                </div>

                <!-- Number of Guests -->
                <div class="form-group">
                    <label for="num_guests">Number of Guests:</label>
                    <input type="number" class="form-control" name="num_guests" id="num_guests" required />
                </div>

                <!-- Event Date -->
                <div class="form-group">
                    <label for="event_date">Event Date:</label>
                    <input type="date" class="form-control" name="event_date" id="event_date" required />
                </div>

                <!-- Additional Request -->
                <div class="form-group">
                    <label for="additional_request">Additional Request:</label>
                    <textarea class="form-control" name="additional_request" id="additional_request" placeholder="Add any special request"></textarea>
                </div>

                <!-- User ID and Password -->
                <div class="form-group">
                    <label for="user_id">CustomerId</label>
                    <input type="text" class="form-control" name="user_id" id="user_id" required />
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" id="password" required />
                </div>

                <button type="submit" class="btn btn-primary btn-block">Submit Banquet Request</button>
            </form>
        </div>
    </center>

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>