<?php
// Include the database connection file
include('../registerScreen/dbconnection.php');

// Start the session at the beginning of the page
session_start();

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
            $_SESSION['userid'] = $user['userid']; // Store the user ID in the session
            $_SESSION['user_name'] = $user['first_name']; // Store user's first name in the session

            // Redirect to the main page after login
            header('Location: ../mainScreen/mainIndex.php');  // Change .html to .php
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

<!-- Your login form below -->
<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
