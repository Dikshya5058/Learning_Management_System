<?php
session_start();
require 'config/db.php'; 

if (!isset($_SESSION['admin'])) {
    header("Location: index.html");
    exit();
}

$success = "";
$error   = "";
$book    = null;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = (int) $_GET['id'];

// Fetch book details
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ? LIMIT 1");
$stmt->execute([$id]);
$book = $stmt->fetch();

if (!$book) {
    header("Location: dashboard.php");
    exit();
}

// Handle deletion
if (isset($_POST['confirm_delete'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
        if ($stmt->execute([$id])) {
            $success = "deleted";
            $deleted_title = $book['title'];
            $book = null;
        }
    } catch (PDOException $e) {
        $error = " Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Book — LMS</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { display: block; padding: 20px; background: #f0f2f5; }
        .main-container { max-width: 500px; margin: 60px auto; }
        .card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); text-align: center; }
        .warn-icon { font-size: 50px; margin-bottom: 15px; }
        .book-title { font-weight: bold; color: #6a5acd; font-size: 1.2rem; margin: 10px 0; }
        .btn-row { display: flex; gap: 10px; justify-content: center; margin-top: 25px; }
        .btn-confirm { background: #e24b4a; color: white; border: none; padding: 12px 25px; border-radius: 8px; cursor: pointer; font-weight: bold; }
        .btn-back { background: #eee; color: #333; padding: 12px 25px; border-radius: 8px; text-decoration: none; }
    </style>
</head>
<body>
    <div class="main-container">
        <?php if ($success === "deleted"): ?>
            <div class="card">
                <div class="warn-icon"></div>
                <h2>Deleted Successfully</h2>
                <p>"<strong><?= htmlspecialchars($deleted_title) ?></strong>" has been removed.</p>
                <a href="dashboard.php" class="btn-back" style="display:inline-block; margin-top:20px; background:#6a5acd; color:#fff;">Back to Dashboard</a>
            </div>
        <?php else: ?>
            <div class="card">
                <div class="warn-icon"></div>
                <h2>Delete Book?</h2>
                <p>Are you sure you want to delete:</p>
                <p class="book-title"><?= htmlspecialchars($book['title']) ?></p>
                <p style="color: #888; font-size: 0.9rem;">This action is permanent.</p>

                <form method="POST">
                    <div class="btn-row">
                        <a href="dashboard.php" class="btn-back">Cancel</a>
                        <button type="submit" name="confirm_delete" class="btn-confirm">Yes, Delete</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>