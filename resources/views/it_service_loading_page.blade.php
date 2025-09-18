<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XLSERP - IT Services In Calgary</title>
    
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .grid-item {
            position: relative;
            padding: 20px;
            border-radius: 25px;
            background: 
                linear-gradient(white, white) padding-box,
                linear-gradient(to bottom, #4566B0, #89B9E3) border-box;
            border: 4px solid transparent;
            background-origin: padding-box, border-box;
            background-clip: padding-box, border-box;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            /*text-align: center;*/
            min-height: 100px;
            /*display: flex;*/
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Method 1: Using grid-column-start to center last 2 items */
        /*.grid-item:nth-child(7) {*/
        /*    grid-column-start: 1;*/
        /*    grid-column-end: 2;*/
        /*    margin-left: 50%;*/
        /*}*/

        /*.grid-item:nth-child(8) {*/
        /*    grid-column-start: 2;*/
        /*    grid-column-end: 4;*/
        /*    margin-right: 50%;*/
        /*}*/

        /* Alternative Method 2: Better approach using CSS Grid positioning */
        .grid-container-v2 {
            display: grid;
            grid-template-columns: repeat(6, 1fr); /* Use 6 columns for easier centering */
            gap: 20px;
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            margin-top: 50px;
        }

        .grid-container-v2 .grid-item {
            grid-column: span 2; /* Each item spans 2 columns */
        }

        .grid-container-v2 .grid-item:nth-child(7) {
            grid-column: 2 / 4; /* Center the 7th item */
        }

        .grid-container-v2 .grid-item:nth-child(8) {
            grid-column: 4 / 6; /* Center the 8th item */
        }
        
        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .grid-container-v2 {
                grid-template-columns: repeat(2, 1fr); /* 2 columns on mobile */
                gap: 15px;
                padding: 15px;
            }

            .grid-container-v2 .grid-item {
                grid-column: span 1; /* Each item spans 1 column */
            }

            .grid-container-v2 .grid-item:nth-child(7),
            .grid-container-v2 .grid-item:nth-child(8) {
                grid-column: auto; /* Reset positioning for mobile */
            }
        }

        @media (max-width: 480px) {
            .grid-container-v2 {
                grid-template-columns: 1fr; /* Single column on small mobile */
                gap: 12px;
                padding: 12px;
            }

            .grid-item {
                padding: 15px;
                min-height: 80px;
                font-size: 14px;
            }
        }

        /* Tablet responsive */
        @media (min-width: 769px) and (max-width: 1024px) {
            .grid-container-v2 {
                grid-template-columns: repeat(4, 1fr); /* 4 columns on tablet */
                gap: 18px;
            }

            .grid-container-v2 .grid-item {
                grid-column: span 2; /* Each item spans 2 columns */
            }

            .grid-container-v2 .grid-item:nth-child(7) {
                grid-column: 1 / 3; /* Position 7th item */
            }

            .grid-container-v2 .grid-item:nth-child(8) {
                grid-column: 3 / 5; /* Position 8th item */
            }
        }

    </style>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
        }
        
        @import url('https://fonts.googleapis.com/css2?family=Piazzolla&display=swap');

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Piazzolla', serif;
        }
        .gradient-border-container {
            background: linear-gradient(to bottom, #4566B0, #89B9E3);
            border-radius: 15px;
            padding: 4px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            max-width: 600px;
            width: 100%;
        }

        .gradient-border-container::before {
            content: '';
            display: block;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 11px;
            padding: 20px;
            width: 100%;
            box-sizing: border-box;
        }

        /* Header Styles */
        .header {
            background: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1.25rem;
            width: 100%;
        }

        .nav-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .logo {
            font-size: clamp(1.2rem, 2.5vw, 1.5rem);
            font-weight: bold;
            color: #4A90E2;
            flex-shrink: 0;
        }

        .logo img {
            max-height: 50px;
            width: auto;
            object-fit: contain;
        }

        .logo span {
            color: #00C851;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: clamp(1rem, 3vw, 2.5rem);
            flex-wrap: wrap;
        }

        .nav-menu a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
            font-size: clamp(0.9rem, 1.2vw, 1rem);
        }

        .nav-menu a:hover {
            color: #4A90E2;
        }

        /* Hero Section */
        .hero {
            /*background: linear-gradient(135deg, #f8fbff 0%, #e3f2fd 100%);*/
            padding: clamp(2rem, 8vw, 5rem) 0;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: clamp(2rem, 5vw, 3.75rem);
            align-items: center;
            margin: clamp(1rem, 2vw, 1rem) 0;
        }

        .hero-text h1 {
            font-size: clamp(1.8rem, 4vw, 3rem);
            color: #333;
            margin-bottom: 1.25rem;
            line-height: 1.2;
        }

        .hero-text .highlight {
            color: #4A90E2;
        }

        .hero-text p {
            font-size: clamp(1rem, 1.5vw, 1.125rem);
            color: #666;
            margin-bottom: 1.875rem;
            line-height: 1.6;
        }

        .cta-button {
            display: inline-block;
            background: transparent;
            color: #4A90E2;
            padding: clamp(0.75rem, 1.5vw, 0.9375rem) clamp(1.5rem, 3vw, 1.875rem);
            border: 2px solid #4A90E2;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            font-size: clamp(0.9rem, 1.2vw, 1rem);
        }

        .cta-button:hover {
            background: #4A90E2;
            color: white;
        }

        .hero-image {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            justify-content: center;
        }

        .dashboard-mockup {
            align-self: center;
            border-radius: 10px;
            overflow: hidden;
            max-width: 100%;
        }

        .dashboard-mockup img {
            width: 100%;
            height: auto;
            max-width: 550px;
            object-fit: contain;
            display: block;
        }

        /* About Section */
        .about {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            padding: clamp(2rem, 8vw, 5rem) 0;
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: clamp(2rem, 5vw, 3.75rem);
            align-items: center;
        }

        .about-images {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .about-images img {
            width: 100%;
            height: auto;
            max-width: 650px;
            object-fit: contain;
            border-radius: 10px;
        }

        .about-text h2 {
            font-size: clamp(1.5rem, 3vw, 2.25rem);
            color: #333;
            margin-bottom: 0.625rem;
        }

        .about-text .subtitle {
            color: #4A90E2;
            font-size: clamp(1rem, 1.5vw, 1.125rem);
            margin-bottom: 1.25rem;
        }

        .about-text h3 {
            font-size: clamp(1.2rem, 2.5vw, 1.75rem);
            color: #333;
            margin-bottom: 1.25rem;
        }

        .about-text p {
            color: #666;
            margin-bottom: 1.875rem;
            line-height: 1.6;
            font-size: clamp(0.9rem, 1.2vw, 1rem);
        }

        /* Features Section */
        .features {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            padding: clamp(2rem, 8vw, 5rem) 0;
        }
        .implementation {
            background: white;
            padding: clamp(2rem, 8vw, 5rem) 0;
        }
        
        .features h2 {
            text-align: center;
            font-size: clamp(1.5rem, 3vw, 2.25rem);
            color: #333;
            margin-bottom: 1.25rem;
        }
        .implementation h2 {
            text-align: center;
            font-size: clamp(1.5rem, 3vw, 2.25rem);
            color: #333;
            margin-bottom: 1.25rem;
        }

        .features-intro {
            text-align: center;
            color: #666;
            margin-bottom: 3.75rem;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            font-size: clamp(0.9rem, 1.2vw, 1rem);
            line-height: 1.6;
        }

        /*.features-grid {*/
        /*    display: grid;*/
        /*    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));*/
        /*    gap: clamp(1rem, 3vw, 1.875rem);*/
        /*    margin-bottom: 2.5rem;*/
        /*}*/
        /*.features-grid {*/
        /*    display: grid;*/
            /*grid-template-columns: repeat(3, 1fr); */
        /*    gap: clamp(1rem, 3vw, 1.875rem);*/
        /*    margin-bottom: 2.5rem;*/
        /*}*/

        /*.feature-card {*/
        /*    background: white;*/
        /*    border: 1px solid #e0e0e0;*/
        /*    border-radius: 10px;*/
        /*    padding: clamp(1.25rem, 3vw, 1.875rem) clamp(1rem, 2vw, 1.25rem);*/
        /*    text-align: start;*/
        /*    transition: transform 0.3s, box-shadow 0.3s;*/
        /*}*/

        /*.feature-card:hover {*/
        /*    transform: translateY(-5px);*/
        /*    box-shadow: 0 10px 25px rgba(0,0,0,0.1);*/
        /*}*/

        /*.feature-icon {*/
        /*    width: clamp(50px, 6vw, 60px);*/
        /*    height: clamp(50px, 6vw, 60px);*/
        /*    background: #f0f8ff;*/
        /*    border: 2px solid #4A90E2;*/
        /*    border-radius: 10px;*/
        /*    margin: 0 auto 1.25rem;*/
        /*    display: inline-grid;*/
        /*    align-items: center;*/
        /*    justify-content: center;*/
        /*    color: #4A90E2;*/
        /*    font-size: clamp(1.2rem, 2vw, 1.5rem);*/
        /*}*/

        /*.feature-card h3 {*/
        /*    font-size: clamp(1.1rem, 1.8vw, 1.4rem);*/
        /*    color: #333;*/
        /*    margin-bottom: 0.9375rem;*/
        /*}*/

        /*.feature-card p {*/
        /*    color: #666;*/
        /*    line-height: 1.6;*/
        /*    font-size: clamp(0.85rem, 1.1vw, 0.95rem);*/
        /*}*/

        /* ERP Section */
        .erp-section {
            padding: clamp(2rem, 8vw, 5rem) 0;
        }

        .erp-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: clamp(2rem, 5vw, 3.75rem);
            align-items: center;
        }

        .erp-text h2 {
            font-size: clamp(1.5rem, 3vw, 2.25rem);
            color: #333;
            margin-bottom: 1.25rem;
        }

        .erp-text h3 {
            font-size: clamp(1.2rem, 2.5vw, 1.75rem);
            color: #333;
            margin-bottom: 1.25rem;
        }

        .erp-text p {
            color: #666;
            margin-bottom: 1.875rem;
            line-height: 1.6;
            font-size: clamp(0.9rem, 1.2vw, 1rem);
        }

        .erp-text img {
            width: 100%;
            height: auto;
            max-width: 650px;
            object-fit: contain;
            border-radius: 10px;
        }

        .erp-mockup {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .erp-mockup img {
            width: 100%;
            height: auto;
            max-width: 650px;
            object-fit: contain;
            border-radius: 10px;
        }

        /* FAQ Section */
        .faq {
            background: white;
            padding: clamp(2rem, 8vw, 5rem) 0;
        }

        .faq h2 {
            text-align: center;
            font-size: clamp(1.5rem, 3vw, 2.25rem);
            color: #333;
            margin-bottom: 1.25rem;
        }

        .faq .highlight {
            color: #4A90E2;
        }

        .faq-intro {
            text-align: center;
            color: #666;
            margin-bottom: 3.75rem;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            font-size: clamp(0.9rem, 1.2vw, 1rem);
            line-height: 1.6;
        }

        .faq-items {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            max-width: 800px;
            margin: 0 auto;
        }

        .faq-item {
            background: #f0f8ff;
            border-radius: 10px;
            padding: clamp(1.25rem, 3vw, 1.875rem);
            border-left: 4px solid #4A90E2;
            min-height: 60px;
        }

        /* Footer */
        .footer {
            background: white;
            border-top: 4px solid #4566B0;
            border-bottom: 4px solid #89B9E3;
            padding: clamp(1.5rem, 4vw, 2.5rem) 0 clamp(1rem, 2vw, 1.25rem);
        }

        .footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: clamp(1.5rem, 4vw, 2.5rem);
    margin-bottom: 1.875rem;
    text-align: center;
}

.footer-content > div {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

/* Create the vertical gradient border */
.footer-content > div:not(:last-child)::after {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(to bottom, #89B9E31A 10%, #4566B0, #89B9E31A 90%);
    border-radius: 2px;
}
        /* Remove border for last column */
        .footer-content > div:last-child {
            border-right: none;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 0.9375rem;
        }

        .footer-logo img {
            max-height: 60px;
            width: auto;
            object-fit: contain;
        }

        .footer-logo-icon {
            width: 50px;
            height: 50px;
            background: #4A90E2;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .footer-company {
            color: #666;
            font-size: clamp(0.8rem, 1vw, 0.875rem);
        }

        .footer h4 {
            color: #4A90E2;
            margin-bottom: 0.9375rem;
            font-size: clamp(1rem, 1.5vw, 1.125rem);
        }

        .footer p, .footer a {
            color: #666;
            text-decoration: none;
            margin-bottom: 0.5rem;
            display: block;
            font-size: clamp(0.85rem, 1.1vw, 0.95rem);
        }

        .footer a:hover {
            color: #4A90E2;
        }

        .social-links {
            display: flex;
            gap: 0.625rem;
        }

        .social-links a {
            width: 35px;
            height: 35px;
            background: #4A90E2;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .footer-bottom {
            padding-top:0.75rem;
            padding-bottom: 0.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #666;
            font-size: clamp(0.8rem, 1vw, 0.875rem);
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-links {
            display: flex;
            gap: 1.25rem;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: #666;
            text-decoration: none;
            font-size: clamp(0.8rem, 1vw, 0.875rem);
        }

        .footer-links a:hover {
            color: #4A90E2;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .hero-content,
            .about-content,
            .erp-content {
                grid-template-columns: 1fr;
                gap: clamp(1.5rem, 4vw, 2.5rem);
                text-align: center;
            }

            .hero-image,
            .about-images,
            .erp-mockup {
                order: -1;
            }

            .features-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }

            .hero-text h1 {
                font-size: clamp(1.5rem, 6vw, 2.2rem);
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 0.75rem;
            }

            .hero {
                padding: clamp(1.5rem, 6vw, 3rem) 0;
            }

            .about,
            .features,
            .implementation
            .erp-section,
            .faq {
                padding: clamp(1.5rem, 6vw, 3rem) 0;
            }

            .feature-card {
                padding: 1rem;
            }
        }

        /* High DPI and Zoom Level Adjustments */
        @media (-webkit-min-device-pixel-ratio: 1.5),
               (min-resolution: 144dpi) {
            body {
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
        }

        /* Ensure images scale properly at all zoom levels */
        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        /* Prevent horizontal scrolling on smaller screens */
        .container {
            max-width: min(1400px, 100vw - 2rem);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="nav-wrapper">
                <div class="logo">
                    <img src="{{ asset('images/xlserp_services/main_logo.png') }}" alt="XLSERP Logo">
                </div>
                <nav>
                    <ul class="nav-menu">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#features">Features</a></li>
                        <li><a href="#contact">Contact Us</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>
                        XLSERP – Your All-in-One ERP Solution for Manufacturing, Retail, and Wholesale Success
                    </h1>
                    <!--<h1>IT Services In Calgary<br>-->
                    <!--Focused <span class="highlight">On The Dynamic<br>-->
                    <!--Growth Of</span> Your Organization</h1>-->
                    <p>XLSERP is a powerful, all-in-one ERP (Enterprise Resource Planning) solution designed specifically for manufacturers, retailers, and wholesalers.
                            It helps businesses automate and optimize daily operations — from procurement and inventory to sales, finance,
                            and customer service — all from one unified platform.</p>
                    <a href="https://excelstech.ae/test/xlserp-registration" class="cta-button">Get a free Demo</a>
                </div>
                <div class="hero-image">
                    <div class="dashboard-mockup">
                        <img src="{{ asset('images/xlserp_services/home.png') }}" alt="Dashboard Mockup">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <div class="about-text">
                <h2 style="justify-self: center;">About XLSERP</h2>
            </div>

            <div class="about-content">
                <div class="about-images">
                    <img src="{{ asset('images/xlserp_services/about.png') }}" alt="About Us">
                </div>
                <div class="about-text">
                    <div style="font-family: Arial, sans-serif; color: #000; padding: 20px; line-height: 1.6; max-width: 700px;">
                        <h2 style="color: #2d4e8b; font-style: italic;">
                            Advantages and benefits of <span style="font-weight: bold;">XLSERP</span><br />
                            <span style="font-size: 18px;">for Small and Medium-sized Enterprises</span>
                        </h2>
                        <p style="margin-top: 20px;">
                            <span style="color: #2d4e8b; font-size: 18px;">» <strong>Cost Effective & Freedom:</strong></span><br />
                            <span style="margin-left: 20px;">XLSERP is <strong>cost-effectiveness</strong> over expensive licensed software</span>
                        <br>
                            <span style="color: #2d4e8b; font-size: 18px;">» <strong>License Free:</strong></span><br />
                            <span style="margin-left: 20px;">XLSERP has no per-user fees, unlike licensed software systems.</span>
                        <br>
                            <span style="color: #2d4e8b; font-size: 18px;">» <strong>Easy Customization:</strong></span><br />
                            <span style="margin-left: 20px;">XLSERP allows full customization anytime as business needs change.</span>
                        <br>
                            <span style="color: #2d4e8b; font-size: 18px;">» <strong>Quick Implementation:</strong></span><br />
                            <span style="margin-left: 20px;">XLSERP enables quick implementation with customizable plug-and-play modules.</span>
                        <br>
                            <span style="color: #2d4e8b; font-size: 18px;">» <strong>Single software covering all your needs:</strong></span><br />
                            <span style="margin-left: 20px;">
                                With XLSERP you can manage all your entire departments such as Sales, CRM, HR, Accounting, Warehouse and even
                                specialized sectors such as Trading business, Manufacturing, Service industry and so on.
                            </span>
                        </p>
                    </div>
                    
                    
                    <p class="subtitle">Get Best IT Solution Company 2025</p>
                    <h3>Trusted by Growing Businesses</h3>
                    <p>Whether you're managing a production facility, a retail chain, or a wholesale operation,
                            XLSERP adapts to your needs and scales with your growth — providing better control, visibility, and performance.</p>
                    <a href="https://excelstech.ae/test/xlserp-registration" class="cta-button">Get a free Demo</a>
                </div>
            </div>
        </div>
    </section>
    
    
    
    
    <section class="implementation" id="implementation">
        <div class="container">
            <div class="logo" style="text-align: center;">
                    <img src="{{ asset('images/xlserp_services/main_logo.png') }}" alt="XLSERP Logo" style=" display: inline;">
                </div>

            <h2>XLSERP IMPLEMENTATION</h2>

            <div style="text-align: center;">
                    <img src="{{ asset('images/xlserp_services/implementation.png') }}" alt="About Us">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <h2>XLSERP Feature</h2>
            <!--<p class="features-intro">It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>-->
            
            
            
             <!-- Features Grid -->
            <div class="grid-container-v2" >
                <!--style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 20px; max-width: 1400px; margin: 0 auto; margin-bottom: 15px;"-->
                
                <!-- Manufacturing Card -->
                <div class="grid-item" >
                    
                    <!-- style="-->
                    <!--position: relative;-->
                    <!--padding: 20px;-->
                    <!--border-radius: 25px;-->
                    <!--background: -->
                    <!--    linear-gradient(white, white) padding-box,-->
                    <!--    linear-gradient(to bottom, #4566B0, #89B9E3) border-box;-->
                    <!--border: 4px solid transparent;-->
                    <!--background-origin: padding-box, border-box;-->
                    <!--background-clip: padding-box, border-box;-->
                    <!--box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);-->
                    <!--"-->

                    <h2 style="color: #1a365d; font-size: 1.5rem; font-weight: bold; margin: 0 0 15px 0; text-align: center;   padding-bottom: 10px;">Manufacturing</h2>
                    <div style="space-y: 10px;">
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Budgeting & Forecasting</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Plans Financial goals and predicts future expenses.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Expense Management</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Tracks and controls business spendings.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Revenue & Income Tracking:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Monitors earnings from different sources.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Invoicing & Billing:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Automates invoice generation And payments.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Financial Reporting & Analytics:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Provides insights into profits and losses.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Tax & Compliance Management:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Ensures legal financial regulations are met.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Investment & Asset Management:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Manages company assets and investments.</p>
                        </div>
                    </div>
                </div>
                <!--style=" position: relative;   padding: 20px; border-radius: 25px; background: linear-gradient(white, white) padding-box, linear-gradient(to bottom, #4566B0, #89B9E3) border-box; border: 4px solid transparent; background-origin: padding-box, border-box; background-clip: padding-box, border-box; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);"-->
        
                <!-- Dashboard Card -->
                <div class="grid-item" >
                    <h2 style="color: #1a365d; font-size: 1.5rem; font-weight: bold; margin: 0 0 15px 0; text-align: center;   padding-bottom: 10px;">Dashboard</h2>
                    <div style="space-y: 10px;">
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
                                <span style="color: #4169E1; margin-right: 8px;">
                                    <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>
                                        <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>
                                    </svg>
                                </span>
                                <strong style="color: #1a365d; font-weight: bold;">Cash Flow Management:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Tracks incoming and outgoing cash to ensure stability.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Income & Expense Tracking:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Monitors revenue sources and business expenses.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Account Balance Overview:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Displays current balances of all accounts.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Latest Income Records:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Shows recent earnings from various sources.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Recent Bills & Payments:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Lists upcoming and past due bills for better planning.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Weekly & Monthly Stats:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Provides financial trends and performance insights.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Goal Setting & Tracking:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Helps in planning financial targets and growth.</p>
                        </div>
                    </div>
                </div>
        
                <!-- Dynamic Websites Card -->
                <div class="grid-item" >
                    <h2 style="color: #1a365d; font-size: 1.5rem; font-weight: bold; margin: 0 0 15px 0; text-align: center;   padding-bottom: 10px;">Dynamic Websites</h2>
                    <div style="space-y: 10px;">
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Multiple Themes:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Allows switching between different website designs.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Dynamic Content Management:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Updates text, Images, and Videos in real-times.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Order History For Cutomers:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Enables users to track past purchases.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Re-order for Customers:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Simplifies repeat purchases with one-click reordering.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Status Update by Department:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Track order progress through different departments.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">User Role Management:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Controls access and permissions for admins, editors.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Performance & Security Monitoring:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Ensures website speed, uptime and protection.</p>
                        </div>
                    </div>
                </div>
        
                <!-- Product Customization Card -->
                <div class="grid-item" >
                    <h2 style="color: #1a365d; font-size: 1.5rem; font-weight: bold; margin: 0 0 15px 0; text-align: center;   padding-bottom: 10px;">Product Customization</h2>
                    <div style="space-y: 10px;">
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Upload Logos:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Allows users to add their own logos to products.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Pre-Built Logos & Texture:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Provides ready- made designs and patterns.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Font Style, Size & Colors:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Enables text customization with various fonts / Colors.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Fonts & Back Customization:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Allows Modifications on both sides of the product.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Pen Tool:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Lets users draw custom designs freely.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Selection & Delete Tool:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Helps in selecting and removing unwanted elements.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Live Preview:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Displays real-time changes before finalizing the design.</p>
                        </div>
                    </div>
                </div>
        
                <!-- User Management Card -->
                <div class="grid-item" >
                    <h2 style="color: #1a365d; font-size: 1.5rem; font-weight: bold; margin: 0 0 15px 0; text-align: center;   padding-bottom: 10px;">User Management</h2>
                    <div style="space-y: 10px;">
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">User Registration & Login:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Secure Account creation and authentication.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Role- Based Access Control:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Assigns roles like admin, User or Manager.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Permissions Management:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Controls user access to specific features.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">User Profile Management:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Allows users to update personal details.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Activity Logs & Monitoring:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Tracks user actions for security and audits.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Password Management:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Enables secure password reset and recovery.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Multi-Platform Access:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Supports web, mobile, and third-party integrations.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Finance Card -->
                <div class="grid-item" >
                    <h2 style="color: #1a365d; font-size: 1.5rem; font-weight: bold; margin: 0 0 15px 0; text-align: center;   padding-bottom: 10px;">Finance</h2>
                    <div style="space-y: 10px;">
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Budgeting & Forecasting:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Plans financial goals and predicts future expenses.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Expense Management:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Tracks and controls business spending.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Revenue & Income Tracking:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Monitors earnings from different sources.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Invoicing & Billing:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Automates invoice generation and payments.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Financial Reporting & Analytics:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Provides insights into profits and losses.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Tax & Compliance Management:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Ensures legal financial regulations are met.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Investment & Asset Management:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Manages company assets and investments.</p>
                        </div>
                    </div>
                </div>
            <!--</div>-->
            <!--<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 20px; max-width: 900px; margin: 0 auto; margin-bottom: 15px;">-->
                
                    <!--<div class="last-row">-->

                <!-- CRM & SALES Card -->
                <div class="grid-item"  >
                    <h2 style="color: #1a365d; font-size: 1.5rem; font-weight: bold; margin: 0 0 15px 0; text-align: center;   padding-bottom: 10px;">CRM & SALES</h2>
                    <div style="space-y: 10px;">
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
                                <span style="color: #4169E1; margin-right: 8px;">
                                    <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         
                                        <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         
                                        <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     
                                    </svg>                                 
                                </span>
                                <strong style="color: #1a365d; font-weight: bold;">Contact Management:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Stores customer details and interactions.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Lead & Sales Management:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Tracks leads, opportunities, and deals</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Marketing Automation:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Automates emails, campaigns, and promotions</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Customer Support:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Manages queries, complaints, and tickets.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Reports & Analytics:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Provides insights with dashboards and data.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Workflow Automation:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Streamlines tasks, reminders, and approvals.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Multi-Platform Integration:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Streamlines tasks, reminders, and approvals.</p>
                        </div>
                    </div>
                </div>
        
                <!-- HRM Card -->
                <div class="grid-item" >
                    <h2 style="color: #1a365d; font-size: 1.5rem; font-weight: bold; margin: 0 0 15px 0; text-align: center;   padding-bottom: 10px;">HRM</h2>
                    <div style="space-y: 10px;">
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Employee Management:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Maintains records of employees and job roles.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Recruitment & Hiring:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Manages job postings, applications, and interviews.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Attendance & Leave Tracking:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Tracks working hours, shifts, and leaves.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Payroll Management:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Automates salary calculations, tax deductions.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Performance Management:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Evaluates employee performance and feedback.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">Training & Development:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Organizes training programs and skill upgrades.</p>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
<span style="color: #4169E1; margin-right: 8px;">                                     <svg width="21" height="17" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                         <path d="M26.5 10.4019C28.5 11.5566 28.5 14.4434 26.5 15.5981L16 21.6603C14 22.815 11.5 21.3716 11.5 19.0622L11.5 6.93782C11.5 4.62842 14 3.18504 16 4.33975L26.5 10.4019Z" fill="#4566B0"/>                                         <path d="M21.5 10.4019C23.5 11.5566 23.5 14.4434 21.5 15.5981L11 21.6603C9 22.815 6.5 21.3716 6.5 19.0622L6.5 6.93782C6.5 4.62842 9 3.18504 11 4.33975L21.5 10.4019Z" fill="#89B9E3"/>                                     </svg>                                 </span>
                                <strong style="color: #1a365d; font-weight: bold;">HR Reports & Analytics:</strong>
                            </div>
                            <p style="margin: 0; padding-left: 24px; color: #4a5568; font-size: 14px; line-height: 1.4;">Provides insights on workforce and productivity.</p>
                        </div>
                    </div>
                </div>
        
        <!--</div>-->
            </div>
                
            <div style="text-align: center;" >
                <a href="https://excelstech.ae/test/xlserp-registration" class="cta-button">Get a free Demo</a>
            </div>
        </div>
    </section>

    <!-- ERP Solutions Section -->
    <section class="erp-section">
        <div class="container">
            <div class="erp-text">
                <h2 style="justify-self:center;">ERP Solutions</h2>
            </div>

            <div class="erp-content">
                <div class="erp-text">
                    <h3>ERP Solutions For Businesses</h3>
                    <p>Effective tools for your business management needs, made with the largest technologies.</p>
                    <img src="{{ asset('images/xlserp_services/erp_left.png') }}" alt="ERP Solutions">
                </div>
                <div class="erp-mockup">
                    <img src="{{ asset('images/xlserp_services/erp_right.png') }}" alt="ERP Dashboard">
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <!--<section class="faq">-->
    <!--    <div class="container">-->
    <!--        <h2>Frequently <span class="highlight">Asked Questions</span></h2>-->
    <!--        <p class="faq-intro">Find comprehensive answers to frequently asked questions, offering insights and solutions to common queries. If your specific question isn't covered, don't hesitate to get in touch with us for personalized support</p>-->
            
    <!--        <div class="faq-items">-->
    <!--            <div class="faq-item"></div>-->
    <!--            <div class="faq-item"></div>-->
    <!--            <div class="faq-item"></div>-->
    <!--            <div class="faq-item"></div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</section>-->
    
    <!--<section class="faq">-->
    <!--    <div class="container">-->
    <!--        <h2>Frequently <span class="highlight">Asked Questions</span></h2>-->
    <!--        <p class="faq-intro">Find comprehensive answers to frequently asked questions, offering insights and solutions to common queries. If your specific question isn't covered, don't hesitate to get in touch with us for personalized support</p>-->
            
    <!--        <div class="faq-items">-->
    <!--            <div class="faq-item">-->
    <!--                <h4>What services does XLSERP provide?</h4>-->
    <!--                <p>We provide comprehensive IT solutions including ERP systems, CRM, HRM, POS systems, and website development services.</p>-->
    <!--            </div>-->
    <!--            <div class="faq-item">-->
    <!--                <h4>How can I get started with XLSERP?</h4>-->
    <!--                <p>You can get started by clicking our "Get a free Demo" button to schedule a consultation with our team.</p>-->
    <!--            </div>-->
    <!--            <div class="faq-item">-->
    <!--                <h4>Do you provide ongoing support?</h4>-->
    <!--                <p>Yes, we provide comprehensive ongoing support and maintenance for all our solutions to ensure optimal performance.</p>-->
    <!--            </div>-->
    <!--            <div class="faq-item">-->
    <!--                <h4>Are your solutions scalable?</h4>-->
    <!--                <p>Absolutely! Our solutions are designed to grow with your business and can be scaled according to your needs.</p>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</section>-->

    <!-- Footer -->
    <section class="footer" id="contact">
        <div class="container">
            <div class="footer-content">
                <div>
                    <div class="footer-logo">
                        <img src="{{ asset('images/xlserp_services/contact_us.png') }}" alt="Contact Us">
                    </div>
                </div>
                <div>
                    <h4>Address:</h4>
                    <p>The Binary by OMNIYAT<br>Business Bay</p>
                </div>
                <div>
                    <h4>Contact Us:</h4>
                    <p>📧 info@excelstech.ae</p>
                    <p><a href="https://xlserp.com/" target="_blank">🌐  xlserp.com</a></p>
                </div>
                <div>
                    <h4>Follow Us:</h4>
                    <div class="social-links">
                        <a href="#">f</a>
                        <a href="#">in</a>
                        <a href="#">X</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section style="background: linear-gradient(to right, #89B9E3, #4566B0B2 70%, #89B9E3); ">
        <div class="container">
            <div class="footer-bottom">
                <div style="color: white;">© 2025 | All rights reserved.</div>
                <div class="footer-links">
                    <a href="#"  style="color: white;">Terms & Conditions</a>
                    <a href="#" style="color: white;">Privacy Policy</a>
                </div>
            </div>
        </div>
    </section>
</body>
</html>