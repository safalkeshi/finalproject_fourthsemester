<?php
require_once '../includes/dbconnect.php';

// Create the database connection
$connection = connectDatabase(); // Assign the returned connection object

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
            // Redirect to the same page to refresh data
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . $connection->error;
        }
    } else {
        echo '<ul>';
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo '</ul>';
    }
}

// Fetch all records from the database
$result = $connection->query("SELECT * FROM workers");
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="p-3 m-0 border-0 bd-example m-0 border-0">

    <form class="row g-3 needs-validation" novalidate="" method="post" enctype="multipart/form-data" autocomplete="on">
        <div class="mb-3">
            <label for="empname" class="form-label">Full Name</label>
            <input type="text" name="empname" class="form-control" id="empname" placeholder="Enter full name">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="address" placeholder="Godawari-03,Lalitpur">
        </div>

        <div class="mb-3">
            <label for="salary" class="form-label">Salary</label>
            <input type="number" name="salary" class="form-control" id="salary" placeholder="Enter amount in Rupees">
        </div>

        <div class="mb-3">
            <label for="joindate" class="form-label">Joining Date</label>
            <input type="date" name="joindate" class="form-control" id="joindate">
        </div>

        <input type="submit" name="register" value="Register" class="btn btn-primary">
    </form>

    <hr>

    <h2>Workers List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Salary</th>
                <th>Join Date</th>
                <th>Operation</th>
                <th>Info</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['address']) ?></td>
                        <td><?= htmlspecialchars($row['salary']) ?></td>
                        <td><?= htmlspecialchars($row['joindate']) ?></td>
                        <td> <a href="editwork.php?id=<?php echo $row['id']; ?>">Edit</a> ||<a href="deletework.php?id=<?php echo $row['id']; ?>">Delete</a> </td>
                        <td><a href="#">View</a></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No workers found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>