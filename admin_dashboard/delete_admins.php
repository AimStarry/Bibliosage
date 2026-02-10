<?php
include('admin_check.php'); 
include('../config/db.php'); 

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // SECURITY CHECK: Prevent an admin from deleting themselves
    // $_SESSION['user_id'] was set during login
    if ($id == $_SESSION['user_id']) {
        echo "<script>
                alert('Action Denied: You cannot remove your own administrative power while logged in.'); 
                window.location='manage_admins.php';
              </script>";
        exit();
    }

    // SQL to delete the admin record
    // In your system, admins are stored in the 'users' table with role 'admin'
    $sql = "DELETE FROM users WHERE user_id = $id AND role = 'admin'";

    if (mysqli_query($conn, $sql)) {
        // Redirect back to the admin list with a success message
        header("Location: manage_admins.php?msg=AdminRemoved");
    } else {
        echo "Error removing admin: " . mysqli_error($conn);
    }
} else {
    // If no ID is found, just go back to the list
    header("Location: manage_admins.php");
}
?>