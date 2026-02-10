<?php include('admin_check.php'); include('../config/db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Scholars Registry | Biblio-Sage</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .members-container { padding: 40px 10%; background-color: #f8f9fa; min-height: 100vh; }
        
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .registry-table {
            width: 100%;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border-collapse: collapse;
        }

        .registry-table th {
            background: var(--charcoal);
            color: var(--gold);
            padding: 18px;
            text-align: left;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1.5px;
        }

        .registry-table td {
            padding: 18px;
            border-bottom: 1px solid #eee;
            color: #444;
            font-size: 0.95rem;
        }

        .registry-table tr:hover { background-color: var(--cream); }

        /* Role Badge */
        .role-badge {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            background: #e9ecef;
            color: #495057;
        }

        /* Action Buttons */
        .action-link {
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            margin-right: 15px;
            transition: 0.3s;
        }
        .edit-link { color: #2c3e50; }
        .edit-link:hover { color: var(--gold); }
        .delete-link { color: var(--crimson); }
        .delete-link:hover { color: black; }

        .btn-add {
            background: var(--gold);
            color: var(--charcoal);
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            transition: 0.3s;
        }
        .btn-add:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(218, 164, 40, 0.3); }
    </style>
</head>
<body>
    <?php include('admin_navbar.php'); ?>

    <div class="members-container">
        <div class="header-actions">
            <div>
                <h1 style="font-family: 'Playfair Display'; font-size: 2.5rem; color: var(--charcoal);">Scholars Registry</h1>
                <p style="color: #888;">Manage and oversee all active library members.</p>
            </div>
            <a href="add_user.php" class="btn-add">➕ Register New User</a>
        </div>

        <table class="registry-table">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email Address</th>
                    <th>Status / Role</th>
                    <th>Management</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = mysqli_query($conn, "SELECT * FROM users WHERE role != 'admin' ORDER BY fullname ASC");
                while($row = mysqli_fetch_assoc($res)) {
                    echo "<tr>
                        <td style='font-weight: 600;'>{$row['fullname']}</td>
                        <td>{$row['email']}</td>
                        <td><span class='role-badge'>" . strtoupper($row['role']) . "</span></td>
                        <td>
                            <a href='edit_user.php?id={$row['user_id']}' class='action-link edit-link'>Edit Profile</a>
                            <a href='delete_user.php?id={$row['user_id']}' class='action-link delete-link' onclick='return confirm(\"Permanently remove this scholar?\")'>Remove</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
        
        <div style="margin-top: 30px;">
            <a href="Admin_dashboard.php" style="color: #666; text-decoration: none; font-size: 0.9rem;">← Back to Command Center</a>
        </div>
    </div>
</body>
</html>