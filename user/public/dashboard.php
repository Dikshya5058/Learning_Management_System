<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// --- Logic for Unique Greeting ---
$greeting_prefix = "Welcome back,";
if (!isset($_SESSION['returning_user'])) {
    $greeting_prefix = "Great to have you,";
    $_SESSION['returning_user'] = true;
}

// Fetch books
$books_result = $conn->query("SELECT * FROM books LIMIT 6");

// Fetch borrowed status
$borrowed_result = $conn->query("SELECT book_id FROM borrowed_books WHERE user_id = $user_id AND returned_at IS NULL");
$borrowed_books = [];
while($row = $borrowed_result->fetch_assoc()){
    $borrowed_books[] = $row['book_id']; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Hub | Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --brand-teal: #3cb1c5; 
            --bg-light: #fdfdfd;
            --sidebar-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --accent-soft: rgba(60, 177, 197, 0.08);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-main);
            height: 100vh;
            overflow: hidden;
        }

        .dashboard-wrapper { display: flex; height: 100vh; }

        /* --- Sidebar Navigation --- */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            border-right: 1px solid #f1f5f9;
            display: flex;
            flex-direction: column;
            padding: 40px 0;
            z-index: 10;
        }

        .sidebar-header { padding: 0 30px 50px; }
        .logo-box { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .logo-sq { width: 38px; height: 38px; background: var(--brand-teal); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; box-shadow: 0 8px 15px rgba(60, 177, 197, 0.2); }
        .logo-text h1 { font-size: 18px; font-weight: 800; color: var(--brand-teal); line-height: 1; }
        .logo-text span { font-size: 9px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; }

        .sidebar-nav { flex-grow: 1; }
        .sidebar-nav ul { list-style: none; }
        .sidebar-nav li a {
            display: flex;
            align-items: center;
            padding: 14px 30px;
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s;
            position: relative;
        }

        .sidebar-nav li a:hover, .sidebar-nav li a.active { color: var(--brand-teal); background: var(--accent-soft); }
        .sidebar-nav li a.active::after { content: ''; position: absolute; right: 0; height: 20px; width: 4px; background: var(--brand-teal); border-radius: 4px 0 0 4px; }
        .sidebar-nav li a .icon { margin-right: 15px; font-size: 18px; opacity: 0.8; }

        .sidebar-footer { padding: 20px 30px; }
        .logout-link { display: flex; align-items: center; color: #f43f5e; text-decoration: none; font-weight: 700; font-size: 14px; gap: 10px; }

        /* --- Main Content Layout --- */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            padding: 0 60px;
        }

        .top-nav {
            display: flex;
            justify-content: flex-end; /* Push greeting to the right */
            align-items: center;
            padding: 40px 0 20px 0; /* Reduced bottom padding */
        }

        /* Unique Greeting UI */
        .user-greeting {
            background: white;
            padding: 10px 25px;
            border-radius: 100px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-greeting .avatar { width: 32px; height: 32px; background: var(--brand-teal); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 12px; }
        .greet-txt { font-size: 13px; font-weight: 600; }
        .greet-txt span { color: var(--brand-teal); font-weight: 800; }

        /* Professional Header Section */
        .hero-section { margin-bottom: 50px; }
        .hero-section h2 { font-size: 32px; font-weight: 800; letter-spacing: -1px; margin-bottom: 8px; }
        .hero-section p { color: var(--text-muted); font-size: 15px; max-width: 500px; line-height: 1.6; }

        /* Book Display Grid */
        .book-shelf {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 60px;
        }

        .book-card {
            background: white;
            border-radius: 20px;
            padding: 15px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid #f1f5f9;
        }

        .book-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.06); border-color: var(--brand-teal); }

        .book-thumb {
            width: 100%;
            aspect-ratio: 2/3;
            background: #f8fafc;
            border-radius: 14px;
            margin-bottom: 15px;
            overflow: hidden;
            position: relative;
        }

        .book-thumb img { width: 100%; height: 100%; object-fit: cover; }
        
        .borrow-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .bg-avail { background: #dcfce7; color: #15803d; }
        .bg-brwd { background: #fee2e2; color: #b91c1c; }

        .book-card h3 { font-size: 15px; font-weight: 700; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .book-card p { font-size: 12px; color: var(--text-muted); margin-bottom: 12px; }

        .shelf-action {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--accent-soft);
            padding: 25px 40px;
            border-radius: 24px;
            margin-bottom: 80px;
        }

        .shelf-action span { font-weight: 600; color: var(--brand-teal); }
        .btn-main {
            background: var(--brand-teal);
            color: white;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(60, 177, 197, 0.3);
        }
        .btn-main:hover { background: var(--brand-hover); transform: scale(1.05); }

    </style>
</head>
<body>

<div class="dashboard-wrapper">
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="#" class="logo-box">
                <div class="logo-sq">📖</div>
                <div class="logo-text">
                    <h1>Learning Hub</h1>
                    <span>Library Management</span>
                </div>
            </a>
        </div>

        <nav class="sidebar-nav">
            <ul>
                <li><a href="dashboard.php" class="active"><span class="icon">🏠</span> Dashboard</a></li>
                <li><a href="borrow.php"><span class="icon">📖</span> Borrow Books</a></li>
                <li><a href="my_borrowed.php"><span class="icon">📑</span> View Borrowed</a></li>
                <li><a href="return.php"><span class="icon">↩️</span> Return Books</a></li>
                <li><a href="view_books.php"><span class="icon">📚</span> View All Books</a></li>
                <li><a href="#"><span class="icon">💻</span> Online Learning</a></li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <a href="logout.php" class="logout-link"><span>🚪</span> Log Out</a>
        </div>
    </aside>

    <main class="main-content">
        <nav class="top-nav">
            <div class="user-greeting">
                <div class="avatar"><?php echo strtoupper(substr($user_name, 0, 1)); ?></div>
                <div class="greet-txt">
                    <?php echo $greeting_prefix; ?> <span><?php echo htmlspecialchars($user_name); ?></span>
                </div>
            </div>
        </nav>

        <header class="hero-section">
            <h2>Explore Featured Books</h2>
            <p>Dive into our curated collection of literature, science, and technology. Your next big idea starts with a single page.</p>
        </header>

        <section class="book-shelf">
            <?php while($book = $books_result->fetch_assoc()): 
                $is_borrowed = in_array($book['id'], $borrowed_books);
            ?>
            <div class="book-card">
                <div class="book-thumb">
                    <img src="../assets/images/placeholder.jpg" alt="Cover">
                    <div class="borrow-badge <?php echo $is_borrowed ? 'bg-brwd' : 'bg-avail'; ?>">
                        <?php echo $is_borrowed ? 'Borrowed' : 'Available'; ?>
                    </div>
                </div>
                <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                <p><?php echo htmlspecialchars($book['author']); ?></p>
            </div>
            <?php endwhile; ?>
        </section>

        <div class="shelf-action">
            <span>Ready to dive in? Check out the books you can borrow today.</span>
            <a href="view_books.php" class="btn-main">View Full Book List &rarr;</a>
        </div>
    </main>
</div>

</body>
</html>