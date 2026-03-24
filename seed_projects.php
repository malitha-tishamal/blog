<?php
require_once 'includes/db-conn.php';

// Empty existing if any to avoid duplicates
$conn->query("TRUNCATE TABLE portfolio_projects");

$stmt = $conn->prepare("INSERT INTO portfolio_projects (title, category, short_description, main_image, details_link, gallery_images, display_order) VALUES (?, ?, ?, ?, ?, '[]', ?)");

// We map short_description directly from the HTML and assign details link
$projects = [
    [
        'title' => 'MediQ Antibiotic Management App (Upcomming...)',
        'cat' => 'filter-personal',
        'desc' => '🧪 Tracks antibiotic release & return, real-time stock monitoring, ward-wise usage logs, and automated reports. <br> 📱 Built with Flutter & Firebase for cross-platform, cloud-powered management.',
        'img' => 'assets/img/portfolio/app/mediq-app.png',
        'link' => 'portfolio-details -mediq-app.php',
        'order' => 1
    ],
    [
        'title' => 'CeyTrack (Flutter + Firebase)',
        'cat' => 'filter-personal',
        'desc' => '🌾 Cey-Track App – Land-to-Factory Order Management & Geo-Location System<br> Allows landowners (Tea, Cinnamon, etc.) to submit orders while factories track total, pending & completed orders in real-time 📝',
        'img' => 'assets/img/portfolio/app/caytrack-app.png',
        'link' => 'portfolio-details -ceytrack-app.php',
        'order' => 2
    ],
    [
        'title' => 'Career Guideline System for ATI Galle',
        'cat' => 'filter-personal',
        'desc' => 'Advanced Career Guideline System<br> Intelligent Role-Based Career Platform for Education & Recruitment.',
        'img' => 'assets/img/portfolio/acgs/4.jpg',
        'link' => 'portfolio-details-advanced-carrier-guideline-system.php',
        'order' => 3
    ],
    [
        'title' => 'Learning Management System',
        'cat' => 'filter-personal',
        'desc' => 'Edulk Learning Management System. LMS with advanced features for students.',
        'img' => 'assets/img/portfolio/edulk/edulk.png',
        'link' => 'portfolio-details-edulk.php',
        'order' => 4
    ],
    [
        'title' => 'Antibiogram System – Karapitiya Hospital',
        'cat' => 'filter-offcial',
        'desc' => 'MediQ Antibiogram Analyze System.<br>Hospital-scale antibiotic sensitivity analysis system.',
        'img' => 'assets/img/portfolio/antibiogram.png',
        'link' => 'portfolio-details-antibiogram.php',
        'order' => 5
    ],
    [
        'title' => 'Southern Province Irrigation Department',
        'cat' => 'filter-offcial',
        'desc' => 'Irrigation Department Website.<br>Official government website redesign.',
        'img' => 'assets/img/portfolio/Screenshot 2025-09-01 111145.png',
        'link' => 'portfolio-details-spid-web.php',
        'order' => 6
    ],
    [
        'title' => 'Career Guideline & Learning Support System',
        'cat' => 'filter-hndit',
        'desc' => 'Eduwide – HNDIT 2nd Sem Project.<br>Career guideline + learning support system for students.',
        'img' => 'assets/img/portfolio/eduwide.png',
        'link' => 'portfolio-details-eduwide.php',
        'order' => 7
    ],
    [
        'title' => 'Antibiotic Usage Analysis Platform',
        'cat' => 'filter-offcial',
        'desc' => 'MediQ Antibiotic Analyze System.<br>Online antibiotic tracking & analytics system.',
        'img' => 'assets/img/portfolio/mediq.png',
        'link' => 'portfolio-details-mediq.php',
        'order' => 8
    ]
];

foreach($projects as $p) {
    // For description, use same text since it's short
    $stmt->bind_param("sssssi", $p['title'], $p['cat'], $p['desc'], $p['img'], $p['link'], $p['order']);
    $stmt->execute();
}

echo "Successfully seeded " . count($projects) . " projects into portfolio_projects.";
?>
