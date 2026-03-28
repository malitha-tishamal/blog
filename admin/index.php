<?php
require_once 'includes/db.php';
check_admin_auth();

// Fetch Quick Stats
$stats = [
    'views' => 0,
    'projects' => 0,
    'messages' => 0,
    'testimonials' => 0
];

// Views
$v_res = $conn->query("SELECT total_views FROM site_views WHERE id = 1");
if($v_res && $v_row = $v_res->fetch_assoc()) $stats['views'] = $v_row['total_views'];

// Projects
$p_res = $conn->query("SELECT COUNT(*) as c FROM portfolio_projects");
if($p_res && $p_row = $p_res->fetch_assoc()) $stats['projects'] = $p_row['c'];

// Unread Messages (assuming we just created the table, might be empty)
$m_res = $conn->query("SELECT COUNT(*) as c FROM contact_messages WHERE status = 'unread'");
if($m_res && $m_row = $m_res->fetch_assoc()) $stats['messages'] = $m_row['c'];

// Testimonials
$t_res = $conn->query("SELECT COUNT(*) as c FROM testimonials");
if($t_res && $t_row = $t_res->fetch_assoc()) $stats['testimonials'] = $t_row['c'];

// Certifications
$cert_res = $conn->query("SELECT COUNT(*) FROM certifications");
$stats['certifications'] = ($cert_res) ? $cert_res->fetch_row()[0] : 0;

// Resume
$exp_res = $conn->query("SELECT COUNT(*) FROM resume_experience");
$stats['experience'] = ($exp_res) ? $exp_res->fetch_row()[0] : 0;
$edu_res = $conn->query("SELECT COUNT(*) FROM resume_education");
$stats['education'] = ($edu_res) ? $edu_res->fetch_row()[0] : 0;
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
        <!-- Sidebar -->
        <div class="col-md-2 d-none d-md-block sidebar">
            <h4>CMS Admin</h4>
            <a href="index.php" class="active"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
            <a href="settings.php"><i class="bi bi-gear me-2"></i> Site Settings</a>
            <a href="about.php"><i class="bi bi-person me-2"></i> About Me</a>
            <a href="resume.php"><i class="bi bi-file-earmark-person me-2"></i> Resume</a>
            <a href="skills.php"><i class="bi bi-stars me-2"></i> Skills</a>
            <a href="portfolio.php"><i class="bi bi-grid me-2"></i> Portfolio</a>
            <a href="events.php"><i class="bi bi-camera me-2"></i> Events Gallery</a>
            <a href="services.php"><i class="bi bi-briefcase me-2"></i> Services</a>
            <a href="testimonials.php"><i class="bi bi-chat-quote me-2"></i> Testimonials</a>
            <a href="certifications.php"><i class="bi bi-award me-2"></i> Licenses & Certifications</a>
            <a href="messages.php"><i class="bi bi-envelope me-2"></i> Messages</a>
            <hr class="text-secondary">
            <a href="../index.php" target="_blank"><i class="bi bi-box-arrow-up-right me-2"></i> View Site</a>
            <a href="logout.php" class="text-danger"><i class="bi bi-box-arrow-left me-2"></i> Logout</a>
        </div>

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
            <a href="skills.php"><i class="bi bi-stars me-2"></i> Skills</a>
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
