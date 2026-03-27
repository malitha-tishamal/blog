<?php
require_once 'includes/db.php';
check_admin_auth();

$message = '';

// Handle Delete
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM contact_messages WHERE id = $id");
    $message = "<div class='alert alert-warning'>Message deleted.</div>";
}

// Handle Mark as Read
if(isset($_GET['mark_read'])) {
    $id = (int)$_GET['mark_read'];
    $conn->query("UPDATE contact_messages SET status='read' WHERE id = $id");
    $message = "<div class='alert alert-success'>Message marked as read.</div>";
}

// Fetch existing entries
$entries = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Messages - CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Open Sans', sans-serif; }
        .sidebar { background-color: #212529; min-height: 100vh; padding-top: 20px; color: #fff;}
        .sidebar a { color: #c2c7d0; text-decoration: none; display: block; padding: 10px 20px; margin-bottom: 5px; border-radius: 4px;}
        .sidebar a:hover, .sidebar a.active { background-color: #0066cc; color: #fff; }
        .content { padding: 30px; }
        .msg-unread { background-color: #f8faff; font-weight: 600; }
        .msg-read { color: #6c757d; }
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
            <a href="services.php"><i class="bi bi-briefcase me-2"></i> Services</a>
            <a href="testimonials.php"><i class="bi bi-chat-quote me-2"></i> Testimonials</a>
            <a href="messages.php" class="active"><i class="bi bi-envelope me-2"></i> Messages</a>
            <hr class="text-secondary">
            <a href="../index.php" target="_blank"><i class="bi bi-box-arrow-up-right me-2"></i> View Site</a>
            <a href="logout.php" class="text-danger"><i class="bi bi-box-arrow-left me-2"></i> Logout</a>
        </div>

        <div class="col-md-10 content">
            <h2 class="mb-4">Contact Form Messages</h2>
            
            <?php echo $message; ?>

            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Status</th>
                                <th>Date/Time</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($entries->num_rows > 0): ?>
                                <?php while($row = $entries->fetch_assoc()): ?>
                                <tr class="<?php echo $row['status'] == 'unread' ? 'msg-unread' : 'msg-read'; ?>">
                                    <td>
                                        <?php if($row['status'] == 'unread'): ?>
                                            <span class="badge bg-primary">New</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Read</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo date('d M Y, h:i A', strtotime($row['created_at'])); ?></td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><a href="mailto:<?php echo htmlspecialchars($row['email']); ?>"><?php echo htmlspecialchars($row['email']); ?></a></td>
                                    <td><?php echo htmlspecialchars($row['subject']); ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-info me-1" 
                                            onclick='viewMessage(<?php echo json_encode($row); ?>)' title="Read Message">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <?php if($row['status'] == 'unread'): ?>
                                            <a href="messages.php?mark_read=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-success me-1" title="Mark Read"><i class="bi bi-check2-all"></i></a>
                                        <?php endif; ?>
                                        <a href="messages.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this message permanently?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No messages received yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- View Message Modal -->
<div class="modal fade" id="msgModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-light">
            <h5 class="modal-title">Received Message</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <small class="text-muted d-block">From:</small>
                <strong id="v_name"></strong> (<a href="" id="v_email"></a>)
            </div>
            <div class="mb-3">
                <small class="text-muted d-block">Date:</small>
                <span id="v_date"></span>
            </div>
            <div class="mb-3">
                <small class="text-muted d-block">Subject:</small>
                <strong id="v_subject"></strong>
            </div>
            <hr>
            <div>
                <small class="text-muted d-block mb-2">Message Content:</small>
                <p id="v_message" style="white-space: pre-wrap; background: #f8f9fa; padding: 15px; border-radius: 5px;"></p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <a href="#" id="v_reply" class="btn btn-primary"><i class="bi bi-reply"></i> Reply via Email</a>
        </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const modal = new bootstrap.Modal(document.getElementById('msgModal'));

    function viewMessage(data) {
        document.getElementById('v_name').innerText = data.name;
        document.getElementById('v_email').innerText = data.email;
        document.getElementById('v_email').href = "mailto:" + data.email;
        document.getElementById('v_date').innerText = data.created_at;
        document.getElementById('v_subject').innerText = data.subject;
        document.getElementById('v_message').innerText = data.message;
        
        document.getElementById('v_reply').href = "mailto:" + data.email + "?subject=Re: " + encodeURIComponent(data.subject);
        
        modal.show();
    }
</script>
</body>
</html>
