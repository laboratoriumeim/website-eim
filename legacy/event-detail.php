<?php
session_start();
require_once 'db.php';

$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($event_id === 0) {
    header("Location: event.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    header("Location: event.php");
    exit;
}

$images = [];
$decodedImages = json_decode($event['image'], true);
if (is_array($decodedImages)) {
    $images = $decodedImages;
} elseif (is_string($event['image']) && trim($event['image']) !== '') {
    $images = [$event['image']];
}

$benefits = json_decode($event['benefits'], true) ?: [];
$requirements = json_decode($event['requirements'], true) ?: [];
$organizer = $event['organizer'] ?: "EIM Research Lab";

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($event['title']) ?> - EIM Research Lab</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        @media (max-width: 900px) {
            .detail-grid {
                grid-template-columns: 1fr !important;
            }

            .detail-sidebar {
                position: static !important;
            }
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
                <li class="active"><a href="event.php">Event</a></li>
                <li><a href="structure.php">Structure</a></li>
                <li><a href="news.php">News</a></li>
                
                <?php if (isset($_SESSION["user_id"])): ?>
                    <li><a href="pendaftaran.php">Pendaftaran</a></li>
                    <li><a href="logout.php" style="color: var(--accent-red);">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php" style="color: var(--accent-cyan);">Login</a></li>
                <?php endif; ?>
            </ul>

            <div class="nav-toggle" id="nav-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- --- DETAIL EVENT SECTION --- -->
    <section class="event-detail-section" style="padding: 140px 0 60px 0; min-height: 100vh;">
        <div class="container">
            <!-- Header -->
            <div class="detail-header"
                style="margin-bottom: 40px; border-bottom: 1px solid var(--border-color); padding-bottom: 30px;">
                <a href="event.php"
                    style="color: var(--text-secondary); margin-bottom: 20px; display: inline-block; font-weight: 500;"><i
                        class="fa-solid fa-arrow-left"></i> Kembali</a>
                <div
                    style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                    <div>
                        <h1 id="detail-title"
                            style="font-size: 2.8rem; margin-bottom: 12px; font-weight: 800; letter-spacing: -1px;">
                            <?= htmlspecialchars($event['title']) ?></h1>
                        <div
                            style="color: var(--text-secondary); display: flex; align-items: center; gap: 8px; font-size: 1.1rem;">
                            <i class="fa-regular fa-building"></i> <span id="detail-organizer"><?= htmlspecialchars($organizer) ?></span>
                        </div>
                    </div>
                    <button class="btn btn-secondary" style="border-radius: 50px; padding: 10px 24px;" onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan disalin!')"><i
                            class="fa-solid fa-share-nodes"></i> Bagikan</button>
                </div>
            </div>

            <!-- Content -->
            <div class="detail-grid"
                style="display: grid; grid-template-columns: 2fr 1fr; gap: 50px; align-items: start;">
                <!-- Left Column -->
                <div class="detail-main">
                    <div style="margin-bottom: 40px;">
                        <h3
                            style="color: var(--accent-cyan); display: flex; align-items: center; gap: 10px; margin-bottom: 15px; font-size: 1.3rem;">
                            <i class="fa-solid fa-graduation-cap"></i> Deskripsi
                        </h3>
                        <p id="detail-desc" style="color: var(--text-secondary); font-size: 1.05rem; line-height: 1.8; white-space: pre-wrap;"><?= htmlspecialchars($event['description']) ?></p>
                    </div>

                    <?php if (!empty($benefits)): ?>
                    <div style="margin-bottom: 40px;">
                        <h3
                            style="color: var(--accent-cyan); display: flex; align-items: center; gap: 10px; margin-bottom: 15px; font-size: 1.3rem;">
                            <i class="fa-solid fa-book-open"></i> Keuntungan / Materi
                        </h3>
                        <ul id="detail-benefits"
                            style="color: var(--text-secondary); padding-left: 20px; line-height: 2; font-size: 1.05rem;">
                            <?php foreach ($benefits as $b): ?>
                                <li style="margin-bottom: 8px;"><?= htmlspecialchars($b) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($requirements)): ?>
                    <div style="margin-bottom: 40px;">
                        <h3
                            style="color: var(--accent-cyan); display: flex; align-items: center; gap: 10px; margin-bottom: 15px; font-size: 1.3rem;">
                            <i class="fa-regular fa-circle-check"></i> Persyaratan
                        </h3>
                        <ul id="detail-reqs"
                            style="color: var(--text-secondary); padding-left: 20px; line-height: 2; font-size: 1.05rem;">
                            <?php foreach ($requirements as $r): ?>
                                <li style="margin-bottom: 8px;"><?= htmlspecialchars($r) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($images)): ?>
                    <div id="detail-gallery-container" style="margin-bottom: 40px;">
                        <h3
                            style="color: var(--accent-cyan); display: flex; align-items: center; gap: 10px; margin-bottom: 15px; font-size: 1.3rem;">
                            <i class="fa-regular fa-images"></i> Dokumentasi
                        </h3>
                        <div id="detail-gallery"
                            style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                            <?php foreach ($images as $index => $imgSrc): ?>
                                <img src="<?= htmlspecialchars($imgSrc) ?>" alt="Dokumentasi <?= $index + 1 ?>" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; transition: transform 0.25s ease-out;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Right Column -->
                <div class="detail-sidebar" style="position: sticky; top: 100px;">
                    <div class="glass-panel" style="padding: 30px;">
                        <h3
                            style="margin-bottom: 25px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; font-size: 1.2rem;">
                            Informasi Penting</h3>

                        <div style="display: flex; gap: 15px; margin-bottom: 25px; align-items: center;">
                            <div
                                style="width: 45px; height: 45px; border-radius: 8px; background: rgba(17, 180, 189, 0.1); display: flex; align-items: center; justify-content: center; color: var(--accent-cyan); font-size: 1.2rem;">
                                <i class="fa-regular fa-calendar"></i>
                            </div>
                            <div>
                                <div style="font-size: 0.85rem; color: var(--text-secondary);">Tanggal</div>
                                <div id="detail-date" style="font-weight: 600; font-size: 1.05rem;"><?= htmlspecialchars($event['event_date']) ?></div>
                            </div>
                        </div>

                        <div style="display: flex; gap: 15px; margin-bottom: 25px; align-items: center;">
                            <div
                                style="width: 45px; height: 45px; border-radius: 8px; background: rgba(17, 180, 189, 0.1); display: flex; align-items: center; justify-content: center; color: var(--accent-cyan); font-size: 1.2rem;">
                                <i class="fa-solid fa-tag"></i>
                            </div>
                            <div>
                                <div style="font-size: 0.85rem; color: var(--text-secondary);">Kategori</div>
                                <div id="detail-category" style="font-weight: 600; font-size: 1.05rem;"><?= htmlspecialchars($event['category']) ?></div>
                            </div>
                        </div>

                        <div style="display: flex; gap: 15px; margin-bottom: 35px; align-items: center;">
                            <div
                                style="width: 45px; height: 45px; border-radius: 8px; background: rgba(17, 180, 189, 0.1); display: flex; align-items: center; justify-content: center; color: var(--accent-cyan); font-size: 1.2rem;">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <div style="font-size: 0.85rem; color: var(--text-secondary);">Penyelenggara</div>
                                <div id="detail-organizer-sidebar" style="font-weight: 600; font-size: 1.05rem;"><?= htmlspecialchars($organizer) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- --- FOOTER --- -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-about">
                    <a href="index.php" class="logo-container">
                        <div class="logo-icon" style="width: 30px; height: 30px;">
                            <img src="img/EIM Only Logo.png" alt="EIM Logo">
                        </div>
                        <div class="logo-text">
                            <span class="text-gradient-dual" style="font-size: 1.2rem;">EIM</span>
                            <span class="logo-sub" style="font-size: 0.6rem; letter-spacing: 1px;">Research Lab</span>
                        </div>
                    </a>
                    <p>Enterprise Infrastructure Management (EIM) Research Laboratory merupakan bagian dari Kelompok
                        Keahlian Enterprise & Industrial System (EIS), Program Studi S1 Sistem Informasi, Fakultas
                        Rekayasa Industri, Telkom University.</p>
                </div>

                <div>
                    <h4 class="footer-title">Navigasi Cepat</h4>
                    <ul class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="event.php">Event</a></li>
                        <li><a href="structure.php">Structure</a></li>
                        <li><a href="news.php">News</a></li>
                        
                <?php if (isset($_SESSION["user_id"])): ?>
                    <li><a href="pendaftaran.php">Pendaftaran</a></li>
                    <li><a href="logout.php" style="color: var(--accent-red);">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php" style="color: var(--accent-cyan);">Login</a></li>
                <?php endif; ?>
            </ul>
                </div>

                <div>
                    <h4 class="footer-title">Kontak & Lokasi</h4>
                    <ul class="footer-links" style="margin-bottom: 20px;">
                        <li><i class="fa-solid fa-location-dot"
                                style="margin-right: 8px; color: var(--accent-red);"></i> Gedung TULT Lantai 8, Ruangan
                            TULT.08.09</li>
                        <li><i class="fa-solid fa-university" style="margin-right: 8px; color: var(--accent-red);"></i>
                            Telkom University, Bandung, Indonesia</li>
                        <li><i class="fa-solid fa-envelope" style="margin-right: 8px; color: var(--accent-cyan);"></i>
                            eimlab@telkomuniversity.ac.id</li>
                    </ul>
                    <h4 class="footer-title" style="margin-bottom: 12px; font-size: 0.95rem;">Ikuti Media Sosial Kami
                    </h4>
                    <div class="footer-socials">
                        <a href="https://www.instagram.com/eimresearchlab/" target="_blank" class="footer-social-btn"
                            title="Instagram @eimresearchlab">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="https://youtube.com" target="_blank" class="footer-social-btn" title="YouTube Channel">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2026 EIM Research Laboratory. All Rights Reserved.</p>
                <p>Designed with <i class="fa-solid fa-heart" style="color: var(--accent-red);"></i> in Telkom
                    University</p>
            </div>
        </div>
    </footer>

    <div class="toast-container" id="toast-container"></div>
    <script>window.USER_ROLE = '<?php echo isset($_SESSION["user_role"]) ? $_SESSION["user_role"] : ""; ?>';</script>
    <script src="app.js"></script>
</body>
</html>
