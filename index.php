<?php
session_start();
include("./config/db.php"); 

// Fetch bikes
$sql = "SELECT * FROM bikes ORDER BY brand ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Fleet | WheelConnect</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #ff9a9e 0%, #fecfef 99%, #fecfef 100%);
            --btn-gradient: linear-gradient(45deg, #FF512F 0%, #DD2476 100%);
            --bg-color: #bbb0b07a;
            --text-dark: #2d3436;
            --text-light: #636e72;
            --card-shadow: 10px 10px 40px rgba(0, 0, 0, 0.47);
            --hover-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* --- Glass Navbar (Light) --- */
        .navbar {
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 15px 0;
            box-shadow: 0 2px 15px rgba(0,0,0,0.03);
           
            color: #fff;
        }

        .navbar-brand {
            color: var(--text-dark) !important;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            transition: 0.3s;
        }

        .nav-link:hover {
            color: #DD2476 !important;
        }

        /* --- Hero Section --- */
        .page-header {
            position: relative;
            background: url('https://images.unsplash.com/photo-1558981806-ec527fa84c3d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0 0 50px 50px; /* Curve at bottom */
            margin-bottom: 60px;
            overflow: hidden;
        }

        .hero-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(to bottom, rgba(255,255,255,0.1), rgba(255,255,255,0.9));
             background: linear-gradient(rgba(0,0,0,0.8), rgba(35, 33, 33, 0.9)), url('./assets/images/bikebackgroundimg1.jpg');
            background-size: cover;
            background-attachment: fixed;
            color:#fff;
            background-position: center;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            animation: float 2s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        /* --- Search Bar --- */
        .search-container {
            margin-top: -80px; /* Overlap hero */
            position: relative;
            z-index: 5;
            margin-bottom: 60px;
        }

        .search-box {
            background: white;
            padding: 10px;
            border-radius: 50px;
            box-shadow: var(--card-shadow);
            display: flex;
            align-items: center;
        }

        .search-input {
            border: none;
            outline: none;
            width: 100%;
            padding: 15px 20px;
            font-size: 1rem;
            color: var(--text-dark);
        }

        .btn-search {
            background: var(--btn-gradient);
            color: white;
            border-radius: 40px;
            padding: 12px 30px;
            border: none;
            font-weight: 600;
            transition: 0.3s;
                        width:200px;

        }

        .btn-search:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(221, 36, 118, 0.4);
        }

        /* --- Bike Cards --- */
        .bike-card {
            background: white;
            border-radius: 20px;
            border: none;
            box-shadow: var(--card-shadow);
            transition: all 0.4s ease;
            overflow: hidden;
            height: 100%;
            position: relative;
        }

        .bike-card:hover {
            transform: translateY(-15px);
            box-shadow: var(--hover-shadow);
        }

        .img-container {
            height: 220px;
            overflow: hidden;
            position: relative;
            background: #f1f2f6;
        }

        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .bike-card:hover .img-container img {
            transform: scale(1.1) rotate(2deg);
        }

        .price-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.9);
            color: #DD2476;
            padding: 8px 15px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 0.9rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            backdrop-filter: blur(5px);
        }

        .card-content {
            padding: 25px;
        }

        .brand-text {
            font-size: 0.8rem;
            color: #a4b0be;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .bike-name {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 5px 0 15px;
            color: var(--text-dark);
        }

        .specs-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 10px;
        }

        .spec-item {
            font-size: 0.8rem;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-book {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            border: 2px solid #DD2476;
            background: transparent;
            color: #DD2476;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-book:hover {
            background: var(--btn-gradient);
            color: white;
            border-color: transparent;
        }

        .btn-book.disabled {
            border-color: #ccc;
            color: #ccc;
            cursor: not-allowed;
        }

        .stock-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .in-stock { background: #e3f9e5; color: #2ecc71; }
        .out-stock { background: #ffeaea; color: #ff6b6b; }

    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="./user.php">
                <i class="fas fa-motorcycle text-danger me-2"></i>WheelConnect
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav gap-3 align-items-center">
                    <li class="nav-item"><a class="nav-link active" href="./user/index.php">Browse</a></li>
                    <li class="nav-item"><a class="nav-link" href="./user/my_bookings.php">My Rides</a></li>
                    <li class="nav-item"><a class="nav-link" href="./user/cart.php"><i class="fas fa-shopping-cart"></i></a></li>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle btn btn-light px-3 rounded-pill shadow-sm" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i> Account
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li><a class="dropdown-item" href="./user/profile.php">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="./user/logout.php">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a href="./user/login.php" class="btn btn-dark rounded-pill px-4">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="page-header">
        <div class="hero-overlay"></div>
        <div class="hero-content animate__animated animate__fadeInDown">
            <h1 class="display-3 fw-bold mb-2" style="color: #feffff;">Explore the City</h1>
            <p class="lead text"  style="color: #a6aeae;">Premium bikes for your daily adventures.</p>
        </div>
    </div>

    <div class="container search-container animate__animated animate__fadeInUp">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="search-box">
                    <span class="ps-3 text-muted"><i class="fas fa-search"></i></span>
                    <input type="text" class="search-input" id="searchInput" placeholder="Search by brand, name, or type...">
                    <button class="btn-search" onclick="filterBikes()">Find Bike</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row g-4" id="bikeGrid">
            
            <?php 
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { 
                    $is_available = $row['stock'] > 0;
                    $badge_html = $is_available 
                        ? '<span class="stock-badge in-stock"><i class="fas fa-bolt me-1"></i>Available</span>' 
                        : '<span class="stock-badge out-stock"><i class="far fa-clock me-1"></i>Booked Out</span>';
            ?>
            
            <div class="col-md-6 col-lg-4 col-xl-3 bike-item" data-name="<?php echo strtolower($row['name'] . ' ' . $row['brand']); ?>">
                <div class="bike-card animate__animated animate__fadeIn">
                    
                    <div class="img-container">
                        <img src="./uploads/bikes/<?php echo $row['image']; ?>" 
                             onerror="this.src='https://images.unsplash.com/photo-1568772585407-9361f9bf3a87?auto=format&fit=crop&w=800&q=80'">
                        <div class="price-badge">₹<?php echo number_format($row['daily_rate']); ?> <small style="font-weight:400; font-size:0.7em;">/day</small></div>
                    </div>

                    <div class="card-content">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="brand-text"><?php echo $row['brand']; ?></span>
                            <?php echo $badge_html; ?>
                        </div>
                        
                        <h5 class="bike-name"><?php echo $row['name']; ?></h5>

                        <div class="specs-row">
                            <div class="spec-item" title="Fuel Type"><i class="fas fa-gas-pump text-muted"></i> Petrol</div>
                            <div class="spec-item" title="Transmission"><i class="fas fa-cogs text-muted"></i> Manual</div>
                            <div class="spec-item" title="Speed"><i class="fas fa-tachometer-alt text-muted"></i> Fast</div>
                        </div>

                        <a href="./user/bike_details.php?id=<?php echo $row['id']; ?>" class="btn-book <?php echo $is_available ? '' : 'disabled'; ?>">
                            <?php echo $is_available ? 'Rent Now' : 'Unavailable'; ?>
                        </a>
                    </div>

                </div>
            </div>

            <?php 
                } 
            } else {
                echo '<div class="col-12 text-center py-5 text-muted"><h3>No bikes currently in the fleet.</h3></div>';
            }
            ?>

        </div>
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let items = document.querySelectorAll('.bike-item');

            items.forEach(function(item) {
                let name = item.getAttribute('data-name');
                if (name.includes(filter)) {
                    item.style.display = 'block';
                    item.classList.add('animate__fadeIn');
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>

    <?php include("./includes/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>