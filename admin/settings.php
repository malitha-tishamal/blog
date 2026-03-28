<?php
require_once 'includes/db.php';
check_admin_auth();

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $site_name = $_POST['site_name'];
    $hero_title = $_POST['hero_title'];
    $hero_desc = $_POST['hero_description'];
    $contact_email = $_POST['contact_email'];
    $contact_phone1 = $_POST['contact_phone1'];
    $address = $_POST['address'];
    $cv_link = $_POST['cv_link'];

    try {
        $stmt = $conn->prepare("UPDATE site_settings SET 
                    site_name = ?, 
                    hero_title = ?, 
                    hero_description = ?,
                    contact_email = ?,
                    contact_phone1 = ?,
                    address = ?,
                    cv_link = ?
                  WHERE id = 1");
                  
        $stmt->execute([$site_name, $hero_title, $hero_desc, $contact_email, $contact_phone1, $address, $cv_link]);
        $message = "<div class='alert alert-success'>Settings updated successfully.</div>";
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Error updating settings: " . $e->getMessage() . "</div>";
    }
}

try {
    $stmt = $conn->query("SELECT * FROM site_settings WHERE id = 1");
    $settings = $stmt->fetch();
} catch (PDOException $e) {
    // Log error
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Site Settings - CMS</title>
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
            <a href="settings.php" class="active"><i class="bi bi-gear me-2"></i> Site Settings</a>
            <a href="about.php"><i class="bi bi-person me-2"></i> About Me</a>
            <a href="resume.php"><i class="bi bi-file-earmark-person me-2"></i> Resume</a>
            <a href="skills.php"><i class="bi bi-stars me-2"></i> Skills</a>
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
            <h2>Site Settings & Hero Section</h2>
            <?php echo $message; ?>
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <form method="POST">
                        <h5 class="mb-3 text-primary">Global Settings</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Site Name (Nav Logo Text)</label>
                                <input type="text" name="site_name" class="form-control" value="<?php echo htmlspecialchars($settings['site_name']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>CV Download Link</label>
                                <input type="text" name="cv_link" class="form-control" value="<?php echo htmlspecialchars($settings['cv_link']); ?>">
                            </div>
                        </div>

                        <hr>
                        <h5 class="mb-3 text-primary mt-4">Hero Section (Top of site)</h5>
                        <div class="mb-3">
                            <label>Hero Titles (Comma separated for typing effect)</label>
                            <input type="text" name="hero_title" class="form-control" value="<?php echo htmlspecialchars($settings['hero_title']); ?>">
                            <small class="text-muted">Example: Designer, Full-Stack Developer, Freelancer</small>
                        </div>
                        <div class="mb-3">
                            <label>Hero Description</label>
                            <textarea name="hero_description" class="form-control" rows="3"><?php echo htmlspecialchars($settings['hero_description']); ?></textarea>
                        </div>
                        
                        <hr>
                        <h5 class="mb-3 text-primary mt-4">Contact Information</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Email Address</label>
                                <input type="email" name="contact_email" class="form-control" value="<?php echo htmlspecialchars($settings['contact_email']); ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Phone Number</label>
                                <input type="text" name="contact_phone1" class="form-control" value="<?php echo htmlspecialchars($settings['contact_phone1']); ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($settings['address']); ?>">
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary px-4">Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
