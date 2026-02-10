<?php 
include('admin_check.php'); 
include('../config/db.php'); 

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    
    // Image Handling - Assuming they are in assets/images/
    $image = "images/" . $_POST['image_name'];

    // PDF File Handling
    $target_dir = "../uploads/";
    if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
    
    $file_name = time() . "_" . basename($_FILES["pdf_file"]["name"]); // Added timestamp to prevent overwrites
    $target_file = $target_dir . $file_name;
    $db_file_path = "uploads/" . $file_name;

    if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO books (title, author, price, stock, image, file_path) 
                VALUES ('$title', '$author', '$price', '$stock', '$image', '$db_file_path')";
        
        if(mysqli_query($conn, $sql)) { 
            header("Location: manage_books.php"); 
            exit();
        }
    } else {
        $error = "Critical Error: Failed to move uploaded PDF to server directory.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Archive New Volume | Biblio-Sage</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { background-color: #f4f1e8; }
        .form-container {
            max-width: 900px;
            margin: 50px auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .form-sidebar {
            background: var(--charcoal);
            padding: 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .form-sidebar h2 { font-family: 'Playfair Display'; font-size: 2rem; color: var(--gold); }

        .main-form { padding: 40px; }

        .input-group { margin-bottom: 20px; }
        .input-group label { 
            display: block; 
            font-size: 0.75rem; 
            font-weight: 700; 
            text-transform: uppercase; 
            color: #777; 
            margin-bottom: 8px;
        }

        input[type="text"], input[type="number"], input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-family: inherit;
        }

        input:focus { outline: none; border-color: var(--gold); background: #fffcf5; }

        .file-upload-box {
            border: 2px dashed #ddd;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            background: #fafafa;
        }

        .btn-save {
            background: var(--crimson);
            color: white;
            border: none;
            width: 100%;
            padding: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-save:hover { background: var(--charcoal); }

        .error-msg { color: #d32f2f; font-size: 0.85rem; margin-bottom: 15px; font-weight: bold; }
    </style>
</head>
<body>
    <?php include('admin_navbar.php'); ?>

    <div class="form-container">
        <div class="form-sidebar">
            <div>
                <h2>New Volume Intake</h2>
                <p style="font-size: 0.9rem; opacity: 0.8; line-height: 1.6; margin-top: 15px;">
                    Enter the bibliographic details and upload the digital manuscript. Ensure the file size does not exceed the server limit (usually 2MB).
                </p>
            </div>
            
            <div style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 8px;">
                <span style="color: var(--gold); font-size: 0.7rem; font-weight: bold;">ARCHIVE TIP</span>
                <p style="font-size: 0.8rem; margin: 5px 0;">Use high-resolution JPGs for cover images to ensure the catalog remains visually prestigious.</p>
            </div>
        </div>

        <div class="main-form">
            <?php if($error) echo "<div class='error-msg'>$error</div>"; ?>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="input-group">
                    <label>Book Title</label>
                    <input type="text" name="title" placeholder="The Great Archive" required>
                </div>

                <div class="input-group">
                    <label>Author / Scholar</label>
                    <input type="text" name="author" placeholder="F. Scott Fitzgerald" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="input-group">
                        <label>Price (₱)</label>
                        <input type="number" step="0.01" name="price" placeholder="499.00" required>
                    </div>
                    <div class="input-group">
                        <label>Stock Count</label>
                        <input type="number" name="stock" placeholder="10" required>
                    </div>
                </div>

                <div class="input-group">
                    <label>Image Reference (Filename)</label>
                    <input type="text" name="image_name" placeholder="cover_image.jpg" required>
                </div>

                <div class="input-group">
                    <label>Digital Manuscript (PDF)</label>
                    <div class="file-upload-box">
                        <input type="file" name="pdf_file" accept=".pdf" required>
                    </div>
                </div>

                <button type="submit" class="btn-save">Finalize and Archive</button>
                <a href="manage_books.php" style="display:block; text-align:center; margin-top:15px; color:#888; text-decoration:none; font-size:0.8rem;">Cancel Entry</a>
            </form>
        </div>
    </div>
</body>
</html>