<?php
// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Collect and sanitize form data
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $password = $_POST['pwd'];
    
    // Simple validation (can be extended)
    if (empty($fname) || empty($lname) || empty($email) || empty($password)) {
        die('All fields are required.');
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    try {
        // Include the database connection
        require_once 'dbh.inc.php';

        // Prepare the SQL query with placeholders
        $query = "INSERT INTO users (first_name, last_name, email, pwd) VALUES (?, ?, ?, ?)";
        
        // Prepare the statement
        $stmt = $pdo->prepare($query);
        
        // Execute the statement with values
        $stmt->execute([$fname, $lname, $email, $hashed_password]);
        
        // Redirect after successful insertion
        header("Location: ../registerScreen/registerIndex.php");
        exit(); // Make sure the script stops after redirect
        
    } catch (PDOException $e) {
        // Handle error gracefully
        die('Query failed: ' . $e->getMessage());
    }

} else {
    // Redirect back to the register page if the form is not submitted via POST
    header("Location: ../registerScreen/registerIndex.php");
    exit();
}
?>
