<?php
// db.inc.php

$servername = "127.0.0.1:8889";  // Replace 8889 with the correct port number if necessary
$username = "root"; // Your database username
$password = ""; // Your database password (use your actual password)
$dbname = "library_db"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    
}
var_dump($_SERVER);  // Check if 'REQUEST_METHOD' exists
exit;



