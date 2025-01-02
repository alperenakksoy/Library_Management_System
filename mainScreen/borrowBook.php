<?php
session_start();
include '../registerScreen/dbconnection.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
$response = ['success' => false, 'message' => ''];

if (!isset($_SESSION['userid'])) {
    $response['message'] = 'User not logged in';
    echo json_encode($response);
    exit;
}

if (!isset($_POST['book_id'])) {
    $response['message'] = 'Book ID not provided';
    echo json_encode($response);
    exit;
}

try {
    $book_id = (int)$_POST['book_id'];
    $user_id = $_SESSION['userid'];
    $borrow_date = date('Y-m-d');

    // Start transaction
    $conn->begin_transaction();

    // Check if user has already borrowed this book
    $check_sql = "SELECT id FROM borrow_records WHERE borrow_bookID = ? AND borrow_userid = ? AND status = 'borrowed'";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param('ii', $book_id, $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        throw new Exception("You have already borrowed this book");
    }

    // Check book availability
    $sql = "SELECT copies FROM books WHERE bookid = ? FOR UPDATE";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception("Book not found");
    }
    
    $book = $result->fetch_assoc();
    if ($book['copies'] <= 0) {
        throw new Exception("No copies available");
    }

    // Insert borrow record
    $sql = "INSERT INTO borrow_records (borrow_bookID, borrow_userid, borrow_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iis', $book_id, $user_id, $borrow_date);
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to create borrow record: " . $stmt->error);
    }

    // Update book copies
    $sql = "UPDATE books SET copies = copies - 1 WHERE bookid = ? AND copies > 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $book_id);
    
    if (!$stmt->execute() || $stmt->affected_rows === 0) {
        throw new Exception("Failed to update book copies");
    }

    // Commit transaction
    $conn->commit();
    
    $response['success'] = true;
    $response['message'] = "Book borrowed successfully!";

} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    $response['message'] = $e->getMessage();
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
    echo json_encode($response);
}
?>