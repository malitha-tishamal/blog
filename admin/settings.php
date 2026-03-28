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

    $upload_dir = '../assets/img/profile/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $hero_image = $_POST['current_hero_image']; // fallback to current

    if (isset($_FILES['hero_image']) && $_FILES['hero_image']['error'] == 0) {
        $ext = pathinfo($_FILES['hero_image']['name'], PATHINFO_EXTENSION);
        $new_filename = 'hero_' . time() . '.' . $ext;
        $target_file = $upload_dir . $new_filename;
        
        $allowed = ['jpg','jpeg','png','webp','gif'];
        if (in_array(strtolower($ext), $allowed)) {
            if (move_uploaded_file($_FILES['hero_image']['tmp_name'], $target_file)) {
                $hero_image = 'assets/img/profile/' . $new_filename;
                // Optional: Delete old image if it's not the default
                if ($_POST['current_hero_image'] != 'assets/img/profile/profile-malitha.jpg' && file_exists('../'.$_POST['current_hero_image'])) {
                    @unlink('../'.$_POST['current_hero_image']);
                }
            }
        }
    }

    try {
        $stmt = $conn->prepare("UPDATE site_settings SET 
                    site_name = ?, 
                    hero_title = ?, 
                    hero_description = ?,
                    contact_email = ?,
                    contact_phone1 = ?,
                    address = ?,
                    cv_link = ?,
                    hero_image = ?
                  WHERE id = 1");
                  
        $stmt->execute([$site_name, $hero_title, $hero_desc, $contact_email, $contact_phone1, $address, $cv_link, $hero_image]);
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
        <?php include 'includes/sidebar.php'; ?>

        <div class="col-md-10 content">
            <h2>Site Settings & Hero Section</h2>
            <?php echo $message; ?>
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
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
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label>Hero Titles (Comma separated for typing effect)</label>
                                    <input type="text" name="hero_title" class="form-control" value="<?php echo htmlspecialchars($settings['hero_title']); ?>">
                                    <small class="text-muted">Example: Designer, Full-Stack Developer, Freelancer</small>
                                </div>
                                <div class="mb-3">
                                    <label>Hero Description</label>
                                    <textarea name="hero_description" class="form-control" rows="3"><?php echo htmlspecialchars($settings['hero_description']); ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Hero Profile Image</label>
                                    <input type="file" name="hero_image" class="form-control" accept="image/*">
                                    <input type="hidden" name="current_hero_image" value="<?php echo htmlspecialchars($settings['hero_image']); ?>">
                                    <small class="text-muted">Recommended: Transparent PNG or square JPG (High resolution)</small>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <label class="d-block mb-2">Current Hero Image</label>
                                <img src="../<?php echo htmlspecialchars($settings['hero_image']); ?>" class="img-thumbnail" style="max-height: 200px; border-radius: 15px;">
                            </div>
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
