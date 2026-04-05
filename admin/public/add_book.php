<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: index.html"); 
    exit();
}

$success = "";
$error = "";

if (isset($_POST['add_book'])) {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $category = trim($_POST['category']);
    $content = trim($_POST['content']);

    if ($title && $author && $category) {
        try {
            $stmt = $pdo->prepare("INSERT INTO books (title, author, category, content) VALUES (?, ?, ?, ?)");
            $stmt->execute([$title, $author, $category, $content]);
            $success = " Book added successfully!";
        } catch (PDOException $e) {
            $error = " Error: " . $e->getMessage();
        }
    } else {
        $error = " All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Book — LMS</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { display: block; padding: 20px; background: #f0f2f5; }
        .form-card { background: white; max-width: 500px; margin: 50px auto; padding: 30px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-family: inherit; }
    </style>
</head>
<body>
    <div class="form-card">
        <h2> Add New Book</h2>
        <?php if($success) echo "<p style='color:green'>$success</p>"; ?>
        <?php if($error) echo "<p style='color:red'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="title" placeholder="Book Title" required>
            <input type="text" name="author" placeholder="Author" required>
            <input type="text" name="category" placeholder="Category" required>
            <textarea name="content" rows="4" placeholder="Description/Content"></textarea>
            <button type="submit" name="add_book">Save Book</button>
            <a href="dashboard.php" style="display: block; text-align: center; margin-top: 15px; text-decoration: none; color: #888;">Back to Dashboard</a>
        </form>
    </div>
</body>
</html>