<?php
require_once 'includes/db.php';
check_admin_auth();

$message = '';
$upload_dir = '../assets/img/portfolio/';

// Handle Delete
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    // Fetch image path to delete file
    $res = $conn->query("SELECT main_image FROM portfolio_projects WHERE id = $id");
    if($res && $row = $res->fetch_assoc()) {
        $file_path = '../' . $row['main_image'];
        if(file_exists($file_path) && !is_dir($file_path)) {
            unlink($file_path);
        }
    }
    $conn->query("DELETE FROM portfolio_projects WHERE id = $id");
    $message = "<div class='alert alert-success'>Project deleted successfully.</div>";
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $desc = mysqli_real_escape_string($conn, $_POST['short_description']);
    $link = mysqli_real_escape_string($conn, $_POST['details_link']);
    $order = (int)$_POST['display_order'];

    $image_path = '';
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    // Handle Image Upload
    if(isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
        $ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
        $new_filename = uniqid('proj_') . '.' . $ext;
        $target_file = $upload_dir . $new_filename;
        
        $allowed = ['jpg','jpeg','png','webp','gif'];
        if(in_array(strtolower($ext), $allowed)) {
            if(move_uploaded_file($_FILES['main_image']['tmp_name'], $target_file)) {
                $image_path = 'assets/img/portfolio/' . $new_filename;
            } else {
                $message = "<div class='alert alert-danger'>Failed to upload image.</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>Invalid file format. Only JPG, PNG, WEBP allowed.</div>";
        }
    }

    if(empty($message)) {
        if($id > 0) {
            // Update
            if($image_path != '') {
                // Remove old image
                $res = $conn->query("SELECT main_image FROM portfolio_projects WHERE id = $id");
                if($row = $res->fetch_assoc()) {
                    @unlink('../'.$row['main_image']);
                }
                $query = "UPDATE portfolio_projects SET title='$title', category='$category', short_description='$desc', details_link='$link', display_order=$order, main_image='$image_path' WHERE id=$id";
            } else {
                $query = "UPDATE portfolio_projects SET title='$title', category='$category', short_description='$desc', details_link='$link', display_order=$order WHERE id=$id";
            }
            $msg = "Project updated successfully.";
        } else {
            // Insert
            if($image_path == '') {
                $image_path = 'assets/img/portfolio/default-project.jpg'; // fallback
            }
            $query = "INSERT INTO portfolio_projects (title, category, short_description, main_image, details_link, display_order) 
                      VALUES ('$title', '$category', '$desc', '$image_path', '$link', $order)";
            $msg = "New project added successfully.";
        }

        if(mysqli_query($conn, $query)) {
            $message = "<div class='alert alert-success'>$msg</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: ".mysqli_error($conn)."</div>";
        }
    }
}

// Fetch existing entries
$entries = $conn->query("SELECT * FROM portfolio_projects ORDER BY display_order ASC, id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Portfolio - CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Open Sans', sans-serif; }
        .sidebar { background-color: #212529; min-height: 100vh; padding-top: 20px; color: #fff;}
        .sidebar a { color: #c2c7d0; text-decoration: none; display: block; padding: 10px 20px; margin-bottom: 5px; border-radius: 4px;}
        .sidebar a:hover, .sidebar a.active { background-color: #0066cc; color: #fff; }
        .content { padding: 30px; }
        .proj-img { width: 80px; height: 60px; object-fit: cover; border-radius: 4px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);}
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
            <a href="about.php"><i class="bi bi-person me-2"></i> About Me</a>
            <a href="resume.php"><i class="bi bi-file-earmark-person me-2"></i> Resume</a>
            <a href="portfolio.php" class="active"><i class="bi bi-grid me-2"></i> App Projects</a>
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Manage Portfolio Projects</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#entryModal" onclick="resetForm()">
                    <i class="bi bi-plus-circle me-1"></i> Add Project
                </button>
            </div>
            
            <?php echo $message; ?>

            <!-- Entries Table -->
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover table-bordered mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Order</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($entries->num_rows > 0): ?>
                                <?php while($row = $entries->fetch_assoc()): ?>
                                <tr>
                                    <td class="text-center">
                                        <img src="../<?php echo htmlspecialchars($row['main_image']); ?>" class="proj-img" alt="Proj Image">
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($row['title']); ?></strong>
                                        <div class="small text-muted text-truncate" style="max-width:300px;"><?php echo htmlspecialchars($row['short_description']); ?></div>
                                    </td>
                                    <td><span class="badge bg-secondary"><?php echo htmlspecialchars($row['category']); ?></span></td>
                                    <td><?php echo $row['display_order']; ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-secondary me-1" 
                                            onclick='editEntry(<?php echo json_encode($row); ?>)'>
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="portfolio.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('WARNING: This will delete the project mapping completely. Continue?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No projects found. Add a portfolio project above!</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="entryModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" id="entryForm" enctype="multipart/form-data">
          <!-- Hidden field to signify standard action processing -->
          <input type="hidden" name="action" value="save">
          <input type="hidden" name="id" id="entryId">
          
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Add Portfolio Project</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-8 mb-3">
                      <label>Project Title</label>
                      <input type="text" name="title" id="title" class="form-control" required placeholder="e.g. MediQ Healthcare App">
                  </div>
                  <div class="col-md-4 mb-3">
                      <label>Category Group</label>
                      <select name="category" id="category" class="form-select" required>
                          <option value="filter-customer">Customers Projects</option>
                            <option value="filter-hndit">HNDIT Projects</option>
                          <option value="filter-personal">Personal Projects</option>
                          <option value="filter-offcial">Goverment Projects</option>
                      </select>
                  </div>
                  
                  <div class="col-md-12 mb-3">
                      <label>Short Description (Shown on Card Hover)</label>
                      <textarea name="short_description" id="desc" class="form-control" rows="2" required placeholder="Describe what this project is..."></textarea>
                  </div>
                  
                  <div class="col-md-12 mb-3">
                      <label>Main Cover Image <small class="text-muted">(Leaves unchanged on Edit if empty)</small></label>
                      <input type="file" name="main_image" id="main_image" class="form-control" accept="image/*">
                      <small class="text-muted">Recommended resolution: 800x600 pixels.</small>
                  </div>
                  
                  <div class="col-md-8 mb-3">
                      <label>Portfolio Details Page Link</label>
                      <input type="text" name="details_link" id="link" class="form-control" value="portfolio-details.php" required>
                      <small class="text-muted">Example: portfolio-details-mediq.php</small>
                  </div>
                  
                  <div class="col-md-4 mb-3">
                      <label>Display Order</label>
                      <input type="number" name="display_order" id="order" class="form-control" value="0">
                  </div>
              </div>
          </div>
          <div class="modal-footer bg-light border-top-0">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="saveBtn">Save Project</button>
          </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const modal = new bootstrap.Modal(document.getElementById('entryModal'));
    
    function resetForm() {
        document.getElementById('entryForm').reset();
        document.getElementById('entryId').value = '';
        document.getElementById('modalTitle').innerText = 'Add Portfolio Project';
        document.getElementById('saveBtn').innerText = 'Save Project';
        document.getElementById('main_image').required = true;
    }

    function editEntry(data) {
        document.getElementById('entryId').value = data.id;
        document.getElementById('title').value = data.title;
        document.getElementById('category').value = data.category;
        document.getElementById('desc').value = data.short_description;
        document.getElementById('link').value = data.details_link;
        document.getElementById('order').value = data.display_order;
        
        // Image isn't strictly required when editing
        document.getElementById('main_image').required = false;
        
        document.getElementById('modalTitle').innerText = 'Edit Portfolio Project';
        document.getElementById('saveBtn').innerText = 'Update Project';
        
        modal.show();
    }
</script>
</body>
</html>
