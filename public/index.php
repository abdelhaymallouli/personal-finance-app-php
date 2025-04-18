<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MonBudget - Smart Financial Tracking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/index.css?v=<?php echo time(); ?>">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <a href="index.html" class="logo">
            <i class="fas fa-wallet logo-icon"></i>
            <span class="logo-text">MonBudget</span>
        </a>
        <nav class="nav-links">
            <a href="#features" class="nav-link">Features</a>
            <a href="#testimonials" class="nav-link">Testimonials</a>
            <a href="#pricing" class="nav-link">Pricing</a>
            <a href="#about" class="nav-link">About</a>
        </nav>
        <div class="auth-buttons">
            <a href="login.php" class="btn btn-outline">Login</a>
            <a href="register.php" class="btn btn-primary">Sign Up Free</a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Take Control of Your Financial Life</h1>
            <p class="hero-subtitle">MonBudget helps you track expenses, manage your budget, and achieve your financial goals with an intuitive dashboard and powerful analysis tools.</p>
            <div class="hero-buttons">
                <a href="register.php" class="btn btn-primary">Get Started - It's Free</a>
                <a href="#learn-more" class="btn btn-outline">Learn More</a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <span class="stat-value">50K+</span>
                    <span class="stat-label">Active Users</span>
                </div>
                <div class="hero-stat">
                    <span class="stat-value">€2.5M</span>
                    <span class="stat-label">Saved by Users</span>
                </div>
                <div class="hero-stat">
                    <span class="stat-value">4.8/5</span>
                    <span class="stat-label">User Rating</span>
                </div>
            </div>
        </div>
        <div class="hero-image">
            <img src="../uploads/img/dashboard.svg" alt="MonBudget Dashboard Preview">
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <h2 class="section-title">Powerful Features</h2>
        <p class="section-subtitle">Everything you need to manage your finances in one place, with intuitive tools and insights.</p>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="feature-title">Expense Tracking</h3>
                <p class="feature-description">Easily track your expenses across multiple categories. Understand where your money goes with visual breakdowns and analysis.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3 class="feature-title">Budget Planning</h3>
                <p class="feature-description">Set monthly budgets by category and track your progress. Get notifications when you're approaching your limits.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <h3 class="feature-title">Financial Dashboard</h3>
                <p class="feature-description">Get a complete overview of your finances with our intuitive dashboard that displays all important metrics at a glance.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-piggy-bank"></i>
                </div>
                <h3 class="feature-title">Savings Goals</h3>
                <p class="feature-description">Set savings targets and track your progress. Visualize your path to financial milestones and stay motivated.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3 class="feature-title">Mobile Access</h3>
                <p class="feature-description">Track expenses on the go with our mobile-friendly design. Update your budget anytime, anywhere.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h3 class="feature-title">Secure & Private</h3>
                <p class="feature-description">Your financial data is encrypted and secure. We never share your personal information with third parties.</p>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonials">
        <h2 class="section-title">What Our Users Say</h2>
        <p class="section-subtitle">Thousands of people are taking control of their finances with MonBudget.</p>
        
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <p class="testimonial-text">"MonBudget has completely changed how I manage my money. The expense tracking is intuitive, and the visual breakdown helps me understand where I can save more."</p>
                <div class="testimonial-author">
                    <div class="author-avatar">SW</div>
                    <div class="author-info">
                        <div class="author-name">Sophie Wilson</div>
                        <div class="author-title">Using MonBudget for 2 years</div>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <p class="testimonial-text">"I've tried many budget apps, but MonBudget stands out with its clean interface and powerful analysis tools. I've saved over €3,000 in the past year!"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">TD</div>
                    <div class="author-info">
                        <div class="author-name">Thomas Dubois</div>
                        <div class="author-title">Small Business Owner</div>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <p class="testimonial-text">"As a student, MonBudget helps me keep track of my limited funds and plan for future expenses. The savings goals feature is perfect for planning big purchases."</p>
                <div class="testimonial-author">
                    <div class="author-avatar">EM</div>
                    <div class="author-info">
                        <div class="author-name">Elena Martinez</div>
                        <div class="author-title">University Student</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-box">
            <h2 class="cta-title">Start Your Financial Journey Today</h2>
            <p class="cta-text">Join thousands of users who are taking control of their finances with MonBudget. Sign up for free and start tracking your expenses today.</p>
            <a href="register.php" class="btn btn-light">Create Free Account</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-column">
                <div class="footer-logo">
                    <i class="fas fa-wallet logo-icon"></i>
                    <span class="logo-text">MonBudget</span>
                </div>
                <p class="footer-description">Smart financial tracking and budgeting tools to help you achieve your financial goals.</p>
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            
            <div class="footer-column">
                <h3>Product</h3>
                <div class="footer-links">
                    <a href="#" class="footer-link">Features</a>
                    <a href="#" class="footer-link">Pricing</a>
                    <a href="#" class="footer-link">Testimonials</a>
                    <a href="#" class="footer-link">FAQ</a>
                </div>
            </div>
            
            <div class="footer-column">
                <h3>Company</h3>
                <div class="footer-links">
                    <a href="#" class="footer-link">About Us</a>
                    <a href="#" class="footer-link">Careers</a>
                    <a href="#" class="footer-link">Blog</a>
                    <a href="#" class="footer-link">Contact</a>
                </div>
            </div>
            
            <div class="footer-column">
                <h3>Legal</h3>
                <div class="footer-links">
                    <a href="#" class="footer-link">Privacy Policy</a>
                    <a href="#" class="footer-link">Terms of Service</a>
                    <a href="#" class="footer-link">Cookie Policy</a>
                    <a href="#" class="footer-link">Security</a>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="copyright">© 2025 MonBudget. All rights reserved.</div>
            <div>Made with <i class="fas fa-heart" style="color: var(--negative-red);"></i> in Tangier</div>
        </div>
    </footer>
</body>
</html>