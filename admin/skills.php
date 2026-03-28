<?php
require_once 'includes/db.php';
check_admin_auth();

$message = '';

// --- Handle Category Actions ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_cat'])) {
    $name = trim($_POST['name']);
    $icon = trim($_POST['icon']);
    $order = (int)$_POST['display_order'];
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    try {
        if ($id > 0) {
            $stmt = $conn->prepare("UPDATE skill_categories SET name=?, icon=?, display_order=? WHERE id=?");
            $stmt->execute([$name, $icon, $order, $id]);
            $msg = "Category updated successfully.";
        } else {
            $stmt = $conn->prepare("INSERT INTO skill_categories (name, icon, display_order) VALUES (?, ?, ?)");
            $stmt->execute([$name, $icon, $order]);
            $msg = "New category added successfully.";
        }
        $message = "<div class='alert alert-success'>$msg</div>";
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

if (isset($_GET['delete_cat'])) {
    $id = (int)$_GET['delete_cat'];
    try {
        $stmt = $conn->prepare("DELETE FROM skill_categories WHERE id = ?");
        $stmt->execute([$id]);
        $message = "<div class='alert alert-success'>Category deleted successfully.</div>";
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

// --- Handle Skill Actions ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_skill'])) {
    $cat_id = (int)$_POST['category_id'];
    $name = trim($_POST['name']);
    $percentage = (int)$_POST['percentage'];
    $order = (int)$_POST['display_order'];
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    try {
        if ($id > 0) {
            $stmt = $conn->prepare("UPDATE skills SET category_id=?, name=?, percentage=?, display_order=? WHERE id=?");
            $stmt->execute([$cat_id, $name, $percentage, $order, $id]);
            $msg = "Skill updated successfully.";
        } else {
            $stmt = $conn->prepare("INSERT INTO skills (category_id, name, percentage, display_order) VALUES (?, ?, ?, ?)");
            $stmt->execute([$cat_id, $name, $percentage, $order]);
            $msg = "New skill added successfully.";
        }
        $message = "<div class='alert alert-success'>$msg</div>";
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

if (isset($_GET['delete_skill'])) {
    $id = (int)$_GET['delete_skill'];
    try {
        $stmt = $conn->prepare("DELETE FROM skills WHERE id = ?");
        $stmt->execute([$id]);
        $message = "<div class='alert alert-success'>Skill deleted successfully.</div>";
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

// --- Handle Expertise Actions ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_expertise'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $highlights = trim($_POST['highlights']);
    $years = trim($_POST['years_experience']);
    $projects = trim($_POST['projects_completed']);
    $badges = trim($_POST['badges']);

    try {
        $stmt = $conn->prepare("UPDATE skills_expertise SET title=?, description=?, highlights=?, years_experience=?, projects_completed=?, badges=? WHERE id=1");
        $stmt->execute([$title, $description, $highlights, $years, $projects, $badges]);
        $message = "<div class='alert alert-success'>Expertise settings updated successfully.</div>";
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

// Fetch data using PDO
try {
    $categories_stmt = $conn->query("SELECT * FROM skill_categories ORDER BY display_order ASC, name ASC");
    $all_categories = $categories_stmt->fetchAll();
    
    $expertise = $conn->query("SELECT * FROM skills_expertise WHERE id=1")->fetch();

    // Build nested skills array
    $cat_list = [];
    foreach ($all_categories as $c) {
        $c['skills'] = [];
        $cat_list[$c['id']] = $c;
    }
    
    $skills_res = $conn->query("SELECT * FROM skills ORDER BY category_id, display_order ASC, name ASC")->fetchAll();
    foreach ($skills_res as $s) {
        if (isset($cat_list[$s['category_id']])) {
            $cat_list[$s['category_id']]['skills'][] = $s;
        }
    }
} catch (PDOException $e) {
    $message = "<div class='alert alert-danger'>Database Error: " . $e->getMessage() . "</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Skills Management - CMS</title>
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
        .skill-group-header { background: #e9ecef; padding: 10px 15px; font-weight: bold; border-radius: 5px; margin-top: 20px; }
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
            <a href="skills.php" class="active"><i class="bi bi-stars me-2"></i> Skills</a>
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
                <h2>Manage Skills & Expertise</h2>
                <div class="btn-group">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#catModal" onclick="resetCatForm()">
                        <i class="bi bi-plus-circle me-1"></i> New Category
                    </button>
                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#skillModal" onclick="resetSkillForm()">
                        <i class="bi bi-plus-circle me-1"></i> New Skill
                    </button>
                </div>
            </div>
            
            <?php echo $message; ?>

            <ul class="nav nav-tabs mb-4" id="skillsTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="skills-list-tab" data-bs-toggle="tab" data-bs-target="#skills-list-pane" type="button">All Skills</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories-pane" type="button">Categories</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="expertise-tab" data-bs-toggle="tab" data-bs-target="#expertise-pane" type="button">Expertise Sidebar</button>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Skills List Pane -->
                <div class="tab-pane fade show active" id="skills-list-pane">
                    <?php foreach($cat_list as $cat): ?>
                        <div class="skill-group-header d-flex justify-content-between align-items-center">
                            <span><i class="<?php echo $cat['icon']; ?> me-2"></i> <?php echo htmlspecialchars($cat['name']); ?></span>
                            <small class="text-muted">Order: <?php echo $cat['display_order']; ?></small>
                        </div>
                        <div class="card shadow-sm mt-2 mb-4">
                            <div class="card-body p-0">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Skill Name</th>
                                            <th>Proficiency</th>
                                            <th>Order</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($cat['skills'])): ?>
                                            <?php foreach($cat['skills'] as $s): ?>
                                            <tr>
                                                <td width="40%"><?php echo htmlspecialchars($s['name']); ?></td>
                                                <td width="30%">
                                                    <div class="progress" style="height: 10px;">
                                                      <div class="progress-bar" role="progressbar" style="width: <?php echo $s['percentage']; ?>%"><?php echo $s['percentage']; ?>%</div>
                                                    </div>
                                                </td>
                                                <td><?php echo $s['display_order']; ?></td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-outline-secondary me-1" onclick='editSkill(<?php echo json_encode($s); ?>)'>
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <a href="skills.php?delete_skill=<?php echo $s['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this skill?');">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr><td colspan="4" class="text-center py-3 text-muted">No skills in this category.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Categories Pane -->
                <div class="tab-pane fade" id="categories-pane">
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <table class="table table-hover table-bordered mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Icon</th>
                                        <th>Category Name</th>
                                        <th>Order</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach($all_categories as $row): 
                                    ?>
                                    <tr>
                                        <td class="text-center"><i class="<?php echo htmlspecialchars($row['icon']); ?> fs-4"></i></td>
                                        <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
                                        <td><?php echo $row['display_order']; ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-secondary me-1" onclick='editCat(<?php echo json_encode($row); ?>)'>
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <a href="skills.php?delete_cat=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this category and all its skills?');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Expertise Pane -->
                <div class="tab-pane fade" id="expertise-pane">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form method="POST">
                                <input type="hidden" name="action_expertise" value="1">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">Section Title</label>
                                        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($expertise['title']); ?>" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">Description</label>
                                        <textarea name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($expertise['description']); ?></textarea>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">Expertise Highlights (One per line, start with 🔹 if desired)</label>
                                        <textarea name="highlights" class="form-control" rows="8"><?php echo htmlspecialchars($expertise['highlights']); ?></textarea>
                                        <small class="text-muted">Example: 🔹 Flutter & Dart — Cross-platform app development</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Years Experience</label>
                                        <input type="text" name="years_experience" class="form-control" value="<?php echo htmlspecialchars($expertise['years_experience']); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Projects Completed</label>
                                        <input type="text" name="projects_completed" class="form-control" value="<?php echo htmlspecialchars($expertise['projects_completed']); ?>">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">Skills Badges (Comma separated)</label>
                                        <textarea name="badges" class="form-control" rows="2"><?php echo htmlspecialchars($expertise['badges']); ?></textarea>
                                        <small class="text-muted">Example: Flutter, Firebase, React.js, Laravel</small>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary px-4">Update Expertise Settings</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Category Modal -->
<div class="modal fade" id="catModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
          <input type="hidden" name="action_cat" value="1">
          <input type="hidden" name="id" id="catId">
          <div class="modal-header">
            <h5 class="modal-title" id="catModalTitle">Add Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
              <div class="mb-3">
                  <label>Category Name*</label>
                  <input type="text" name="name" id="catName" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label>Icon Class (Bootstrap Icons)*</label>
                  <input type="text" name="icon" id="catIcon" class="form-control" placeholder="bi bi-code-slash" required>
                  <small class="text-muted"><a href="https://icons.getbootstrap.com/" target="_blank">Browse Icons</a></small>
              </div>
              <div class="mb-3">
                  <label>Display Order</label>
                  <input type="number" name="display_order" id="catOrder" class="form-control" value="0">
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="catSaveBtn">Save</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Skill Modal -->
<div class="modal fade" id="skillModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
          <input type="hidden" name="action_skill" value="1">
          <input type="hidden" name="id" id="skillId">
          <div class="modal-header">
            <h5 class="modal-title" id="skillModalTitle">Add Skill</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
              <div class="mb-3">
                  <label>Category*</label>
                  <select name="category_id" id="skillCatId" class="form-select" required>
                      <?php 
                      foreach($all_categories as $row): 
                      ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></option>
                      <?php endforeach; ?>
                  </select>
              </div>
              <div class="mb-3">
                  <label>Skill Name*</label>
                  <input type="text" name="name" id="skillName" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label>Proficiency (%)*</label>
                  <input type="number" name="percentage" id="skillPerc" class="form-control" min="0" max="100" value="80" required>
              </div>
              <div class="mb-3">
                  <label>Display Order</label>
                  <input type="number" name="display_order" id="skillOrder" class="form-control" value="0">
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="skillSaveBtn">Save</button>
          </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const catModal = new bootstrap.Modal(document.getElementById('catModal'));
    const skillModal = new bootstrap.Modal(document.getElementById('skillModal'));

    function resetCatForm() {
        document.getElementById('catId').value = '';
        document.getElementById('catName').value = '';
        document.getElementById('catIcon').value = 'bi bi-code-slash';
        document.getElementById('catOrder').value = '0';
        document.getElementById('catModalTitle').innerText = 'Add Category';
        document.getElementById('catSaveBtn').innerText = 'Save';
    }

    function editCat(data) {
        document.getElementById('catId').value = data.id;
        document.getElementById('catName').value = data.name;
        document.getElementById('catIcon').value = data.icon;
        document.getElementById('catOrder').value = data.display_order;
        document.getElementById('catModalTitle').innerText = 'Edit Category';
        document.getElementById('catSaveBtn').innerText = 'Update';
        catModal.show();
    }

    function resetSkillForm() {
        document.getElementById('skillId').value = '';
        document.getElementById('skillName').value = '';
        document.getElementById('skillPerc').value = '80';
        document.getElementById('skillOrder').value = '0';
        document.getElementById('skillModalTitle').innerText = 'Add Skill';
        document.getElementById('skillSaveBtn').innerText = 'Save';
    }

    function editSkill(data) {
        document.getElementById('skillId').value = data.id;
        document.getElementById('skillCatId').value = data.category_id;
        document.getElementById('skillName').value = data.name;
        document.getElementById('skillPerc').value = data.percentage;
        document.getElementById('skillOrder').value = data.display_order;
        document.getElementById('skillModalTitle').innerText = 'Edit Skill';
        document.getElementById('skillSaveBtn').innerText = 'Update';
        skillModal.show();
    }
</script>
</body>
</html>
