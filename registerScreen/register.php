<?php
session_start();  // Start the session

// Include the database connection
include 'dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form inputs
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['pwd'];

    // Basic validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        header(header: "Location: ..\registerIndex.html");
        exit;
     

    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        
        exit;
    }

    
    // SQL query to insert user into the database
    $sql = "INSERT INTO users (first_name, last_name, email, pwd) VALUES (?, ?, ?, ?);";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssss", $first_name, $last_name, $email, $password);

        if ($stmt->execute()) {
            echo "Registration successful!";
          
        } else {
            echo "Error: " . $stmt->error;
        }
        header("Location: ../loginScreen/loginIndex.php");
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>