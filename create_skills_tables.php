<?php
require_once 'includes/db-conn.php';

// Create skill_categories table
$sql1 = "CREATE TABLE IF NOT EXISTS skill_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    icon VARCHAR(100) DEFAULT 'bi bi-code-slash',
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Create skills table
$sql2 = "CREATE TABLE IF NOT EXISTS skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    percentage INT DEFAULT 0,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES skill_categories(id) ON DELETE CASCADE
)";

// Create skills_expertise table (singleton for right sidebar)
$sql3 = "CREATE TABLE IF NOT EXISTS skills_expertise (
    id INT PRIMARY KEY DEFAULT 1,
    title VARCHAR(255) NOT NULL DEFAULT 'Core Technologies & Expertise',
    description TEXT,
    highlights TEXT,
    years_experience VARCHAR(50) DEFAULT '2+',
    projects_completed VARCHAR(50) DEFAULT '15+',
    badges TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE && $conn->query($sql3) === TRUE) {
    echo "Tables created successfully.\n";
    
    // Seed default categories
    $categories = [
        ['Frontend Development', 'bi bi-code-slash', 1],
        ['Backend Development', 'bi bi-server', 2],
        ['Design & Tools', 'bi bi-palette', 3],
        ['Cloud & DevOps', 'bi bi-cloud', 4],
        ['AI & Cybersecurity', 'bi bi-cpu-fill', 5]
    ];
    
    $stmt = $conn->prepare("INSERT IGNORE INTO skill_categories (name, icon, display_order) VALUES (?, ?, ?)");
    foreach ($categories as $cat) {
        $stmt->bind_param("ssi", $cat[0], $cat[1], $cat[2]);
        $stmt->execute();
    }
    
    // Get category IDs for seeding skills
    $res = $conn->query("SELECT id, name FROM skill_categories");
    $cat_ids = [];
    while($row = $res->fetch_assoc()) {
        $cat_ids[$row['name']] = $row['id'];
    }
    
    // Seed skills
    $skills = [
        ['Frontend Development', 'HTML / CSS / Bootstrap', 95, 1],
        ['Frontend Development', 'JavaScript', 90, 2],
        ['Frontend Development', 'React.js', 85, 3],
        ['Frontend Development', 'Flutter', 82, 4],
        
        ['Backend Development', 'Java', 85, 1],
        ['Backend Development', 'Python', 55, 2],
        ['Backend Development', 'PHP / Laravel', 78, 3],
        ['Backend Development', 'MySQL', 72, 4],
        
        ['Design & Tools', 'Figma', 85, 1],
        ['Design & Tools', 'Photoshop / Illustrator', 70, 2],
        ['Design & Tools', 'Adobe XD / Canva', 80, 3],
        
        ['Cloud & DevOps', 'AWS', 90, 1],
        ['Cloud & DevOps', 'Git / CI-CD', 90, 2],
        
        ['AI & Cybersecurity', 'Python / TensorFlow / PyTorch', 70, 1],
        ['AI & Cybersecurity', 'Secure Coding / Pen Testing', 65, 2]
    ];
    
    $stmt_skill = $conn->prepare("INSERT IGNORE INTO skills (category_id, name, percentage, display_order) VALUES (?, ?, ?, ?)");
    foreach ($skills as $s) {
        if (isset($cat_ids[$s[0]])) {
            $stmt_skill->bind_param("isii", $cat_ids[$s[0]], $s[1], $s[2], $s[3]);
            $stmt_skill->execute();
        }
    }
    
    // Seed expertise
    $expertise_desc = "I craft scalable, modern, and visually engaging applications using a blend of mobile, web, cloud, AI, and cybersecurity technologies — bridging creativity with functionality.";
    $expertise_highlights = "Flutter & Dart — Cross-platform app development\nFirebase — Auth, Firestore, Storage, Hosting & Functions\nFrontend: HTML / CSS / Bootstrap / JS / React.js\nBackend: PHP / Laravel / MySQL / Java / Python\nDevOps: AWS / Git / CI-CD Pipelines\nAI & ML: Python, TensorFlow, PyTorch\nCybersecurity: Secure Coding, Pen Testing";
    $expertise_badges = "Flutter, Firebase, React.js, Laravel, AWS, AI/ML, Cybersecurity";
    
    $stmt_exp = $conn->prepare("INSERT IGNORE INTO skills_expertise (id, title, description, highlights, years_experience, projects_completed, badges) VALUES (1, ?, ?, ?, ?, ?, ?)");
    $title = "Core Technologies & Expertise";
    $years = "2+";
    $projects = "15+";
    $stmt_exp->bind_param("ssssss", $title, $expertise_desc, $expertise_highlights, $years, $projects, $expertise_badges);
    $stmt_exp->execute();

    echo "Data seeded successfully.";
} else {
    echo "Error creating tables: " . $conn->error;
}
?>
