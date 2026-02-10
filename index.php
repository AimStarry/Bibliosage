<?php include('navbar.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <section style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('images/library-bg.jpg') center/cover no-repeat fixed; height: 90vh; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; color: white; padding: 0 20px;">
        <h1 style="font-size: clamp(3.5rem, 10vw, 7rem); margin-bottom: 0; line-height: 0.9;">Biblio-Sage</h1>
        <p style="font-size: 1.5rem; letter-spacing: 5px; color: var(--gold); margin-top: 10px; text-transform: uppercase;">The Digital Archive</p>
        
        <div style="margin-top: 50px;">
            <a href="books.php" class="hero-btn">Explore Library</a>
        </div>
    </section>

    <section style="padding: 100px 10%; background: #fff;">
        <div style="display: flex; align-items: center; gap: 80px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 300px;">
                <span style="color: var(--gold); font-weight: 700; letter-spacing: 2px;">SINCE 2024</span>
                <h2 style="font-size: 3.5rem; margin-top: 10px; color: var(--charcoal);">Preserving the <span style="color: var(--crimson);">Art of Reading.</span></h2>
                <p style="font-size: 1.2rem; color: #555; line-height: 1.8;">
                    Biblio-Sage provides scholars with a curated selection of digital and physical resources. We believe that a library is more than a building—it's a gateway to infinite possibilities.
                </p>
            </div>
            <div style="flex: 1; display: flex; gap: 20px;">
                <div class="stat-card" style="text-align: center;">
                    <h3 style="font-size: 3rem; color: var(--gold);">50+</h3>
                    <p>New Titles Monthly</p>
                </div>
                <div class="stat-card" style="text-align: center; background: var(--crimson); color: white;">
                    <h3 style="font-size: 3rem; color: white;">0$</h3>
                    <p>Subscription Fee</p>
                </div>
            </div>
        </div>
    </section>

    <section style="padding: 80px 10%; background: var(--cream);">
        <h2 style="text-align: center; font-size: 2.5rem; margin-bottom: 50px;">Browse Collections</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
            
            <div class="feature-box">
                <div class="icon-circle">📜</div>
                <h3>Classical Literature</h3>
                <p>Access timeless masterpieces from Homer to Hemingway. Available in both PDF and hardcopy.</p>
                <a href="BookPage.php?cat=classic" style="color: var(--crimson); text-decoration: none; font-weight: 600;">View Category →</a>
            </div>

            <div class="feature-box">
                <div class="icon-circle">💻</div>
                <h3>Modern Technology</h3>
                <p>Stay ahead with the latest in AI, Programming, and Digital Innovation resources.</p>
                <a href="BookPage.php?cat=tech" style="color: var(--crimson); text-decoration: none; font-weight: 600;">View Category →</a>
            </div>

            <div class="feature-box">
                <div class="icon-circle">🎨</div>
                <h3>Arts & Design</h3>
                <p>A curated gallery of design theory, architecture, and visual arts history.</p>
                <a href="BookPage.php?cat=arts" style="color: var(--crimson); text-decoration: none; font-weight: 600;">View Category →</a>
            </div>

        </div>
    </section>

    <section style="padding: 100px 10%; text-align: center; background: var(--charcoal); color: white;">
        <h2 style="font-size: 2.5rem; color: var(--gold);">Stay Inspired</h2>
        <p style="margin-bottom: 40px; opacity: 0.8;">Subscribe to get notified about new arrivals and library events.</p>
        <form action="newsletter_signup.php" method="POST" style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
            <input type="email" name="email" placeholder="Enter your email" required 
                   style="padding: 15px 25px; border-radius: 30px; border: none; width: 300px;">
            <button type="submit" class="hero-btn" style="padding: 15px 35px;">Join Now</button>
        </form>
    </section>

    <footer style="background: #111; color: #777; padding: 60px 10%; text-align: center;">
        <p>&copy; 2026 Biblio-Sage. People's choice for digital research.</p>
    </footer>

</body>
</html>