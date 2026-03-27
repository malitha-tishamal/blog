<?php
require_once 'includes/db.php';
check_admin_auth();

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    $stat_projects = (int)$_POST['stat_projects'];
    $stat_exp = (int)$_POST['stat_experience'];
    
    $query = "UPDATE about_section SET 
                title = '$title', 
                bio = '$bio', 
                stat_projects = $stat_projects,
                stat_experience = $stat_exp
              WHERE id = 1";
              
    if(mysqli_query($conn, $query)) {
        $message = "<div class='alert alert-success'>About section updated!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: ".mysqli_error($conn)."</div>";
    }
}

$res = $conn->query("SELECT * FROM about_section WHERE id = 1");
$about = $res->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Me - CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Open Sans', sans-serif; }
        .sidebar { background-color: #212529; min-height: 100vh; padding-top: 20px; color: #fff;}
        .sidebar a { color: #c2c7d0; text-decoration: none; display: block; padding: 10px 20px; margin-bottom: 5px; border-radius: 4px;}
        .sidebar a:hover, .sidebar a.active { background-color: #0066cc; color: #fff; }
        .content { padding: 30px; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 d-none d-md-block sidebar">
            <h4 class="text-center text-white mb-4 mt-2">CMS Admin</h4>
            <a href="index.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
            <a href="settings.php"><i class="bi bi-gear me-2"></i> Site Settings</a>
            <a href="about.php" class="active"><i class="bi bi-person me-2"></i> About Me</a>
            <a href="resume.php"><i class="bi bi-file-earmark-person me-2"></i> Resume</a>
            <a href="portfolio.php"><i class="bi bi-grid me-2"></i> App Projects</a>
            <a href="events.php"><i class="bi bi-camera me-2"></i> Events Gallery</a>
            <a href="services.php"><i class="bi bi-briefcase me-2"></i> Services</a>
            <a href="testimonials.php"><i class="bi bi-chat-quote me-2"></i> Testimonials</a>
            <a href="certifications.php"><i class="bi bi-award me-2"></i> Licenses & Certifications</a>
            <a href="messages.php"><i class="bi bi-envelope me-2"></i> Messages</a>
            <hr class="text-secondary">
            <a href="../index.php" target="_blank"><i class="bi bi-box-arrow-up-right me-2"></i> View Site</a>
            <a href="logout.php" class="text-danger"><i class="bi bi-box-arrow-left me-2"></i> Logout</a>
        </div>

        <div class="col-md-10 content">
            <h2>About Me Configuration</h2>
            <?php echo $message; ?>
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label>Section Title</label>
                            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($about['title']); ?>">
                        </div>
                        <div class="mb-3">
                            <label>Biography Details</label>
                            <textarea name="bio" class="form-control" rows="8"><?php echo htmlspecialchars($about['bio']); ?></textarea>
                            <small class="text-muted">HTML tags (like &lt;br&gt; or &lt;strong&gt;) are supported.</small>
                        </div>
                        
                        <h5 class="mt-4 mb-3 text-primary">Key Statistics</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Projects Completed</label>
                                <input type="number" name="stat_projects" class="form-control" value="<?php echo (int)$about['stat_projects']; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Years Experience</label>
                                <input type="number" name="stat_experience" class="form-control" value="<?php echo (int)$about['stat_experience']; ?>">
                            </div>
                        </div>

                        <!-- Add Image Update future extension comment to keep it simple for now -->
                        <p class="text-muted mt-3 mb-4"><i class="bi bi-info-circle"></i> Profile image upload will use the existing assets/img/profile mapping to preserve frontend consistency.</p>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary px-4">Update About Me</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
