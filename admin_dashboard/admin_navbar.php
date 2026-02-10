<nav class="admin-nav">
    <div class="admin-logo">
        <a href="../index.php">BIBLIO<span>SAGE</span></a>
        <span class="badge">ADMIN PANEL</span>
    </div>
    
    <div class="admin-menu">
        <?php 
            $current_page = basename($_SERVER['PHP_SELF']); 
        ?>
        <a href="Admin_dashboard.php" class="admin-nav-link <?php echo ($current_page == 'Admin_dashboard.php') ? 'active' : ''; ?>">📊 Stats</a>
        <a href="manage_books.php" class="admin-nav-link <?php echo ($current_page == 'manage_books.php') ? 'active' : ''; ?>">📚 Inventory</a>
        <a href="view_users.php" class="admin-nav-link <?php echo ($current_page == 'view_users.php') ? 'active' : ''; ?>">👥 Users</a>
        <a href="manage_admins.php" class="admin-nav-link <?php echo ($current_page == 'manage_admins.php') ? 'active' : ''; ?>">🛡️ Admins</a>
        <a href="transaction.php" class="admin-nav-link <?php echo ($current_page == 'transaction.php') ? 'active' : ''; ?>">💳 Transactions</a>
    </div>

    <div class="admin-auth">
        <a href="../logout.php" class="admin-logout">Exit Dashboard</a>
    </div>
</nav>

<style>
    :root {
        --admin-dark: #111111;
    }

    .admin-nav {
        background: var(--admin-dark);
        height: 70px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 5%;
        border-bottom: 2px solid var(--crimson);
        position: sticky;
        top: 0;
        z-index: 2000;
    }

    .admin-logo a {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        color: white;
        text-decoration: none;
        letter-spacing: 2px;
        font-weight: 700;
    }

    .admin-logo span { color: var(--gold); }

    .admin-logo .badge {
        font-size: 0.6rem;
        background: var(--crimson);
        color: white;
        padding: 2px 8px;
        border-radius: 4px;
        margin-left: 10px;
        vertical-align: middle;
        letter-spacing: 1px;
    }

    .admin-menu {
        display: flex;
        gap: 25px;
    }

    .admin-nav-link {
        color: rgba(255,255,255,0.7);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        transition: 0.3s;
        padding: 8px 12px;
        border-radius: 5px;
    }

    .admin-nav-link:hover, .admin-nav-link.active {
        color: white;
        background: rgba(255,255,255,0.1);
    }

    .admin-logout {
        color: #ff4d4d;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        border-left: 1px solid #333;
        padding-left: 20px;
    }

    .admin-logout:hover {
        text-decoration: underline;
    }
</style>