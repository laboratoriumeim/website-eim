<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check either username or email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
    $stmt->execute(['username' => $username, 'email' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nama'];
        $_SESSION['user_role'] = $user['role'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EIM Research Lab</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .registration-form-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 40px;
            border-top: 3px solid var(--accent-cyan);
        }
        .registration-header {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="index.php" class="logo-container">
                <div class="logo-icon">
                    <img src="img/EIM Only Logo.png" alt="EIM Logo">
                </div>
                <div class="logo-text">
                    <span class="text-gradient-dual">EIM</span>
                    <span class="logo-sub">Research Lab</span>
                </div>
            </a>
            <ul class="nav-links" id="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="event.php">Event</a></li>
                <li><a href="structure.php">Structure</a></li>
                <li><a href="news.php">News</a></li>
                <li><a href="pendaftaran.php">Pendaftaran</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </div>
    </nav>

    <section class="page-header" style="padding-top: 150px; padding-bottom: 50px;">
        <div class="container">
            <div class="page-header-content">
                <h1>Login <span class="text-gradient-cyan">Akun</span></h1>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="registration-form-container glass-panel">
                <div class="registration-header">
                    <h2>Masuk ke Akun Anda</h2>
                </div>
                <?php if (isset($error)): ?>
                    <div style="background-color: rgba(255,0,0,0.1); color: #ff6b6b; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="username">Username / Email</label>
                        <input type="text" name="username" class="form-control" id="username" placeholder="Username atau Email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                    </div>
                    <div class="form-actions" style="justify-content: center; margin-top: 40px;">
                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 1.1rem;">
                            Login <i class="fa-solid fa-right-to-bracket" style="margin-left: 8px;"></i>
                        </button>
                    </div>
                </form>
                <div style="text-align: center; margin-top: 20px;">
                    Belum punya akun? <a href="register.php" style="color: var(--accent-cyan);">Daftar di sini</a>
                </div>
            </div>
        </div>
    </section>

    <script src="app.js"></script>
</body>
</html>
