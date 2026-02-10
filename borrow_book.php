<?php
session_start();
include('config/db.php');

if(!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$book_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Check stock first
$check = mysqli_query($conn, "SELECT stock FROM books WHERE book_id = $book_id");
$book = mysqli_fetch_assoc($check);

if($book['stock'] > 0) {
    // 1. Reduce stock
    mysqli_query($conn, "UPDATE books SET stock = stock - 1 WHERE book_id = $book_id");
    
    // 2. Record transaction (Assumes you have a transactions table)
    // Inside your borrow_book.php logic
    $date_issued = date('Y-m-d H:i:s');
    $due_date = date('Y-m-d H:i:s', strtotime('+7 days'));

    $sql = "INSERT INTO transactions (user_id, book_id, type, date_issued, due_date) 
            VALUES ('$user_id', '$book_id', 'borrow', '$date_issued', '$due_date')";

    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Book borrowed successfully! Due date: $due_date'); window.location='books.php';</script>";
    } else {
        die("Transaction Error: " . mysqli_error($conn));
    }
} else {
    echo "<script>alert('Sorry, this book is out of stock!'); window.location='books.php';</script>";
}
?>