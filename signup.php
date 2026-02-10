<?php
include('config/db.php');
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // SECURITY UPGRADE: Hash the password
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $checkEmail = "SELECT email FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($result) > 0) {
        $message = "<div class='alert error'>This email is already registered in our archives.</div>";
    } else {
        $sql = "INSERT INTO users (fullname, email, password, role) VALUES ('$fullname', '$email', '$password', '$role')";
        
        if (mysqli_query($conn, $sql)) {
            $message = "<div class='alert success'>Membership granted! <a href='login.php'>Proceed to Login</a></div>";
        } else {
            $message = "<div class='alert error'>Archival Error: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Membership Application | Biblio-Sage</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        :root {
            --crimson: #7C0A02;
            --charcoal: #1A1A1A;
            --gold: #DAA428;
            --parchment: #F4F1E8;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body, html { height: 100%; margin: 0; font-family: 'Inter', sans-serif; background-color: var(--parchment); }

        .signup-wrapper {
            display: grid;
            grid-template-columns: 1fr 1.2fr; /* Mirror of login page */
            height: 100vh;
            width: 100%;
        }

        /* Form Side */
        .form-side {
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 80px;
            overflow-y: auto;
        }

        /* Branding Side */
        .branding-side {
            background: linear-gradient(rgba(124, 10, 2, 0.85), rgba(26, 26, 26, 0.9)), 
                        url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&q=80&w=2000');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 80px;
            color: white;
            text-align: right;
        }

        .branding-side h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            color: var(--gold);
            margin: 0;
        }

        .signup-card { max-width: 450px; width: 100%; margin: 0 auto; }
        .signup-card h2 { font-family: 'Playfair Display', serif; font-size: 2.2rem; color: var(--charcoal); margin-bottom: 8px; }
        .subtitle { color: #666; margin-bottom: 30px; font-size: 0.95rem; }

        /* Form Styling */
        .input-group { margin-bottom: 20px; }
        .input-group label { 
            display: block; font-weight: 700; font-size: 0.75rem; 
            text-transform: uppercase; letter-spacing: 1px; color: var(--charcoal); margin-bottom: 8px;
        }

        input, select {
            width: 100%; padding: 12px 15px; border: 2px solid #EEE;
            border-radius: 8px; font-size: 1rem; transition: var(--transition); box-sizing: border-box;
        }

        input:focus, select:focus { outline: none; border-color: var(--gold); background: #FFFDF9; }

        .signup-btn {
            width: 100%; background: var(--crimson); color: white; padding: 16px;
            border: none; border-radius: 8px; font-size: 1rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 2px; cursor: pointer; transition: var(--transition); margin-top: 10px;
        }

        .signup-btn:hover { background: var(--charcoal); transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }

        /* Alerts */
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; font-weight: 500; }
        .error { background: #FFF5F5; color: #C53030; border-left: 4px solid #C53030; }
        .success { background: #F0FFF4; color: #2F855A; border-left: 4px solid #2F855A; }
        .success a { color: #2F855A; text-decoration: underline; font-weight: 700; }

        @media (max-width: 900px) {
            .signup-wrapper { grid-template-columns: 1fr; }
            .branding-side { display: none; }
        }
    </style>
</head>
<body>

    <div class="signup-wrapper">
        <div class="form-side">
            <div class="signup-card">
                <h2>Join the Sanctuary</h2>
                <p class="subtitle">Complete your application for archival access.</p>
                
                <?php echo $message; ?>
                
                <form method="POST">
                    <div class="input-group">
                        <label>Full Name</label>
                        <input type="text" name="fullname" placeholder="e.g. Leonardo Da Vinci" required>
                    </div>

                    <div class="input-group">
                        <label>Institutional Email</label>
                        <input type="email" name="email" placeholder="scholar@student.com" required>
                    </div>

                    <div class="input-group">
                        <label>Create Password</label>
                        <input type="password" name="password" placeholder="Minimum 8 characters" required>
                    </div>

                    <div class="input-group">
                        <label>Scholarly Status</label>
                        <select name="role">
                            <option value="student">University Student</option>
                            <option value="employee">Staff / Faculty</option>
                        </select>
                    </div>

                    <button type="submit" class="signup-btn">Apply for Access</button>
                </form>

                <div style="text-align: center; margin-top: 25px; font-size: 0.9rem; color: #666;">
                    Already an initiate? <a href="login.php" style="color: var(--crimson); font-weight: 700; text-decoration: none;">Sign In</a>
                </div>
            </div>
        </div>

        <div class="branding-side">
            <h1>Biblio-Sage</h1>
            <p>Become a member of our growing community of scholars. Gain exclusive access to restricted manuscripts, borrow physical volumes, and track your intellectual journey.</p>
        </div>
    </div>

</body>
</html>