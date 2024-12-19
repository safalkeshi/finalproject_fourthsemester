<?php
$host = "localhost";
$username = "root";
$password = "";
$db = "finalproj";

function connectDatabase()
{
    global $host, $username, $password, $db;
    $connection = new mysqli($host, $username, $password, $db);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    return $connection;
}
