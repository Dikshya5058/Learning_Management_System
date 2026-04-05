<?php
session_start();
require 'config/db.php';

// 1. Security Check
if (!isset($_SESSION['admin'])) {
    header("Location: index.html");
    exit();
}

// 2. Fetch actual book count for the stat card
$stmt = $pdo->query("SELECT COUNT(*) FROM books");
$totalBooks = $stmt->fetchColumn();

// 3. Fetch all books (Updated to include 'content' for the description)
$booksStmt = $pdo->query("SELECT id, title, author, category, content FROM books ORDER BY id DESC");
$books = $booksStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LMS | Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Ensures the dashboard isn't centered like the login page */
        body { 
            display: block !important; 
            height: auto; 
            padding: 20px; 
            background: #f8f9fa; 
        }
        
        .dashboard-wrapper {
            max-width: 1100px;
            margin: 0 auto;
        }

        .manage-section { 
            background: white; 
            padding: 25px; 
            border-radius: 12px; 
            margin-top: 30px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.05); 
        }

        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { text-align: left; padding: 12px; border-bottom: 1px solid #eee; }
        th { color: #6a5acd; font-size: 0.9rem; }

        /* Description styling to keep the table neat */
        .desc-column {
            max-width: 300px;
            font-size: 0.85rem;
            color: #666;
            line-height: 1.4;
        }

        /* Action button container */
        .action-links {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .delete-btn {
            color: #e24b4a;
            text-decoration: none;
            font-weight: bold;
            font-size: 0.9rem;
            padding: 5px 10px;
            border: 1px solid #e24b4a;
            border-radius: 6px;
            transition: 0.3s;
        }

        .delete-btn:hover {
            background: #e24b4a;
            color: white;
        }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <header class="admin-header">
            <h1>Admin Dashboard</h1>
            <button class="logout-btn-header" onclick="logout()">Logout</button>
        </header>

        <section class="manage-section">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3>Manage Existing Library</h3>
                <a href="add_book.php" style="text-decoration: none; background: #dcd6f7; color: #6a5acd; padding: 10px 15px; border-radius: 8px; font-weight: bold;">+ Add New Book</a>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Book Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Description</th> 
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($books) > 0): ?>
                        <?php foreach ($books as $book): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($book['title']); ?></td>
                            <td><?php echo htmlspecialchars($book['author']); ?></td>
                            <td><?php echo htmlspecialchars($book['category']); ?></td>
                            <td class="desc-column">
                                <?php echo nl2br(htmlspecialchars($book['content'])); ?>
                            </td>
                            <td>
                                <div class="action-links">
                                    <a href="edit_book.php?id=<?php echo $book['id']; ?>" class="edit-btn">Edit</a>
                                    <a href="delete_book.php?id=<?php echo $book['id']; ?>" class="delete-btn">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align:center; padding: 30px; color: #999;">No books found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>

    <script src="script.js"></script>
</body>
</html>