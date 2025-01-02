<?php
session_start();
include '../registerScreen/dbconnection.php';

if (isset($_SESSION['userid'])) {
    $user_id = $_SESSION['userid'];

    // Fetch books borrowed by the user
    $sql = "SELECT b.title, b.author, br.borrow_date 
            FROM borrow_records br
            JOIN books b ON br.borrow_bookID = b.bookid
            WHERE br.borrow_userid = ? AND br.status = 'borrowed'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $borrowed_books = [];
    while ($row = $result->fetch_assoc()) {
        $borrowed_books[] = $row;
    }
    $stmt->close();

    echo json_encode($borrowed_books);
} else {
    echo json_encode([]);
}
?>
