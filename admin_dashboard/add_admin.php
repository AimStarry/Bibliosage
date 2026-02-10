<?php 
include('admin_check.php'); 
include('../config/db.php'); 

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    // Recommended: use password_hash($password, PASSWORD_DEFAULT) for security
    $password = $_POST['password']; 
    $role = 'admin';

    $checkEmail = "SELECT email FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($result) > 0) {
        $message = "<div class='alert error'>Access Denied: Email already exists in the registry.</div>";
    } else {
        $sql = "INSERT INTO users (fullname, email, password, role) VALUES ('$fullname', '$email', '$password', '$role')";
        if (mysqli_query($conn, $sql)) {
            $message = "<div class='alert success'>Success: New Administrative account verified.</div>";
        } else {
            $message = "<div class='alert error'>System Error: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Onboard Admin | Biblio-Sage</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { background-color: var(--cream); }
        
        .onboard-container {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            max-width: 1000px;
            margin: 60px auto;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        /* Information Sidebar */
        .onboard-info {
            background: var(--charcoal);
            color: white;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .onboard-info h2 { font-family: 'Playfair Display'; font-size: 2rem; color: var(--gold); }
        .onboard-info p { opacity: 0.8; line-height: 1.6; margin-top: 15px; font-size: 0.95rem; }
        
        .onboard-form { padding: 50px; position: relative; }

        /* Modern Input Styling */
        .form-group { margin-bottom: 25px; }
        .form-group label { 
            display: block; 
            font-weight: 700; 
            font-size: 0.8rem; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            color: #555;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #eee;
            border-radius: 8px;
            font-family: inherit;
            transition: 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--crimson);
            background: #fffcfc;
        }

        /* Custom Alerts */
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; font-weight: 600; }
        .error { background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }
        .success { background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }

        .btn-grant {
            background: var(--crimson);
            color: white;
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-grant:hover { background: var(--charcoal); transform: translateY(-2px); }

        @media (max-width: 800px) {
            .onboard-container { grid-template-columns: 1fr; margin: 20px; }
            .onboard-info { padding: 30px; }
        }
    </style>
</head>
<body>
    <?php include('admin_navbar.php'); ?>

    <div class="onboard-container">
        <div class="onboard-info">
            <h2>Administrative Credentials</h2>
            <p>You are granting high-level system access. New administrators will have the power to manage inventory, oversee scholars, and process financial transactions.</p>
            <div style="margin-top: 30px; border-left: 2px solid var(--gold); padding-left: 20px;">
                <small style="color: var(--gold); display: block; font-weight: bold;">SECURITY NOTICE</small>
                <small>Ensure the temporary password is shared securely via institutional channels.</small>
            </div>
        </div>

        <div class="onboard-form">
            <?php echo $message; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>Full Legal Name</label>
                    <input type="text" name="fullname" placeholder="E.g. Dr. Arthur Sage" required>
                </div>

                <div class="form-group">
                    <label>Institutional Email</label>
                    <input type="email" name="email" placeholder="staff@admin.com" required>
                </div>

                <div class="form-group">
                    <label>Temporary Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-grant">Authorize Admin Account</button>
                
                <p style="text-align: center; margin-top: 25px;">
                    <a href="manage_admins.php" style="color: #999; text-decoration: none; font-size: 0.8rem; font-weight: bold;">
                        ← Cancel and Return to Registry
                    </a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>