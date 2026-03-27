<?php
require_once 'includes/db-conn.php';

$sql = "CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    role VARCHAR(255),
    message TEXT NOT NULL,
    profile_pic VARCHAR(255),
    rating INT DEFAULT 5,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table testimonials created successfully" . PHP_EOL;
} else {
    echo "Error creating table: " . $conn->error . PHP_EOL;
}

// Also check existing tables
$res = $conn->query("SHOW TABLES");
echo "Existing tables:" . PHP_EOL;
while($row = $res->fetch_array()) {
    echo "- " . $row[0] . PHP_EOL;
}
?>
