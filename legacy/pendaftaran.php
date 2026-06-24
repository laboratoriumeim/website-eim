<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pendaftaran Asisten Laboratorium EIM Research Lab Telkom University.">
    <meta name="keywords" content="EIM, Pendaftaran, Asisten Lab, Telkom University, Rekrutmen">
    <meta name="author" content="EIM Research Lab">

    <title>Pendaftaran Asisten - EIM Research Lab</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
        .registration-form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            border-top: 3px solid var(--accent-cyan);
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

        .registration-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .registration-header h2 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .registration-header p {
            color: var(--text-secondary);
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
                <li class="active"><a href="pendaftaran.php">Pendaftaran</a></li>
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
                <div class="hero-tag"><span></span> Oprec Asisten</div>
                <h1>Pendaftaran <span class="text-gradient-cyan">Asisten Lab</span></h1>
                <p class="hero-desc">Mari bergabung menjadi bagian dari EIM Research Lab. Kembangkan potensimu di bidang
                    infrastruktur IT, jaringan, dan riset teknologi.</p>
            </div>
        </div>
    </section>

    <!-- --- REGISTRATION FORM SECTION --- -->
    <section class="section-padding" id="pendaftaran">
        <div class="container">
            <div class="registration-form-container glass-panel">
                <div class="registration-header">
                    <h2>Formulir Pendaftaran Asisten</h2>
                    <p>Lengkapi formulir di bawah ini dengan data yang valid dan benar.</p>
                </div>

                <form id="registration-form">
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" placeholder="Nama lengkap" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <input type="text" class="form-control" id="kelas" placeholder="Contoh: SI4XXX" required>
                        </div>
                        <div class="form-group">
                            <label for="nim">NIM</label>
                            <input type="text" class="form-control" id="nim" placeholder="NIM" pattern="[0-9]+"
                                required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label for="nomor_telp">Nomor Telepon (WhatsApp)</label>
                            <input type="tel" class="form-control" id="nomor_telp" placeholder="Contoh: 081XXXXX"
                                pattern="[0-9]+" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="divisi_1">Pilihan Divisi 1 (Prioritas Utama)</label>
                            <select class="form-control" id="divisi_1" required>
                                <option value="" disabled selected>Pilih Divisi 1</option>
                                <option value="Inti">INTI (Koordinator, Sekretaris, Bendahara)</option>
                                <option value="Riset">RISET (Penelitian Infrastruktur & AI)</option>
                                <option value="PKU">PKU (Pengembangan Kapasitas Utama)</option>
                                <option value="Lomba">LOMBA (Kompetisi IT & Jaringan)</option>
                                <option value="Medhum">MEDHUM (Media & Hubungan Masyarakat)</option>
                                <option value="Pengmas">PENGMAS (Pengabdian Masyarakat)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="divisi_2">Pilihan Divisi 2</label>
                            <select class="form-control" id="divisi_2" required>
                                <option value="" disabled selected>Pilih Divisi 2</option>
                                <option value="Inti">INTI (Koordinator, Sekretaris, Bendahara)</option>
                                <option value="Riset">RISET (Penelitian Infrastruktur & AI)</option>
                                <option value="PKU">PKU (Pengembangan Kapasitas Utama)</option>
                                <option value="Lomba">LOMBA (Kompetisi IT & Jaringan)</option>
                                <option value="Medhum">MEDHUM (Media & Hubungan Masyarakat)</option>
                                <option value="Pengmas">PENGMAS (Pengabdian Masyarakat)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alasan">Alasan Mendaftar</label>
                        <textarea class="form-control" id="alasan"
                            placeholder="Ceritakan motivasi dan alasan Anda ingin bergabung dengan divisi pilihan Anda..."
                            required></textarea>
                    </div>

                    <div class="form-actions" style="justify-content: center; margin-top: 40px;">
                        <button type="submit" class="btn btn-primary"
                            style="width: 100%; max-width: 300px; padding: 14px; font-size: 1.1rem;">
                            Kirim Pendaftaran <i class="fa-solid fa-paper-plane" style="margin-left: 8px;"></i>
                        </button>
                    </div>
                </form>
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('registration-form');
            if (form) {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();

                    // Basic validation to check if division 1 and 2 are the same
                    const div1 = document.getElementById('divisi_1').value;
                    const div2 = document.getElementById('divisi_2').value;

                    if (div1 === div2) {
                        showToast("Pilihan Divisi 1 dan Divisi 2 tidak boleh sama!", "danger");
                        return;
                    }

                    const scriptURL = "https://script.google.com/macros/s/AKfycbz8AXxyFoeeq453EjMEtu_A9Cd10DSgVa8Le2YTZ0PvnIdSf43aN_C9d_2wc_hoRWpY/exec";
                    const btn = form.querySelector('button[type="submit"]');
                    const originalText = btn.innerHTML;
                    btn.innerHTML = 'Mengirim... <i class="fa-solid fa-circle-notch fa-spin"></i>';
                    btn.disabled = true;

                    // Mengumpulkan data dari form
                    const formData = new FormData();
                    formData.append('Nama Lengkap', document.getElementById('nama_lengkap').value);
                    formData.append('Kelas', document.getElementById('kelas').value);
                    formData.append('NIM', document.getElementById('nim').value);
                    formData.append('Email', document.getElementById('email').value);
                    formData.append('Nomor Telepon', document.getElementById('nomor_telp').value);
                    formData.append('Divisi 1', div1);
                    formData.append('Divisi 2', div2);
                    formData.append('Alasan', document.getElementById('alasan').value);

                    fetch(scriptURL, { method: 'POST', body: formData })
                        .then(response => {
                            showToast("Pendaftaran berhasil dikirim! Silakan cek email Anda.", "success");
                            form.reset();
                            btn.innerHTML = originalText;
                            btn.disabled = false;
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        })
                        .catch(error => {
                            console.error('Error!', error.message);
                            showToast("Gagal mengirim data. Coba lagi beberapa saat.", "danger");
                            btn.innerHTML = originalText;
                            btn.disabled = false;
                        });
                });
            }
        });
    </script>
</body>

</html>