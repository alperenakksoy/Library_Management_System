const addBookBtn = document.querySelector('.main-header .addBook');
const closeBookBtn = document.querySelector('.closeBtn');
const modal = document.querySelector('.popup-container');

addBookBtn.addEventListener('click',()=>{
    modal.classList.add('open');
});


closeBookBtn.addEventListener('click',()=>{
    modal.classList.remove('open');
});


    // Function to fetch and display borrowed books
    function displayBorrowedBooks() {
        fetch('getBorrowedBooks.php')
        .then(response => response.json())
        .then(data => {
            const borrowedBooksContainer = document.getElementById('borrowedBooksContainer');
            borrowedBooksContainer.innerHTML = '';

            if (data.length === 0) {
                borrowedBooksContainer.innerHTML = '<p>No books borrowed.</p>';
            } else {
                data.forEach(book => {
                    const bookCard = document.createElement('div');
                    bookCard.classList.add('book-card');
                    bookCard.innerHTML = `
                        <div class="book-title">${book.title}</div>
                        <div class="book-author">${book.author}</div>
                        <p>Borrowed on: ${book.borrow_date}</p>
                    `;
                    borrowedBooksContainer.appendChild(bookCard);
                });
            }
        })
        .catch(error => console.error('Error fetching borrowed books:', error));
    }

    // Call the function when the page loads
    window.onload = function() {
        displayBorrowedBooks();
    }