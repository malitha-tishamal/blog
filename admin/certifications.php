<?php
require_once 'includes/db.php';
check_admin_auth();

$message = '';
$upload_dir = '../assets/img/certifications/';

// Ensure dir exists
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Handle Delete
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $res = $conn->query("SELECT logo, media_image FROM certifications WHERE id = $id");
    if($res && $row = $res->fetch_assoc()) {
        if(!empty($row['logo']) && file_exists('../' . $row['logo'])) unlink('../' . $row['logo']);
        if(!empty($row['media_image']) && file_exists('../' . $row['media_image'])) unlink('../' . $row['media_image']);
    }
    $conn->query("DELETE FROM certifications WHERE id = $id");
    $message = "<div class='alert alert-success'>Certification deleted successfully.</div>";
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $org = mysqli_real_escape_string($conn, $_POST['organization']);
    $issue_month = mysqli_real_escape_string($conn, $_POST['issue_month']);
    $issue_year = (int)$_POST['issue_year'];
    $expiry_month = mysqli_real_escape_string($conn, $_POST['expiry_month']);
    $expiry_year = isset($_POST['expiry_year']) && $_POST['expiry_year'] != '' ? (int)$_POST['expiry_year'] : 'NULL';
    $cred_id = mysqli_real_escape_string($conn, $_POST['credential_id']);
    $cred_url = mysqli_real_escape_string($conn, $_POST['credential_url']);
    $skills = mysqli_real_escape_string($conn, $_POST['skills']);
    $order = (int)$_POST['display_order'];

    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    
    // Fetch old paths if editing
    $logo_path = '';
    $media_path = '';
    if($id > 0) {
        $old_res = $conn->query("SELECT logo, media_image FROM certifications WHERE id = $id");
        if($old_row = $old_res->fetch_assoc()) {
            $logo_path = $old_row['logo'];
            $media_path = $old_row['media_image'];
        }
    }

    // Handle Logo Upload
    if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $new_filename = uniqid('logo_') . '.' . $ext;
        if(move_uploaded_file($_FILES['logo']['tmp_name'], $upload_dir . $new_filename)) {
            if($id > 0 && !empty($logo_path) && file_exists('../' . $logo_path)) { @unlink('../' . $logo_path); }
            $logo_path = 'assets/img/certifications/' . $new_filename;
        }
    }

    // Handle Media Upload
    if(isset($_FILES['media_image']) && $_FILES['media_image']['error'] == 0) {
        $ext = pathinfo($_FILES['media_image']['name'], PATHINFO_EXTENSION);
        $new_filename = uniqid('media_') . '.' . $ext;
        if(move_uploaded_file($_FILES['media_image']['tmp_name'], $upload_dir . $new_filename)) {
            if($id > 0 && !empty($media_path) && file_exists('../' . $media_path)) { @unlink('../' . $media_path); }
            $media_path = 'assets/img/certifications/' . $new_filename;
        }
    }

    if($id > 0) {
        $query = "UPDATE certifications SET 
                    title='$title', organization='$org', issue_month='$issue_month', issue_year=$issue_year, 
                    expiry_month='$expiry_month', expiry_year=$expiry_year, credential_id='$cred_id', 
                    credential_url='$cred_url', skills='$skills', display_order=$order, 
                    logo='$logo_path', media_image='$media_path' 
                  WHERE id=$id";
        $msg = "Certification updated successfully.";
    } else {
        $query = "INSERT INTO certifications (title, organization, issue_month, issue_year, expiry_month, expiry_year, credential_id, credential_url, skills, display_order, logo, media_image) 
                  VALUES ('$title', '$org', '$issue_month', $issue_year, '$expiry_month', $expiry_year, '$cred_id', '$cred_url', '$skills', $order, '$logo_path', '$media_path')";
        $msg = "New certification added successfully.";
    }

    if(mysqli_query($conn, $query)) {
        $message = "<div class='alert alert-success'>$msg</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: ".mysqli_error($conn)."</div>";
    }
}

// Fetch existing
$entries = $conn->query("SELECT * FROM certifications ORDER BY display_order ASC, id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certifications - CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Open Sans', sans-serif; }
        .sidebar { background-color: #212529; min-height: 100vh; padding-top: 20px; color: #fff;}
        .sidebar a { color: #c2c7d0; text-decoration: none; display: block; padding: 10px 20px; margin-bottom: 5px; border-radius: 4px;}
        .sidebar a:hover, .sidebar a.active { background-color: #0066cc; color: #fff; }
        .content { padding: 30px; }
        .cert-logo { width: 50px; height: 50px; object-fit: contain; background: #fff; border-radius: 4px; padding: 2px;}
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
            <a href="certifications.php" class="active"><i class="bi bi-award me-2"></i> Certifications</a>
            <a href="portfolio.php"><i class="bi bi-grid me-2"></i> App Projects</a>
            <a href="events.php"><i class="bi bi-camera me-2"></i> Events Gallery</a>
            <a href="services.php"><i class="bi bi-briefcase me-2"></i> Services</a>
            <a href="testimonials.php"><i class="bi bi-chat-quote me-2"></i> Testimonials</a>
            <a href="messages.php"><i class="bi bi-envelope me-2"></i> Messages</a>
            <hr class="text-secondary">
            <a href="../index.php" target="_blank"><i class="bi bi-box-arrow-up-right me-2"></i> View Site</a>
            <a href="logout.php" class="text-danger"><i class="bi bi-box-arrow-left me-2"></i> Logout</a>
        </div>

        <div class="col-md-10 content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Manage Licenses & Certifications</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#entryModal" onclick="resetForm()">
                    <i class="bi bi-plus-circle me-1"></i> Add Certification
                </button>
            </div>
            
            <?php echo $message; ?>

            <!-- Entries Table -->
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover table-bordered mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">Logo</th>
                                <th>Name & Organization</th>
                                <th>Issue Date</th>
                                <th>Order</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($entries->num_rows > 0): ?>
                                <?php while($row = $entries->fetch_assoc()): ?>
                                <tr>
                                    <td class="text-center">
                                        <?php if(!empty($row['logo'])): ?>
                                            <img src="../<?php echo htmlspecialchars($row['logo']); ?>" class="cert-logo border" alt="Logo">
                                        <?php else: ?>
                                            <div class="bg-light text-muted d-inline-block border text-center" style="width:50px; height:50px; line-height: 50px;">-</div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($row['title']); ?></strong><br>
                                        <small class="text-muted"><?php echo htmlspecialchars($row['organization']); ?></small>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($row['issue_month']); ?> <?php echo htmlspecialchars($row['issue_year']); ?>
                                    </td>
                                    <td><?php echo $row['display_order']; ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-secondary me-1" 
                                            onclick='editEntry(<?php echo json_encode($row); ?>)'>
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="certifications.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this certification?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No certifications found. Add one above!</td>
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
          <input type="hidden" name="action" value="save">
          <input type="hidden" name="id" id="entryId">
          
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Add Certification</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-12 mb-3">
                      <label>Name (Title)*</label>
                      <input type="text" name="title" id="title" class="form-control" required placeholder="Ex: Microsoft Certified Network Associate">
                  </div>
                  <div class="col-md-12 mb-3">
                      <label>Issuing Organization*</label>
                      <input type="text" name="organization" id="organization" class="form-control" required placeholder="Ex: Microsoft">
                  </div>
                  
                  <div class="col-md-3 mb-3">
                      <label>Issue Month</label>
                      <select name="issue_month" id="issue_month" class="form-select">
                          <option value="">Month</option>
                          <option>Jan</option><option>Feb</option><option>Mar</option><option>Apr</option><option>May</option><option>Jun</option>
                          <option>Jul</option><option>Aug</option><option>Sep</option><option>Oct</option><option>Nov</option><option>Dec</option>
                      </select>
                  </div>
                  <div class="col-md-3 mb-3">
                      <label>Issue Year</label>
                      <input type="number" name="issue_year" id="issue_year" class="form-control" placeholder="Year" required>
                  </div>

                  <div class="col-md-3 mb-3">
                      <label>Expiration Month</label>
                      <select name="expiry_month" id="expiry_month" class="form-select">
                          <option value="">Month</option>
                          <option>Jan</option><option>Feb</option><option>Mar</option><option>Apr</option><option>May</option><option>Jun</option>
                          <option>Jul</option><option>Aug</option><option>Sep</option><option>Oct</option><option>Nov</option><option>Dec</option>
                      </select>
                  </div>
                  <div class="col-md-3 mb-3">
                      <label>Expiration Year</label>
                      <input type="number" name="expiry_year" id="expiry_year" class="form-control" placeholder="Year">
                  </div>
                  
                  <div class="col-md-6 mb-3">
                      <label>Credential ID</label>
                      <input type="text" name="credential_id" id="credential_id" class="form-control">
                  </div>
                  <div class="col-md-6 mb-3">
                      <label>Credential URL</label>
                      <input type="url" name="credential_url" id="credential_url" class="form-control">
                  </div>

                  <div class="col-md-12 mb-3">
                      <label>Skills <small class="text-muted">(Comma separated)</small></label>
                      <input type="text" name="skills" id="skills" class="form-control" placeholder="Ex: Cisco Packet Tracer, Networking">
                  </div>

                  <div class="col-md-6 mb-3">
                      <label>Organization Logo Image</label>
                      <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                      <small class="text-muted">Square icon format looks best (e.g. Cisco logo)</small>
                  </div>
                  
                  <div class="col-md-6 mb-3">
                      <label>Certificate Document / Media</label>
                      <input type="file" name="media_image" id="media_image" class="form-control" accept="image/*">
                      <small class="text-muted">The actual certificate image to display.</small>
                  </div>

                  <div class="col-md-4 mb-3">
                      <label>Display Order</label>
                      <input type="number" name="display_order" id="order" class="form-control" value="0">
                  </div>
              </div>
          </div>
          <div class="modal-footer bg-light border-top-0">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
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
        document.getElementById('modalTitle').innerText = 'Add Certification';
        document.getElementById('saveBtn').innerText = 'Save';
    }

    function editEntry(data) {
        document.getElementById('entryId').value = data.id;
        document.getElementById('title').value = data.title;
        document.getElementById('organization').value = data.organization;
        document.getElementById('issue_month').value = data.issue_month;
        document.getElementById('issue_year').value = data.issue_year;
        document.getElementById('expiry_month').value = data.expiry_month;
        document.getElementById('expiry_year').value = data.expiry_year;
        document.getElementById('credential_id').value = data.credential_id;
        document.getElementById('credential_url').value = data.credential_url;
        document.getElementById('skills').value = data.skills;
        document.getElementById('order').value = data.display_order;
        
        document.getElementById('modalTitle').innerText = 'Edit Certification';
        document.getElementById('saveBtn').innerText = 'Update';
        
        modal.show();
    }
</script>
</body>
</html>
