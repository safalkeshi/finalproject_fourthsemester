<?php
include '../includes/dbconnect.php';


function delete($connection, $id)
{
    $sql = "Delete from workers where id='$id'";
    $result = $connection->query($sql);
}
$connection = connectDatabase();
$id = $_GET['id'];
$delete = delete($connection, $id);
$connection->close();
header('location:mainpage.php');
