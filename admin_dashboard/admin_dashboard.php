<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include('../config/db.php');

// Fetch Stats
$total_books = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM books"))['count'];
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE role='student' OR role='employee'"))['count'];
$total_sales = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(amount) as total FROM transactions WHERE type='purchase'"))['total'];
$active_borrows = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM transactions WHERE type='borrow' AND due_date >= CURDATE()"))['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>Admin Dashboard | Biblio-Sage</title>
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .stat-val { font-size: 2rem; font-weight: 700; color: var(--charcoal); }
        .stat-label { color: #888; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; }
        
        .recent-section {
            margin-top: 50px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; padding: 15px; border-bottom: 2px solid var(--cream); color: #555; }
        td { padding: 15px; border-bottom: 1px solid #eee; font-size: 0.9rem; }
        .type-pill { 
            padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; 
        }
        .buy { background: #e1f5fe; color: #0288d1; }
        .borrow { background: #fff3e0; color: #f57c00; }
    </style>
</head>
<body style="background: #f8f9fa;">
    <?php include('admin_navbar.php'); ?>
    
    <div style="padding: 40px 5%;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-family: 'Playfair Display'; font-size: 2.2rem;">System Overview</h2>
            <p style="color: #666;">Current Date: <strong><?php echo date('M d, Y'); ?></strong></p>
        </div>

        <div class="stats-grid">
            <div class="stat-card" style="border-left: 5px solid var(--gold);">
                <div>
                    <div class="stat-label">Total Volumes</div>
                    <div class="stat-val"><?php echo $total_books; ?></div>
                </div>
                <span style="font-size: 2.5rem;">📚</span>
            </div>

            <div class="stat-card" style="border-left: 5px solid var(--crimson);">
                <div>
                    <div class="stat-label">Active Users</div>
                    <div class="stat-val"><?php echo $total_users; ?></div>
                </div>
                <span style="font-size: 2.5rem;">🎓</span>
            </div>

            <div class="stat-card" style="border-left: 5px solid #2ecc71;">
                <div>
                    <div class="stat-label">Total Revenue</div>
                    <div class="stat-val">₱<?php echo number_format($total_sales, 2); ?></div>
                </div>
                <span style="font-size: 2.5rem;">💰</span>
            </div>

            <div class="stat-card" style="border-left: 5px solid #3498db;">
                <div>
                    <div class="stat-label">Active Borrows</div>
                    <div class="stat-val"><?php echo $active_borrows; ?></div>
                </div>
                <span style="font-size: 2.5rem;">⏳</span>
            </div>