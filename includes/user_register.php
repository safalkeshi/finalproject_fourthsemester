<?php
session_start();
include "../includes/dbconnect.php";
$connection = connectDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Trim user inputs to remove extra spaces
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $number = trim($_POST['number']);
    $password = trim($_POST['password']);

    // Initialize an array to store error messages
    $errors = [];
    if (!preg_match("/^[a-zA-Z\s'-]+$/", $name)) {
        $errors[] = "Invalid name format. Only letters, spaces, apostrophes, and hyphens are allowed.";
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate phone number (10 digits)
    if (!preg_match("/^\d{10}$/", $number)) {
        $errors[] = "Phone number should be exactly 10 digits.";
    }

    // Validate password length
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    // Check for errors
    if (empty($errors)) {
        // Use a prepared statement to prevent SQL injection
        $insertquery = $connection->prepare("INSERT INTO user_registration (name, email, phone, password) VALUES (?, ?, ?, ?)");
        $insertquery->bind_param("ssss", $name, $email, $number, $password);

        if ($insertquery->execute()) {
            // Fetch the last inserted customerId (auto-incremented)
            $customerId = $connection->insert_id;

            // Insert into user_login table with the name, email, password, and customerId
            $insertLoginQuery = $connection->prepare("INSERT INTO user_login (customerId, name, password) VALUES (?, ?, ?)");
            $insertLoginQuery->bind_param("iss", $customerId, $name, $password);

            if ($insertLoginQuery->execute()) {
                // Redirect to the main page after successful registration
                header("Location: ../reception/mainpage.php");
                exit();
            } else {
                echo "Error inserting into user_login: " . $insertLoginQuery->error;
            }
        } else {
            echo "Error inserting into user_registration: " . $insertquery->error;
        }
    } else {
        // If there are validation errors, display them
        echo '<ul>';
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo '</ul>';
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fa;
        }

        .form-container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
            color: #333;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
            border-radius: 25px;
            padding: 12px 25px;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .link-custom {
            color: #007bff;
            text-decoration: none;
        }

        .link-custom:hover {
            text-decoration: underline;
        }

        .error-msg {
            color: red;
            list-style: none;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="p-3">

    <div class="form-container">
        <h2 class="form-title">User Registration</h2>

        <?php if (!empty($errors)) { ?>
            <div class="alert alert-danger">
                <ul class="error-msg">
                    <?php foreach ($errors as $error) {
                        echo "<li>$error</li>";
                    } ?>
                </ul>
            </div>
        <?php } ?>

        <form class="needs-validation" method="post" novalidate="" autocomplete="on">
            <!-- Full Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Ram Shrestha" required>
            </div>

            <!-- Phone Number -->
            <div class="mb-3">
                <label for="number" class="form-label">Phone Number</label>
                <input type="text" name="number" class="form-control" id="number" placeholder="0987654321" required>
            </div>

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" required>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Your password" required>
            </div>

            <!-- Submit Button -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-custom">Register</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <p>Already have an account? <a href="../userlogin/login.php" class="link-custom">Login</a></p>
            <p>Admin? <a href="../userlogin/login.php" class="link-custom">Login as Admin</a></p>
        </div>
    </div>

</body>

</html>