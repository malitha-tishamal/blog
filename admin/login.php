<?php
session_start();
require_once '../includes/db-conn.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT id, password_hash, role FROM admin_users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user) {
            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_role'] = $user['role'];
                $_SESSION['admin_username'] = $username;
                session_regenerate_id(true); // Extra security on login
                header("Location: index.php");
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "Invalid username.";
        }
    } catch (PDOException $e) {
        $error = "Database error. Please try again later.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - CMS</title>
    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            /* Colorful modern gradient background */
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #0d6efd 100%);
            background-size: 200% 200%;
            animation: gradientAnim 10s ease infinite;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            overflow: hidden;
        }

        @keyframes gradientAnim {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Glassmorphism background shapes */
        .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
        }
        .shape1 { background: rgba(0, 255, 204, 0.4); width: 400px; height: 400px; top: -100px; left: -100px; }
        .shape2 { background: rgba(255, 0, 128, 0.4); width: 300px; height: 300px; bottom: -50px; right: -50px; }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 40px;
            border-radius: 20px;
            
            /* Glassmorphism Effect */
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
            
            color: #fff;
            text-align: center;
        }

        .login-logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255,255,255,0.5);
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .login-card h3 {
            font-weight: 700;
            margin-bottom: 30px;
            letter-spacing: 1px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            backdrop-filter: blur(5px);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 0 10px rgba(255,255,255,0.2);
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-label {
            text-align: left;
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
            color: #e0e0e0;
        }

        .btn-primary {
            background: linear-gradient(45deg, #00d2ff 0%, #3a7bd5 100%);
            border: none;
            padding: 10px;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 8px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
            background: linear-gradient(45deg, #3a7bd5 0%, #00d2ff 100%);
        }

        .password-toggle {
            cursor: pointer;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-left: none;
            color: #fff;
        }

        .input-group-text {
            border-radius: 0 0.375rem 0.375rem 0;
            backdrop-filter: blur(5px);
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.8);
            border: 1px solid rgba(220, 53, 69, 0.5);
            color: #fff;
            backdrop-filter: blur(5px);
        }
    </style>
</head>
<body>

<div class="shape shape1"></div>
<div class="shape shape2"></div>

<div class="login-card">
    <img src="../assets/img/profile/profile-malitha.jpg" alt="Logo" class="login-logo">
    <h3>CMS Secure Login</h3>
    
    <?php if($error): ?>
        <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="mb-3 text-start">
            <label class="form-label" for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Enter username" required autofocus>
        </div>
        <div class="mb-4 text-start">
            <label class="form-label" for="password">Password</label>
            <div class="input-group">
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required style="border-right: none;">
                <span class="input-group-text password-toggle" onclick="togglePassword()">
                    <i class="bi bi-eye" id="toggleIcon"></i>
                </span>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login to Dashboard <i class="bi bi-arrow-right ms-2"></i></button>
    </form>
</div>

<script>
    function togglePassword() {
        const passField = document.getElementById("password");
        const toggleIcon = document.getElementById("toggleIcon");
        if (passField.type === "password") {
            passField.type = "text";
            toggleIcon.classList.remove("bi-eye");
            toggleIcon.classList.add("bi-eye-slash");
        } else {
            passField.type = "password";
            toggleIcon.classList.remove("bi-eye-slash");
            toggleIcon.classList.add("bi-eye");
        }
    }
</script>
</body>
</html>
