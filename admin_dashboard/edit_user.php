<?php 
include('admin_check.php'); 
include('../config/db.php'); 

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM users WHERE user_id = $id AND role != 'admin'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        header("Location: view_users.php");
        exit();
    }
} else {
    header("Location: view_users.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $update_sql = "UPDATE users SET fullname='$fullname', email='$email', role='$role' WHERE user_id=$id";
    
    if (mysqli_query($conn, $update_sql)) {
        header("Location: view_users.php?msg=UserUpdated");
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
    <title>Edit Scholar Profile | Biblio-Sage</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { background-color: #f4f1e8; }
        
        .edit-user-container {
            max-width: 900px;
            margin: 60px auto;
            background: white;
            border-radius: 15px;
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        /* Profile Sidebar */
        .profile-summary {
            background: var(--charcoal);
            color: white;
            padding: 50px;
            text-align: center;
            border-right: 1px solid rgba(255,255,255,0.1);
        }

        .avatar-circle {
            width: 100px;
            height: 100px;
            background: var(--gold);
            color: var(--charcoal);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0 auto 20px;
            font-family: 'Playfair Display';
        }

        .profile-summary h2 { font-family: 'Playfair Display'; font-size: 1.8rem; margin-bottom: 5px; }
        .profile-summary p { opacity: 0.6; font-size: 0.85rem; letter-spacing: 1px; }

        /* Form Area */
        .edit-form-panel { padding: 50px; }
        
        .input-group { margin-bottom: 25px; }
        .input-group label { 
            display: block; 
            font-weight: 700; 
            font-size: 0.75rem; 
            text-transform: uppercase; 
            color: #888;
            margin-bottom: 8px;
        }

        input[type="text"], input[type="email"], select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #eee;
            border-radius: 8px;
            font-family: inherit;
            box-sizing: border-box;
            transition: 0.3s;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--crimson);
            background: #fffcfc;
        }

        .btn-update {
            background: var(--crimson);
            color: white;
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-update:hover { background: var(--charcoal); transform: translateY(-2px); }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #999;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .back-link:hover { color: var(--charcoal); }

        .error-box {
            background: #ffebee;
            color: #c62828;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.85rem;
            border: 1px solid #ffcdd2;
        }
    </style>
</head>
<body>
    <?php include('admin_navbar.php'); ?>

    <div class="edit-user-container">
        <div class="profile-summary">
            <div class="avatar-circle">
                <?php echo strtoupper(substr($user['fullname'], 0, 1)); ?>
            </div>
            <p>SCHOLAR DOSSIER</p>
            <h2><?php echo explode(' ', $user['fullname'])[0]; ?></h2>
            <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); text-align: left;">
                <small style="color: var(--gold); display: block; font-weight: bold; margin-bottom: 5px;">ACCOUNT STATUS</small>
                <small style="opacity: 0.8;">Active Member since Ref ID: #USR-<?php echo $user['user_id']; ?></small>
            </div>
        </div>

        <div class="edit-form-panel">
            <h1 style="font-family: 'Playfair Display'; font-size: 2rem; margin-bottom: 30px; color: var(--charcoal);">Modify Profile</h1>
            
            <?php if(isset($error)) echo "<div class='error-box'>$error</div>"; ?>
            
            <form method="POST">
                <div class="input-group">
                    <label>Full Legal Name</label>
                    <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
                </div>

                <div class="input-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>

                <div class="input-group">
                    <label>Institutional Role</label>
                    <select name="role">
                        <option value="student" <?php if($user['role'] == 'student') echo 'selected'; ?>>Student</option>
                        <option value="employee" <?php if($user['role'] == 'employee') echo 'selected'; ?>>Employee</option>
                    </select>
                </div>

                <button type="submit" class="btn-update">Commit Changes</button>
                
                <a href="view_users.php" class="back-link">← Cancel and Return to Registry</a>
            </form>
        </div>
    </div>
</body>
</html>