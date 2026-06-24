<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $telp = $_POST['telp'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (nama, username, nim, email, telp, password) VALUES (:nama, :username, :nim, :email, :telp, :password)");
        $stmt->execute([
            'nama' => $nama,
            'username' => $username,
            'nim' => $nim,
            'email' => $email,
            'telp' => $telp,
            'password' => $password
        ]);
        $success = "Pendaftaran berhasil! Silakan login.";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $error = "Email sudah terdaftar!";
        } else {
            $error = "Terjadi kesalahan: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - EIM Research Lab</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .registration-form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px;
            border-top: 3px solid var(--accent-cyan);
        }
        .registration-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
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
                <li><a href="login.php">Login</a></li>
            </ul>
        </div>
    </nav>

    <section class="page-header" style="padding-top: 150px; padding-bottom: 50px;">
        <div class="container">
            <div class="page-header-content">
                <h1>Daftar <span class="text-gradient-cyan">Akun Baru</span></h1>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="registration-form-container glass-panel">
                <div class="registration-header">
                    <h2>Buat Akun Anda</h2>
                </div>
                <?php if (isset($error)): ?>
                    <div style="background-color: rgba(255,0,0,0.1); color: #ff6b6b; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($success)): ?>
                    <div style="background-color: rgba(0,255,0,0.1); color: #20c997; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
                        <?php echo $success; ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" id="username" placeholder="Username" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nim">NIM</label>
                            <input type="text" name="nim" class="form-control" id="nim" placeholder="Nomor Induk Mahasiswa" required>
                        </div>
                        <div class="form-group">
                            <label for="telp">No. Telepon (WhatsApp)</label>
                            <input type="text" name="telp" class="form-control" id="telp" placeholder="08xxxxxxxxx" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                    </div>
                    <div class="form-actions" style="justify-content: center; margin-top: 40px;">
                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 1.1rem;">
                            Daftar <i class="fa-solid fa-user-plus" style="margin-left: 8px;"></i>
                        </button>
                    </div>
                </form>
                <div style="text-align: center; margin-top: 20px;">
                    Sudah punya akun? <a href="login.php" style="color: var(--accent-cyan);">Login di sini</a>
                </div>
            </div>
        </div>
    </section>

    <script src="app.js"></script>
</body>
</html>
