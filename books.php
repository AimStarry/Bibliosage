<?php 
session_start();
include('config/db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Archives | Biblio-Sage</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .library-hero {
            background: linear-gradient(rgba(26, 26, 26, 0.8), rgba(26, 26, 26, 0.8)), url('images/library-banner.jpg') center/cover;
            padding: 80px 10%;
            text-align: center;
            color: white;
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 40px;
            padding: 60px 10%;
            background-color: var(--cream);
        }

        .book-card {
            background: var(--white);
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .book-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .image-container {
            position: relative;
            height: 380px;
            overflow: hidden;
        }

        .book-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .book-card:hover .book-image {
            transform: scale(1.1);
        }

        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            backdrop-filter: blur(5px);
        }

        .status-available { background: rgba(40, 167, 69, 0.8); color: white; }
        .status-out { background: rgba(220, 53, 69, 0.8); color: white; }

        .book-info {
            padding: 25px;
            flex-grow: 1;
            text-align: center;
        }

        .book-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            margin-bottom: 10px;
            color: var(--charcoal);
        }

        .action-area {
            padding: 0 25px 25px;
            display: grid;
            gap: 10px;
        }

        .btn-read { background: var(--charcoal); color: var(--gold) !important; border: 1px solid var(--gold); }
        .btn-buy { background: transparent; border: 1px solid var(--charcoal); color: var(--charcoal) !important; }
        .btn-buy:hover { background: var(--charcoal); color: white !important; }

        /* Styling for all action buttons */
.action-area a {
    text-decoration: none;
    padding: 12px;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    text-align: center;
    transition: all 0.3s ease;
    display: block; /* Ensures they stack correctly in the grid */
}

/* Primary Borrow Button (Crimson) */
.btn-primary {
    background-color: var(--crimson);
    color: white !important;
}

.btn-primary:hover {
    background-color: var(--charcoal);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(124, 10, 2, 0.2);
}

/* Digital Reader Button (Charcoal + Gold) */
.btn-read {
    background-color: var(--charcoal);
    color: var(--gold) !important;
    border: 1px solid var(--gold);
}

.btn-read:hover {
    background-color: var(--gold);
    color: var(--charcoal) !important;
}

/* Buy Button (Outline Style) */
.btn-buy {
    background-color: transparent;
    border: 1px solid var(--charcoal);
    color: var(--charcoal) !important;
}

.btn-buy:hover {
    background-color: var(--charcoal);
    color: white !important;
}

.book-title-link {
    text-decoration: none;
    color: var(--charcoal);
    transition: color 0.3s ease;
}

.book-title-link:hover {
    color: var(--crimson);
}
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>

    <section class="library-hero">
        <h1 style="font-size: 3.5rem; margin-bottom: 10px;">The Archives</h1>
        <p style="color: var(--gold); letter-spacing: 2px;">DISCOVER YOUR NEXT GREAT ADVENTURE</p>
    </section>

    <div class="book-grid">
        <?php
        $res = mysqli_query($conn, "SELECT * FROM books");
        while($row = mysqli_fetch_assoc($res)) {
            $isAvailable = $row['stock'] > 0;
            $statusClass = $isAvailable ? 'status-available' : 'status-out';
            $statusText = $isAvailable ? 'In Stock' : 'Unavailable';
        ?>
            <div class="book-card">
                <div class="image-container">
                    <img src="<?php echo $row['image']; ?>" class="book-image" alt="Book Cover">
                    <span class="status-badge <?php echo $statusClass; ?>">
                        <?php echo $statusText; ?>
                    </span>
                </div>

                <div class="book-info">
                    <h3 class="book-title">
                        <a href="Book_details.php?id=<?php echo $row['book_id']; ?>" class="book-title-link">
                            <?php echo $row['title']; ?>
                        </a>
                    </h3>
                    <p style="color: #888; font-size: 0.9rem;">Ref. ID: #<?php echo $row['book_id']; ?></p>
                </div>

                <div class="action-area">
                    <?php if(!empty($row['file_path'])): ?>
                        <a href="<?php echo $row['file_path']; ?>" target="_blank" class="btn-read">
                            📖 Digital Reader
                        </a>
                    <?php endif; ?>
                    
                    <a href="borrow_book.php?id=<?php echo $row['book_id']; ?>" class="btn-primary">
                        Borrow Item
                    </a>
                    
                    <a href="buy_book.php?id=<?php echo $row['book_id']; ?>" class="btn-buy">
                        Own Copy • ₱<?php echo number_get_formatted_price($row['price']); ?>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>

    <?php 
    // Small helper for price formatting if needed
    function number_get_formatted_price($price) {
        return number_format((float)$price, 2, '.', ',');
    }
    ?>
</body>
</html>