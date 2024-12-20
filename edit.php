<?php
include '../includes/dbconnect.php';

function getcategory($connection)
{
    $id = $_GET['id'];
    $sql = "SELECT * FROM user_registration WHERE id = ?";
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
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $phone = htmlspecialchars(trim($_POST['phone'])); // Updated variable name
        $password = htmlspecialchars(trim($_POST['password']));

        // Get the current values from the database
        $currentData = getcategory($connection);

        // Use existing data for fields that are not provided
        $name = empty($name) ? $currentData['name'] : $name;
        $email = empty($email) ? $currentData['email'] : $email;
        $phone = empty($phone) ? $currentData['phone'] : $phone;
        $password = empty($password) ? $currentData['password'] : $password;

        // Check if any field is empty and return an error
        if (empty($name) || empty($email) || empty($phone)) {
            return "All fields except password are required.";
        }

        // Prepare the SQL update query
        $sql = "UPDATE user_registration SET name = ?, email = ?, phone = ?, password = ? WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssssi", $name, $email, $phone, $password, $id);

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
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Ram Shrestha" value="<?php echo isset($output['name']) ? $output['name'] : ''; ?>">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" name="phone" class="form-control" id="phone" placeholder="0987654321" value="<?php echo isset($output['phone']) ? $output['phone'] : ''; ?>">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" value="<?php echo isset($output['email']) ? $output['email'] : ''; ?>">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password (Leave blank to keep current password)</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="********">
        </div>

        <input type="submit" name="submit" value="Update" class="btn btn-primary">
    </form>

</body>

</html>
