<?php
include "../includes/dbconnect.php"; // Ensure this file defines the connectDatabase function properly
// Start session
session_start();

// Initialize Database Connection
$connection = connectDatabase(); // Assuming this returns a valid mysqli connection

// Get form data
$role = $_POST['role'];
$username = $_POST['username'];
$password = $_POST['password'];

// Check if all fields are filled
if (empty($role) || empty($username) || empty($password)) {
    die("All fields are required!");
}

if ($role === "user") {
    // Check user credentials
    $sql = "SELECT * FROM user_login WHERE name = ? AND password = ?";
    $stmt = $connection->prepare($sql);

    if (!$stmt) {
        die("Query preparation failed: " . $connection->error);
    }

    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login successful
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        header("Location: ../userlogin/userdashboard.php");
        echo "error";
    } else {
        echo "Invalid username or password for User!";
    }

    $stmt->close();
} else if ($role === "admin") {
    // Query to check admin credentials
    $sql = "SELECT * FROM admins WHERE username = ? AND password = ?";
    $stmt = $connection->prepare($sql);

    if (!$stmt) {
        die("Query preparation failed: " . $connection->error);
    }

    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login successful
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        header("Location:../reception/mainpage.php");
        exit;
    } else {
        echo "Invalid username or password for Admin!";
    }

    $stmt->close();
}

// Close the database connection
if ($connection) {
    $connection->close();
}
