<?php
session_start(); // Start session to store session variables

// Include the database connection file
include('../registerScreen/dbconnection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email and password from POST
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if user exists
    $query = "SELECT * FROM users WHERE email = ?;";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, fetch the user data
        $user = $result->fetch_assoc();

        // Directly compare plain text password
        if ($password === $user['pwd']) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $user['userid']; // Assuming 'userid' is the user's ID in the database
            $_SESSION['user_name'] = $user['first_name']; // Store user's first name

            // Redirect to the main page after login
            header('Location: ../mainScreen/mainIndex.html');
            exit;
        } else {
            // If password is incorrect
            echo "Invalid email or password!";
        }
    } else {
        // If no user found
        echo "Invalid email or password!";
    }
}
?>
