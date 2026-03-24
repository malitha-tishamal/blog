<?php
require_once 'includes/db-conn.php';

$sql = "CREATE TABLE IF NOT EXISTS portfolio_events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    highlight_text VARCHAR(255),
    description TEXT,
    main_image VARCHAR(255),
    link_url VARCHAR(255),
    gallery_id VARCHAR(100),
    display_order INT DEFAULT 0
)";

if($conn->query($sql)) {
    echo "Table portfolio_events created successfully.\n";
} else {
    echo "Error: " . $conn->error . "\n";
}

// Ensure the portfolio_projects table has what it needs and hasn't been corrupted
// We will also insert the static items into portfolio_events to bootstrap it if empty.

$check = $conn->query("SELECT COUNT(*) as dcnt FROM portfolio_events");
$row = $check->fetch_assoc();
if($row['dcnt'] == 0) {
    echo "Inserting initial data into portfolio_events...\n";
    $stmt = $conn->prepare("INSERT INTO portfolio_events (title, category, highlight_text, description, main_image, link_url, gallery_id, display_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Item 1
    $t1 = "Project Presentation"; $c1 = "filter-events"; $h1 = "INTROVA 1.0 HNDIT Event";
    $d1 = "🏆 Top Performer – Project Presentation for Lecture Panel.<br>My project: <strong>Learning Management System</strong>";
    $m1 = "assets/img/portfolio/Screenshot 2025-08-17 203217.png";
    $l1 = "https://www.linkedin.com/posts/malitha-tishamal_applicationdevelopment-webdevelopment-innovation-activity-7271807286140911617-vdts?utm_source=share&utm_medium=member_desktop&rcm=ACoAACt-9MEB0xnd63ORqOqlYjGi186im0mO314";
    $g1 = "portfolio-gallery-development"; $o1 = 1;
    $stmt->bind_param("sssssssi", $t1, $c1, $h1, $d1, $m1, $l1, $g1, $o1); $stmt->execute();

    // Item 2
    $t2 = "ATI – Advanced Technological Institute, Galle"; $c2 = "filter-events"; $h2 = "Official Website Launch";
    $d2 = "The official website of ATI Galle was launched on December 22nd with the participation of the Director and lecture staff. I was proud to be a part of the developer team contributing to this digital milestone.";
    $m2 = "assets/img/portfolio/WhatsApp Image 2026-01-04 at 6.57.01 PM.jpeg";
    $l2 = "https://www.linkedin.com/posts/malitha-tishamal_atigalle-officiallaunch-hndit-activity-7412887393747263488-I2hx?utm_source=share&utm_medium=member_desktop&rcm=ACoAACt-9MEB0xnd63ORqOqlYjGi186im0mO314";
    $g2 = "portfolio-gallery-events"; $o2 = 2;
    $stmt->bind_param("sssssssi", $t2, $c2, $h2, $d2, $m2, $l2, $g2, $o2); $stmt->execute();
    
    // Item 3
    $t3 = "Irrigation Department – Galle"; $c3 = "filter-office"; $h3 = "Software Development";
    $d3 = "💻 Working as a Full Stack Developer – developed both Web and Mobile applications for the Irrigation Department, Galle. Contributed to database design, backend logic, and responsive frontend interfaces.";
    $m3 = "assets/img/portfolio/WhatsApp Image 2025-08-18 at 11.44.13_11535d1b.jpg";
    $l3 = "https://www.linkedin.com/posts/malitha-tishamal_just-be-yourself-irrigation-department-activity-7341829512214548481-D_IS?utm_source=share&utm_medium=member_desktop&rcm=ACoAACt-9MEB0xnd63ORqOqlYjGi186im0mO314";
    $g3 = "portfolio-gallery-photography"; $o3 = 3;
    $stmt->bind_param("sssssssi", $t3, $c3, $h3, $d3, $m3, $l3, $g3, $o3); $stmt->execute();

    // Item 4
    $t4 = "Badulla Travel Trip 2025"; $c4 = "filter-travel"; $h4 = "Matara → Badulla";
    $d4 = "Dunhida Waterfall, Kubalwela Maha Asapuwa, Ella & Scenic Views";
    $m4 = "assets/img/portfolio/WhatsApp Image 2025-08-18 at 18.48.11_8440db55.jpg";
    $l4 = "https://www.facebook.com/share/p/17JmYsWetd/";
    $g4 = "portfolio-gallery-travel"; $o4 = 4;
    $stmt->bind_param("sssssssi", $t4, $c4, $h4, $d4, $m4, $l4, $g4, $o4); $stmt->execute();
    
    // Item 5
    $t5 = "Night Mail Train Journey"; $c5 = "filter-travel"; $h5 = "Colombo → Badulla";
    $d5 = "Colombo to Badulla • Night Ride • Hill Country Experience";
    $m5 = "assets/img/portfolio/WhatsApp Image 2025-08-18 at 18.48.12_fec59360.jpg";
    $l5 = "https://www.facebook.com/share/p/16fr1VLJ5d/";
    $g5 = "portfolio-gallery-travel"; $o5 = 5;
    $stmt->bind_param("sssssssi", $t5, $c5, $h5, $d5, $m5, $l5, $g5, $o5); $stmt->execute();
    
    // Item 6
    $t6 = "Nuwara Eliya Travel Experience"; $c6 = "filter-travel"; $h6 = "Nuwara Eliya";
    $d6 = "Little England • Tea Gardens • Cool Climate";
    $m6 = "assets/img/portfolio/WhatsApp Image 2025-08-18 at 18.48.08_a79e85cc.jpg";
    $l6 = "https://www.facebook.com/share/p/1D6n51RXdD/";
    $g6 = "portfolio-gallery-travel"; $o6 = 6;
    $stmt->bind_param("sssssssi", $t6, $c6, $h6, $d6, $m6, $l6, $g6, $o6); $stmt->execute();
    
    echo "Initial data seeded.\n";
}
?>
