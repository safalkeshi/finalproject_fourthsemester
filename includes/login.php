<?php
session_start();
include 'dbconnect.php'; // Include the database connection file

// Create the database connection
$connection = connectDatabase();

if (isset($_POST['submit'])) {
    // Get the email and password from the form
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid email format.");</script>';
    } else {
        // Use a prepared statement to prevent SQL injection
        $query = $connection->prepare("SELECT id, name, password FROM user_registration WHERE email = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            // Fetch the user record
            $user = $result->fetch_assoc();
            $db_password = $user['password'];

            // Check if the passwords match
            if ($password === $db_password) {
                // Store user data in session
                $_SESSION['userid'] = $user['id'];
                $_SESSION['username'] = $user['name'];
                $_SESSION['email'] = $email;

                // Redirect to user dashboard or main page
                header("Location: ../reception/mainpage.php");
                exit();
            } else {
                echo '<script>alert("Incorrect password.");</script>';
            }
        } else {
            echo '<script>alert("No user found with this email.");</script>';
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <form method="post" enctype="multipart/form-data" autocomplete="on">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control"
                name="email" id="exampleInputEmail1" aria-describedby="emailHelp">

        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Login</button>
        <p>Or</p>
        <p><a class="link-opacity-100" href="user_register.php">Register</a></p>
        <p><a class="link-opacity-100" href="">Admin</a></p>

    </form>
</body>

</html>