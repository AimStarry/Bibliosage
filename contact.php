<?php 
session_start();
include('config/db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiries | Biblio-Sage</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .contact-hero {
            background: linear-gradient(rgba(26, 26, 26, 0.7), rgba(26, 26, 26, 0.7)), url('images/contact-bg.jpg') center/cover;
            padding: 100px 10%;
            text-align: center;
            color: white;
        }

        .contact-wrapper {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 50px;
            max-width: 1200px;
            margin: -60px auto 100px; /* Overlaps the hero slightly */
            padding: 0 20px;
        }

        /* Side Info Panel */
        .info-panel {
            background: var(--charcoal);
            color: white;
            padding: 60px 40px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .info-item {
            margin-bottom: 35px;
        }

        .info-item h4 {
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
            font-size: 0.85rem;
        }

        .info-item p {
            font-size: 1.1rem;
            opacity: 0.9;
            line-height: 1.6;
        }

        /* Form Panel */
        .form-panel {
            background: white;
            padding: 60px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .input-group {
            margin-bottom: 25px;
            position: relative;
        }

        .input-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--charcoal);
            font-size: 0.9rem;
        }

        .input-group input, 
        .input-group textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            transition: 0.3s;
            background: #f9f9f9;
        }

        .input-group input:focus, 
        .input-group textarea:focus {
            outline: none;
            border-color: var(--gold);
            background: white;
            box-shadow: 0 0 0 4px rgba(218, 164, 40, 0.1);
        }

        @media (max-width: 900px) {
            .contact-wrapper { grid-template-columns: 1fr; margin-top: 40px; }
            .info-panel { order: 2; }
        }
    </style>
</head>
<body style="background-color: var(--cream);">
    <?php include('navbar.php'); ?>

    <section class="contact-hero">
        <h1 style="font-size: 3.5rem; margin-bottom: 10px;">Connect With Us</h1>
        <p style="color: var(--gold); letter-spacing: 3px; text-transform: uppercase;">A Librarian is always standing by</p>
    </section>

    <div class="contact-wrapper">
        <aside class="info-panel">
            <h2 style="font-family: 'Playfair Display'; font-size: 2.2rem; margin-bottom: 40px;">Contact Details</h2>
            
            <div class="info-item">
                <h4>Location</h4>
                <p>Angeles City, Pampanga</p>
            </div>

            <div class="info-item">
                <h4>Hours of Operation</h4>
                <p>Monday – Friday: 8 AM – 7 PM<br>Saturday: 9 AM – 12 PM</p>
            </div>

            <div class="info-item">
                <h4>Direct Support</h4>
                <p>support@bibliosage.com<br>+63 (45) 123 4567</p>
            </div>

            <div style="margin-top: 60px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 30px;">
                <p style="font-style: italic; opacity: 0.6;">"The library is a gathering place for the curious."</p>
            </div>
        </aside>

        <main class="form-panel">
            <h3 style="font-family: 'Playfair Display'; font-size: 1.8rem; margin-bottom: 10px;">Send a Message</h3>
            <p style="color: #777; margin-bottom: 40px;">Fill out the form below and we’ll respond within 24 business hours.</p>

            <form action="contact_process.php" method="POST">
                <div class="input-group">
                    <label>Your Full Name</label>
                    <input type="text" name="name" placeholder="E.g. John Doe" required>
                </div>

                <div class="input-group">
                    <label>Institutional Email</label>
                    <input type="email" name="email" placeholder="name@student.com" required>
                </div>

                <div class="input-group">
                    <label>Message</label>
                    <textarea name="message" rows="6" placeholder="How can we assist you today?" required></textarea>
                </div>

                <button type="submit" class="hero-btn" style="width: 100%; border: none; cursor: pointer;">
                    Dispatch Message
                </button>
                
                <p style="text-align: center; margin-top: 20px;">
                    <a href="index.php" style="color: #999; text-decoration: none; font-size: 0.85rem;">← Return to Sanctuary</a>
                </p>
            </form>
        </main>
    </div>

    <footer style="text-align: center; padding-bottom: 50px; color: #bbb;">
        <p>&copy; 2026 Biblio-Sage Digital Library</p>
    </footer>
</body>
</html>