<?php
require_once 'includes/db.php';
check_admin_auth();

$message = '';

// Handle Delete Experience
if(isset($_GET['delete_exp'])) {
    $id = (int)$_GET['delete_exp'];
    try {
        $stmt = $conn->prepare("DELETE FROM resume_experience WHERE id = ?");
        $stmt->execute([$id]);
        $message = "<div class='alert alert-success'>Experience entry deleted successfully.</div>";
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

// Handle Delete Education
if(isset($_GET['delete_edu'])) {
    $id = (int)$_GET['delete_edu'];
    try {
        $stmt = $conn->prepare("DELETE FROM resume_education WHERE id = ?");
        $stmt->execute([$id]);
        $message = "<div class='alert alert-success'>Education entry deleted successfully.</div>";
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

// Handle Add/Edit Experience
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_exp'])) {
    $role = $_POST['role'];
    $org = $_POST['organization'];
    $dur = $_POST['duration'];
    $desc = $_POST['description'];
    $achievements = $_POST['achievements'];
    $order = (int)$_POST['display_order'];
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    try {
        if($id > 0) {
            $stmt = $conn->prepare("UPDATE resume_experience SET role=?, organization=?, duration=?, description=?, achievements=?, display_order=? WHERE id=?");
            $stmt->execute([$role, $org, $dur, $desc, $achievements, $order, $id]);
            $msg = "Experience updated successfully.";
        } else {
            $stmt = $conn->prepare("INSERT INTO resume_experience (role, organization, duration, description, achievements, display_order) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$role, $org, $dur, $desc, $achievements, $order]);
            $msg = "New experience added successfully.";
        }
        $message = "<div class='alert alert-success'>$msg</div>";
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

// Handle Add/Edit Education
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_edu'])) {
    $degree = $_POST['degree'];
    $inst = $_POST['institution'];
    $year = $_POST['year'];
    $desc = $_POST['description'];
    $details = $_POST['details'];
    $order = (int)$_POST['display_order'];
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    try {
        if($id > 0) {
            $stmt = $conn->prepare("UPDATE resume_education SET degree=?, institution=?, year=?, description=?, details=?, display_order=? WHERE id=?");
            $stmt->execute([$degree, $inst, $year, $desc, $details, $order, $id]);
            $msg = "Education updated successfully.";
        } else {
            $stmt = $conn->prepare("INSERT INTO resume_education (degree, institution, year, description, details, display_order) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$degree, $inst, $year, $desc, $details, $order]);
            $msg = "New education added successfully.";
        }
        $message = "<div class='alert alert-success'>$msg</div>";
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

try {
    $experience = $conn->query("SELECT * FROM resume_experience ORDER BY display_order ASC, id DESC")->fetchAll();
    $education = $conn->query("SELECT * FROM resume_education ORDER BY display_order ASC, id DESC")->fetchAll();
} catch (PDOException $e) {
    // Log error
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resume Management - CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Open Sans', sans-serif; }
        .sidebar { background-color: #212529; min-height: 100vh; padding-top: 20px; color: #fff;}
        .sidebar a { color: #c2c7d0; text-decoration: none; display: block; padding: 10px 20px; margin-bottom: 5px; border-radius: 4px;}
        .sidebar a:hover, .sidebar a.active { background-color: #0066cc; color: #fff; }
        .content { padding: 30px; }
        .card { border-radius: 10px; border: none; }
        .nav-tabs .nav-link { color: #495057; font-weight: 600; }
        .nav-tabs .nav-link.active { color: #0066cc; }
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Manage Resume</h2>
                <div class="btn-group">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#expModal" onclick="resetExpForm()">
                        <i class="bi bi-plus-circle me-1"></i> Add Experience
                    </button>
                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#eduModal" onclick="resetEduForm()">
                        <i class="bi bi-plus-circle me-1"></i> Add Education
                    </button>
                </div>
            </div>
            
            <?php echo $message; ?>

            <ul class="nav nav-tabs mb-4" id="resumeTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="exp-tab" data-bs-toggle="tab" data-bs-target="#exp-pane" type="button">Professional Journey</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="edu-tab" data-bs-toggle="tab" data-bs-target="#edu-pane" type="button">Academic Excellence</button>
                </li>
            </ul>

            <div class="tab-content" id="resumeTabContent">
                <!-- Experience Pane -->
                <div class="tab-pane fade show active" id="exp-pane">
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <table class="table table-hover table-bordered mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Role & Organization</th>
                                        <th>Duration</th>
                                        <th>Order</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($experience) > 0): ?>
                                        <?php foreach($experience as $row): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo htmlspecialchars($row['role']); ?></strong><br>
                                                <small class="text-muted"><?php echo htmlspecialchars($row['organization']); ?></small>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['duration']); ?></td>
                                            <td><?php echo $row['display_order']; ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-secondary me-1" onclick='editExp(<?php echo json_encode($row); ?>)'>
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <a href="resume.php?delete_exp=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this entry?');">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="4" class="text-center py-4 text-muted">No experience items found.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Education Pane -->
                <div class="tab-pane fade" id="edu-pane">
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <table class="table table-hover table-bordered mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Degree & Institution</th>
                                        <th>Year</th>
                                        <th>Order</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($education) > 0): ?>
                                        <?php foreach($education as $row): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo htmlspecialchars($row['degree']); ?></strong><br>
                                                <small class="text-muted"><?php echo htmlspecialchars($row['institution']); ?></small>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['year']); ?></td>
                                            <td><?php echo $row['display_order']; ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-secondary me-1" onclick='editEdu(<?php echo json_encode($row); ?>)'>
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <a href="resume.php?delete_edu=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this entry?');">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="4" class="text-center py-4 text-muted">No education items found.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Experience Modal -->
<div class="modal fade" id="expModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST">
          <input type="hidden" name="action_exp" value="1">
          <input type="hidden" name="id" id="expId">
          <div class="modal-header">
            <h5 class="modal-title" id="expModalTitle">Add Experience</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
              <div class="mb-3">
                  <label>Job Role*</label>
                  <input type="text" name="role" id="expRole" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label>Organization / Company*</label>
                  <input type="text" name="organization" id="expOrg" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label>Duration* (e.g. 2022 - Present)</label>
                  <input type="text" name="duration" id="expDur" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label>Short Description</label>
                  <textarea name="description" id="expDesc" class="form-control" rows="2"></textarea>
              </div>
              <div class="mb-3">
                  <label>Achievements / Key Responsibilities (One per line)</label>
                  <textarea name="achievements" id="expAch" class="form-control" rows="4" placeholder="Designed UI...&#10;Developed web apps..."></textarea>
              </div>
              <div class="mb-3">
                  <label>Display Order</label>
                  <input type="number" name="display_order" id="expOrder" class="form-control" value="0">
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="expSaveBtn">Save</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Education Modal -->
<div class="modal fade" id="eduModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST">
          <input type="hidden" name="action_edu" value="1">
          <input type="hidden" name="id" id="eduId">
          <div class="modal-header">
            <h5 class="modal-title" id="eduModalTitle">Add Education</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
              <div class="mb-3">
                  <label>Degree / Certificate*</label>
                  <input type="text" name="degree" id="eduDeg" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label>Institution*</label>
                  <input type="text" name="institution" id="eduInst" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label>Year / Duration* (e.g. 2020 - 2024)</label>
                  <input type="text" name="year" id="eduYear" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label>Description</label>
                  <textarea name="description" id="eduDesc" class="form-control" rows="2"></textarea>
              </div>
              <div class="mb-3">
                  <label>Key Details / Subjects (One per line)</label>
                  <textarea name="details" id="eduDet" class="form-control" rows="4" placeholder="Core Areas: ...&#10;Key Skills: ..."></textarea>
              </div>
              <div class="mb-3">
                  <label>Display Order</label>
                  <input type="number" name="display_order" id="eduOrder" class="form-control" value="0">
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="eduSaveBtn">Save</button>
          </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const expModal = new bootstrap.Modal(document.getElementById('expModal'));
    const eduModal = new bootstrap.Modal(document.getElementById('eduModal'));

    function resetExpForm() {
        document.getElementById('expId').value = '';
        document.getElementById('expRole').value = '';
        document.getElementById('expOrg').value = '';
        document.getElementById('expDur').value = '';
        document.getElementById('expDesc').value = '';
        document.getElementById('expAch').value = '';
        document.getElementById('expOrder').value = '0';
        document.getElementById('expModalTitle').innerText = 'Add Experience';
        document.getElementById('expSaveBtn').innerText = 'Save';
    }

    function editExp(data) {
        document.getElementById('expId').value = data.id;
        document.getElementById('expRole').value = data.role;
        document.getElementById('expOrg').value = data.organization;
        document.getElementById('expDur').value = data.duration;
        document.getElementById('expDesc').value = data.description;
        document.getElementById('expAch').value = data.achievements;
        document.getElementById('expOrder').value = data.display_order;
        document.getElementById('expModalTitle').innerText = 'Edit Experience';
        document.getElementById('expSaveBtn').innerText = 'Update';
        expModal.show();
    }

    function resetEduForm() {
        document.getElementById('eduId').value = '';
        document.getElementById('eduDeg').value = '';
        document.getElementById('eduInst').value = '';
        document.getElementById('eduYear').value = '';
        document.getElementById('eduDesc').value = '';
        document.getElementById('eduDet').value = '';
        document.getElementById('eduOrder').value = '0';
        document.getElementById('eduModalTitle').innerText = 'Add Education';
        document.getElementById('eduSaveBtn').innerText = 'Save';
    }

    function editEdu(data) {
        document.getElementById('eduId').value = data.id;
        document.getElementById('eduDeg').value = data.degree;
        document.getElementById('eduInst').value = data.institution;
        document.getElementById('eduYear').value = data.year;
        document.getElementById('eduDesc').value = data.description;
        document.getElementById('eduDet').value = data.details;
        document.getElementById('eduOrder').value = data.display_order;
        document.getElementById('eduModalTitle').innerText = 'Edit Education';
        document.getElementById('eduSaveBtn').innerText = 'Update';
        eduModal.show();
    }
</script>
</body>
</html>
