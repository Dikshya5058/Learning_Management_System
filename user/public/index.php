<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Hub</title>

<style>
:root {
    --primary: #3cb1c5; /* This matches your requested color */
    --primary-dark: #357abd;
    --bg: #f7faff;
    --text: #1a1a1a;
    --subtext: #6b7280;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    background: var(--bg);
    color: var(--text);
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 80px;
    background: white;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
}

.logo {
    font-size: 22px;
    font-weight: 800;
    color: var(--primary);
}

.nav-auth {
    display: flex;
    gap: 12px;
}

.btn {
    padding: 10px 22px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
}

.btn-outline {
    border: 2px solid var(--primary);
    color: var(--primary);
}

.btn-outline:hover {
    background: var(--primary);
    color: white;
}

.btn-primary {
    background: var(--primary);
    color: white;
    /* Updated shadow to match the new primary color */
    box-shadow: 0 8px 20px rgba(60, 177, 197, 0.3); 
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

.hero {
    text-align: center;
    padding: 100px 20px 60px;
}

.hero h1 {
    font-size: 64px;
    font-weight: 800;
}

.hero p {
    margin: 20px 0 30px;
    color: var(--subtext);
    font-size: 18px;
}

.features {
    padding: 80px;
    text-align: center;
}

.features h2 {
    font-size: 32px;
    margin-bottom: 50px;
}

.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
}

.card {
    background: white;
    padding: 30px;
    border-radius: 18px;
    border: 1px solid #eef2f7;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(74,144,226,0.15);
}

.icon {
    font-size: 30px;
    margin-bottom: 15px;
}

.card h3 {
    margin-bottom: 10px;
}

.card p {
    color: var(--subtext);
    font-size: 14px;
}

/* MODIFIED PART: Background changed to flat #3cb1c5 */
.cta {
    background: var(--primary); /* Uses #3cb1c5 */
    color: white;
    text-align: center;
    padding: 80px 20px;
    border-radius: 40px 40px 0 0;
    margin-top: 60px;
}

.cta h2 {
    font-size: 36px;
    margin-bottom: 10px;
}

.cta p {
    margin-bottom: 25px;
    color: #eaf3ff;
}

/* CTA BUTTON SPECIFIC: Matching the button color in your screenshot */
.cta .btn-primary {
    background: #56c2d6; /* Slightly lighter teal to stand out against the background */
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

footer {
    text-align: center;
    padding: 30px;
    font-size: 14px;
    color: #777;
}
</style>

</head>

<body>

<nav class="navbar">
    <div class="logo">Learning Hub</div>
    <div class="nav-auth">
        <a href="login.php" class="btn btn-outline">Log In</a>
        <a href="register.php" class="btn btn-primary">Sign Up</a>
    </div>
</nav>

<section class="hero">
    <h1>Smart Digital Library</h1>
    <p>Discover, borrow, and manage books with ease.</p>
    <a href="register.php" class="btn btn-primary">Get Started</a>
</section>

<section class="features">
    <h2>What You Can Do</h2>

<div class="grid">

    <div class="card">
        <div class="icon">📚</div>
        <h3>Browse Books</h3>
        <p>Explore available books in different categories.</p>
    </div>

    <div class="card">
        <div class="icon">⚡</div>
        <h3>Borrow Instantly</h3>
        <p>Borrow books easily with automatic due dates.</p>
    </div>

    <div class="card">
        <div class="icon">📅</div>
        <h3>Track Books</h3>
        <p>Monitor borrowed books and return dates.</p>
    </div>

    <div class="card">
        <div class="icon">📖</div>
        <h3>Read Online</h3>
        <p>Access reading features anytime.</p>
    </div>

</div>

</section>

<section class="cta">
    <h2>Start Your Learning Journey</h2>
    <p>Create your account and explore your library today.</p>
    <a href="register.php" class="btn btn-primary">Create Account</a>
</section>

<footer>
    © 2026 Learning Hub - Library Management System
</footer>

</body>
</html>