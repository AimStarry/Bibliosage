<?php 
include('admin_check.php'); 
include('../config/db.php'); 

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM users WHERE user_id = $id AND role = 'admin'";
    $result = mysqli_query($conn, $query);
    $admin = mysqli_fetch_assoc($result);

    if (!$admin) {
        header("Location: manage_admins.php");
        exit();
    }
} else {
    header("Location: manage_admins.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    $update_sql = "UPDATE users SET fullname='$fullname', email='$email' WHERE user_id=$id";
    
    if (mysqli_query($conn, $update_sql)) {
        header("Location: manage_admins.php?msg=AdminUpdated");
        exit();
    } else {
        $error = "System Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Admin Credentials | Biblio-Sage</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { background-color: #f4f1e8; }
        
        .admin-edit-container {
            max-width: 900px;
            margin: 60px auto;
            background: white;
            border-radius: 15px;
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            border: 1px solid rgba(0,0,0,0.05);
        }

        /* Sidebar: Security Branding */
        .security-sidebar {
            background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%);
            color: white;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        .security-sidebar::after {
            content: '🛡️';
            position: absolute;
            bottom: -20px;
            right: -10px;
            font-size: 8rem;
            opacity: 0.05;
        }

        .security-sidebar h2 { 
            font-family: 'Playfair Display'; 
            font-size: 1.8rem; 
            color: var(--gold);
            line-height: 1.2;
        }

        .access-badge {
            display: inline-block;
            background: var(--crimson);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        /* Form Area */
        .admin-form-panel { padding: 50px; background: #fff; }
        
        .input-group { margin-bottom: 25px; }
        .input-group label { 
            display: block; 
            font-weight: 800; 
            font-size: 0.7rem; 
            text-transform: uppercase; 
            color: #999;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #f0f0f0;
            border-radius: 10px;
            font-family: inherit;
            box-sizing: border-box;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: var(--gold);
            background: #fffdf9;
            box-shadow: 0 4px 12px rgba(218, 164, 40, 0.1);
        }

        .btn-update {
            background: var(--charcoal);
            color: var(--gold);
            width: 100%;
            padding: 16px;
            border: 1px solid var(--gold);
            border-radius: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-update:hover {
            background: var(--gold);
            color: var(--charcoal);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: #bbb;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: bold;
            transition: 0.2s;
        }

        .back-link:hover { color: var(--crimson); }

        .error-alert {
            background: #fff5f5;
            color: #e53e3e;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 0.85rem;
            border-left: 4px solid #e53e3e;
        }
    </style>
</head>
<body>
    <?php include('admin_navbar.php'); ?>

    <div class="admin-edit-container">
        <div class="security-sidebar">
            <div>
                <span class="access-badge">LEVEL: MASTER ADMIN</span>
                <h2>Modify Staff Privileges</h2>
                <p style="font-size: 0.9rem; opacity: 0.7; margin-top: 15px; line-height: 1.6;">
                    Updating these credentials modifies system-wide access. Ensure the institutional email remains valid to prevent lockout.
                </p>
            </div>
            
            <div style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
                <?php if($id == $_SESSION['user_id']): ?>
                    <small style="color: var(--gold); font-weight: bold;">⚠️ You are editing your own profile.</small>
                <?php else: ?>
                    <small style="opacity: 0.5;">Modifying Access for: #ADM-<?php echo $id; ?></small>
                <?php endif; ?>
            </div>
        </div>

        <div class="admin-form-panel">
            <h1 style="font-family: 'Playfair Display'; font-size: 2.2rem; margin-bottom: 10px;">Admin Details</h1>
            <p style="color: #888; margin-bottom: 35px; font-size: 0.9rem;">Refine identity and contact information.</p>
            
            <?php if(isset($error)) echo "<div class='error-alert'>$error</div>"; ?>
            
            <form method="POST">
                <div class="input-group">
                    <label>Full Name / Title</label>
                    <input type="text" name="fullname" value="<?php echo htmlspecialchars($admin['fullname']); ?>" required>
                </div>

                <div class="input-group">
                    <label>System Email Address</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                </div>

                <button type="submit" class="btn-update">Update Credentials</button>
                
                <a href="manage_admins.php" class="back-link">← Return to Administrative Registry</a>
            </form>
        </div>
    </div>
</body>
</html>