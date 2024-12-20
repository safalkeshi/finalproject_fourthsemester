<?php
// Include database connection
include "../includes/dbconnect.php";
$connection = connectDatabase();

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form data
    $laundry_type = isset($_POST['laundry_type']) ? htmlspecialchars(trim($_POST['laundry_type'])) : '';
    $num_cloth = isset($_POST['num_cloth']) ? htmlspecialchars(trim($_POST['num_cloth'])) : '';
    $event_date = isset($_POST['event_date']) ? htmlspecialchars(trim($_POST['event_date'])) : '';
    $additional_request = isset($_POST['additional_request']) ? htmlspecialchars(trim($_POST['additional_request'])) : '';
    $user_id = isset($_POST['user_id']) ? htmlspecialchars(trim($_POST['user_id'])) : '';
    $user_password = isset($_POST['password']) ? htmlspecialchars(trim($_POST['password'])) : '';

    // Validate required fields
    if (empty($laundry_type) || empty($num_cloth) || empty($event_date) || empty($user_id) || empty($user_password)) {
        die("All fields are required.");
    }

    // Validate user login credentials
    $sql = "SELECT customerId, password FROM user_login WHERE customerId = ? AND password = ?";
    if (!$stmt = $connection->prepare($sql)) {
        die("Query preparation failed: " . $connection->error);
    }

    $stmt->bind_param("is", $user_id, $user_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Insert laundry request data
        $sql_insert = "INSERT INTO laundry (user_id, laundry_type, num_cloth, event_date, additional_request)
                       VALUES (?, ?, ?, ?, ?)";
        if (!$stmt_insert = $connection->prepare($sql_insert)) {
            die("Insert query preparation failed: " . $connection->error);
        }

        $stmt_insert->bind_param("isiss", $user_id, $laundry_type, $num_cloth, $event_date, $additional_request);

        if ($stmt_insert->execute()) {
            // Redirect to main page on success
            header("Location: ../reception/mainpage.php");
            exit();
        } else {
            echo "Error submitting laundry request: " . $stmt_insert->error;
        }

        $stmt_insert->close();
    } else {
        echo "Invalid credentials, please try again.";
    }

    $stmt->close();
}

$connection->close();
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry Service Request</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #laundrysection {
            background-color: #ecf0f1;
            border-radius: 10px;
            padding: 30px;
            width: 80%;
            max-width: 500px;
            margin: 40px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        #laundrysection h3 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }

        #laundrysection label {
            font-size: 16px;
            color: #2c3e50;
        }

        #laundrysection button {
            background-color: #2c3e50;
            color: white;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 16px;
        }

        #laundrysection button:hover {
            background-color: #34495e;
        }

        @media (max-width: 768px) {
            #laundrysection {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <center>
        <div id="laundrysection" class="container mt-5">
            <form action="laundry.php" method="POST" enctype="multipart/form-data">
                <h3>Laundry Service Request</h3>
                <p>We offer a variety of laundry services to meet your needs.</p>

                <div class="form-group">
                    <label for="laundry_service">Select Laundry Service:</label>
                    <select class="form-control" name="laundry_type" id="laundry_service" required>
                        <option value="dry_cleaning">Dry Cleaning</option>
                        <option value="regular_laundry">Regular Laundry</option>
                        <option value="ironing">Ironing Services</option>
                        <option value="special_fabric">Special Fabric Care</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="num_cloth">Number of Clothes:</label>
                    <input type="number" class="form-control" name="num_cloth" id="num_cloth" required />
                </div>

                <div class="form-group">
                    <label for="event_date">Event Date:</label>
                    <input type="date" class="form-control" name="event_date" id="event_date" required />
                </div>

                <div class="form-group">
                    <label for="additional_request">Additional Request:</label>
                    <textarea class="form-control" name="additional_request" id="additional_request" placeholder="Add any special request"></textarea>
                </div>

                <div class="form-group">
                    <label for="user_id">User ID:</label>
                    <input type="text" class="form-control" name="user_id" id="user_id" required />
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" id="password" required />
                </div>

                <button type="submit" class="btn btn-primary">Submit Laundry Request</button>
            </form>
        </div>
    </center>
</body>

</html>