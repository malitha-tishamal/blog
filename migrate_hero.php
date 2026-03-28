<?php
try {
    $conn = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Add hero_image if not exists
    $stmt = $conn->query("SHOW COLUMNS FROM site_settings LIKE 'hero_image'");
    if (!$stmt->fetch()) {
        $conn->exec("ALTER TABLE site_settings ADD COLUMN hero_image VARCHAR(255) DEFAULT 'assets/img/profile/profile-malitha.jpg' AFTER hero_description");
        echo "Column hero_image added to site_settings.\n";
    }

    // Create hero_cards table if not exists with position columns
    $conn->exec("CREATE TABLE IF NOT EXISTS hero_cards (
        id INT AUTO_INCREMENT PRIMARY KEY,
        icon VARCHAR(100) NOT NULL,
        title VARCHAR(255) NOT NULL,
        pos_top VARCHAR(50) DEFAULT 'auto',
        pos_bottom VARCHAR(50) DEFAULT 'auto',
        pos_left VARCHAR(50) DEFAULT 'auto',
        pos_right VARCHAR(50) DEFAULT 'auto',
        display_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Ensure columns exist if table was already created
    $cols = ['pos_top', 'pos_bottom', 'pos_left', 'pos_right'];
    foreach ($cols as $col) {
        $stmt = $conn->query("SHOW COLUMNS FROM hero_cards LIKE '$col'");
        if (!$stmt->fetch()) {
            $conn->exec("ALTER TABLE hero_cards ADD COLUMN $col VARCHAR(50) DEFAULT 'auto' AFTER title");
            echo "Column $col added to hero_cards.\n";
        }
    }
    echo "Table hero_cards created/checked.\n";

    // Seed hero_cards if empty
    $stmt = $conn->query("SELECT COUNT(*) FROM hero_cards");
    if ($stmt->fetchColumn() == 0) {
        $conn->exec("INSERT INTO hero_cards (icon, title, display_order) VALUES 
            ('bi-palette', 'UI/UX Design', 1),
            ('bi-code-slash', 'Fullstack Development & DevOps', 2),
            ('bi-lightning', 'Creative Ideas', 3),
            ('bi-shield-lock', 'Cybersecurity & AI ML', 4),
            ('bi-phone', 'Mobile App Development', 5),
            ('bi-cpu', 'Embedded Systems', 6)");
        echo "Hero cards seeded.\n";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
