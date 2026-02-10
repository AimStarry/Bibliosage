<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<nav class="main-nav">
    <div class="nav-container">
        <div class="logo">
            <a href="index.php">BIBLIO<span>SAGE</span></a>
        </div>
        
        <div class="nav-menu">
            <a href="index.php" class="nav-link">Home</a>
            <a href="books.php" class="nav-link">Library</a>
            <a href="about.php" class="nav-link">About</a>
            <a href="contact.php" class="nav-link">Contact</a>
            
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="admin/Admin_dashboard.php" class="admin-link">Dashboard</a>
            <?php endif; ?>
        </div>

        <div class="nav-auth">
            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="user-pill">
                    <span class="user-name">Welcome, <?php echo explode(' ', $_SESSION['fullname'])[0]; ?>!</span>
                    <a href="logout.php" class="logout-btn">Logout</a>
                </div>
            <?php else: ?>
                <a href="login.php" class="login-btn">Sign In</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<style>
    /* Advanced Navbar Styling */
    .main-nav {
        background: rgba(26, 26, 26, 0.95); /* Glass effect */
        backdrop-filter: blur(10px);
        padding: 0;
        height: 80px;
        width: 100%;
        display: flex;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 1000;
        border-bottom: 1px solid rgba(218, 164, 40, 0.2);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .nav-container {
        width: 90%;
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Logo Design */
    .logo a {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        color: white;
        text-decoration: none;
        letter-spacing: 3px;
        font-weight: 700;
        transition: 0.3s;
    }
    .logo span { color: var(--gold); }
    .logo a:hover { text-shadow: 0 0 15px rgba(218, 164, 40, 0.5); }

    /* Modern Links with Underline Animation */
    .nav-menu { display: flex; gap: 40px; }
    
    .nav-link {
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 400;
        position: relative;
        padding: 5px 0;
        transition: 0.3s;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--gold);
        transition: 0.3s;
    }

    .nav-link:hover { color: white; }
    .nav-link:hover::after { width: 100%; }

    .admin-link {
        color: var(--gold);
        text-decoration: none;
        font-weight: 600;
        border: 1px solid var(--gold);
        padding: 8px 15px;
        border-radius: 4px;
        font-size: 0.85rem;
        transition: 0.3s;
    }
    .admin-link:hover { background: var(--gold); color: var(--charcoal); }

    /* User Information Pill */
    .user-pill {
        display: flex;
        align-items: center;
        gap: 15px;
        background: rgba(255,255,255,0.05);
        padding: 5px 5px 5px 15px;
        border-radius: 30px;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .user-name { color: white; font-size: 0.85rem; font-weight: 300; }

    .logout-btn {
        background: var(--crimson);
        color: white;
        text-decoration: none;
        padding: 8px 18px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: 0.3s;
    }
    .logout-btn:hover { background: white; color: var(--crimson); }

    .login-btn {
        background: var(--gold);
        color: var(--charcoal);
        padding: 10px 25px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        transition: 0.3s;
    }
    .login-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(218, 164, 40, 0.3); }
</style>