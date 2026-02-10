<?php
$host = "localhost";
$user = "root";

// Test 1: Try without password
echo "<h2>Test 1: Connecting without password...</h2>";
try {
    $conn = new mysqli($host, $user, "");
    if ($conn->connect_error) {
        echo "Error: " . $conn->connect_error . "<br>";
    } else {
        echo "✓ Connection successful!<br>";
        echo "Current user: ";
        $result = $conn->query("SELECT USER();");
        $row = $result->fetch_row();
        echo $row[0] . "<br>";
        $conn->close();
        exit;
    }
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "<br>";
}

// Test 2: Check MySQL version using command line
echo "<h2>Test 2: Checking MySQL installation...</h2>";
$output = shell_exec('cd "C:\Program Files\MySQL\MySQL Server 9.6\bin" && mysql.exe -u root -proot site -e "SELECT 1" 2>&1');
echo "<pre>$output</pre>";
?>
