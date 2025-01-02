<?php
session_start();  // Start the session

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    // User not logged in, redirect to login page
    header('Location: ../loginScreen/loginIndex.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="stylesheet" href="mainStyle.css">
</head>
<body>
    
    <div class="container">
        <!-- Header -->
        <header class="main-header">
            <div class="logo">
                <h1>Library System</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="../mainScreen/books.php">Books</a></li>
                    <li><a href="../mainScreen/logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>

        <!-- Main Content -->
        <main>
            <h2>Books You Borrowed</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                    </tr>
                </thead>
                <tbody id="borrowedBooksContainer">
                    <!-- Borrowed books will be dynamically inserted here -->
                </tbody>
            </table>
        </main>
    </div>


    <script src="mainApp.js">
        session_start();  // Start the session
        $(document).ready(function() {
            // Initialize Select2 for all select elements
            $('select').select2({
                placeholder: "Select an option",
                allowClear: true
            });
        });
    </script>
</body>

</html>