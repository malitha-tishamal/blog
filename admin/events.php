<?php
require_once 'includes/db.php';
check_admin_auth();

$message = '';
$upload_dir = '../assets/img/portfolio/';

// Handle Delete
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        $stmt = $conn->prepare("SELECT main_image FROM portfolio_events WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if($row) {
            $file_path = '../' . $row['main_image'];
            if(file_exists($file_path) && !is_dir($file_path)) {
                @unlink($file_path);
            }
        }
        $stmt = $conn->prepare("DELETE FROM portfolio_events WHERE id = ?");
        $stmt->execute([$id]);
        $message = "<div class='alert alert-warning'>Event deleted successfully.</div>";
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $highlight = $_POST['highlight_text'];
    $desc = $_POST['description'];
    $link = $_POST['link_url'];
    $gallery = $_POST['gallery_id'];
    $order = (int)$_POST['display_order'];

    $image_path = '';
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    // Handle Image Upload
    if(isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
        $ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
        $new_filename = uniqid('evt_') . '.' . $ext;
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
        try {
            if($id > 0) {
                // Update
                if($image_path != '') {
                    $stmt = $conn->prepare("SELECT main_image FROM portfolio_events WHERE id = ?");
                    $stmt->execute([$id]);
                    $row = $stmt->fetch();
                    if($row) {
                        @unlink('../'.$row['main_image']);
                    }
                    $stmt = $conn->prepare("UPDATE portfolio_events SET title=?, category=?, highlight_text=?, description=?, link_url=?, gallery_id=?, display_order=?, main_image=? WHERE id=?");
                    $stmt->execute([$title, $category, $highlight, $desc, $link, $gallery, $order, $image_path, $id]);
                } else {
                    $stmt = $conn->prepare("UPDATE portfolio_events SET title=?, category=?, highlight_text=?, description=?, link_url=?, gallery_id=?, display_order=? WHERE id=?");
                    $stmt->execute([$title, $category, $highlight, $desc, $link, $gallery, $order, $id]);
                }
                $msg = "Event updated successfully.";
            } else {
                // Insert
                if($image_path == '') {
                    $image_path = 'assets/img/portfolio/default-event.jpg';
                }
                $stmt = $conn->prepare("INSERT INTO portfolio_events (title, category, highlight_text, description, main_image, link_url, gallery_id, display_order) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$title, $category, $highlight, $desc, $image_path, $link, $gallery, $order]);
                $msg = "New event added successfully.";
            }
            $message = "<div class='alert alert-success'>$msg</div>";
        } catch (PDOException $e) {
            $message = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        }
    }
}

try {
    $entries = $conn->query("SELECT * FROM portfolio_events ORDER BY display_order ASC, id DESC")->fetchAll();
} catch (PDOException $e) {
    // Log error
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Events & Travel Portfolio - CMS</title>
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
            <a href="skills.php"><i class="bi bi-stars me-2"></i> Skills</a>
            <a href="portfolio.php"><i class="bi bi-laptop me-2"></i> App Projects</a>
            <a href="events.php" class="active"><i class="bi bi-camera me-2"></i> Events Gallery</a>
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
                <h2>Manage Events & Travel Portfolio</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#entryModal" onclick="resetForm()">
                    <i class="bi bi-plus-circle me-1"></i> Add Event
                </button>
            </div>
            
            <?php echo $message; ?>

            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover table-bordered mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">Image</th>
                                <th>Title & Highlight</th>
                                <th>Category</th>
                                <th>Order</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($entries) > 0): ?>
                                <?php foreach($entries as $row): ?>
                                <tr>
                                    <td class="text-center">
                                        <img src="../<?php echo htmlspecialchars($row['main_image']); ?>" class="proj-img">
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($row['title']); ?></strong><br>
                                        <small class="text-primary"><?php echo htmlspecialchars($row['highlight_text']); ?></small>
                                    </td>
                                    <td><span class="badge bg-secondary"><?php echo htmlspecialchars($row['category']); ?></span></td>
                                    <td><?php echo $row['display_order']; ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-secondary me-1" 
                                            onclick='editEntry(<?php echo json_encode($row); ?>)'>
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="events.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this event?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No events found. Add one!</td>
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
            <h5 class="modal-title" id="modalTitle">Add Event/Travel Entry</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-8 mb-3">
                      <label>Event/Location Title</label>
                      <input type="text" name="title" id="title" class="form-control" required placeholder="e.g. Badulla Travel Trip 2025">
                  </div>
                  <div class="col-md-4 mb-3">
                      <label>Category Filter</label>
                      <select name="category" id="category" class="form-select" required>
                          <option value="filter-events">Events & Wins</option>
                          <option value="filter-office">Office</option>
                          <option value="filter-traning">Training Programs</option>
                          <option value="filter-travel">Travel</option>
                      </select>
                  </div>
                  
                  <div class="col-md-6 mb-3">
                      <label>Highlight Text Banner</label>
                      <input type="text" name="highlight_text" id="highlight" class="form-control" placeholder="e.g. Matara → Badulla or INTROVA 1.0">
                  </div>
                  
                  <div class="col-md-6 mb-3">
                      <label>Gallery ID (Lightbox Group)</label>
                      <input type="text" name="gallery_id" id="gallery" class="form-control" placeholder="e.g. portfolio-gallery-travel">
                  </div>
                  
                  <div class="col-md-12 mb-3">
                      <label>Description (Supports HTML like &lt;br&gt;)</label>
                      <textarea name="description" id="desc" class="form-control" rows="3" required></textarea>
                  </div>
                  
                  <div class="col-md-12 mb-3">
                      <label>Cover Photo <small class="text-muted">(Leaves unchanged on Edit if empty)</small></label>
                      <input type="file" name="main_image" id="main_image" class="form-control" accept="image/*">
                  </div>
                  
                  <div class="col-md-8 mb-3">
                      <label>External Link (Facebook, LinkedIn, etc.)</label>
                      <input type="text" name="link_url" id="link" class="form-control" value="#">
                  </div>
                  
                  <div class="col-md-4 mb-3">
                      <label>Display Order</label>
                      <input type="number" name="display_order" id="order" class="form-control" value="0">
                  </div>
              </div>
          </div>
          <div class="modal-footer bg-light border-top-0">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="saveBtn">Save Entry</button>
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
        document.getElementById('modalTitle').innerText = 'Add Event/Travel Entry';
        document.getElementById('saveBtn').innerText = 'Save Entry';
        document.getElementById('main_image').required = true;
    }

    function editEntry(data) {
        document.getElementById('entryId').value = data.id;
        document.getElementById('title').value = data.title;
        document.getElementById('category').value = data.category;
        document.getElementById('highlight').value = data.highlight_text;
        document.getElementById('desc').value = data.description;
        document.getElementById('link').value = data.link_url;
        document.getElementById('gallery').value = data.gallery_id;
        document.getElementById('order').value = data.display_order;
        
        document.getElementById('main_image').required = false;
        
        document.getElementById('modalTitle').innerText = 'Edit Event Entry';
        document.getElementById('saveBtn').innerText = 'Update Entry';
        
        modal.show();
    }
</script>
</body>
</html>
