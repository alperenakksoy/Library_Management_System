<?php
session_start();
include '../registerScreen/dbconnection.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['userid'])) {
    echo json_encode(['success' => false, 'message' => 'Please log in to borrow books']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['userid'];
    $book_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;

    if ($book_id === 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid book ID']);
        exit;
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // Check if book is available and has copies
        $check_book = "SELECT copies FROM books WHERE bookid = ? AND copies > 0";
        $stmt = $conn->prepare($check_book);
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception('Book is not available for borrowing');
        }

        // Update book copies
        $update_book = "UPDATE books SET copies = copies - 1 WHERE bookid = ? AND copies > 0";
        $stmt = $conn->prepare($update_book);
        $stmt->bind_param("i", $book_id);
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            throw new Exception('Failed to update book availability');
        }

        // Calculate borrow and return dates
        $borrow_date = date('Y-m-d');
        $return_date = date('Y-m-d', strtotime('+30 days')); // Add 30 days to current date

        // Create borrow record with return date
        $insert_borrow = "INSERT INTO borrow_records (borrow_bookID, borrow_userid, borrow_date, return_date, status) 
                         VALUES (?, ?, ?, ?, 'borrowed')";
        $stmt = $conn->prepare($insert_borrow);
        $stmt->bind_param("iiss", $book_id, $user_id, $borrow_date, $return_date);
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            throw new Exception('Failed to create borrow record');
        }

        // If everything is successful, commit the transaction
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Book borrowed successfully. Please return by ' . date('F j, Y', strtotime($return_date))]);

    } catch (Exception $e) {
        // If there's an error, rollback the transaction
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>