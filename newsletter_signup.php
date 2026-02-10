<?php
include('config/db.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Check if already exists
    $check = mysqli_query($conn, "SELECT id FROM newsletter WHERE email = '$email'");
    if(mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO newsletter (email) VALUES ('$email')");
        echo "<script>alert('Thanks for subscribing!'); window.location='Home.php';</script>";
    } else {
        echo "<script>alert('You are already subscribed!'); window.location='Home.php';</script>";
    }
}
?>