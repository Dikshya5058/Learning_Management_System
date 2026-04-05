<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Hub - Modern Library Management System</title>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="logo">
        <div class="logo-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
        </div>
        <div class="logo-text">
            <span class="brand-name">Learning Hub</span>
            <span class="brand-sub">Modern Library Management System</span>
        </div>
    </div>
    <div class="nav-links">
        <a href="login.php" class="nav-signin-btn">Log In</a>
        <a href="register.php" class="nav-getstarted-btn">Sign Up</a>
    </div>
</nav>

<header class="hero-section">
    <h1>Your Digital Learning Library</h1>
    <p>A comprehensive Learning Management System for borrowing, reading, and managing books online. Powered by AI for personalized recommendations.</p>
    <div class="hero-actions">
        <a href="register.php" class="btn-create-acc">Create Account</a>
        <a href="javascript:void(0);" class="btn-admin-access" style="cursor: not-allowed; opacity: 0.6;">Admin Access</a>
    </div>
</header>

<section class="features-section">
    <h2 class="section-title">Key Features</h2>
    <div class="features-grid">
        <div class="feature-item">
            <div class="feat-icon blue-bg">🔍</div>
            <h3>Smart Search</h3>
            <p>Advanced search and filtering to find exactly what you need. Search by title, author, or category.</p>
        </div>
        <div class="feature-item">
            <div class="feat-icon orange-bg">📖</div>
            <h3>Read Online</h3>
            <p>Read books directly in your browser with our digital reader. Adjust zoom and navigate easily.</p>
        </div>
        <div class="feature-item">
            <div class="feat-icon light-blue-bg">📈</div>
            <h3>AI Recommendations</h3>
            <p>Get personalized book recommendations based on your reading history and preferences.</p>
        </div>
        <div class="feature-item">
            <div class="feat-icon light-orange-bg">💬</div>
            <h3>AI Chatbot</h3>
            <p>24/7 AI assistant to help you find books, check due dates, and answer questions.</p>
        </div>
    </div>
</section>

<section class="how-works-section">
    <h2 class="section-title">How It Works</h2>
    <div class="steps-container">
        <div class="step-card">
            <div class="step-num step-blue">1</div>
            <h3>Create Account</h3>
            <p>Sign up for free and get instant access to our entire digital library catalog.</p>
        </div>
        <div class="step-card">
            <div class="step-num step-orange">2</div>
            <h3>Browse & Borrow</h3>
            <p>Search our collection, borrow books you like, and keep them for up to 14 days.</p>
        </div>
        <div class="step-card">
            <div class="step-num step-dark">3</div>
            <h3>Read & Learn</h3>
            <p>Read online or download for offline access. Return when done and borrow more!</p>
        </div>
    </div>
</section>

<section class="demo-box-container">
    <div class="demo-card">
        <h2>Try It Now - Demo Credentials</h2>
        <p>Use these credentials to explore the system</p>
        <div class="demo-flex">
            <div class="demo-item user-cred">
                <strong>User Account</strong>
                <p>Email: user@test.com</p>
                <p>Password: user123</p>
                <a href="login.php" class="demo-login-btn user-btn">Login as User</a>
            </div>
            <div class="demo-item admin-cred">
                <strong>Admin Account</strong>
                <p>Email: admin@test.com</p>
                <p>Password: admin123</p>
                <a href="javascript:void(0);" class="demo-login-btn admin-btn" style="cursor: not-allowed; opacity: 0.6;">Login as Admin</a>
            </div>
        </div>
    </div>
</section>

<footer class="main-footer">
    <p>© 2026 Learning Hub - Modern Library Management System</p>
    <p>Built with PHP and MySQL</p>
</footer>

</body>
</html>