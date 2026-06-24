<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Tentang EIM Research Lab - Visi, Misi, dan Nilai-nilai Laboratorium Enterprise Infrastructure Management Telkom University.">
    <meta name="keywords" content="EIM, About EIM, Visi Misi, Laboratorium Jaringan, Telkom University">
    <meta name="author" content="EIM Research Lab">

    <title>About - EIM Research Lab</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
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
                <li class="active"><a href="about.php">About</a></li>
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

            <div class="nav-toggle" id="nav-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- --- PAGE HEADER --- -->
    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <div class="hero-tag"><span></span> Tentang Kami</div>
                <h1>Tentang <span class="text-gradient-red">EIM</span> Research Lab</h1>
                <p class="hero-desc">Mengenal lebih dekat laboratorium riset Enterprise Infrastructure Management di
                    Telkom University.</p>
            </div>
        </div>
    </section>

    <!-- --- ABOUT SECTION (OVERVIEW, VISI & MISI, VALUES) --- -->
    <section class="section-padding" id="about">
        <div class="container">
            <!-- Overview -->
            <div class="about-overview-grid" style="margin-bottom: 80px;">
                <div class="about-content">
                    <h2 style="font-size: 2rem; margin-bottom: 20px;">Laboratorium Enterprise Infrastructure Management
                    </h2>
                    <p class="hero-desc" style="margin-bottom: 20px; max-width: 100%;">
                        EIM (Enterprise Infrastructure Management) adalah laboratorium riset di Program Studi S1 Sistem
                        Informasi yang berada di bawah Kelompok Keahlian Enterprise and Industrial System, Fakultas
                        Rekayasa Industri, Telkom University.
                    </p>
                    <p style="color: var(--text-secondary); margin-bottom: 20px;">
                        Kami berfokus pada pemahaman dan pengembangan infrastruktur digital seperti jaringan komputer,
                        sistem operasi, cloud computing, dan cybersecurity. Kami melakukan riset, pengkajian mendalam,
                        dan pelatihan teknologi skala besar guna mempersiapkan talenta digital masa depan.
                    </p>
                </div>
                <div class="about-image" style="display: flex; align-items: center; justify-content: center;">
                    <img src="img/Salinan EIM.png" alt="EIM Lab"
                        style="border-radius: var(--border-radius-md); box-shadow: var(--shadow-md); max-height: 280px; object-fit: contain; padding: 50px; background: white;">
                </div>
            </div>

            <!-- Visi & Misi -->
            <div class="about-visimisi-grid glass-panel" style="padding: 40px; margin-bottom: 80px;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 40px;">
                    <div>
                        <h3
                            style="font-size: 1.8rem; margin-bottom: 16px; color: var(--accent-red); display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-eye"></i> Visi
                        </h3>
                        <p style="color: var(--text-secondary); font-size: 1rem; line-height: 1.6;">
                            Terwujudnya Laboratorium Riset Enterprise Infrastructure Management (EIM) sebagai wadah
                            pengembangan potensi para asisten secara optimal, sehingga terbentuk laboratorium riset yang
                            unggul, kolaboratif, dan berdaya saing, serta mampu mencetak sumber daya manusia yang
                            inovatif, profesional, dan siap berkontribusi di tingkat akademik maupun industri.
                        </p>
                    </div>
                    <div>
                        <h3
                            style="font-size: 1.8rem; margin-bottom: 16px; color: var(--accent-cyan); display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-bullseye"></i> Misi
                        </h3>
                        <ul
                            style="color: var(--text-secondary); font-size: 0.95rem; line-height: 1.6; padding-left: 20px;">
                            <li style="margin-bottom: 8px;">Menguatkan nilai keimanan dan ketakwaan sebagai landasan
                                moral dalam setiap aktivitas Laboratorium Riset EIM.</li>
                            <li style="margin-bottom: 8px;">Membentuk asisten yang cerdas, profesional, dan bertanggung
                                jawab dalam akademik, riset, dan pengabdian.</li>
                            <li style="margin-bottom: 8px;">Mewujudkan lingkungan laboratorium yang kondusif dan
                                produktif dengan menjunjung nilai EIM Kerja.</li>
                            <li style="margin-bottom: 8px;">Mengembangkan program kerja secara berkelanjutan melalui
                                inovasi dan peningkatan kualitas.</li>
                            <li style="margin-bottom: 8px;">Memperkuat komunikasi dan kolaborasi dengan seluruh pemangku
                                kepentingan.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Values -->
            <div>
                <div class="section-title">
                    <h2>Our Values</h2>
                    <p>Nilai-nilai utama yang menjadi pilar dan budaya kerja di EIM Lab.</p>
                </div>

                <div class="focus-grid">
                    <div class="focus-card glass-panel">
                        <div class="focus-icon" style="color: var(--accent-red);">
                            <i class="fa-solid fa-handshake"></i>
                        </div>
                        <h3>Reliability</h3>
                        <p>Membangun kepercayaan melalui identitas yang kuat dan konsisten dalam setiap riset dan
                            layanan.</p>
                    </div>
                    <div class="focus-card glass-panel">
                        <div class="focus-icon">
                            <i class="fa-solid fa-award"></i>
                        </div>
                        <h3>Commitment</h3>
                        <p>Menunjukkan dedikasi tinggi dalam menciptakan inovasi teknologi yang berdampak bagi
                            masyarakat.</p>
                    </div>
                    <div class="focus-card glass-panel">
                        <div class="focus-icon" style="color: var(--accent-red);">
                            <i class="fa-solid fa-people-arrows"></i>
                        </div>
                        <h3>Availability</h3>
                        <p>Selalu hadir sebagai wadah kolaborasi, bertukar ide, dan perkembangan keilmuan digital.</p>
                    </div>
                    <div class="focus-card glass-panel">
                        <div class="focus-icon">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <h3>Quality</h3>
                        <p>Menghadirkan karya riset, solusi praktis, dan pelatihan dengan standar kualitas terbaik.</p>
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

    <!-- --- TOAST NOTIFICATIONS --- -->
    <div class="toast-container" id="toast-container"></div>

    <script src="app.js"></script>
</body>

</html>