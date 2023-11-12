<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "23042002";
$dbname = "spiderverse";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get the database connection
function getDbConnection() {
    global $conn;
    if ($conn->ping()) {
        return $conn;
    } else {
        // Handle connection error as needed
        die("Connection lost: " . $conn->connect_error);
    }
}
?>