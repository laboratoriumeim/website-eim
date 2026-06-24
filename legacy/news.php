<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Berita & Kabar Terkini dari EIM Research Lab Telkom University.">
    <meta name="keywords" content="EIM, Berita, News, Lab EIM, Telkom University">
    <meta name="author" content="EIM Research Lab">

    <title>News - EIM Research Lab</title>

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
                <li><a href="about.php">About</a></li>
                <li><a href="event.php">Event</a></li>
                <li><a href="structure.php">Structure</a></li>
                <li class="active"><a href="news.php">News</a></li>
                
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
                <div class="hero-tag"><span></span> Berita Terkini</div>
                <h1>Kabar & <span class="text-gradient-cyan">Berita</span> Terkini</h1>
                <p class="hero-desc">Ikuti info kegiatan, prestasi, webinar, dan info akademik terbaru dari kami.</p>
            </div>
        </div>
    </section>

    <!-- --- NEWS (BERITA) SECTION --- -->
    <section class="section-padding" id="news">
        <div class="container">
            <div class="news-header">
                <div>
                    <h2 style="font-size: 2.2rem; margin-bottom: 8px;">Semua Berita</h2>
                    <p style="color: var(--text-secondary);">Daftar lengkap semua berita dan artikel yang diterbitkan
                        oleh EIM Research Lab.</p>
                </div>
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <button class="btn btn-primary" id="btn-add-news">
                    Tambah Berita <i class="fa-solid fa-plus"></i>
                </button>
                <?php endif; ?>
            </div>

            <div class="news-grid" id="news-grid">
                <!-- Dynamic Content Loaded by JS -->
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

    <!-- --- ADMIN / NEWS MODAL FORM --- -->
    <div class="modal" id="news-modal">
        <div class="modal-overlay" id="news-modal-overlay"></div>
        <div class="modal-wrapper">
            <div class="modal-header">
                <h3 id="modal-title">Tambah Berita Baru</h3>
                <i class="fa-solid fa-xmark modal-close" id="modal-close-btn"></i>
            </div>
            <form id="news-form">
                <input type="hidden" id="news-id">

                <div class="form-group">
                    <label for="news-input-title">Judul Berita</label>
                    <input type="text" class="form-control" id="news-input-title" placeholder="Masukkan judul berita"
                        required>
                </div>

                <div class="form-group">
                    <label for="news-input-category">Kategori</label>
                    <select class="form-control" id="news-input-category" required>
                        <option value="Kegiatan Lab">Kegiatan Lab</option>
                        <option value="Prestasi">Prestasi</option>
                        <option value="Tutorial">Tutorial</option>
                        <option value="Webinar">Webinar & Workshop</option>
                        <option value="Pengumuman">Pengumuman Akademik</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="news-input-author">Penulis / Asisten</label>
                    <input type="text" class="form-control" id="news-input-author" placeholder="Nama penulis berita"
                        required>
                </div>

                <div class="form-group">
                    <label>Gambar Berita</label>
                    <div class="file-upload-wrapper">
                        <i class="fa-solid fa-cloud-arrow-up fa-2x"
                            style="color: var(--accent-cyan); margin-bottom: 8px; display: block;"></i>
                        <span id="file-label-text">Klik atau seret gambar ke sini (Opsional)</span>
                        <input type="file" id="news-input-file" accept="image/*">
                        <img src="" id="file-preview-img" class="file-upload-preview" alt="Preview unggahan">
                    </div>
                    <div style="margin-top: 12px; text-align: center; color: var(--text-muted); font-size: 0.8rem;">
                        Atau tempel URL Gambar:
                    </div>
                    <input type="text" class="form-control" id="news-input-url"
                        placeholder="https://contoh.com/gambar.jpg" style="margin-top: 8px;">
                </div>

                <div class="form-group">
                    <label for="news-input-content">Konten Berita</label>
                    <textarea class="form-control" id="news-input-content"
                        placeholder="Tuliskan berita lengkap di sini..." required></textarea>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" id="btn-cancel-news">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-submit-news">Simpan Berita</button>
                </div>
            </form>
        </div>
    </div>

    <!-- --- TOAST NOTIFICATIONS --- -->
    <div class="toast-container" id="toast-container"></div>

    <script>window.USER_ROLE = '<?php echo isset($_SESSION["user_role"]) ? $_SESSION["user_role"] : ""; ?>';</script>
    <script src="app.js"></script>
</body>

</html>