<?php
include('config/db.php'); 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; 

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['role'] = $user['role'];

        if ($_SESSION['role'] === 'admin') {
            header("Location: admin_dashboard/admin_dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        echo "<script>alert('Invalid Email or Password'); window.location='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Biblio-Sage</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        :root {
            --crimson: #7C0A02;
            --charcoal: #1A1A1A;
            --gold: #DAA428;
            --parchment: #F4F1E8;
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--parchment);
        }

        .login-wrapper {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            height: 100vh;
            width: 100%;
        }

        /* Branding Side */
        .branding-side {
            background: linear-gradient(rgba(26, 26, 26, 0.8), rgba(26, 26, 26, 0.8)), 
                        url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&q=80&w=2000');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 80px;
            color: white;
        }

        .branding-side h1 {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            color: var(--gold);
            margin: 0;
            letter-spacing: -1px;
        }

        .branding-side p {
            font-size: 1.2rem;
            max-width: 400px;
            line-height: 1.6;
            opacity: 0.9;
            margin-top: 20px;
        }

        /* Form Side */
        .form-side {
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 80px;
        }

        .login-card {
            max-width: 400px;
            width: 100%;
            margin: 0 auto;
        }

        .login-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: var(--charcoal);
            margin-bottom: 10px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 40px;
            font-size: 0.95rem;
        }

        .input-group {
            margin-bottom: 25px;
        }

        .input-group label {
            display: block;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--charcoal);
            margin-bottom: 8px;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 14px;
            border: 2px solid #EEE;
            border-radius: 8px;
            font-size: 1rem;
            transition: 0.3s;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: var(--gold);
            background: #FFFDF9;
        }

        .login-btn {
            width: 100%;
            background: var(--crimson);
            color: white;
            padding: 16px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .login-btn:hover {
            background: var(--charcoal);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .signup-footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9rem;
            color: #666;
        }

        .signup-footer a {
            color: var(--crimson);
            font-weight: 700;
            text-decoration: none;
        }

        /* Mobile Responsive */
        @media (max-width: 900px) {
            .login-wrapper { grid-template-columns: 1fr; }
            .branding-side { display: none; }
            .form-side { padding: 40px; }
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <div class="branding-side">
            <h1>Biblio-Sage</h1>
            <p>Enter the archive. Discover thousands of digital manuscripts and physical volumes in our scholarly sanctuary.</p>
        </div>

        <div class="form-side">
            <div class="login-card">
                <h2>Welcome Back</h2>
                <p class="subtitle">Please enter your credentials to access the library.</p>
                
                <form method="POST">
                    <div class="input-group">
                        <label>Email Address</label>
                        <input type="email" name="email" placeholder="scholar@student.com" required>
                    </div>

                    <div class="input-group">
                        <label>Access Password</label>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="login-btn">Secure Login</button>
                </form>

                <div class="signup-footer">
                    New to the sanctuary? <a href="signup.php">Apply for Membership</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>