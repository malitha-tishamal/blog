<?php
require_once 'includes/db.php';
check_admin_auth();

$message = '';

// Handle Delete
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM services WHERE id = $id");
    $message = "<div class='alert alert-success'>Service deleted successfully.</div>";
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $icon = mysqli_real_escape_string($conn, $_POST['icon_class']);
    $order = (int)$_POST['display_order'];

    if(!empty($_POST['id'])) {
        // Update
        $id = (int)$_POST['id'];
        $query = "UPDATE services SET 
                    title='$title', description='$desc', icon_class='$icon', display_order=$order 
                  WHERE id=$id";
        $msg = "Service updated successfully.";
    } else {
        // Insert
        $query = "INSERT INTO services (title, description, icon_class, display_order) 
                  VALUES ('$title', '$desc', '$icon', $order)";
        $msg = "New service added successfully.";
    }

    if(mysqli_query($conn, $query)) {
        $message = "<div class='alert alert-success'>$msg</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: ".mysqli_error($conn)."</div>";
    }
}

// Fetch existing entries
$entries = $conn->query("SELECT * FROM services ORDER BY display_order ASC, id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Services - CMS</title>
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
            <a href="about.php"><i class="bi bi-person me-2"></i> About Me</a>
            <a href="resume.php"><i class="bi bi-file-earmark-person me-2"></i> Resume</a>
            <a href="portfolio.php"><i class="bi bi-grid me-2"></i> Portfolio</a>
            <a href="events.php"><i class="bi bi-camera me-2"></i> Events Gallery</a>
            <a href="services.php" class="active"><i class="bi bi-briefcase me-2"></i> Services</a>
            <a href="testimonials.php"><i class="bi bi-chat-quote me-2"></i> Testimonials</a>
            <a href="messages.php"><i class="bi bi-envelope me-2"></i> Messages</a>
            <hr class="text-secondary">
            <a href="../index.php" target="_blank"><i class="bi bi-box-arrow-up-right me-2"></i> View Site</a>
            <a href="logout.php" class="text-danger"><i class="bi bi-box-arrow-left me-2"></i> Logout</a>
        </div>

        <div class="col-md-10 content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Manage Services</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#entryModal" onclick="resetForm()">
                    <i class="bi bi-plus-circle me-1"></i> Add Service
                </button>
            </div>
            
            <?php echo $message; ?>

            <!-- Entries Table -->
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Icon</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Order</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($entries->num_rows > 0): ?>
                                <?php while($row = $entries->fetch_assoc()): ?>
                                <tr>
                                    <td class="text-center fs-4"><i class="<?php echo htmlspecialchars($row['icon_class']); ?> text-primary"></i></td>
                                    <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                                    <td><?php echo htmlspecialchars(substr($row['description'], 0, 50)) . '...'; ?></td>
                                    <td><?php echo $row['display_order']; ?></td>
                                    <td class="text-center">
                                        <!-- Edit button passes data to JS -->
                                        <button class="btn btn-sm btn-outline-secondary me-1" 
                                            onclick='editEntry(<?php echo json_encode($row); ?>)'>
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="services.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this service?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No services found. Add one above!</td>
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
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="entryForm">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Add Service</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
              <input type="hidden" name="id" id="entryId">
              <div class="mb-3">
                  <label>Service Title</label>
                  <input type="text" name="title" id="title" class="form-control" required placeholder="e.g. Web Development">
              </div>
              <div class="mb-3">
                  <label>Bootstrap Icon Class</label>
                  <input type="text" name="icon_class" id="icon" class="form-control" required placeholder="e.g. bi bi-laptop">
                  <small class="text-muted"><a href="https://icons.getbootstrap.com/" target="_blank">Search icons here</a></small>
              </div>
              <div class="mb-3">
                  <label>Display Order</label>
                  <input type="number" name="display_order" id="order" class="form-control" value="0">
              </div>
              <div class="mb-3">
                  <label>Service Description</label>
                  <textarea name="description" id="desc" class="form-control" rows="4" required></textarea>
              </div>
          </div>
          <div class="modal-footer bg-light border-top-0">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="saveBtn">Save Service</button>
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
        document.getElementById('modalTitle').innerText = 'Add Service';
        document.getElementById('saveBtn').innerText = 'Save Service';
    }

    function editEntry(data) {
        document.getElementById('entryId').value = data.id;
        document.getElementById('title').value = data.title;
        document.getElementById('icon').value = data.icon_class;
        document.getElementById('desc').value = data.description;
        document.getElementById('order').value = data.display_order;
        
        document.getElementById('modalTitle').innerText = 'Edit Service';
        document.getElementById('saveBtn').innerText = 'Update Service';
        
        modal.show();
    }
</script>
</body>
</html>
