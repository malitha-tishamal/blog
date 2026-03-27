<?php
require_once 'includes/db-conn.php';

$sql = "CREATE TABLE IF NOT EXISTS certifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    organization VARCHAR(255) NOT NULL,
    issue_month VARCHAR(20),
    issue_year INT,
    expiry_month VARCHAR(20),
    expiry_year INT,
    credential_id VARCHAR(255),
    credential_url VARCHAR(255),
    logo VARCHAR(255),
    media_image VARCHAR(255),
    description TEXT,
    skills VARCHAR(255),
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if($conn->query($sql)) {
    echo "Table certifications created successfully.\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}
?>
