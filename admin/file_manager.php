<?php
require_once 'includes/db.php';
check_admin_auth();

// Handle AJAX file uploads
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['files'])) {
    header('Content-Type: application/json');
    $response = ['success' => false, 'messages' => [], 'uploaded' => [], 'failed' => []];

    $dest_type = $_POST['destination'] ?? 'normal';
    $subfolder = $_POST['subfolder'] ?? '';

    // Determine Base Target Directory
    $target_dir = "";
    if ($dest_type === 'portfolio') {
        $target_dir = "../assets/img/portfolio/";
        if (!empty(trim($subfolder))) {
            // Sanitize subfolder name
            $safe_subfolder = preg_replace('/[^a-zA-Z0-9_\-]/', '_', trim($subfolder));
            $target_dir .= $safe_subfolder . '/';
        }
    } else {
        $target_dir = "../uploads/";
    }

    // Create directory if it doesn't exist
    if (!file_exists($target_dir)) {
        if (!mkdir($target_dir, 0755, true)) {
            echo json_encode(['success' => false, 'error' => 'Failed to create destination directory. Check permissions.']);
            exit;
        }
    }

    // Process Files
    $totalFiles = count($_FILES['files']['name']);
    
    // Security: Block execution extensions
    $disallowed_exts = ['php', 'php3', 'php4', 'php5', 'phtml', 'exe', 'sh', 'bat', 'cmd', 'pl', 'cgi', 'py'];

    for ($i = 0; $i < $totalFiles; $i++) {
        $filename = $_FILES['files']['name'][$i];
        $tmp_name = $_FILES['files']['tmp_name'][$i];
        $error    = $_FILES['files']['error'][$i];

        if ($error === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if (in_array($ext, $disallowed_exts)) {
                $response['failed'][] = ['name' => $filename, 'reason' => 'Blocked for security reasons.'];
                continue;
            }

            // Clean filename
            $safe_filename = preg_replace('/[^a-zA-Z0-9.\-_]/', '_', $filename);
            $target_file = $target_dir . $safe_filename;
            
            // To avoid overwriting, prepend a timestamp if file exists
            if (file_exists($target_file)) {
                $target_file = $target_dir . time() . '_' . $safe_filename;
            }

            if (move_uploaded_file($tmp_name, $target_file)) {
                $response['uploaded'][] = $filename;
            } else {
                $response['failed'][] = ['name' => $filename, 'reason' => 'Failed to move file.'];
            }
        } else {
            $response['failed'][] = ['name' => $filename, 'reason' => "Upload error code: $error"];
        }
    }

    $response['success'] = true;
    echo json_encode($response);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Manager - CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Open Sans', sans-serif; }
        .sidebar { background-color: #212529; min-height: 100vh; padding-top: 20px; color: #fff;}
        .sidebar a { color: #c2c7d0; text-decoration: none; display: block; padding: 10px 20px; margin-bottom: 5px; border-radius: 4px;}
        .sidebar a:hover, .sidebar a.active { background-color: #0066cc; color: #fff; }
        .content { padding: 30px; }
        .upload-area {
            border: 2px dashed #0d6efd;
            border-radius: 8px;
            padding: 40px;
            text-align: center;
            background: #fff;
            transition: all 0.3s;
            cursor: pointer;
        }
        .upload-area:hover, .upload-area.dragover {
            background-color: #f8f9fa;
            border-color: #0a58ca;
        }
        .file-list-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .file-list-item:last-child {
            border-bottom: none;
        }
        .file-name {
            flex-grow: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <div class="col-md-10 content">
            <h2 class="mb-4">File Manager</h2>

            <div class="row">
                <div class="col-lg-5">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="card-title mb-0">Upload Settings</h5>
                        </div>
                        <div class="card-body">
                            <form id="uploadForm">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Select Destination</label>
                                    <select class="form-select" id="destination" name="destination" onchange="toggleSubfolder()">
                                        <option value="normal">Normal Folder (uploads/)</option>
                                        <option value="portfolio">Portfolio Folder (assets/img/portfolio/)</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3" id="subfolderGroup" style="display: none;">
                                    <label class="form-label fw-bold">New Portfolio Subfolder Name (Optional)</label>
                                    <input type="text" class="form-control" id="subfolder" name="subfolder" placeholder="e.g. app-project-1">
                                    <small class="text-muted">Folders will be created automatically.</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Select Files</label>
                                    <div class="upload-area" id="drop-area" onclick="document.getElementById('fileInput').click()">
                                        <i class="bi bi-cloud-arrow-up fs-1 text-primary"></i>
                                        <p class="mt-2 mb-0">Click to select files or drag and drop here</p>
                                        <input type="file" id="fileInput" name="files[]" multiple class="d-none" onchange="handleFiles(this.files)">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary w-100 mt-2" onclick="startUpload()" id="uploadBtn" disabled>
                                    <i class="bi bi-upload"></i> Start Upload
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Upload Queue & Progress</h5>
                            <span class="badge bg-secondary" id="queueCount">0 files</span>
                        </div>
                        <div class="card-body p-0">
                            <div id="fileList" class="p-3" style="min-height: 250px; max-height: 400px; overflow-y: auto;">
                                <div class="text-muted text-center mt-5" id="emptyList">No files selected yet.</div>
                            </div>
                        </div>
                        <div class="card-footer bg-light" id="overallProgressContainer" style="display:none;">
                            <strong>Overall Progress</strong>
                            <div class="progress mt-2" style="height: 20px;">
                                <div id="overallProgress" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 0%;">0%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let selectedFiles = [];

    function toggleSubfolder() {
        const dest = document.getElementById('destination').value;
        const subfolderGroup = document.getElementById('subfolderGroup');
        if (dest === 'portfolio') {
            subfolderGroup.style.display = 'block';
        } else {
            subfolderGroup.style.display = 'none';
        }
    }

    // Drag and Drop Logic
    const dropArea = document.getElementById('drop-area');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.add('dragover'), false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.remove('dragover'), false);
    });

    dropArea.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }, false);

    function handleFiles(files) {
        for(let i=0; i<files.length; i++) {
            selectedFiles.push({ file: files[i], status: 'pending' });
        }
        updateQueueUI();
    }

    function removeFile(index) {
        if(selectedFiles[index].status === 'pending') {
            selectedFiles.splice(index, 1);
            updateQueueUI();
        }
    }

    function updateQueueUI() {
        const fileList = document.getElementById('fileList');
        const queueCount = document.getElementById('queueCount');
        const uploadBtn = document.getElementById('uploadBtn');
        
        queueCount.innerText = selectedFiles.length + ' files';
        
        if (selectedFiles.length === 0) {
            fileList.innerHTML = '<div class="text-muted text-center mt-5">No files selected yet.</div>';
            uploadBtn.disabled = true;
            return;
        }

        uploadBtn.disabled = false;
        fileList.innerHTML = '';
        
        selectedFiles.forEach((item, index) => {
            let statusBadge = '';
            let actionBtn = `<button class="btn btn-sm btn-outline-danger" onclick="removeFile(${index})"><i class="bi bi-x"></i></button>`;
            
            if (item.status === 'uploading') {
                statusBadge = '<span class="badge bg-warning text-dark me-2">Uploading...</span>';
                actionBtn = '';
            } else if (item.status === 'success') {
                statusBadge = '<span class="badge bg-success me-2">Complete</span>';
                actionBtn = '';
            } else if (item.status === 'failed') {
                statusBadge = '<span class="badge bg-danger me-2">Failed</span>';
                actionBtn = '';
            } else {
                statusBadge = '<span class="badge bg-secondary me-2">Pending</span>';
            }

            // Approximate file size
            let size = (item.file.size / 1024).toFixed(2);
            let sizeText = size + ' KB';
            if(size > 1024) sizeText = (size/1024).toFixed(2) + ' MB';

            const html = `
                <div class="file-list-item d-flex align-items-center mb-2" id="file-item-${index}">
                    <i class="bi bi-file-earmark me-3 fs-4 text-secondary"></i>
                    <div class="file-name">
                        <div class="fw-bold">${item.file.name}</div>
                        <small class="text-muted">${sizeText}</small>
                    </div>
                    <div class="ms-auto d-flex align-items-center">
                        ${statusBadge}
                        ${actionBtn}
                    </div>
                </div>
            `;
            fileList.insertAdjacentHTML('beforeend', html);
        });
    }

    function startUpload() {
        const pendingFiles = selectedFiles.filter(f => f.status === 'pending');
        if (pendingFiles.length === 0) return;

        const uploadBtn = document.getElementById('uploadBtn');
        const destination = document.getElementById('destination').value;
        const subfolder = document.getElementById('subfolder').value;
        const overallContainer = document.getElementById('overallProgressContainer');
        const overallProgress = document.getElementById('overallProgress');

        uploadBtn.disabled = true;
        overallContainer.style.display = 'block';
        overallProgress.style.width = '0%';
        overallProgress.innerText = '0%';
        overallProgress.classList.remove('bg-danger');
        overallProgress.classList.add('bg-success');

        // We will upload them all together in one XHR request as requested (multi-files)
        // Mark all pending as uploading visually
        selectedFiles.forEach(f => {
            if(f.status === 'pending') f.status = 'uploading';
        });
        updateQueueUI();

        const formData = new FormData();
        formData.append('destination', destination);
        formData.append('subfolder', subfolder);

        selectedFiles.forEach(item => {
            if(item.status === 'uploading') {
                formData.append('files[]', item.file);
            }
        });

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'file_manager.php', true);

        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                const percent = Math.round((e.loaded / e.total) * 100);
                overallProgress.style.width = percent + '%';
                overallProgress.innerText = percent + '%';
            }
        };

        xhr.onload = function() {
            uploadBtn.disabled = false;
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    
                    // Update statuses based on response
                    selectedFiles.forEach((item, index) => {
                        if (item.status === 'uploading') {
                            if (response.uploaded && response.uploaded.includes(item.file.name)) {
                                item.status = 'success';
                            } else {
                                item.status = 'failed';
                            }
                        }
                    });

                    updateQueueUI();

                    if (!response.success && response.error) {
                         alert("Upload Error: " + response.error);
                         overallProgress.classList.remove('bg-success');
                         overallProgress.classList.add('bg-danger');
                         overallProgress.innerText = 'Error';
                    }

                } catch(e) {
                    console.error("Invalid JSON response", xhr.responseText);
                    alert("An error occurred generating the upload response.");
                    overallProgress.classList.remove('bg-success');
                    overallProgress.classList.add('bg-danger');
                    overallProgress.innerText = 'Failed';
                }
            } else {
                alert("Server error occurred!");
                selectedFiles.forEach(item => {
                    if(item.status === 'uploading') item.status = 'failed';
                });
                updateQueueUI();
                overallProgress.classList.remove('bg-success');
                overallProgress.classList.add('bg-danger');
                overallProgress.innerText = 'Failed';
            }
            
            // Clear input so same file can be selected again if needed
            document.getElementById('fileInput').value = '';
        };

        xhr.onerror = function() {
            uploadBtn.disabled = false;
            alert("Network error occurred!");
            selectedFiles.forEach(item => {
                if(item.status === 'uploading') item.status = 'failed';
            });
            updateQueueUI();
            overallProgress.classList.remove('bg-success');
            overallProgress.classList.add('bg-danger');
            overallProgress.innerText = 'Failed';
        };

        xhr.send(formData);
    }
</script>
</body>
</html>
