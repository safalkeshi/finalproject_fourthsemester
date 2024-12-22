<?php
// Include database connection
include "../includes/dbconnect.php";
$connection = connectDatabase();

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $meal_type = isset($_POST['meal_type']) ? trim($_POST['meal_type']) : '';
    $num_guests = isset($_POST['num_guests']) ? trim($_POST['num_guests']) : '';
    $event_date = isset($_POST['event_date']) ? trim($_POST['event_date']) : '';
    $additional_request = isset($_POST['additional_request']) ? trim($_POST['additional_request']) : '';
    $user_id = isset($_POST['user_id']) ? trim($_POST['user_id']) : '';
    $user_password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (empty($meal_type) || empty($num_guests) || empty($event_date) || empty($user_id) || empty($user_password)) {
        die("All fields are required.");
    }

    // Validate the user login credentials with plain text password
    $sql = "SELECT customerId, password FROM user_login WHERE customerId = ? AND password = ?";
    if (!$stmt = $connection->prepare($sql)) {
        die("Query preparation failed: " . $connection->error);
    }

    $stmt->bind_param("is", $user_id, $user_password); // 'is' means integer for user_id and string for password
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch customerId
        $row = $result->fetch_assoc();
        $customerId = $row['customerId'];  // Get the correct customerId

        // Insert kitchen request data
        $sql_insert = "INSERT INTO kitchen (user_id, food_type, num_guests, event_date, additional_request, customerId)
                       VALUES (?, ?, ?, ?, ?, ?)";
        if (!$stmt_insert = $connection->prepare($sql_insert)) {
            die("Insert query preparation failed: " . $connection->error);
        }

        $stmt_insert->bind_param("isisss", $user_id, $meal_type, $num_guests, $event_date, $additional_request, $customerId);

        if ($stmt_insert->execute()) {
            header("location:../reception/mainpage.php");
        } else {
            echo "Error submitting kitchen request: " . $stmt_insert->error;
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
<center>
    <div id="kitchenformsection">
        <form action="kitchen.php" method="POST">
            <label>Enjoy our kitchen service with a variety of delicious options:</label>
            <ul class="list-group">
                <li class="list-group-item" data-meal="breakfast">Breakfast</li>
                <li class="list-group-item" data-meal="lunch">Lunch</li>
                <li class="list-group-item" data-meal="dinner">Dinner</li>
                <li class="list-group-item" data-meal="snacks">Snacks and Beverages</li>
                <li class="list-group-item" data-meal="special">Special Dietary Meals</li>
            </ul>

            <!-- Additional Fields -->
            <div class="form-group">
                <label for="meal_type">Select Meal Type:</label>
                <select class="form-control" name="meal_type" id="meal_type" required>
                    <option value="breakfast">Breakfast</option>
                    <option value="lunch">Lunch</option>
                    <option value="dinner">Dinner</option>
                    <option value="snacks">Snacks and Beverages</option>
                    <option value="special">Special Dietary Meals</option>
                </select>
            </div>

            <div class="form-group">
                <label for="num_guests">Number of Guests:</label>
                <input type="number" class="form-control" name="num_guests" id="num_guests" required />
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
                <label for="user_id">Customer ID:</label>
                <input type="text" class="form-control" name="user_id" id="user_id" required />
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password" required />
            </div>

            <button type="submit" class="btn btn-primary btn-block">Submit Kitchen Request</button>
        </form>
    </div>
</center>

<!-- External Bootstrap CSS link -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<style>
    #kitchenformsection {
        background-color: #ecf0f1;
        border-radius: 10px;
        padding: 30px;
        width: 80%;
        max-width: 500px;
        margin: 40px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        text-align: left;
    }

    #kitchenformsection label {
        font-size: 16px;
        color: #2c3e50;
        display: block;
        margin-bottom: 15px;
    }

    #kitchenformsection .list-group-item {
        cursor: pointer;
    }

    #kitchenformsection .list-group-item:hover {
        background-color: #3498db;
        color: white;
    }

    @media (max-width: 768px) {
        #kitchenformsection {
            width: 90%;
        }
    }
</style>