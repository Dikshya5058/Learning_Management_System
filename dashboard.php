<?php
session_start();
require 'db.php';

// Security: If not logged in as admin, redirect to login page
if (!isset($_SESSION['admin'])) {
    header("Location: index.html");
    exit();
}

// Fetch actual book count from database
$stmt = $pdo->query("SELECT COUNT(*) FROM books");
$totalBooks = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LMS | Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { display: block; height: auto; padding: 20px; background: #f8f9fa; }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <header class="admin-header">
            <div class="header-left">
                <div class="admin-icon">🛡️</div>
                <div>
                    <h1>Admin Dashboard</h1>
                    <p>Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?></p>
                </div>
            </div>
            <button class="logout-btn-header" onclick="logout()">Logout</button>
        </header>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <p class="stat-label">Total Books</p>
                    <h2 class="stat-value"><?php echo $totalBooks; ?></h2>
                </div>
                <div class="stat-icon" style="font-size: 2rem;">📖</div>
            </div>
        </div>

        <section class="quick-actions-section">
            <h3>Quick Actions</h3>
            <div class="actions-grid">
                <a href="add_book.php" class="action-card primary-action">
                    <span class="plus-icon">+</span>
                    <span>Add New Book</span>
                </a>
            </div>
        </section>
    </div>
    <script src="script.js"></script>
</body>
</html>