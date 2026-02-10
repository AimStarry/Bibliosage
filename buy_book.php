<?php
session_start();
include('config/db.php');

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$book_id = mysqli_real_escape_string($conn, $_GET['id']);
$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn, "SELECT title, price, stock FROM books WHERE book_id = $book_id");
$book = mysqli_fetch_assoc($result);

if($book && $book['stock'] > 0) {
    mysqli_query($conn, "UPDATE books SET stock = stock - 1 WHERE book_id = $book_id");
    
    $date_issued = date('Y-m-d H:i:s');
    $price = $book['price'];
    
    // Updated to match your column names: date_issued and due_date
    // Since it's a purchase, due_date is NULL
    $sql = "INSERT INTO transactions (user_id, book_id, type, date_issued, due_date, amount) 
        VALUES ('$user_id', '$book_id', 'purchase', '$date_issued', NULL, '$price')";
    
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Success! You now own " . $book['title'] . "'); window.location='books.php';</script>";
    } else {
        die("Transaction Error: " . mysqli_error($conn));
    }
} else {
    echo "<script>alert('Out of stock!'); window.location='books.php';</script>";
}
?>