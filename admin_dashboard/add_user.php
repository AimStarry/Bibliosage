<?php 
include('admin_check.php'); 
include('../config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escaping inputs for security
    $name = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password']; 
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $sql = "INSERT INTO users (fullname, email, password, role) VALUES ('$name', '$email', '$pass', '$role')";
    if(mysqli_query($conn, $sql)) { 
        header("Location: view_users.php"); 
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Scholar | Biblio-Sage</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { background-color: #f4f1e8; }
        
        .onboard-container {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            max-width: 900px;
            margin: 60px auto;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        /* Sidebar Branding */
        .onboard-sidebar {
            background: var(--charcoal);
            padding: 50px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .onboard-sidebar h2 { font-family: 'Playfair Display'; font-size: 2.2rem; color: var(--gold); line-height: 1.2; }
        .onboard-sidebar p { opacity: 0.8; font-size: 0.95rem; margin-top: 20px; line-height: 1.6; }

        .onboard-form { padding: 50px; }

        /* Elegant Inputs */
        .input-group { margin-bottom: 25px; }
        .input-group label { 
            display: block; 
            font-weight: 700; 
            font-size: 0.75rem; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            color: #666;
            margin-bottom: 8px;
        }

        input[type="text"], input[type="email"], input[type="password"], select {
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
            border-color: var(--gold);
            background: #fffcf5;
        }

        .btn-register {
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

        .btn-register:hover { background: var(--charcoal); transform: translateY(-2px); }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #888;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .back-link:hover { color: var(--crimson); }
    </style>
</head>
<body>
    <?php include('admin_navbar.php'); ?>

    <div class="onboard-container">
        <div class="onboard-sidebar">
            <div>
                <h2>Scholar Registration</h2>
                <p>Welcome a new member into the Biblio-Sage community. Assign their institutional role to determine their borrowing privileges and access levels.</p>
            </div>
            
            <div style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
                <small style="color: var(--gold);">PRIVILEGE STATUS</small>
                <p style="font-size: 0.8rem;">Students and Employees carry different borrowing durations and overdue fine rates.</p>
            </div>
        </div>

        <div class="onboard-form">
            <form method="POST">
                <div class="input-group">
                    <label>Full Scholar Name</label>
                    <input type="text" name="fullname" placeholder="E.g., Julian Thorne" required>
                </div>

                <div class="input-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="scholar@student.com" required>
                </div>

                <div class="input-group">
                    <label>Access Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>

                <div class="input-group">
                    <label>Classification</label>
                    <select name="role">
                        <option value="student">Student Member</option>
                        <option value="employee">Institutional Employee</option>
                    </select>
                </div>

                <button type="submit" class="btn-register">Register Member</button>
                <a href="view_users.php" class="back-link">← Return to User Registry</a>
            </form>
        </div>
    </div>
</body>
</html>