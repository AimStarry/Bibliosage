<?php
// 1. Start or resume the session to check who is logged in
session_start();

// 2. Check if the 'role' session variable exists AND if it is 'admin'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    
    // 3. If they are NOT an admin, redirect them back to the login page
    header("Location: ../login.php");
    
    // 4. Stop the script immediately so the rest of the page doesn't load
    exit();
}
?>