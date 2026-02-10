<?php 
include('admin_check.php'); 
include('../config/db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administrative Staff | Biblio-Sage</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        :root {
            --admin-bg: #f4f1e8;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body { background-color: var(--admin-bg); }

        .admin-container { padding: 40px 10%; min-height: 100vh; }

        /* Header Styling */
        .page-header {
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            margin-bottom: 40px;
            border-bottom: 2px solid var(--gold);
            padding-bottom: 20px;
        }

        .header-title h1 { font-family: 'Playfair Display'; font-size: 2.8rem; margin: 0; color: var(--charcoal); }
        
        /* Add Admin Button Customization */
        .btn-add-admin {
            text-decoration: none;
            background: var(--crimson);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.85rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(165, 28, 48, 0.2);
        }

        .btn-add-admin:hover {
            background: var(--charcoal);
            color: var(--gold);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        /* Card Grid */
        .admin-card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }

        .admin-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            border-top: 5px solid var(--charcoal);
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            position: relative;
        }

        .admin-card:hover { transform: translateY(-5px); border-top-color: var(--gold); }

        /* Card Elements */
        .badge-head { 
            background: #eee; 
            color: #777; 
            padding: 4px 10px; 
            border-radius: 4px; 
            font-size: 0.65rem; 
            font-weight: 800; 
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .self-badge { background: var(--gold); color: var(--charcoal); }

        .admin-info h3 { margin: 15px 0 5px 0; font-family: 'Playfair Display'; font-size: 1.4rem; color: var(--charcoal); }
        .admin-info p { color: #888; font-size: 0.9rem; margin: 0 0 20px 0; }

        /* Internal Link Buttons */
        .admin-actions { 
            border-top: 1px solid #f0f0f0; 
            padding-top: 20px; 
            display: flex; 
            gap: 10px; 
        }

        .btn-action {
            flex: 1;
            text-align: center;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 10px;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: var(--transition);
        }

        .btn-edit { background: #f4f4f4; color: var(--charcoal); }
        .btn-edit:hover { background: var(--charcoal); color: white; }

        .btn-revoke { border: 1px solid #ffdbdb; color: var(--crimson); }
        .btn-revoke:hover { background: var(--crimson); color: white; border-color: var(--crimson); }

    </style>
</head>
<body>
    <?php include('admin_navbar.php'); ?>

    <div class="admin-container">
        <header class="page-header">
            <div class="header-title">
                <h1>Administrative Staff</h1>
                <p style="color: #888;">System Registry of Archivists and Personnel</p>
            </div>
            <a href="add_admin.php" class="btn-add-admin"><span>➕</span> Add New Admin</a>
        </header>

        <div class="admin-card-grid">
            <?php
            $res = mysqli_query($conn, "SELECT * FROM users WHERE role = 'admin' ORDER BY fullname ASC");
            while($row = mysqli_fetch_assoc($res)) {
                $is_me = ($row['user_id'] == $_SESSION['user_id']);
                $badge_text = $is_me ? "YOU — MASTER ACCESS" : "SYSTEM ACCESS";
                $badge_class = $is_me ? "self-badge" : "";
                ?>
                
                <div class="admin-card">
                    <div class="admin-info">
                        <span class="badge-head <?php echo $badge_class; ?>">
                            <?php echo $badge_text; ?>
                        </span>
                        <h3><?php echo htmlspecialchars($row['fullname']); ?></h3>
                        <p><?php echo htmlspecialchars($row['email']); ?></p>
                    </div>

                    <div class="admin-actions">
                        <a href="update_admins.php?id=<?php echo $row['user_id']; ?>" class="btn-action btn-edit">
                            Permissions
                        </a>
                        
                        <?php if(!$is_me): ?>
                            <a href="delete_admins.php?id=<?php echo $row['user_id']; ?>" 
                               class="btn-action btn-revoke"
                               onclick="return confirm('Security Alert: Revoking access will immediately disconnect this user from all administrative panels. Proceed?')">
                               Revoke
                            </a>
                        <?php else: ?>
                            <div class="btn-action" style="background: transparent; color: #ccc; cursor: default; border: 1px dashed #eee;">
                                Protected
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>
</body>
</html>