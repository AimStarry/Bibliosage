<?php
include('admin_check.php'); 
include('../config/db.php');
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM books WHERE book_id = $id");
header("Location: manage_books.php");
?>