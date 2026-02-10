<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WheelConnect | Premium Bike Rentals</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #ff6b6b; /* Energetic Red/Orange */
            --secondary-color: #4ecdc4; /* Teal Accent */
            --dark-bg: #434348;
            --glass-bg: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--dark-bg);
            color: #fff;
            overflow-x: hidden;
        }

        /* --- Hero Section with Parallax Background --- */
        .hero-section {
            height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1558981403-c5f9899a28bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* --- Glassmorphism Card --- */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            max-width: 600px;
            width: 90%;
            transition: transform 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
        }

        /* --- Custom Buttons --- */
        .btn-custom-primary {
            background: linear-gradient(45deg, #ff6b6b, #ee5253);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
            transition: all 0.3s ease;
        }

        .btn-custom-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.6);
            color: white;
        }

        .btn-custom-outline {
            background: transparent;
            border: 2px solid rgba(255,255,255,0.5);
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-custom-outline:hover {
            background: white;
            color: var(--dark-bg);
            border-color: white;
        }

        /* --- Features Section --- */
        .features-section {
            padding: 80px 0;
            background: #4f4f64;
        }
        
        .feature-box {
            padding: 30px;
            border-radius: 15px;
            background: #0f3460;
            text-align: center;
            transition: 0.3s;
            height: 100%;
        }
        
        .feature-box:hover {
            transform: translateY(-10px);
            background: #121212;
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--secondary-color);
            margin-bottom: 20px;
        }

        /* Floating Animation for Text */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .floating-text {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top p-3" style="background: rgba(0,0,0,0.8); backdrop-filter: blur(5px);">
        <div class="container">
            <a class="navbar-brand fw-bold text-uppercase" href="#">
                <i class="fas fa-motorcycle text-danger"></i> Wheel<span class="text-danger">Connect</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav gap-3">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Fleet</a></li>
                    <li class="nav-item">
                        <a href="admin/index.php" class="btn btn-sm btn-outline-secondary px-3 rounded-pill mt-1">Admin Portal</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center">
        <div class="container">
            <div class="glass-card mx-auto animate__animated animate__zoomIn">
                <h1 class="display-4 fw-bold mb-3 floating-text">Ride Your Dream</h1>
                <p class="lead mb-4 text-white-50">Premium Superbikes & Cruisers available for rent at the best daily rates. No hidden charges.</p>
                
                <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                    <a href="user/login.php" class="btn btn-custom-primary btn-lg">
                        <i class="fas fa-key me-2"></i> Rent a Bike Now
                    </a>
                    <a href="user/register.php" class="btn btn-custom-outline btn-lg">
                        <i class="fas fa-user-plus me-2"></i> Sign Up
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="features-section">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="fw-bold animate__animated animate__fadeInUp">Why Choose Us?</h2>
                    <p class="text-muted">Experience the thrill without the maintenance.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4 animate__animated animate__fadeInLeft">
                    <div class="feature-box">
                        <i class="fas fa-check-shield feature-icon"></i>
                        <h4>Insured & Secure</h4>
                        <p class="text-white-50">All our bikes come with comprehensive insurance and 24/7 roadside assistance support.</p>
                    </div>
                </div>
                <div class="col-md-4 animate__animated animate__fadeInUp">
                    <div class="feature-box">
                        <i class="fas fa-tags feature-icon" style="color: #ff6b6b;"></i>
                        <h4>Best Rates</h4>
                        <p class="text-white-50">Rentals starting as low as ₹500/day. Transparent pricing with refundable deposits.</p>
                    </div>
                </div>
                <div class="col-md-4 animate__animated animate__fadeInRight">
                    <div class="feature-box">
                        <i class="fas fa-tachometer-alt feature-icon" style="color: #feca57;"></i>
                        <h4>Top Performance</h4>
                        <p class="text-white-50">From the Ninja 300 to the Hayabusa, our fleet is maintained in showroom condition.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-black text-white py-4 text-center">
        <div class="container">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> WheelConnect Bike Rentals. All rights reserved.</p>
            <small class="text-muted">Designed for Speed & Comfort.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>