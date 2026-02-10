<?php
include('admin_check.php'); 
include('../config/db.php'); 

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Prevents an admin from accidentally deleting themselves
    session_start();
    if ($id == $_SESSION['user_id']) {
        echo "<script>alert('Error: You cannot delete your own account while logged in.'); window.location='manage_admins.php';</script>";
        exit();
    }

    // SQL to delete the user record
    $sql = "DELETE FROM users WHERE user_id = $id";

    if (mysqli_query($conn, $sql)) {
        // Successfully deleted
        header("Location: view_users.php?msg=UserDeleted");
    } else {
        // Error handling (e.g., if user has linked transactions)
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    header("Location: view_users.php");
}
?>