<?php
session_start();
require 'db.php'; // Using your existing PDO connection

if (!isset($_SESSION['admin'])) {
    header("Location: index.html");
    exit();
}

$success = "";
$error = "";

// 1. Get book ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = (int) $_GET['id'];

// 2. Fetch book data from database
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ? LIMIT 1");
$stmt->execute([$id]);
$book = $stmt->fetch();

if (!$book) {
    header("Location: dashboard.php");
    exit();
}

// 3. Handle the Save/Update action
if (isset($_POST['edit_book'])) {
    $title    = trim($_POST['title']);
    $author   = trim($_POST['author']);
    $category = trim($_POST['category']);
    $content  = trim($_POST['content']);

    if ($title && $author && $category) {
        try {
            $sql = "UPDATE books SET title=?, author=?, category=?, content=? WHERE id=?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$title, $author, $category, $content, $id])) {
                $success = "Changes saved successfully!";
                // Update local data to refresh the form view
                $book['title'] = $title;
                $book['author'] = $author;
                $book['category'] = $category;
                $book['content'] = $content;
            }
        } catch (PDOException $e) {
            $error = " Error: " . $e->getMessage();
        }
    } else {
        $error = " Title, Author, and Category are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book | LMS</title>
    <link rel="stylesheet" href="style.css"> <style>
        body { display: block; padding: 20px; background: #f4eeff; }
        .form-card { background: white; max-width: 500px; margin: 40px auto; padding: 30px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        
        /* New styles for the labels you wanted */
        label { 
            display: block; 
            margin-top: 15px; 
            font-weight: bold; 
            color: #6a5acd; 
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        input, textarea { 
            width: 100%; 
            padding: 12px; 
            margin-top: 5px; 
            border: 2px solid #eee; 
            border-radius: 10px; 
            box-sizing: border-box;
            outline: none;
            font-family: inherit;
        }
        textarea { height: 120px; resize: vertical; }
        .btn-update { background: #dcd6f7; color: #6a5acd; border: none; padding: 15px; width: 100%; border-radius: 10px; font-weight: bold; cursor: pointer; margin-top: 20px; }
        .cancel-link { display: block; text-align: center; margin-top: 15px; color: #888; text-decoration: none; }
    </style>
</head>
<body>

    <div class="form-card">
        <h2 style="text-align: center;"> Edit Book</h2>
        
        <?php if($success) echo "<p style='color:#2ecc71; text-align:center;'>$success</p>"; ?>
        <?php if($error) echo "<p style='color:#e74c3c; text-align:center;'>$error</p>"; ?>

        <form method="POST">
            <label>Title</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>

            <label>Author</label>
            <input type="text" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>

            <label>Category</label>
            <input type="text" name="category" value="<?php echo htmlspecialchars($book['category']); ?>" required>

            <label>Description</label>
            <textarea name="content"><?php echo htmlspecialchars($book['content']); ?></textarea>

            <button type="submit" name="edit_book" class="btn-update">Update Book</button>
            <a href="dashboard.php" class="cancel-link">Cancel</a>
        </form>
    </div>

</body>
</html>