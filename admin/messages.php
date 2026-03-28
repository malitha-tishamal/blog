<?php
require_once 'includes/db.php';
check_admin_auth();

$message = '';

// Handle Delete
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
        $stmt->execute([$id]);
        $message = "<div class='alert alert-warning'>Message deleted.</div>";
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

// Handle Mark as Read
if(isset($_GET['mark_read'])) {
    $id = (int)$_GET['mark_read'];
    try {
        $stmt = $conn->prepare("UPDATE contact_messages SET status='read' WHERE id = ?");
        $stmt->execute([$id]);
        $message = "<div class='alert alert-success'>Message marked as read.</div>";
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

try {
    // Fetch existing entries
    $entries = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetchAll();
} catch (PDOException $e) {
    // Log error
}
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
       <?php include 'includes/sidebar.php'; ?>

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
                            <?php if(count($entries) > 0): ?>
                                <?php foreach($entries as $row): ?>
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
                                <?php endforeach; ?>
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
