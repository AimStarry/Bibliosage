<?php
session_start();
include('../config/db.php');

// Security Check
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Handle the Return Logic
if(isset($_GET['return_id']) && isset($_GET['book_id'])) {
    $t_id = $_GET['return_id'];
    $b_id = $_GET['book_id'];

    // 1. Update Transaction Status (Optional: you can change 'borrow' to 'returned')
    $update_t = mysqli_query($conn, "UPDATE transactions SET type = 'returned' WHERE trans_id = $t_id");
    
    // 2. Add stock back to the book
    $update_b = mysqli_query($conn, "UPDATE books SET stock = stock + 1 WHERE book_id = $b_id");

    if($update_t && $update_b) {
        echo "<script>alert('Book returned successfully!'); window.location='transaction.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>Transaction Ledger | Biblio-Sage</title>
    <style>
        .ledger-container { padding: 40px 5%; }
        .ledger-table {
            width: 100%;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border-collapse: collapse;
        }
        .ledger-table th { background: var(--charcoal); color: var(--gold); padding: 20px; text-align: left; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; }
        .ledger-table td { padding: 20px; border-bottom: 1px solid #eee; vertical-align: middle; }
        
        .status-pill { padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .type-purchase { background: #e3f2fd; color: #1976d2; }
        .type-borrow { background: #fff3e0; color: #f57c00; }
        .type-returned { background: #e8f5e9; color: #2e7d32; }

        .btn-return {
            background: var(--crimson);
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.8rem;
            transition: 0.3s;
        }
        .btn-return:hover { background: var(--gold); color: var(--charcoal); }
        
        .overdue { color: #d32f2f; font-weight: 700; }
    </style>
</head>
<body style="background: #f8f9fa;">
    <?php include('admin_navbar.php'); ?>

    <div class="ledger-container">
        <h2 style="font-family: 'Playfair Display'; font-size: 2.5rem; margin-bottom: 30px;">Transaction Ledger</h2>

        <table class="ledger-table">
            <thead>
                <tr>
                    <th>Date Issued</th>
                    <th>Scholar ID</th>
                    <th>Book Title</th>
                    <th>Type</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT t.*, b.title, b.book_id 
                          FROM transactions t 
                          JOIN books b ON t.book_id = b.book_id 
                          ORDER BY t.date_issued DESC";
                $result = mysqli_query($conn, $query);

                while($row = mysqli_fetch_assoc($result)) {
                    $type_class = "type-" . $row['type'];
                    $due_date = ($row['due_date']) ? date('M d, Y', strtotime($row['due_date'])) : "—";
                    
                    // Check if overdue
                    $is_overdue = (isset($row['due_date']) && strtotime($row['due_date']) < time() && $row['type'] == 'borrow');
                    $date_style = $is_overdue ? "class='overdue'" : "";

                    echo "<tr>";
                    echo "<td>" . date('M d, Y', strtotime($row['date_issued'])) . "</td>";
                    echo "<td>#USER-" . $row['user_id'] . "</td>";
                    echo "<td><strong>" . $row['title'] . "</strong></td>";
                    echo "<td><span class='status-pill $type_class'>" . strtoupper($row['type']) . "</span></td>";
                    echo "<td $date_style>" . $due_date . "</td>";
                    echo "<td>";
                    
                    // Show Return button only for active borrows
                    if($row['type'] == 'borrow') {
                        echo "<a href='transaction.php?return_id={$row['trans_id']}&book_id={$row['book_id']}' 
                                 class='btn-return' 
                                 onclick='return confirm(\"Process return for this volume?\")'>
                                 Process Return
                              </a>";
                    } else {
                        echo "<span style='color:#ccc; font-size:0.8rem;'>Closed</span>";
                    }
                    
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>