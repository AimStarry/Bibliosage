<?php 
include('admin_check.php'); 
include('../config/db.php'); 

$id = mysqli_real_escape_string($conn, $_GET['id']);
$book = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM books WHERE book_id = $id"));

// Error handling if book not found
if (!$book) {
    header("Location: manage_books.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $file_path = $book['file_path']; 

    if (!empty($_FILES["pdf_file"]["name"])) {
        $file_name = time() . "_" . basename($_FILES["pdf_file"]["name"]);
        $target_file = "../uploads/" . $file_name;
        
        if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $target_file)) {
            // Optional: Delete old file from server to save space
            if (file_exists("../" . $book['file_path'])) {
                unlink("../" . $book['file_path']);
            }
            $file_path = "uploads/" . $file_name;
        }
    }

    $sql = "UPDATE books SET title='$title', stock='$stock', price='$price', file_path='$file_path' WHERE book_id=$id";
    if(mysqli_query($conn, $sql)) { 
        header("Location: manage_books.php"); 
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modify Volume | Biblio-Sage Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { background-color: #f4f1e8; }
        .edit-container {
            max-width: 950px;
            margin: 50px auto;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 350px 1fr;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
        }

        /* Left Panel: Preview */
        .preview-panel {
            background: var(--charcoal);
            padding: 40px;
            color: white;
            text-align: center;
            border-right: 1px solid rgba(255,255,255,0.1);
        }

        .current-cover {
            width: 100%;
            max-width: 200px;
            height: 280px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            margin-bottom: 20px;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .preview-panel h3 { font-family: 'Playfair Display'; color: var(--gold); margin-bottom: 5px; }
        .preview-panel p { font-size: 0.8rem; opacity: 0.7; }

        /* Right Panel: Form */
        .form-panel { padding: 40px; }

        .input-group { margin-bottom: 20px; }
        .input-group label { 
            display: block; 
            font-size: 0.7rem; 
            font-weight: 800; 
            text-transform: uppercase; 
            letter-spacing: 1px;
            color: #888;
            margin-bottom: 8px;
        }

        input[type="text"], input[type="number"], input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #eee;
            border-radius: 8px;
            font-family: inherit;
            transition: 0.3s;
        }

        input:focus { outline: none; border-color: var(--gold); background: #fffcf5; }

        .file-info {
            background: #f9f9f9;
            padding: 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            color: #666;
            margin-top: 5px;
            border: 1px dashed #ddd;
            word-break: break-all;
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
            margin-top: 10px;
        }
        .btn-update:hover { background: var(--charcoal); transform: translateY(-2px); }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #999;
            text-decoration: none;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <?php include('admin_navbar.php'); ?>

    <div class="edit-container">
        <div class="preview-panel">
            <p style="text-transform: uppercase; letter-spacing: 2px; font-size: 0.6rem; color: var(--gold);">Current Volume</p>
            <img src="../<?php echo $book['image']; ?>" class="current-cover" alt="Cover">
            <h3><?php echo $book['title']; ?></h3>
            <p>ID: #<?php echo $book['book_id']; ?></p>
            
            <div style="margin-top: 40px; text-align: left; font-size: 0.8rem; line-height: 1.6; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
                <b style="color: var(--gold);">Note:</b> Updating the title or files will reflect across all user libraries and transaction histories immediately.
            </div>
        </div>

        <div class="form-panel">
            <h2 style="font-family: 'Playfair Display'; margin-bottom: 30px;">Edit Manuscript Details</h2>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="input-group">
                    <label>Volume Title</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="input-group">
                        <label>Stock Quantity</label>
                        <input type="number" name="stock" value="<?php echo $book['stock']; ?>" required>
                    </div>
                    <div class="input-group">
                        <label>Price (₱)</label>
                        <input type="text" name="price" value="<?php echo $book['price']; ?>" required>
                    </div>
                </div>

                <div class="input-group">
                    <label>Digital Asset (PDF)</label>
                    <input type="file" name="pdf_file" accept=".pdf">
                    <div class="file-info">
                        <strong>Current File:</strong> <?php echo basename($book['file_path']); ?>
                    </div>
                    <small style="color: #999; font-size: 0.7rem; display: block; margin-top: 5px;">
                        Leave empty to keep the existing manuscript.
                    </small>
                </div>

                <button type="submit" class="btn-update">Update Archives</button>
                <a href="manage_books.php" class="back-link">Discard Changes and Return</a>
            </form>
        </div>
    </div>
</body>
</html>