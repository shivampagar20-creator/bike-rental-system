<?php
$host = "localhost";
$user = "root";

// Try various passwords in order of likelihood
$passwords = ["root", "mysql", "admin", "password", "123456", ""];

foreach ($passwords as $pwd) {
    echo "Attempting connection with password: '" . ($pwd === "" ? "(empty)" : $pwd) . "'<br>";
    
    try {
        $conn = new mysqli($host, $user, $pwd, "");
        
        if (!$conn->connect_error) {
            echo "<strong>✓ Connection successful with password: " . ($pwd === "" ? "(empty)" : $pwd) . "</strong><br>";
            
            // Try to show the current user
            $result = $conn->query("SELECT USER();");
            if ($result) {
                $row = $result->fetch_row();
                echo "Current user: " . $row[0] . "<br>";
            }
            
            // Now set password to empty for root user
            $conn->query("ALTER USER 'root'@'localhost' IDENTIFIED BY '';");
            if (!$conn->error) {
                echo "<strong>✓ Password reset to empty successfully!</strong><br>";
            } else {
                echo "Error resetting password: " . $conn->error . "<br>";
            }
            
            // Also try to flush privileges
            $conn->query("FLUSH PRIVILEGES;");
            
            $conn->close();
            exit();
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
    }
}

echo "<br><strong>Could not connect with any default password. MySQL root may use a custom password.</strong>";
?>
