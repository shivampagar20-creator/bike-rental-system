<?php
// Database Configuration
$host = "localhost";
$user = "root";
$pass = "ssp@shivam123"; // MySQL password
$dbname = "bike_rental_system";

// 1. Create Connection
$conn = new mysqli($host, $user, $pass);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Create Database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "<h3>Database '$dbname' created successfully.</h3>";
} else {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// 3. Create Tables

// --- Users Table ---
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    address TEXT,
    role ENUM('customer', 'admin') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql_users) === TRUE) echo "Table 'users' created.<br>";
else echo "Error creating users table: " . $conn->error . "<br>";

// --- Bikes Table ---
$sql_bikes = "CREATE TABLE IF NOT EXISTS bikes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    brand VARCHAR(100) NOT NULL,
    description TEXT,
    daily_rate DECIMAL(10,2) NOT NULL COMMENT 'Cost per day to rent',
    security_deposit DECIMAL(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Refundable deposit',
    stock INT NOT NULL DEFAULT 1 COMMENT 'Total quantity available',
    image VARCHAR(255) DEFAULT 'default.jpg',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql_bikes) === TRUE) echo "Table 'bikes' created.<br>";
else echo "Error creating bikes table: " . $conn->error . "<br>";

// --- Bookings Table ---
$sql_bookings = "CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL COMMENT 'Rent + Deposit',
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    status ENUM('Pending', 'Confirmed', 'Active', 'Completed', 'Cancelled') DEFAULT 'Pending',
    payment_status ENUM('Pending', 'Paid') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";
if ($conn->query($sql_bookings) === TRUE) echo "Table 'bookings' created.<br>";
else echo "Error creating bookings table: " . $conn->error . "<br>";

// --- Booking Items Table ---
$sql_items = "CREATE TABLE IF NOT EXISTS booking_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    bike_id INT NOT NULL,
    quantity INT DEFAULT 1,
    rent_price DECIMAL(10,2) NOT NULL COMMENT 'Price at time of booking',
    deposit_price DECIMAL(10,2) NOT NULL,
    return_status ENUM('Pending', 'Returned', 'Overdue') DEFAULT 'Pending',
    actual_return_date DATETIME NULL,
    late_fee DECIMAL(10,2) DEFAULT 0.00,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
    FOREIGN KEY (bike_id) REFERENCES bikes(id) ON DELETE CASCADE
)";
if ($conn->query($sql_items) === TRUE) echo "Table 'booking_items' created.<br>";
else echo "Error creating booking_items table: " . $conn->error . "<br>";

// --- Cart Table ---
$sql_cart = "CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    bike_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (bike_id) REFERENCES bikes(id) ON DELETE CASCADE
)";
if ($conn->query($sql_cart) === TRUE) echo "Table 'cart' created.<br>";
else echo "Error creating cart table: " . $conn->error . "<br>";

// --- User Documents Table ---
$sql_docs = "CREATE TABLE IF NOT EXISTS user_documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    document_type ENUM('Aadhar', 'Driving License', 'PAN') NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    verification_status ENUM('Pending', 'Verified', 'Rejected') DEFAULT 'Pending',
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";
if ($conn->query($sql_docs) === TRUE) echo "Table 'user_documents' created.<br>";
else echo "Error creating user_documents table: " . $conn->error . "<br>";

// 4. Insert Default Data (Bikes)
// We check if table is empty first to avoid duplicates
$check_bikes = $conn->query("SELECT count(*) as count FROM bikes");
$row = $check_bikes->fetch_assoc();

if ($row['count'] == 0) {
    $sql_insert_bikes = "INSERT INTO bikes (name, brand, description, daily_rate, security_deposit, stock, image) VALUES
    ('CBR 650R', 'Honda', '649cc Inline-4. Sport touring simplified.', 4500.00, 10000.00, 5, 'cbr650r.jpg'),
    ('R15 V4', 'Yamaha', '155cc Sports bike with Quick Shifter.', 1200.00, 3000.00, 10, 'r15v4.jpg'),
    ('Duke 390', 'KTM', '373cc Naked beast. High torque.', 2500.00, 5000.00, 8, 'duke390.jpg'),
    ('Ninja 300', 'Kawasaki', 'Twin-cylinder beginner sports bike.', 2200.00, 5000.00, 6, 'ninja300.jpg'),
    ('Apache RR 310', 'TVS', 'Sports tourer with ride modes.', 1800.00, 4000.00, 8, 'apache310.jpg'),
    ('MT-15', 'Yamaha', 'Hyper naked 155cc street fighter.', 1100.00, 3000.00, 12, 'mt15.jpg'),
    ('G 310 R', 'BMW', 'German engineering, agile handling.', 2400.00, 5000.00, 5, 'g310r.jpg'),
    ('CB500X', 'Honda', 'Adventure tourer. Perfect for long rides.', 3500.00, 8000.00, 4, 'cb500x.jpg'),
    ('Interceptor 650', 'Royal Enfield', 'Classic twin-cylinder cruiser.', 2000.00, 5000.00, 10, 'interceptor650.jpg'),
    ('Xtreme 160R', 'Hero', 'Commuter friendly street bike.', 800.00, 2000.00, 15, 'xtreme160r.jpg'),
    ('Hayabusa', 'Suzuki', 'The legend. 1340cc Ultimate Sport.', 15000.00, 50000.00, 2, 'hayabusa.jpg'),
    ('H2R', 'Kawasaki', 'Supercharged beast. Track only specs.', 25000.00, 100000.00, 1, 'h2r.jpg'),
    ('Panigale V4', 'Ducati', 'Italian masterpiece. Pure performance.', 18000.00, 75000.00, 1, 'panigalev4.jpg'),
    ('Bonneville T120', 'Triumph', 'Timeless classic.', 6000.00, 15000.00, 3, 'bonnevillet120.jpg'),
    ('Meteor 350', 'Royal Enfield', 'Comfortable cruiser for highways.', 1400.00, 3000.00, 15, 'meteor350.jpg'),
    ('Dominar 400', 'Bajaj', 'Power cruiser.', 1600.00, 4000.00, 10, 'dominar400.jpg'),
    ('Himalayan 411', 'Royal Enfield', 'Built for all roads and no roads.', 1500.00, 3500.00, 12, 'himalayan411.jpg'),
    ('Classic 350', 'Royal Enfield', 'The reborn classic.', 1300.00, 3000.00, 15, 'classic350.jpg'),
    ('Z900', 'Kawasaki', 'Inline-4 Supernaked.', 5500.00, 15000.00, 4, 'z900.jpg')";

    if ($conn->query($sql_insert_bikes) === TRUE) {
        echo "Bikes data inserted successfully.<br>";
    } else {
        echo "Error inserting bikes: " . $conn->error . "<br>";
    }
} else {
    echo "Bikes table already has data. Skipping insertion.<br>";
}

// 5. Create Default Admin User
// Email: admin@wheelconnect.com
// Password: admin123
$admin_email = "admin@wheelconnect.com";
$check_admin = $conn->query("SELECT id FROM users WHERE email = '$admin_email'");

if ($check_admin->num_rows == 0) {
    $admin_pass = password_hash("admin123", PASSWORD_DEFAULT);
    $sql_admin = "INSERT INTO users (name, email, password, role) VALUES ('Super Admin', '$admin_email', '$admin_pass', 'admin')";
    
    if ($conn->query($sql_admin) === TRUE) {
        echo "<h3>Default Admin Account Created!</h3>";
        echo "Email: <strong>admin@wheelconnect.com</strong><br>";
        echo "Password: <strong>admin123</strong><br>";
    } else {
        echo "Error creating admin: " . $conn->error;
    }
} else {
    echo "Admin account already exists.<br>";
}

$conn->close();

echo "<hr><h3>Setup Complete! <a href='index.php'>Go to Homepage</a></h3>";
?>