<?php
include '../includes/dbconnect.php'; // Include the file that defines the `connectDatabase()` function

// Create the database connection
$connection = connectDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Trim user inputs to remove extra spaces
    $empname = trim($_POST['empname']);
    $salary = trim($_POST['salary']);
    $joindate = trim($_POST['joindate']);
    $address = trim($_POST['address']);

    // Initialize an array to store error messages
    $errors = [];
    if (!preg_match("/^[a-zA-Z\s'-]+$/", $empname)) {
        $errors[] = "Invalid name format. Only letters, spaces, apostrophes, and hyphens are allowed.";
    }
    if (!is_numeric($salary) || $salary <= 0) {
        $errors[] = "Salary must be a positive number.";
    }
    if (empty($joindate)) {
        $errors[] = "Join date is required.";
    }
    if (empty($address)) {
        $errors[] = "Address is required.";
    }

    // Check for errors
    if (empty($errors)) {
        // Use a prepared statement to prevent SQL injection
        $insertquery = $connection->prepare("INSERT INTO workers (name, address, salary, joindate) VALUES (?, ?, ?, ?)");
        $insertquery->bind_param("ssds", $empname, $address, $salary, $joindate);

        if ($insertquery->execute()) {
            // Redirect to the main page after successful registration
            header("Location: ../reception/mainpage.php");
            exit();
        } else {
            // Log and display the error for debugging
            echo "Error: " . $connection->error;
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
    <form class="row g-3 needs-validation" novalidate="" method="post" enctype="multipart/form-data" autocomplete="on">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Full Name</label>
            <input type="text" name="empname" class="form-control" id="exampleFormControlInput1" placeholder="Enter full name">
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="exampleFormControlInput1" placeholder="Godawari-03,Lalitpur">
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Salary</label>
            <input type="number" name="salary" class="form-control" id="exampleFormControlInput1" placeholder="Enter amount in Rupees">
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Joining Date</label>
            <input type="date" name="joindate" class="form-control" id="exampleFormControlInput1">
        </div>

        <input type="submit" name="submit" value="Register" class="btn btn-primary">
    </form>
    <form class="row g-3 needs-validation" novalidate="" method="post" enctype="multipart/form-data" autocomplete="on">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Full Name</label>
            <input type="text" name="empname" class="form-control" id="exampleFormControlInput1" placeholder="Enter full name">
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="exampleFormControlInput1" placeholder="Godawari-03,Lalitpur">
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Salary</label>
            <input type="number" name="salary" class="form-control" id="exampleFormControlInput1" placeholder="Enter amount in Rupees">
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Joining Date</label>
            <input type="date" name="joindate" class="form-control" id="exampleFormControlInput1">
        </div>

        <input type="submit" name="submit" value="Register" class="btn btn-primary">
    </form>
    <form class="row g-3 needs-validation" novalidate="" method="post" enctype="multipart/form-data" autocomplete="on">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Full Name</label>
            <input type="text" name="empname" class="form-control" id="exampleFormControlInput1" placeholder="Enter full name">
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="exampleFormControlInput1" placeholder="Godawari-03,Lalitpur">
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Salary</label>
            <input type="number" name="salary" class="form-control" id="exampleFormControlInput1" placeholder="Enter amount in Rupees">
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Joining Date</label>
            <input type="date" name="joindate" class="form-control" id="exampleFormControlInput1">
        </div>

        <input type="submit" name="submit" value="Register" class="btn btn-primary">
    </form>
    <form class="row g-3 needs-validation" novalidate="" method="post" enctype="multipart/form-data" autocomplete="on">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Full Name</label>
            <input type="text" name="empname" class="form-control" id="exampleFormControlInput1" placeholder="Enter full name">
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="exampleFormControlInput1" placeholder="Godawari-03,Lalitpur">
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Salary</label>
            <input type="number" name="salary" class="form-control" id="exampleFormControlInput1" placeholder="Enter amount in Rupees">
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Joining Date</label>
            <input type="date" name="joindate" class="form-control" id="exampleFormControlInput1">
        </div>

        <input type="submit" name="submit" value="Register" class="btn btn-primary">
    </form>
</body>

</html>