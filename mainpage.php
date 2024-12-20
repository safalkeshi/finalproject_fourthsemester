<?php
include "../includes/dbconnect.php";
function fetchData($connection)
{
    $sql = "select *  from user_registration";
    $result = $connection->query($sql);
    //check if there is data or not
    if ($result->num_rows > 0) {
        //fetch all data 
        $data = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $data = array();
    }
    return $data;
}
$connection = connectDatabase();
$infoData = fetchData($connection);
// print_r($infoData);

$connection->close();

function fetchWorkerData($connection)
{
    $sql = "SELECT * FROM workers";
    $result = $connection->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    return [];
}



?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Bootstrap Example</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="p-3 m-0 border-0 bd-example m-0 border-0">




    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Reception</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#customer">Customer info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#workerinfo">Workers info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#currentservices">Current Services </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Expenses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Statistics</a>
                    </li>


            </div>
        </div>
    </nav>

    <div class="container mt-2" id="customer">
        <table class="table table-hover col-12">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Password</th>
                    <th>Operation</th>
                    <th>Info</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php foreach ($infoData as $row): ?>
                <tr>
                    <td> <?php echo $row['id']; ?> </td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['password']; ?></td>
                    <!-- <td><img src="uploads/<?php echo $row['img']; ?>" alt="" width="20px"></td> -->
                    <td> <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a> ||<a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a> </td>
                    <td><a href="#">View</a></td>
                </tr>
            <?php endforeach; ?>
            </tr>
            <a href="add.php" type="button" class="btn btn-dark">Add New Customer</a>
        </table>
    </div>
    <div class="container bg-primary mt-4" id="workerinfo">
        <table class="table table-hover col-12">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Address</th>
                    <th>Salary</th>
                    <th>Join Date</th>
                    <th>Operation</th>
                    <th>Info</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($empData)): ?>
                    <?php foreach ($empData as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['empname']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td><?php echo htmlspecialchars($row['salary']); ?></td>
                            <td><?php echo htmlspecialchars($row['joindate']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo urlencode($row['id']); ?>">Edit</a> ||
                                <a href="delete.php?id=<?php echo urlencode($row['id']); ?>">Delete</a>
                            </td>
                            <td><a href="#">View</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">View employees data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="employeeregister.php" type="button" class="btn btn-dark mt-3">View New Employee</a>
    </div>

    <div class="container" id="currentservices">

    
    </div>


</body>

</html>