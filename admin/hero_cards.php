<?php
require_once 'includes/db.php';
check_admin_auth();

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'save') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $icon = trim($_POST['icon'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $pos_top = trim($_POST['pos_top'] ?? 'auto');
    $pos_bottom = trim($_POST['pos_bottom'] ?? 'auto');
    $pos_left = trim($_POST['pos_left'] ?? 'auto');
    $pos_right = trim($_POST['pos_right'] ?? 'auto');
    $display_order = (int)($_POST['display_order'] ?? 0);

    try {
        if ($id > 0) {
            $stmt = $conn->prepare("UPDATE hero_cards SET icon = ?, title = ?, pos_top = ?, pos_bottom = ?, pos_left = ?, pos_right = ?, display_order = ? WHERE id = ?");
            $stmt->execute([$icon, $title, $pos_top, $pos_bottom, $pos_left, $pos_right, $display_order, $id]);
            $message = "<div class='alert alert-success'>Card updated successfully.</div>";
        } else {
            $stmt = $conn->prepare("INSERT INTO hero_cards (icon, title, pos_top, pos_bottom, pos_left, pos_right, display_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$icon, $title, $pos_top, $pos_bottom, $pos_left, $pos_right, $display_order]);
            $message = "<div class='alert alert-success'>New card added successfully.</div>";
        }
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        $stmt = $conn->prepare("DELETE FROM hero_cards WHERE id = ?");
        $stmt->execute([$id]);
        $message = "<div class='alert alert-success'>Card deleted successfully.</div>";
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

try {
    $stmt = $conn->query("SELECT * FROM hero_cards ORDER BY display_order ASC, title ASC");
    $cards = $stmt->fetchAll();
} catch (PDOException $e) {
    $message = "<div class='alert alert-danger'>Database Error: " . $e->getMessage() . "</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hero Cards Management - CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Open Sans', sans-serif; }
        .sidebar { background-color: #212529; min-height: 100vh; padding-top: 20px; color: #fff;}
        .sidebar a { color: #c2c7d0; text-decoration: none; display: block; padding: 10px 20px; margin-bottom: 5px; border-radius: 4px;}
        .sidebar a:hover, .sidebar a.active { background-color: #0066cc; color: #fff; }
        .content { padding: 30px; }
        .card { border-radius: 10px; border: none; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <div class="col-md-10 content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Manage Hero Floating Cards</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cardModal" onclick="resetForm()">
                    <i class="bi bi-plus-circle me-1"></i> Add New Card
                </button>
            </div>
            
            <?php echo $message; ?>

            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover table-bordered mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="10%">Icon</th>
                                <th width="30%">Title / Text</th>
                                <th width="30%">Position (T, B, L, R)</th>
                                <th width="10%">Order</th>
                                <th width="20%" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($cards) > 0): ?>
                                <?php foreach($cards as $row): ?>
                                <tr>
                                    <td class="text-center"><i class="bi <?php echo htmlspecialchars($row['icon']); ?> fs-4 text-primary"></i></td>
                                    <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                                    <td>
                                        <small class="text-muted">
                                            T: <?php echo $row['pos_top'] ?? 'auto'; ?>, 
                                            B: <?php echo $row['pos_bottom'] ?? 'auto'; ?>, 
                                            L: <?php echo $row['pos_left'] ?? 'auto'; ?>, 
                                            R: <?php echo $row['pos_right'] ?? 'auto'; ?>
                                        </small>
                                    </td>
                                    <td><?php echo $row['display_order']; ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-secondary me-1" onclick='editCard(<?php echo json_encode($row); ?>)'>
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="hero_cards.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this card?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center py-4 text-muted">No cards found. Go ahead and add some!</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="alert alert-info mt-4">
                <i class="bi bi-info-circle me-2"></i> Use <strong>Top/Bottom</strong> and <strong>Left/Right</strong> to position the cards around your image. Use values like <code>10%</code>, <code>20px</code>, or <code>auto</code>. Ensure they don't overlap!
            </div>
        </div>
    </div>
</div>

<!-- Card Modal -->
<div class="modal fade" id="cardModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST">
          <input type="hidden" name="action" value="save">
          <input type="hidden" name="id" id="cardId">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Add Hero Card</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-6 mb-3">
                      <label class="form-label">Icon Class (Bootstrap Icons)*</label>
                      <input type="text" name="icon" id="cardIcon" class="form-control" placeholder="bi-code-slash" required>
                  </div>
                  <div class="col-md-6 mb-3">
                      <label class="form-label">Card Text*</label>
                      <input type="text" name="title" id="cardTitle" class="form-control" placeholder="Fullstack Development" required>
                  </div>
              </div>
              
              <h6 class="mt-3 mb-3 text-primary border-bottom pb-2">Positioning (Relative to Profile Image)</h6>
              <div class="row">
                  <div class="col-md-3 mb-3">
                      <label class="form-label">Top</label>
                      <input type="text" name="pos_top" id="cardTop" class="form-control" value="auto">
                  </div>
                  <div class="col-md-3 mb-3">
                      <label class="form-label">Bottom</label>
                      <input type="text" name="pos_bottom" id="cardBottom" class="form-control" value="auto">
                  </div>
                  <div class="col-md-3 mb-3">
                      <label class="form-label">Left</label>
                      <input type="text" name="pos_left" id="cardLeft" class="form-control" value="auto">
                  </div>
                  <div class="col-md-3 mb-3">
                      <label class="form-label">Right</label>
                      <input type="text" name="pos_right" id="cardRight" class="form-control" value="auto">
                  </div>
              </div>
              <p class="small text-muted mb-3">Tips: Use <code>%</code> (e.g., 20%) or <code>px</code> (e.g., -10px). Set one to <code>auto</code> if not using it (e.g., if using Top, set Bottom to <code>auto</code>).</p>

              <div class="mb-3">
                  <label class="form-label">Display Order</label>
                  <input type="number" name="display_order" id="cardOrder" class="form-control" value="0">
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="saveBtn">Save Card</button>
          </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const cardModal = new bootstrap.Modal(document.getElementById('cardModal'));

    function resetForm() {
        document.getElementById('cardId').value = '';
        document.getElementById('cardIcon').value = '';
        document.getElementById('cardTitle').value = '';
        document.getElementById('cardTop').value = 'auto';
        document.getElementById('cardBottom').value = 'auto';
        document.getElementById('cardLeft').value = 'auto';
        document.getElementById('cardRight').value = 'auto';
        document.getElementById('cardOrder').value = '0';
        document.getElementById('modalTitle').innerText = 'Add Hero Card';
        document.getElementById('saveBtn').innerText = 'Save Card';
    }

    function editCard(data) {
        document.getElementById('cardId').value = data.id;
        document.getElementById('cardIcon').value = data.icon;
        document.getElementById('cardTitle').value = data.title;
        document.getElementById('cardTop').value = data.pos_top;
        document.getElementById('cardBottom').value = data.pos_bottom;
        document.getElementById('cardLeft').value = data.pos_left;
        document.getElementById('cardRight').value = data.pos_right;
        document.getElementById('cardOrder').value = data.display_order;
        document.getElementById('modalTitle').innerText = 'Edit Hero Card';
        document.getElementById('saveBtn').innerText = 'Update Card';
        cardModal.show();
    }
</script>
</body>
</html>
