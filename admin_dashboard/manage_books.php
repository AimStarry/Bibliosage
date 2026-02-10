<?php 
include('admin_check.php'); 
include('../config/db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Master Catalog | Biblio-Sage Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        :root {
            --admin-bg: #fdfbf7;
            --card-shadow: 0 5px 20px rgba(0,0,0,0.05);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body { background: var(--admin-bg); }

        .inventory-wrapper { padding: 40px 5%; min-height: 100vh; }
        
        /* Refined Page Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
            padding-bottom: 25px;
            border-bottom: 1px solid #e0ddd5;
        }

        .header-title h1 { font-family: 'Playfair Display', serif; font-size: 2.8rem; margin: 0; color: var(--charcoal); }
        .header-title p { color: #888; margin: 5px 0 0 0; font-size: 0.95rem; }

        /* Command Buttons */
        .header-actions { display: flex; gap: 15px; }

        .btn-secondary, .btn-primary {
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition);
        }

        .btn-secondary { background: white; color: var(--charcoal); border: 1px solid #ddd; }
        .btn-secondary:hover { border-color: var(--charcoal); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }

        .btn-primary { background: var(--crimson); color: white; box-shadow: 0 4px 15px rgba(165, 28, 48, 0.2); }
        .btn-primary:hover { background: var(--charcoal); color: var(--gold); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.15); }

        /* Search & Filter Bar */
        .controls-row {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
            align-items: center;
        }

        .search-box { flex-grow: 1; position: relative; }
        #inventorySearch {
            width: 100%;
            padding: 16px 20px;
            border: 1px solid #e0ddd5;
            border-radius: 12px;
            font-size: 1rem;
            background: white;
            transition: var(--transition);
        }
        #inventorySearch:focus { outline: none; border-color: var(--gold); box-shadow: 0 0 0 4px rgba(218, 164, 40, 0.1); }

        /* Table Styling */
        .inventory-table {
            width: 100%;
            background: white;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
        }

        .inventory-table th {
            background: var(--charcoal);
            color: var(--gold);
            padding: 18px;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 2px;
            text-align: center;
        }

        .inventory-table td {
            padding: 20px;
            border-bottom: 1px solid #f0f0f0;
            color: var(--charcoal);
            vertical-align: middle;
            text-align: center;
        }

        .inventory-table tr:last-child td { border-bottom: none; }
        .inventory-table tr:hover { background: #fffcf5; }

        /* Content Elements */
        .book-thumb {
            width: 55px;
            height: 75px;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: var(--transition);
        }
        .book-thumb:hover { transform: scale(1.1); }

        .stock-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 800;
            font-size: 0.75rem;
            display: inline-block;
        }
        .stock-low { background: #fff5f5; color: #c53030; border: 1px solid #feb2b2; }
        .stock-good { background: #f0fff4; color: #2f855a; border: 1px solid #9ae6b4; }

        .action-btns { display: flex; gap: 8px; justify-content: center; }
        .action-btns a {
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 8px 15px;
            border-radius: 6px;
            transition: var(--transition);
        }
        .btn-edit { color: var(--charcoal); background: #f4f4f4; }
        .btn-edit:hover { background: var(--gold); color: white; }
        
        .btn-del { color: #e53e3e; background: #fff5f5; }
        .btn-del:hover { background: #e53e3e; color: white; }
    </style>
</head>
<body>
    <?php include('admin_navbar.php'); ?>

    <div class="inventory-wrapper">
        <header class="page-header">
            <div class="header-title">
                <h1>Master Catalog</h1>
                <p>Bibliographic Archive & Inventory Management</p>
            </div>
            
            <div class="header-actions">
                <a href="Admin_dashboard.php" class="btn-secondary">
                    <span>📊</span> Dashboard
                </a>
                <a href="add_book.php" class="btn-primary">
                    <span>➕</span> Add New Volume
                </a>
            </div>
        </header>

        <div class="controls-row">
            <div class="search-box">
                <input type="text" id="inventorySearch" placeholder="Search by Title, Author, or Reference ID...">
            </div>
        </div>

        <table class="inventory-table" id="bookTable">
            <thead>
                <tr>
                    <th width="10%">Ref ID</th>
                    <th width="10%">Cover</th>
                    <th style="text-align: left;">Bibliographic Details</th>
                    <th width="15%">Price</th>
                    <th width="15%">Availability</th>
                    <th width="20%">Management</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = mysqli_query($conn, "SELECT * FROM books ORDER BY title ASC");
                while($row = mysqli_fetch_assoc($res)) {
                    $is_low = ($row['stock'] <= 3);
                    $stock_class = $is_low ? 'stock-low' : 'stock-good';
                    $stock_label = $is_low ? 'LOW STOCK' : 'IN STOCK';
                    ?>
                    <tr>
                        <td style="font-family: 'Courier New', monospace; font-weight: bold; color: #aaa;">
                            #<?php echo str_pad($row['book_id'], 4, '0', STR_PAD_LEFT); ?>
                        </td>
                        <td>
                            <img src="../<?php echo $row['image']; ?>" class="book-thumb" alt="Cover">
                        </td>
                        <td style="text-align: left;">
                            <div style="font-weight: 800; color: var(--charcoal); font-size: 1.05rem;">
                                <?php echo htmlspecialchars($row['title']); ?>
                            </div>
                            <div style="font-size: 0.8rem; color: #999; margin-top: 4px;">
                                By <?php echo htmlspecialchars($row['author']); ?>
                            </div>
                        </td>
                        <td style="font-weight: 700; color: var(--charcoal);">
                            ₱<?php echo number_format($row['price'], 2); ?>
                        </td>
                        <td>
                            <span class="stock-badge <?php echo $stock_class; ?>">
                                <?php echo $row['stock']; ?> — <?php echo $stock_label; ?>
                            </span>
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="edit_book.php?id=<?php echo $row['book_id']; ?>" class="btn-edit">Modify</a>
                                <a href="delete_book.php?id=<?php echo $row['book_id']; ?>" 
                                   class="btn-del" 
                                   onclick="return confirm('Archive security alert: Are you sure you want to permanently remove this volume?')">
                                   Remove
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        // Live Search Logic
        document.getElementById('inventorySearch').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#bookTable tbody tr');

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>
</body>
</html>