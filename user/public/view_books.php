<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Fetch all books
$books_result = $conn->query("SELECT * FROM books ORDER BY created_at DESC");

// Fetch borrowed books by this user
$borrowed_result = $conn->query("
    SELECT bb.book_id
    FROM borrowed_books bb
    WHERE bb.user_id = $user_id AND bb.returned_at IS NULL
");

$borrowed_books = [];
if($borrowed_result) {
    while($row = $borrowed_result->fetch_assoc()){
        $borrowed_books[] = $row['book_id'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Books - Learning Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-teal: #3cb1c5; 
            --brand-dark: #2e8d9e;
            --bg-light: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --white: #ffffff;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--bg-light); 
            color: var(--text-main);
            line-height: 1.6;
        }

        header { 
            background: var(--white); 
            padding: 25px 60px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        header h1 { font-size: 22px; font-weight: 800; color: var(--brand-teal); }

        .dash-btn {
            text-decoration: none;
            color: var(--text-main);
            font-weight: 700;
            font-size: 14px;
            padding: 8px 20px;
            border-radius: 8px;
            background: #f1f5f9;
            transition: 0.3s;
        }
        .dash-btn:hover { background: var(--brand-teal); color: white; }

        .container { max-width: 1200px; margin: 40px auto; padding: 0 40px; }

        .section-header { margin-bottom: 30px; }
        .section-header h2 { font-size: 28px; font-weight: 800; letter-spacing: -0.5px; }
        .section-header p { color: var(--text-muted); font-size: 15px; }

        /* Books Grid */
        .books-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); 
            gap: 25px; 
        }

        .book-card { 
            background: var(--white); 
            padding: 25px; 
            border-radius: 16px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.02); 
            border: 1px solid #f1f5f9;
            transition: 0.3s;
            display: flex;
            flex-direction: column;
        }
        .book-card:hover { transform: translateY(-5px); border-color: var(--brand-teal); box-shadow: 0 10px 25px rgba(60, 177, 197, 0.1); }

        .category-tag {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 800;
            color: var(--brand-teal);
            letter-spacing: 1px;
            margin-bottom: 8px;
            display: block;
        }

        .book-card h4 { font-size: 18px; margin-bottom: 5px; color: var(--text-main); }
        .book-card .author { font-size: 14px; color: var(--text-muted); margin-bottom: 20px; flex-grow: 1; }

        .status-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 15px;
            border-top: 1px solid #f1f5f9;
        }

        .status-text { font-size: 12px; font-weight: 700; }
        .status-available { color: #10b981; }
        .status-borrowed { color: #f43f5e; }

        /* Unique Button Styling */
        .action-btn {
            border: none;
            padding: 10px 18px;
            border-radius: 10px;
            font-weight: 800;
            font-size: 13px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-borrow { background: var(--brand-teal); color: white; }
        .btn-borrow:hover { background: var(--brand-dark); transform: scale(1.05); }

        .btn-return { background: #fee2e2; color: #b91c1c; }
        .btn-return:hover { background: #fecaca; transform: scale(1.05); }

        .back-link { 
            margin-top: 40px; 
            display: inline-flex; 
            align-items: center; 
            gap: 8px;
            font-weight: 700; 
            color: var(--text-muted); 
            text-decoration: none; 
            font-size: 14px;
        }
        .back-link:hover { color: var(--brand-teal); }
    </style>
</head>
<body>

<header>
    <h1>Learning Hub</h1>
    <a href="dashboard.php" class="dash-btn">Dashboard</a>
</header>

<div class="container">
    <div class="section-header">
        <h2>All Library Books</h2>
        <p>Browse our complete catalog and manage your readings.</p>
    </div>

    <div class="books-grid">
        <?php while($book = $books_result->fetch_assoc()): 
            $is_borrowed = in_array($book['id'], $borrowed_books);
        ?>
        <div class="book-card">
            <span class="category-tag"><?php echo htmlspecialchars($book['category']); ?></span>
            <h4><?php echo htmlspecialchars($book['title']); ?></h4>
            <p class="author">by <?php echo htmlspecialchars($book['author']); ?></p>
            
            <div class="status-box">
                <span class="status-text <?php echo $is_borrowed ? 'status-borrowed' : 'status-available'; ?>">
                    <?php echo $is_borrowed ? '● Borrowed' : '● Available'; ?>
                </span>

                <?php if(!$is_borrowed): ?>
                <form action="borrow.php" method="POST">
                    <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                    <button type="submit" class="action-btn btn-borrow">Borrow</button>
                </form>
                <?php else: ?>
                <form action="return.php" method="POST">
                    <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                    <button type="submit" class="action-btn btn-return">Return</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <a href="dashboard.php" class="back-link">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Back to Dashboard
    </a>
</div>

</body>
</html>