<?php
include "../includes/dbconnect.php";

// Establish database connection
$connection = connectDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Trim user inputs to remove extra spaces
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $number = trim($_POST['number']);
    $password = trim($_POST['password']);

    // Initialize an array to store error messages
    $errors = [];

    // Validate name
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
            // Redirect to the main page after successful registration
            header("Location: ../reception/mainpage.php");
            exit();
        } else {
            // Handle failure
            echo "Error: " . $insertquery->error;
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <form class="row g-3 needs-validation" novalidate="" method="post" enctype="multipart/form-data" autocomplete="off">
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Ram Shrestha" required>
        </div>

        <div class="mb-3">
            <label for="number" class="form-label">Phone Number</label>
            <input type="text" name="number" class="form-control" id="number" placeholder="0987654321" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="********" required>
        </div>

        <input type="submit" name="submit" value="Register" class="btn btn-primary">
    </form>
</body>

</html>