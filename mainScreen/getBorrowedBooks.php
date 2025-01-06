<?php
session_start();
include '../registerScreen/dbconnection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['userid'])) {
    echo json_encode([]);
    exit;
}

$user_id = $_SESSION['userid'];

// Join with books table to get complete book information
$sql = "SELECT 
            br.id as borrow_id,
            b.bookid,
            b.title,
            b.author,
            br.borrow_date,
            br.return_date,
            br.status
        FROM borrow_records br
        JOIN books b ON br.borrow_bookID = b.bookid
        WHERE br.borrow_userid = ? AND br.status = 'borrowed'
        ORDER BY br.borrow_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$borrowed_books = [];
while ($row = $result->fetch_assoc()) {
    $borrowed_books[] = [
        'borrow_id' => $row['borrow_id'],
        'book_id' => $row['bookid'],
        'title' => $row['title'],
        'author' => $row['author'],
        'borrow_date' => $row['borrow_date'],
        'return_date' => $row['return_date'] ?? 'Not returned',
        'status' => $row['status']
    ];
}

$stmt->close();
$conn->close();

echo json_encode($borrowed_books);
?>