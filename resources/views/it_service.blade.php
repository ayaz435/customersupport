<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XLSERP - Business Solutions</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* Header Styles */
        .header {
            background: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .logo {
            font-size: 2rem;
            font-weight: bold;
            color: #2563eb;
        }

        .logo span {
            color: #06b6d4;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
            cursor: pointer;
        }

        .nav-links a:hover {
            color: #2563eb;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
            padding: 8rem 0 4rem;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            padding: 0 2rem;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 600;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            color: #1f2937;
        }

        .hero-content .highlight {
            color: #2563eb;
        }

        .hero-content p {
            font-size: 1.1rem;
            color: #6b7280;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .cta-button {
            background: #2563eb;
            color: white;
            padding: 1rem 2rem;
            border: 2px solid #2563eb;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .cta-button:hover {
            background: transparent;
            color: #2563eb;
        }

        .hero-images {
            position: relative;
        }

        .dashboard-preview {
            width: 100%;
            max-width: 500px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            background: white;
            padding: 1rem;
        }

        .dashboard-mockup {
            width: 100%;
            height: 300px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }

        .sidebar-mock {
            position: absolute;
            left: 0;
            top: 0;
            width: 200px;
            height: 100%;
            background: #047857;
            padding: 1rem;
        }

        .sidebar-item {
            width: 100%;
            height: 8px;
            background: rgba(255,255,255,0.3);
            margin: 8px 0;
            border-radius: 4px;
        }

        .chart-area {
            position: absolute;
            right: 20px;
            top: 20px;
            width: 250px;
            height: 120px;
            background: rgba(255,255,255,0.9);
            border-radius: 8px;
            padding: 10px;
        }

        .chart-mock {
            width: 100%;
            height: 80px;
            background: linear-gradient(45deg, #22c55e 30%, #eab308 70%);
            border-radius: 4px;
            opacity: 0.8;
        }

        /* About Section */
        .about {
            background: #e0f2fe;
            padding: 6rem 0;
        }

        .about-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .about h2 {
            text-align: center;
            font-size: 3rem;
            color: #1f2937;
            margin-bottom: 4rem;
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .about-images {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .about-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }

        .about-image::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,0.9);
            border-radius: 50%;
        }

        .about-text h3 {
            font-size: 1.2rem;
            color: #2563eb;
            margin-bottom: 1rem;
        }

        .about-text h4 {
            font-size: 2rem;
            color: #1f2937;
            margin-bottom: 2rem;
        }

        .about-text p {
            color: #6b7280;
            line-height: 1.8;
            margin-bottom: 2rem;
        }

        /* Features Section */
        .features {
            background: white;
            padding: 6rem 0;
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .features h2 {
            text-align: center;
            font-size: 3rem;
            color: #1f2937;
            margin-bottom: 2rem;
        }

        .features-description {
            text-align: center;
            color: #6b7280;
            max-width: 800px;
            margin: 0 auto 4rem;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .feature-card {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s;
        }

        .feature-card:hover {
            border-color: #2563eb;
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: #eff6ff;
            border-radius: 15px;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 1.5rem;
        }

        .feature-card h4 {
            font-size: 1.5rem;
            color: #1f2937;
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: #6b7280;
            line-height: 1.6;
        }

        /* ERP Section */
        .erp {
            background: #e0f2fe;
            padding: 6rem 0;
        }

        .erp-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .erp h2 {
            text-align: center;
            font-size: 3rem;
            color: #1f2937;
            margin-bottom: 4rem;
        }

        .erp-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .erp-text h3 {
            font-size: 2.5rem;
            color: #1f2937;
            margin-bottom: 2rem;
        }

        .erp-text p {
            color: #6b7280;
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .erp-visual {
            position: relative;
        }

        .erp-dashboard {
            width: 100%;
            height: 300px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 15px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .slack-card, .referral-card {
            position: absolute;
            background: white;
            border-radius: 10px;
            padding: 1rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .slack-card {
            top: -20px;
            right: -50px;
            width: 200px;
            height: 120px;
        }

        .referral-card {
            bottom: -30px;
            right: -30px;
            width: 180px;
            height: 140px;
        }

        /* FAQ Section */
        .faq {
            background: white;
            padding: 6rem 0;
        }

        .faq-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .faq h2 {
            text-align: center;
            font-size: 3rem;
            color: #1f2937;
            margin-bottom: 1rem;
        }

        .faq h2 .highlight {
            color: #2563eb;
        }

        .faq-description {
            text-align: center;
            color: #6b7280;
            max-width: 700px;
            margin: 0 auto 4rem;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .faq-items {
            display: grid;
            gap: 1rem;
            max-width: 800px;
            margin: 0 auto;
        }

        .faq-item {
            background: #a5b4fc;
            border-radius: 10px;
            padding: 2rem;
            opacity: 0.7;
            transition: all 0.3s;
            cursor: pointer;
        }

        .faq-item:hover {
            opacity: 1;
            transform: translateX(5px);
        }

        .faq-item.active {
            opacity: 1;
            background: #6366f1;
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 4rem 0 2rem;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .footer-logo-icon {
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .footer-section h4 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            color: #e5e7eb;
        }

        .footer-section p, .footer-section a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            line-height: 1.8;
        }

        .footer-section a:hover {
            color: white;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-link {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .social-link:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.2);
            padding-top: 2rem;
            display: flex;
            justify-content: between;
            align-items: center;
            color: rgba(255,255,255,0.6);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-container, .about-content, .erp-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }

            .nav-links {
                display: none;
            }

            .footer-content {
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
            }
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeInUp 0.6s ease-out forwards;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="nav-container">
            <div class="logo">
                XLS<span>ERP</span>
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a onclick="scrollToSection('home')">Home</a></li>
                    <li><a onclick="scrollToSection('about')">About</a></li>
                    <li><a onclick="scrollToSection('features')">Feature</a></li>
                    <li><a onclick="scrollToSection('footer')">Contact Us</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1>
                    IT Services In Calgary<br>
                    Focused <span class="highlight">On The Dynamic<br>
                    Growth Of</span> Your Organization
                </h1>
                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting 
                    industry. Lorem Ipsum has been the industry's standard dummy 
                    text ever since the 1500s
                </p>
                <a href="#" class="cta-button">Get a free Demo</a>
            </div>
            <div class="hero-images">
                <div class="dashboard-preview">
                    <div class="dashboard-mockup">
                        <div class="sidebar-mock">
                            <div class="sidebar-item"></div>
                            <div class="sidebar-item"></div>
                            <div class="sidebar-item"></div>
                            <div class="sidebar-item"></div>
                            <div class="sidebar-item"></div>
                        </div>
                        <div class="chart-area">
                            <div class="chart-mock"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="about-container">
            <h2>About Us</h2>
            <div class="about-content">
                <div class="about-images">
                    <div class="about-image"></div>
                    <div class="about-image"></div>
                    <div class="about-image"></div>
                    <div class="about-image"></div>
                </div>
                <div class="about-text">
                    <h3>Get Best IT Solution Company 2025</h3>
                    <h4>Trust Our Best IT Solution For Your Business</h4>
                    <p>
                        It has roots in a piece of classical Latin literature from 45 
                        BC, making it over 2000 years old. Richard McClintock, a 
                        Latin professor at Hampden-Sydney College in Virginia, 
                        looked up one of the more obscure Latin words, consectetur, 
                        from a Lorem Ipsum passage, and going through the cites of 
                        the word in classical literature, discovered the undoubtable 
                        source. It has roots in a piece of classical Latin literature 
                        from 45 BC, making it over 2000 years old.
                    </p>
                    <a href="#" class="cta-button">Get a free Demo</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="features-container">
            <h2>XLSERP Feature</h2>
            <p class="features-description">
                It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. 
                Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one 
                of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going 
                through the cites of the word in classical literature, discovered the undoubtable source.
            </p>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">💻</div>
                    <h4>POS System</h4>
                    <p>It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h4>CRM System</h4>
                    <p>It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h4>HRM System</h4>
                    <p>It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🌐</div>
                    <h4>Website Setting</h4>
                    <p>It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📋</div>
                    <h4>Project System</h4>
                    <p>It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💰</div>
                    <h4>Account System</h4>
                    <p>It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</p>
                </div>
            </div>
            
            <div style="text-align: center;">
                <a href="#" class="cta-button">Get a free Demo</a>
            </div>
        </div>
    </section>

    <!-- ERP Solutions Section -->
    <section class="erp">
        <div class="erp-container">
            <h2>ERP Solutions</h2>
            <div class="erp-content">
                <div class="erp-text">
                    <h3>ERP Solutions For Businesses</h3>
                    <p>
                        Effective tools for your business management needs, made with 
                        the largest technologies.
                    </p>
                </div>
                <div class="erp-visual">
                    <div class="erp-dashboard">
                        <div class="slack-card">
                            <h4 style="color: #333; font-size: 0.9rem; margin-bottom: 0.5rem;">Slack Bot</h4>
                            <div style="display: flex; gap: 5px; margin-bottom: 0.5rem;">
                                <div style="width: 20px; height: 20px; background: #ff6b6b; border-radius: 50%;"></div>
                                <div style="width: 20px; height: 20px; background: #4ecdc4; border-radius: 50%;"></div>
                                <div style="width: 20px; height: 20px; background: #45b7d1; border-radius: 50%;"></div>
                            </div>
                        </div>
                        <div class="referral-card">
                            <h4 style="color: #333; font-size: 0.9rem; margin-bottom: 0.5rem;">Referrals</h4>
                            <div style="width: 80px; height: 80px; border: 8px solid #6366f1; border-top: 8px solid #f59e0b; border-radius: 50%; margin: 0 auto;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="faq">
        <div class="faq-container">
            <h2>Frequently <span class="highlight">Asked Questions</span></h2>
            <p class="faq-description">
                Find comprehensive answers to frequently asked questions, offering insights and solutions to common 
                queries. If your specific question isn't covered, don't hesitate to get in touch with us for personalized 
                support
            </p>
            <div class="faq-items">
                <div class="faq-item active"></div>
                <div class="faq-item"></div>
                <div class="faq-item"></div>
                <div class="faq-item"></div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="footer" class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <div class="footer-logo-icon">ES</div>
                        <div>
                            <div style="font-size: 0.8rem; opacity: 0.8;">EXCELSOFT TECHNOLOGIES CO. LLC</div>
                        </div>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Address:</h4>
                    <p>The Binary by OMNIYAT<br>Business Bay</p>
                </div>
                <div class="footer-section">
                    <h4>Contact Us:</h4>
                    <p>📧 Info@excelstech.ae</p>
                    <p>📞 +971 52 7559 797</p>
                    <p>📞 +92 335 2171 023</p>
                </div>
                <div class="footer-section">
                    <h4>Follow Us:</h4>
                    <div class="social-links">
                        <a href="#" class="social-link">f</a>
                        <a href="#" class="social-link">in</a>
                        <a href="#" class="social-link">x</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© 2025 | All rights reserved.</p>
                <p style="margin-left: auto;">Terms & Conditions Privacy Policy</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling function
        function scrollToSection(sectionId) {
            const element = document.getElementById(sectionId);
            const headerHeight = document.querySelector('.header').offsetHeight;
            const elementPosition = element.offsetTop - headerHeight;
            
            window.scrollTo({
                top: elementPosition,
                behavior: 'smooth'
            });
        }

        // Add scroll animations
        function addScrollAnimations() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                    }
                });
            }, observerOptions);

            // Observe sections
            document.querySelectorAll('section').forEach(section => {
                observer.observe(section);
            });
        }

        // FAQ interactivity
        function initFAQ() {
            const faqItems = document.querySelectorAll('.faq-item');
            faqItems.forEach((item, index) => {
                item.addEventListener('click', () => {
                    faqItems.forEach(faq => faq.classList.remove('active'));
                    item.classList.add('active');
                });
            });
        }

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            addScrollAnimations();
            initFAQ();
        });

        // Header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.querySelector('.header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
                header.style.backdropFilter = 'blur(10px)';
            } else {
                header.style.background = 'white';
                header.style.backdropFilter = 'none';
            }
        });
    </script>
</body>
</html>