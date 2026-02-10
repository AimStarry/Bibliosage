<?php 
session_start();
include('config/db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Story | Biblio-Sage</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .about-hero {
            background: linear-gradient(rgba(26, 26, 26, 0.7), rgba(26, 26, 26, 0.7)), url('images/about-bg.jpg') center/cover;
            padding: 120px 10%;
            text-align: center;
            color: white;
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            padding: 100px 10%;
            align-items: center;
            background-color: var(--white);
        }

        .mission-text h2 {
            font-size: 3rem;
            color: var(--charcoal);
            margin-bottom: 25px;
            line-height: 1.1;
        }

        .mission-text p {
            font-size: 1.1rem;
            color: #555;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        /* Modern Rules Section */
        .rules-container {
            background: var(--cream);
            padding: 100px 10%;
        }

        .rules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .rule-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            border-top: 4px solid var(--gold);
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: 0.3s;
        }

        .rule-card:hover {
            transform: translateY(-10px);
            border-top-color: var(--crimson);
        }

        .rule-icon {
            font-size: 2.5rem;
            margin-bottom: 20px;
            display: block;
        }

        .rule-card h4 {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            margin-bottom: 10px;
            color: var(--charcoal);
        }

        .rule-card p {
            font-size: 0.95rem;
            color: #777;
        }

        @media (max-width: 800px) {
            .about-content { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>

    <section class="about-hero">
        <h1 style="font-size: 4rem; margin-bottom: 10px;">Our Heritage</h1>
        <p style="color: var(--gold); letter-spacing: 4px; text-transform: uppercase;">Wisdom preserved for the modern age</p>
    </section>

    <section class="about-content">
        <div class="mission-text">
            <span style="color: var(--crimson); font-weight: 700; letter-spacing: 2px;">OUR MISSION</span>
            <h2>Bridging the Gap Between <span style="color: var(--gold);">Tradition</span> & Tech.</h2>
            <p>
                Biblio-Sage was established as a dedicated digital sanctuary for students and professionals. 
                We believe that access to academic resources should be seamless, elegant, and uncompromising.
            </p>
            <p>
                Whether you are seeking a physical heirloom through our borrowing system or a digital reference 
                to guide your late-night research, we are here to empower your scholarly journey.
            </p>
            <a href="books.php" class="hero-btn">Explore Collections</a>
        </div>
        <div class="mission-image">
            <img src="images/about-side.jpg" alt="Library Interior" style="width: 100%; border-radius: 20px; box-shadow: 20px 20px 0 var(--gold);">
        </div>
    </section>

    <section class="rules-container">
        <h2 style="text-align: center; font-size: 2.5rem; color: var(--charcoal);">Library Charter</h2>
        <p style="text-align: center; color: #777; max-width: 600px; margin: 10px auto 0;">Standard operating procedures for all Biblio-Sage patrons.</p>

        <div class="rules-grid">
            <div class="rule-card">
                <span class="rule-icon">⏳</span>
                <h4>Borrowing Period</h4>
                <p>Enjoy standard access to physical volumes for a duration of 7 days.</p>
            </div>

            <div class="rule-card">
                <span class="rule-icon">📚</span>
                <h4>Collection Limit</h4>
                <p>Patrons may hold up to 3 physical books at any given time.</p>
            </div>

            <div class="rule-card">
                <span class="rule-icon">⚖️</span>
                <h4>Overdue Policy</h4>
                <p>A fine of ₱10.00 is applied daily for resources kept past their due date.</p>
            </div>
        </div>

        <div style="text-align: center; margin-top: 60px;">
            <a href="index.php" style="color: var(--charcoal); text-decoration: none; font-weight: 600; border-bottom: 2px solid var(--gold);">← Back to Sanctuary</a>
        </div>
    </section>

    <footer style="background: var(--charcoal); padding: 40px; text-align: center; color: rgba(255,255,255,0.5);">
        <p>&copy; 2026 Biblio-Sage. All rights reserved.</p>
    </footer>

</body>
</html>