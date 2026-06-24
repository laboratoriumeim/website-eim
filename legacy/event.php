<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kegiatan & Event EIM Research Lab - Kuliah Umum, Study Group, dan Company Visit.">
    <meta name="keywords" content="EIM, Event, Kuliah Umum, Study Group, Company Visit, Huawei">
    <meta name="author" content="EIM Research Lab">

    <title>Event - EIM Research Lab</title>

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

    <!-- --- PAGE HEADER --- -->
    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <div class="hero-tag"><span></span> Kegiatan Kami</div>
                <h1>Kegiatan & <span class="text-gradient-cyan">Event</span> Lab</h1>
                <p class="hero-desc">Ikuti berbagai kegiatan akademis, pelatihan, dan kunjungan industri yang kami
                    selenggarakan.</p>
            </div>
        </div>
    </section>

    <!-- --- EVENT SECTION --- -->
    <section class="section-padding" id="event">
        <div class="container">
            <div class="news-header" style="margin-bottom: 30px;">
                <div>
                    <h2 style="font-size: 2.2rem; margin-bottom: 8px;">Semua Event</h2>
                    <p style="color: var(--text-secondary);">Daftar kegiatan, acara, dan pelatihan yang diselenggarakan oleh Lab EIM.</p>
                </div>
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <button class="btn btn-primary" id="btn-add-event">
                    Tambah Event <i class="fa-solid fa-plus"></i>
                </button>
                <?php endif; ?>
            </div>
            
            <div class="events-grid" id="events-grid">
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

    <!-- --- EVENT MODAL FORM --- -->
    <div class="modal" id="event-modal">
        <div class="modal-overlay" id="event-modal-overlay"></div>
        <div class="modal-wrapper">
            <div class="modal-header">
                <h3 id="event-modal-title">Tambah Event Baru</h3>
                <i class="fa-solid fa-xmark modal-close" id="event-modal-close-btn"></i>
            </div>
            <form id="event-form">
                <input type="hidden" id="event-id">

                <div class="form-group">
                    <label for="event-input-title">Judul Event</label>
                    <input type="text" class="form-control" id="event-input-title" placeholder="Nama acara" required>
                </div>

                <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label for="event-input-category">Kategori</label>
                        <select class="form-control" id="event-input-category" required>
                            <option value="Study Group">Study Group</option>
                            <option value="Kuliah Umum">Kuliah Umum</option>
                            <option value="Company Visit">Company Visit</option>
                            <option value="EIM Peduli">EIM Peduli</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="event-input-status">Status</label>
                        <select class="form-control" id="event-input-status" required>
                            <option value="upcoming">Upcoming</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="event-input-date">Tanggal</label>
                    <input type="text" class="form-control" id="event-input-date" placeholder="Contoh: 5 Juni 2026" required>
                </div>

                <div class="form-group">
                    <label>Gambar Cover (Bisa pilih lebih dari 1 foto)</label>
                    <div class="file-upload-wrapper">
                        <i class="fa-solid fa-cloud-arrow-up fa-2x" style="color: var(--accent-cyan); margin-bottom: 8px; display: block;"></i>
                        <span id="event-file-label-text">Klik atau seret gambar ke sini</span>
                        <input type="file" id="event-input-file" accept="image/*" multiple>
                        <div id="event-file-preview-container" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px;"></div>
                    </div>
                    <input type="text" class="form-control" id="event-input-url" placeholder="Atau URL Gambar: https://contoh.com/img.jpg" style="margin-top: 8px;">
                </div>

                <div class="form-group">
                    <label for="event-input-desc">Deskripsi Singkat</label>
                    <textarea class="form-control" id="event-input-desc" placeholder="Tuliskan deskripsi event..." style="min-height: 80px;" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="event-input-organizer">Penyelenggara (Opsional)</label>
                    <input type="text" class="form-control" id="event-input-organizer" placeholder="Contoh: EIM Research Lab & Huawei">
                </div>

                <div class="form-group">
                    <label for="event-input-benefits">Keuntungan / Materi (Opsional)</label>
                    <textarea class="form-control" id="event-input-benefits" placeholder="Sertifikat&#10;Snack&#10;Materi PDF (Satu baris per item)" style="min-height: 80px;"></textarea>
                </div>

                <div class="form-group">
                    <label for="event-input-reqs">Persyaratan (Opsional)</label>
                    <textarea class="form-control" id="event-input-reqs" placeholder="Membawa laptop&#10;Terbuka untuk umum (Satu baris per item)" style="min-height: 80px;"></textarea>
                </div>
                

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" id="btn-cancel-event">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-submit-event">Simpan Event</button>
                </div>
            </form>
        </div>
    </div>

    <div class="toast-container" id="toast-container"></div>
    <script>window.USER_ROLE = '<?php echo isset($_SESSION["user_role"]) ? $_SESSION["user_role"] : ""; ?>';</script>
    <script src="app.js"></script>
</body>

</html>