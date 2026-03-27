<?php
require_once 'includes/db.php';
check_admin_auth();

$message = '';

// Handle Delete
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM resume_entries WHERE id = $id");
    $message = "<div class='alert alert-success'>Entry deleted successfully.</div>";
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $org = mysqli_real_escape_string($conn, $_POST['organization']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $order = (int)$_POST['display_order'];

    if(!empty($_POST['id'])) {
        // Update
        $id = (int)$_POST['id'];
        $query = "UPDATE resume_entries SET 
                    type='$type', title='$title', organization='$org', duration='$duration', 
                    description='$desc', display_order=$order 
                  WHERE id=$id";
        $msg = "Entry updated successfully.";
    } else {
        // Insert
        $query = "INSERT INTO resume_entries (type, title, organization, duration, description, display_order) 
                  VALUES ('$type', '$title', '$org', '$duration', '$desc', $order)";
        $msg = "New entry added successfully.";
    }

    if(mysqli_query($conn, $query)) {
        $message = "<div class='alert alert-success'>$msg</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: ".mysqli_error($conn)."</div>";
    }
}

// Fetch existing entries
$entries = $conn->query("SELECT * FROM resume_entries ORDER BY type, display_order ASC, id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resume Timeline - CMS</title>
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
            <a href="resume.php" class="active"><i class="bi bi-file-earmark-person me-2"></i> Resume</a>
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

        <div class="col-md-10 content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Manage Resume Timeline</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#entryModal" onclick="resetForm()">
                    <i class="bi bi-plus-circle me-1"></i> Add New Entry
                </button>
            </div>
            
            <?php echo $message; ?>

            <!-- Entries Table -->
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Type</th>
                                <th>Title</th>
                                <th>Organization</th>
                                <th>Duration</th>
                                <th>Order</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($entries->num_rows > 0): ?>
                                <?php while($row = $entries->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <?php if($row['type'] == 'education'): ?>
                                            <span class="badge bg-info text-dark">Education</span>
                                        <?php else: ?>
                                            <span class="badge bg-primary">Experience</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($row['organization']); ?></td>
                                    <td><?php echo htmlspecialchars($row['duration']); ?></td>
                                    <td><?php echo $row['display_order']; ?></td>
                                    <td class="text-center border-start-0">
                                        <!-- Edit button passes data to JS -->
                                        <button class="btn btn-sm btn-outline-secondary me-1" 
                                            onclick='editEntry(<?php echo json_encode($row); ?>)'>
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="resume.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this entry?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No resume entries found. Create one above!</td>
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
      <form method="POST" id="entryForm">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Add Resume Entry</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
              <input type="hidden" name="id" id="entryId">
              <div class="row">
                  <div class="col-md-6 mb-3">
                      <label>Entry Type</label>
                      <select name="type" id="type" class="form-select" required>
                          <option value="education">Education</option>
                          <option value="experience">Professional Experience</option>
                      </select>
                  </div>
                  <div class="col-md-6 mb-3">
                      <label>Display Order</label>
                      <input type="number" name="display_order" id="order" class="form-control" value="0">
                      <small class="text-muted">Lower numbers show up first</small>
                  </div>
                  <div class="col-md-12 mb-3">
                      <label>Title / Role</label>
                      <input type="text" name="title" id="title" class="form-control" required placeholder="e.g. Master of Fine Arts or Senior Developer">
                  </div>
                  <div class="col-md-7 mb-3">
                      <label>Organization / University</label>
                      <input type="text" name="organization" id="org" class="form-control" required>
                  </div>
                  <div class="col-md-5 mb-3">
                      <label>Duration / Year</label>
                      <input type="text" name="duration" id="duration" class="form-control" required placeholder="e.g. 2020 - 2023 or 2015">
                  </div>
                  <div class="col-md-12 mb-3">
                      <label>Description Details</label>
                      <textarea name="description" id="desc" class="form-control" rows="5"></textarea>
                      <small class="text-muted">Supports HTML. Use &lt;ul&gt;&lt;li&gt;Item&lt;/li&gt;&lt;/ul&gt; for bullet points.</small>
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
        document.getElementById('modalTitle').innerText = 'Add Resume Entry';
        document.getElementById('saveBtn').innerText = 'Save Entry';
    }

    function editEntry(data) {
        document.getElementById('entryId').value = data.id;
        document.getElementById('type').value = data.type;
        document.getElementById('title').value = data.title;
        document.getElementById('org').value = data.organization;
        document.getElementById('duration').value = data.duration;
        document.getElementById('desc').value = data.description;
        document.getElementById('order').value = data.display_order;
        
        document.getElementById('modalTitle').innerText = 'Edit Resume Entry';
        document.getElementById('saveBtn').innerText = 'Update Entry';
        
        modal.show();
    }
</script>
</body>
</html>
