<?php
session_start();
require_once 'db.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil detail user dari database
$stmt = $pdo->prepare("SELECT nama, username, email, role FROM users WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // Jika tidak ditemukan di database, logout
    header("Location: logout.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - EIM Research Lab</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .profile-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px;
            border-top: 3px solid var(--accent-cyan);
            text-align: center;
        }
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-cyan), var(--accent-blue));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            margin: 0 auto 20px auto;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .profile-info {
            margin-bottom: 30px;
        }
        .profile-info h2 {
            font-size: 2rem;
            margin-bottom: 5px;
        }
        .profile-role {
            display: inline-block;
            background: rgba(0, 240, 255, 0.1);
            color: var(--accent-cyan);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .profile-details {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            padding: 20px;
            text-align: left;
            margin-bottom: 30px;
        }
        .profile-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .profile-row:last-child {
            border-bottom: none;
        }
        .profile-label {
            color: var(--text-secondary);
            font-weight: 500;
            width: 30%;
        }
        .profile-value {
            font-weight: 600;
            width: 70%;
            text-align: right;
            word-break: break-all;
        }
        .btn-logout {
            width: 100%;
            padding: 14px;
            font-size: 1.1rem;
            background: var(--accent-red);
            border: none;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-logout:hover {
            background: #d63031;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
        }
    </style>
</head>
<body>
    <!-- --- NAVIGATION BAR --- -->
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
                <?php if (isset($_SESSION["user_id"])): ?>
                    <li><a href="pendaftaran.php">Pendaftaran</a></li>
                    <li class="active"><a href="profile.php" class="btn btn-outline" style="padding: 8px 20px; border-radius: 20px;"><i class="fa-regular fa-user"></i> Profile</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="btn btn-primary" style="padding: 8px 20px; border-radius: 20px;">Login</a></li>
                <?php endif; ?>
            </ul>
            <div class="nav-toggle" id="nav-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- --- PAGE HEADER --- -->
    <section class="page-header" style="padding-top: 150px; padding-bottom: 50px;">
        <div class="container">
            <div class="page-header-content">
                <h1>My <span class="text-gradient-cyan">Profile</span></h1>
            </div>
        </div>
    </section>

    <!-- --- PROFILE SECTION --- -->
    <section class="section-padding" style="padding-top: 0;">
        <div class="container">
            <div class="profile-container glass-panel">
                <div class="profile-avatar">
                    <?php 
                        $initials = "?";
                        if (!empty($user['nama'])) {
                            $words = explode(" ", $user['nama']);
                            $initials = strtoupper(substr($words[0], 0, 1));
                            if (count($words) > 1) {
                                $initials .= strtoupper(substr($words[count($words)-1], 0, 1));
                            }
                        }
                        echo $initials;
                    ?>
                </div>
                <div class="profile-info">
                    <h2><?php echo htmlspecialchars($user['nama']); ?></h2>
                    <span class="profile-role"><i class="fa-solid fa-shield-halved"></i> <?php echo htmlspecialchars($user['role']); ?></span>
                </div>
                
                <div class="profile-details">
                    <div class="profile-row">
                        <div class="profile-label">Nama Lengkap</div>
                        <div class="profile-value"><?php echo htmlspecialchars($user['nama']); ?></div>
                    </div>
                    <div class="profile-row">
                        <div class="profile-label">Username</div>
                        <div class="profile-value"><?php echo htmlspecialchars($user['username']); ?></div>
                    </div>
                    <div class="profile-row">
                        <div class="profile-label">Email</div>
                        <div class="profile-value"><?php echo htmlspecialchars($user['email']); ?></div>
                    </div>
                    <div class="profile-row">
                        <div class="profile-label">Akses Role</div>
                        <div class="profile-value"><?php echo htmlspecialchars($user['role']); ?></div>
                    </div>
                </div>

                <a href="logout.php" class="btn btn-logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout dari Akun
                </a>
            </div>
        </div>
    </section>

    <script src="app.js"></script>
    <script>
        // Scroll navbar handling
        window.addEventListener("scroll", function () {
            const navbar = document.getElementById("navbar");
            if (!navbar) return;

            if (window.scrollY > 50) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });
        
        // --- Mobile menu toggle ---
        const navToggle = document.getElementById("nav-toggle");
        const navLinksContainer = document.getElementById("nav-links");

        if (navToggle && navLinksContainer) {
            navToggle.addEventListener("click", function () {
                this.classList.toggle("active");
                navLinksContainer.classList.toggle("active");
            });

            // Close mobile menu when nav link is clicked
            document.querySelectorAll(".nav-links a").forEach(link => {
                link.addEventListener("click", () => {
                    navToggle.classList.remove("active");
                    navLinksContainer.classList.remove("active");
                });
            });
        }
    </script>
</body>
</html>
