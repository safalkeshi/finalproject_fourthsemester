<?php
include '../includes/dbconnect.php';

function getcategory($connection)
{
    $id = $_GET['id'];
    $sql = "SELECT * FROM workers WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc(); // This will return a single row of user data
}

function editCategory($connection)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_GET['id'];
        $name = htmlspecialchars(trim($_POST['empname']));
        $address = htmlspecialchars(trim($_POST['address']));
        $salary = htmlspecialchars(trim($_POST['salary'])); // Updated variable name
        $joindate = htmlspecialchars(trim($_POST['joindate']));

        // Get the current values from the database
        $currentData = getcategory($connection);

        // Use existing data for fields that are not provided
        $name = empty($name) ? $currentData['name'] : $name;
        $address = empty($address) ? $currentData['address'] : $address;
        $salary = empty($salary) ? $currentData['salary'] : $salary;

        // Check if any field is empty and return an error
        if (empty($name) || empty($address) || empty($salary)) {
            return "All fields except join date are required.";
        }

        // Prepare the SQL update query
        $sql = "UPDATE workers SET name = ?, address = ?, salary = ?, joindate = ? WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssdsi", $name, $address, $salary, $joindate, $id);

        if ($stmt->execute()) {
            header('Location: mainpage.php');
            exit(); // Make sure to stop script execution after redirect
        } else {
            return "Failed to update record: " . $stmt->error;
        }
    }
    return null;
}

$connection = connectDatabase();
$output = getcategory($connection); // Fetch existing data for editing
$errorMessage = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errorMessage = editCategory($connection);
}

// Close the database connection
$connection->close();
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

    <?php if ($errorMessage): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>

    <form class="row g-3 needs-validation" novalidate="" method="post" enctype="multipart/form-data" autocomplete="on">
        <div class="mb-3">
            <label for="empname" class="form-label">Full Name</label>
            <input type="text" name="empname" class="form-control" id="empname" value="<?php echo isset($output['name']) ? $output['name'] : ''; ?>">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="address" value="<?php echo isset($output['address']) ? $output['address'] : ''; ?>">
        </div>

        <div class="mb-3">
            <label for="salary" class="form-label">Salary</label>
            <input type="number" name="salary" class="form-control" id="salary" value="<?php echo isset($output['salary']) ? $output['salary'] : ''; ?>">
        </div>

        <div class="mb-3">
            <label for="joindate" class="form-label">Joining Date</label>
            <input type="date" name="joindate" class="form-control" id="joindate" value="<?php echo isset($output['joindate']) ? $output['joindate'] : ''; ?>">
        </div>

        <input type="submit" name="submit" value="Update" class="btn btn-primary">
    </form>

</body>

</html>