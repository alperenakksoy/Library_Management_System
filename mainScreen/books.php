<?php

session_start();
if (!isset($_SESSION['userid'])) {
    echo "User not logged in.";
    // You can also redirect the user to the login page
    header('Location: ../loginScreen/loginIndex.php');
    exit; // Stop the script after redirect
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
include '../registerScreen/dbconnection.php';

// Fetch books data from the database
$sql = "SELECT * FROM books";
$result = $conn->query($sql);

// Create an array to store books
$books = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Books Catalog</title>
</head>
<body>
    <div class="container">
        <header class="main-header">
            <div class="logo">
                <h1>Library Catalog</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="../mainScreen/mainIndex.php">Home</a></li>
                </ul>
            </nav>
        </header>

        <div class="search-and-filters">
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search by book title...">
            </div>
            <div class="filters">
                <select id="languageFilter">
                    <option value="all">All Languages</option>
                    <option value="English">English</option>
                    <option value="Turkish">Turkish</option>
                    <option value="Italian">Italian</option>
                    <option value="Spanish">Spanish</option>
                    <option value="Arabic">Arabic</option>
                </select>
                <select id="categoryFilter">
                    <option value="all">All Categories</option>
                </select>
            </div>
        </div>

        <main>
            <h2>Available Books</h2>
            <div class="books-grid" id="booksContainer">
                <!-- Books will be dynamically inserted here -->
            </div>
        </main>
    </div>

    <script>
        // Pass PHP data to JavaScript
        const books = <?php echo json_encode($books, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

        // Function to create a book card
        function createBookCard(book) {
            const isAvailable = book.copies > 0;
            return `
                <div class="book-card">
                    <div class="book-title">${book.title}</div>
                    <div class="book-author">${book.author}</div>
                    <div class="book-details">
                        <p>Category: ${book.category}</p>
                        <p>Publisher: ${book.publisher}</p>
                        <p>Year: ${book.year_of_publication}</p>
                        <p>Copies Available: ${book.copies}</p>
                        <p>Location: ${book.location}</p>
                        <span class="language-badge">${book.language}</span>
                    </div>
                    <button 
                        class="borrow-button ${!isAvailable ? 'disabled' : ''}"
                        onclick="borrowBook('${book.title}', ${book.bookid})"
                        ${!isAvailable ? 'disabled' : ''}
                    >
                        ${isAvailable ? 'Borrow Book' : 'Not Available'}
                    </button>
                </div>
            `;
        }

        // Function to handle book borrowing
    
        function borrowBook(title, bookId) {
    if (confirm(`Do you want to borrow "${title}"?`)) {
        const formData = new FormData();
        formData.append('book_id', bookId);

        fetch('borrowBook.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            alert(data.message);
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while borrowing the book. Please try again.');
        });
    }
}
        // Function to display all books
        function displayBooks(booksToShow = books) {
            const container = document.getElementById('booksContainer');
            container.innerHTML = booksToShow.map(book => createBookCard(book)).join('');
        }

        // Function to gather unique categories
        function updateCategoryFilter() {
            const categories = [...new Set(books.map(book => book.category))];
            const categoryFilter = document.getElementById('categoryFilter');
            categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category;
                option.textContent = category;
                categoryFilter.appendChild(option);
            });
        }

        // Function to filter and search books
        function filterAndSearchBooks() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const languageFilter = document.getElementById('languageFilter').value;
            const categoryFilter = document.getElementById('categoryFilter').value;

            let filteredBooks = books;

            // Apply search filter
            if (searchTerm) {
                filteredBooks = filteredBooks.filter(book => 
                    book.title.toLowerCase().includes(searchTerm)
                );
            }

            // Apply language filter
            if (languageFilter !== 'all') {
                filteredBooks = filteredBooks.filter(book => book.language === languageFilter);
            }

            // Apply category filter
            if (categoryFilter !== 'all') {
                filteredBooks = filteredBooks.filter(book => book.category === categoryFilter);
            }

            displayBooks(filteredBooks);
        }

        // Add event listeners
        document.getElementById('searchInput').addEventListener('input', filterAndSearchBooks);
        document.getElementById('languageFilter').addEventListener('change', filterAndSearchBooks);
        document.getElementById('categoryFilter').addEventListener('change', filterAndSearchBooks);

        // Initialize the page
        updateCategoryFilter();
        displayBooks();
    </script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f0f2f5;
            color: #1a1a1a;
            line-height: 1.6;
            min-height: 100vh;
        }

        .main-header {
            background: linear-gradient(135deg, #2193b0, #6dd5ed);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo h1 {
            font-size: 1.8rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .main-header nav ul {
            display: flex;
            gap: 1.5rem;
            list-style: none;
        }

        .main-header nav ul li {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .main-header nav ul li a {
            color: white;
            text-decoration: none;
            padding: 0.8rem 1.2rem;
            display: block;
            font-weight: 500;
            cursor: pointer;
        }

        .main-header nav ul li:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .search-and-filters {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 1rem;
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .search-bar {
            flex: 1;
            min-width: 200px;
        }

        .search-bar input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 1rem;
        }

        .filters {
            display: flex;
            gap: 1rem;
        }

        .filters select {
            padding: 0.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            color: #334155;
        }

        main {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 2rem;
        }

        main h2 {
            color: #2193b0;
            margin-bottom: 1.5rem;
            font-size: 1.6rem;
            text-align: left;
            border-bottom: 2px solid #f0f2f5;
            padding-bottom: 0.5rem;
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            padding: 1rem;
        }

        .book-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .book-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2193b0;
            margin-bottom: 0.5rem;
        }

        .book-author {
            color: #64748b;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .book-details {
            font-size: 0.9rem;
            color: #334155;
            flex-grow: 1;
        }

        .book-details p {
            margin: 0.3rem 0;
        }

        .language-badge {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            background: #e2e8f0;
            border-radius: 4px;
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 0.5rem;
        }

        .borrow-button {
            margin-top: 1rem;
            padding: 0.6rem 1rem;
            background: #2193b0;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .borrow-button:hover:not(.disabled) {
            background: #1a7a8c;
        }

        .borrow-button.disabled {
            background: #e2e8f0;
            cursor: not-allowed;
            color: #64748b;
        }
    </style>
</body>
</html>