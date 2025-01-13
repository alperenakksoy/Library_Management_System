<?php
session_start();  // Start the session to access user-specific data

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['userid'])) {
    header('Location: ../loginScreen/loginIndex.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Specifies the character encoding for the document -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Ensures proper rendering on mobile devices -->
    <title>Library</title> <!-- Sets the title of the page -->
    <link rel="stylesheet" href="mainStyle.css"> <!-- Links the external CSS file for styling -->
</head>
<body>
    <div class="container">
        <header class="main-header">
            <div class="logo">
                <h1>Library System</h1> <!-- Title displayed on the top of the page -->
            </div>
            <nav>
                <ul>
                    <li><a href="books.php">Books</a></li> <!-- Link to books page -->
                    <li><a href="logout.php">Logout</a></li> <!-- Link to logout page -->
                </ul>
            </nav>
        </header>

        <main>
            <h2>Your Borrowed Books</h2> <!-- Heading for the section showing borrowed books -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Title</th> <!-- Column for book title -->
                            <th>Author</th> <!-- Column for book author -->
                            <th>Borrow Date</th> <!-- Column for the borrow date -->
                            <th>Return Date</th> <!-- Column for the return date -->
                            <th>Status</th> <!-- Column for the current status of the book -->
                        </tr>
                    </thead>
                    <tbody id="borrowedBooksContainer">
                        <!-- Loading message is shown while data is being fetched -->
                        <tr>
                            <td colspan="5" class="loading-message">Loading borrowed books...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
    // Function to format dates in a user-friendly format
    function formatDate(dateString) {
        const date = new Date(dateString);  // Converts the date string to a Date object
        return date.toLocaleDateString('en-US', {  // Formats the date as month day, year
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    // Function to fetch and display borrowed books from the server
    function displayBorrowedBooks() {
        const container = document.getElementById('borrowedBooksContainer');
        
        // Fetch the list of borrowed books from the server
        fetch('getBorrowedBooks.php')
            .then(response => response.json())  // Parse the JSON response
            .then(books => {
                // If no books are borrowed, display a message
                if (books.length === 0) {
                    container.innerHTML = `
                        <tr>
                            <td colspan="5" class="no-books-message">
                                You haven't borrowed any books yet.
                            </td>
                        </tr>`;
                    return;
                }

                // Populate the table with the borrowed books data
                container.innerHTML = books.map(book => `
                    <tr>
                        <td>${book.title}</td>  <!-- Display book title -->
                        <td>${book.author}</td>  <!-- Display book author -->
                        <td>${formatDate(book.borrow_date)}</td>  <!-- Display formatted borrow date -->
                        <td>${book.return_date === 'Not returned' ? 'Not returned' : formatDate(book.return_date)}</td>  <!-- Display formatted return date or 'Not returned' -->
                        <td>${book.status}</td>  <!-- Display the status of the book -->
                    </tr>
                `).join('');  // Join the rows as a single string to populate the table body
            })
            .catch(error => {
                // Handle any errors that occur during the fetch
                console.error('Error fetching borrowed books:', error);
                container.innerHTML = `
                    <tr>
                        <td colspan="5" class="error-message">
                            Error loading borrowed books. Please try again later.
                        </td>
                    </tr>`;
            });
    }

    // Load borrowed books when the page loads
    document.addEventListener('DOMContentLoaded', displayBorrowedBooks);
    </script>
</body>
</html>
