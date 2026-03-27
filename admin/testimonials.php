<?php
require_once 'includes/db.php';
check_admin_auth();

$message = '';
$upload_dir = '../assets/img/testimonials/';

// Ensure upload directory exists
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Handle Delete
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    // Fetch image path to delete file
    $res = $conn->query("SELECT profile_pic FROM testimonials WHERE id = $id");
    if($res && $row = $res->fetch_assoc()) {
        $file_path = '../' . $row['profile_pic'];
        if(file_exists($file_path) && !is_dir($file_path) && !empty($row['profile_pic'])) {
            @unlink($file_path);
        }
    }
    $conn->query("DELETE FROM testimonials WHERE id = $id");
    $message = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    Testimonial deleted successfully.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $msg_content = mysqli_real_escape_string($conn, $_POST['message']);
    $rating = (float)$_POST['rating'];
    $order = (int)$_POST['display_order'];

    $image_path = '';
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    // Handle Image Upload
    if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $ext = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
        $new_filename = uniqid('testi_') . '.' . $ext;
        $target_file = $upload_dir . $new_filename;
        
        $allowed = ['jpg','jpeg','png','webp','gif'];
        if(in_array(strtolower($ext), $allowed)) {
            if(move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file)) {
                $image_path = 'assets/img/testimonials/' . $new_filename;
            } else {
                $message = "<div class='alert alert-danger'>Failed to upload image.</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>Invalid file format. Only JPG, PNG, WEBP, GIF allowed.</div>";
        }
    }

    if(empty($message)) {
        if($id > 0) {
            // Update
            if($image_path != '') {
                // Remove old image
                $res = $conn->query("SELECT profile_pic FROM testimonials WHERE id = $id");
                if($row = $res->fetch_assoc()) {
                    if(!empty($row['profile_pic'])) @unlink('../'.$row['profile_pic']);
                }
                $query = "UPDATE testimonials SET name='$name', role='$role', message='$msg_content', rating=$rating, display_order=$order, profile_pic='$image_path' WHERE id=$id";
            } else {
                $query = "UPDATE testimonials SET name='$name', role='$role', message='$msg_content', rating=$rating, display_order=$order WHERE id=$id";
            }
            $success_msg = "Testimonial updated successfully.";
        } else {
            // Insert
            if($image_path == '') {
                $image_path = 'assets/img/testimonials/default-user.png'; // fallback
            }
            $query = "INSERT INTO testimonials (name, role, message, rating, profile_pic, display_order) 
                      VALUES ('$name', '$role', '$msg_content', $rating, '$image_path', $order)";
            $success_msg = "New testimonial added successfully.";
        }

        if(mysqli_query($conn, $query)) {
            $message = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            $success_msg
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: ".mysqli_error($conn)."</div>";
        }
    }
}

// Fetch existing entries
$entries = $conn->query("SELECT * FROM testimonials ORDER BY display_order ASC, id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Testimonials - CMS Admin</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Open Sans', sans-serif; }
        .sidebar { background-color: #212529; min-height: 100vh; padding-top: 20px; color: #fff; position: sticky; top: 0;}
        .sidebar a { color: #c2c7d0; text-decoration: none; display: block; padding: 10px 20px; margin-bottom: 5px; border-radius: 4px; transition: 0.3s;}
        .sidebar a:hover, .sidebar a.active { background-color: #0066cc; color: #fff; }
        .sidebar h4 { text-align: center; color: #fff; margin-bottom: 30px; font-weight: 700; }
        .content { padding: 30px; }
        .testi-img { width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 2px solid #dee2e6; }
        .star-rating { color: #ffc107; }
        .card { border: none; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 d-none d-md-block sidebar">
            <h4>CMS Admin</h4>
            <a href="index.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
            <a href="settings.php"><i class="bi bi-gear me-2"></i> Site Settings</a>
            <a href="about.php"><i class="bi bi-person me-2"></i> About Me</a>
            <a href="resume.php"><i class="bi bi-file-earmark-person me-2"></i> Resume</a>
            <a href="portfolio.php"><i class="bi bi-grid me-2"></i> Portfolio</a>
            <a href="events.php"><i class="bi bi-camera me-2"></i> Events Gallery</a>
            <a href="services.php"><i class="bi bi-briefcase me-2"></i> Services</a>
            <a href="testimonials.php" class="active"><i class="bi bi-chat-quote me-2"></i> Testimonials</a>
            <a href="messages.php"><i class="bi bi-envelope me-2"></i> Messages</a>
            <hr class="text-secondary">
            <a href="../index.php" target="_blank"><i class="bi bi-box-arrow-up-right me-2"></i> View Site</a>
            <a href="logout.php" class="text-danger"><i class="bi bi-box-arrow-left me-2"></i> Logout</a>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Manage Testimonials</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#entryModal" onclick="resetForm()">
                    <i class="bi bi-plus-circle me-1"></i> Add Testimonial
                </button>
            </div>

            <?php echo $message; ?>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 80px;" class="text-center">Photo</th>
                                    <th>Client Details</th>
                                    <th>Message</th>
                                    <th style="width: 100px;">Rating</th>
                                    <th style="width: 80px;" class="text-center">Order</th>
                                    <th style="width: 120px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($entries && $entries->num_rows > 0): ?>
                                    <?php while($row = $entries->fetch_assoc()): ?>
                                    <tr>
                                        <td class="text-center">
                                            <img src="../<?php echo htmlspecialchars($row['profile_pic']); ?>" class="testi-img" alt="User">
                                        </td>
                                        <td>
                                            <div class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></div>
                                            <div class="small text-muted"><?php echo htmlspecialchars($row['role']); ?></div>
                                        </td>
                                        <td>
                                            <div class="small text-muted text-wrap" style="max-width: 400px;">
                                                <?php echo htmlspecialchars(substr($row['message'], 0, 100)) . (strlen($row['message']) > 100 ? '...' : ''); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="star-rating">
                                                <i class="bi bi-star-fill"></i> <?php echo $row['rating']; ?>
                                            </span>
                                        </td>
                                        <td class="text-center"><?php echo $row['display_order']; ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary me-1" onclick='editEntry(<?php echo json_encode($row); ?>)'>
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <a href="testimonials.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this testimonial?');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">No testimonials found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="entryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data" id="entryForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Testimonial</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="save">
                    <input type="hidden" name="id" id="entryId">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Client Name</label>
                            <input type="text" name="name" id="name" class="form-control" required placeholder="e.g. Michael Johnson">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Position / Role</label>
                            <input type="text" name="role" id="role" class="form-control" placeholder="e.g. Scif-Fi Blogger">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Review Message</label>
                            <textarea name="message" id="message" class="form-control" rows="4" required placeholder="Enter the customer review here..."></textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Rating (1-5)</label>
                            <input type="number" name="rating" id="rating" class="form-control" min="1" max="5" step="0.1" value="5">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Display Order</label>
                            <input type="number" name="display_order" id="order" class="form-control" value="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Profile Picture</label>
                            <input type="file" name="profile_pic" id="profile_pic" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn">Save Testimonial</button>
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
        document.getElementById('modalTitle').innerText = 'Add Testimonial';
        document.getElementById('saveBtn').innerText = 'Save Testimonial';
        document.getElementById('profile_pic').required = true;
    }

    function editEntry(data) {
        document.getElementById('entryId').value = data.id;
        document.getElementById('name').value = data.name;
        document.getElementById('role').value = data.role;
        document.getElementById('message').value = data.message;
        document.getElementById('rating').value = data.rating;
        document.getElementById('order').value = data.display_order;
        
        document.getElementById('profile_pic').required = false;
        
        document.getElementById('modalTitle').innerText = 'Edit Testimonial';
        document.getElementById('saveBtn').innerText = 'Update Testimonial';
        
        modal.show();
    }
</script>
</body>
</html>
