<?php
session_start();

if (!isset($_SESSION['userid'])) {
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
        <header class="main-header">
            <div class="logo">
                <h1>Library System</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="books.php">Books</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <h2>Your Borrowed Books</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Borrow Date</th>
                            <th>Return Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="borrowedBooksContainer">
                        <tr>
                            <td colspan="5" class="loading-message">Loading borrowed books...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    function displayBorrowedBooks() {
        const container = document.getElementById('borrowedBooksContainer');
        
        fetch('getBorrowedBooks.php')
            .then(response => response.json())
            .then(books => {
                if (books.length === 0) {
                    container.innerHTML = `
                        <tr>
                            <td colspan="5" class="no-books-message">
                                You haven't borrowed any books yet.
                            </td>
                        </tr>`;
                    return;
                }

                container.innerHTML = books.map(book => `
                    <tr>
                        <td>${book.title}</td>
                        <td>${book.author}</td>
                        <td>${formatDate(book.borrow_date)}</td>
                        <td>${book.return_date === 'Not returned' ? 'Not returned' : formatDate(book.return_date)}</td>
                        <td>${book.status}</td>
                    </tr>
                `).join('');
            })
            .catch(error => {
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