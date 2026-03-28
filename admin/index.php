<?php
require_once 'includes/db.php';
check_admin_auth();

// Fetch Quick Stats
$stats = [
    'views' => 0,
    'projects' => 0,
    'messages' => 0,
    'testimonials' => 0,
    'certifications' => 0,
    'experience' => 0,
    'education' => 0
];

try {
    // Views
    $stmt = $conn->query("SELECT total_views FROM site_views WHERE id = 1");
    $v_row = $stmt->fetch();
    if($v_row) $stats['views'] = $v_row['total_views'];

    // Projects
    $stmt = $conn->query("SELECT COUNT(*) as c FROM portfolio_projects");
    $p_row = $stmt->fetch();
    if($p_row) $stats['projects'] = $p_row['c'];

    // Unread Messages
    $stmt = $conn->query("SELECT COUNT(*) as c FROM contact_messages WHERE status = 'unread'");
    $m_row = $stmt->fetch();
    if($m_row) $stats['messages'] = $m_row['c'];

    // Testimonials
    $stmt = $conn->query("SELECT COUNT(*) as c FROM testimonials");
    $t_row = $stmt->fetch();
    if($t_row) $stats['testimonials'] = $t_row['c'];

    // Certifications
    $stmt = $conn->query("SELECT COUNT(*) as c FROM certifications");
    $cert_row = $stmt->fetch();
    if($cert_row) $stats['certifications'] = $cert_row['c'];

    // Resume
    $stmt = $conn->query("SELECT COUNT(*) as c FROM resume_experience");
    $exp_row = $stmt->fetch();
    if($exp_row) $stats['experience'] = $exp_row['c'];

    $stmt = $conn->query("SELECT COUNT(*) as c FROM resume_education");
    $edu_row = $stmt->fetch();
    if($edu_row) $stats['education'] = $edu_row['c'];

} catch (PDOException $e) {
    // In a production app, log this error
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Malitha Tishamal CMS</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Open Sans', sans-serif; }
        .sidebar { background-color: #212529; min-height: 100vh; padding-top: 20px; color: #fff;}
        .sidebar a { color: #c2c7d0; text-decoration: none; display: block; padding: 10px 20px; margin-bottom: 5px; border-radius: 4px;}
        .sidebar a:hover, .sidebar a.active { background-color: #0066cc; color: #fff; }
        .sidebar h4 { text-align: center; color: #fff; margin-bottom: 30px; font-weight: 700; }
        .content { padding: 30px; }
        .stat-card { border: none; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .stat-card .card-body { display: flex; align-items: center; justify-content: space-between; padding: 25px; }
        .stat-icon { font-size: 3rem; opacity: 0.3; }
        .stat-number { font-size: 2rem; font-weight: 700; margin: 0; }
        .stat-label { font-weight: 600; color: #6c757d; text-transform: uppercase; letter-spacing: 1px; font-size: 0.85rem;}
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="col-md-10 content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Dashboard Overview</h2>
                <span>Welcome, <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong>!</span>
            </div>

            <div class="row">
                <!-- Stat Card 1 -->
                <div class="col-md-3 mb-4">
                    <div class="card stat-card border-primary">
                        <div class="card-body">
                            <div>
                                <p class="stat-label">Total Views</p>
                                <h3 class="stat-number text-primary"><?php echo number_format($stats['views']); ?></h3>
                            </div>
                            <div class="stat-icon text-primary"><i class="bi bi-eye"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="col-md-3 mb-4">
                    <div class="card stat-card border-success">
                        <div class="card-body">
                            <div>
                                <p class="stat-label">Projects</p>
                                <h3 class="stat-number text-success"><?php echo number_format($stats['projects']); ?></h3>
                            </div>
                            <div class="stat-icon text-success"><i class="bi bi-grid-fill"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="col-md-3 mb-4">
                    <div class="card stat-card border-warning">
                        <div class="card-body">
                            <div>
                                <p class="stat-label">Unread Messages</p>
                                <h3 class="stat-number text-warning"><?php echo number_format($stats['messages']); ?></h3>
                            </div>
                            <div class="stat-icon text-warning"><i class="bi bi-chat-dots-fill"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 4 -->
                <div class="col-md-3 mb-4">
                    <div class="card stat-card border-info">
                        <div class="card-body">
                            <div>
                                <p class="stat-label">Testimonials</p>
                                <h3 class="stat-number text-info"><?php echo number_format($stats['testimonials']); ?></h3>
                            </div>
                            <div class="stat-icon text-info"><i class="bi bi-chat-quote-fill"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 5 -->
                <div class="col-md-3 mb-4">
                    <div class="card stat-card border-secondary">
                        <div class="card-body">
                            <div>
                                <p class="stat-label">Certifications</p>
                                <h3 class="stat-number text-secondary"><?php echo number_format($stats['certifications']); ?></h3>
                            </div>
                            <div class="stat-icon text-secondary"><i class="bi bi-award-fill"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 6 -->
                <div class="col-md-3 mb-4">
                    <div class="card stat-card border-dark">
                        <div class="card-body">
                            <div>
                                <p class="stat-label">Resume Items</p>
                                <h3 class="stat-number text-dark"><?php echo number_format($stats['experience'] + $stats['education']); ?></h3>
                            </div>
                            <div class="stat-icon text-dark"><i class="bi bi-file-earmark-person-fill"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Quick Actions</h5>
                        </div>
                        <div class="card-body text-center p-4">
                            <a href="portfolio.php" class="btn btn-lg btn-outline-primary m-2"><i class="bi bi-plus-circle me-1"></i> Add New Project</a>
                            <a href="resume.php" class="btn btn-lg btn-outline-success m-2"><i class="bi bi-plus-circle me-1"></i> Add Resume Entry</a>
                            <a href="skills.php" class="btn btn-lg btn-outline-info m-2"><i class="bi bi-stars me-1"></i> Manage Skills</a>
                            <a href="settings.php" class="btn btn-lg btn-outline-secondary m-2"><i class="bi bi-pencil-square me-1"></i> Site Settings</a>
                            <a href="messages.php" class="btn btn-lg btn-outline-warning m-2"><i class="bi bi-envelope me-1"></i> View Messages</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
