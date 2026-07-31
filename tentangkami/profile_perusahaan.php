<?php 
// 0. Mulai Session untuk mendeteksi status login admin[cite: 4]
session_start();

// 1. Memanggil koneksi database dari folder tentangkami (naik satu tingkat)[cite: 4]
include '../koneksi/koneksi.php';

// 2. Ambil data profil perusahaan[cite: 4]
$query_profil = mysqli_query($conn, "SELECT * FROM tentang_kami WHERE id = 1");
$profil = mysqli_fetch_assoc($query_profil);

// 3. Ambil data keunggulan perusahaan[cite: 4]
$query_keunggulan = mysqli_query($conn, "SELECT * FROM keunggulan_perusahaan");

// 4. Ambil data background/banner terbaru khusus halaman profil_perusahaan dari database[cite: 4]
$q_banner = mysqli_query($conn, "SELECT * FROM page_banners WHERE page_name='profil_perusahaan' ORDER BY id DESC LIMIT 1");
$banner = mysqli_fetch_assoc($q_banner);

// Nilai default jika belum ada data banner di database[cite: 4]
$bg_img = isset($banner['background_image']) ? '../img/' . $banner['background_image'] : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1920&q=80';
$title = isset($banner['title']) ? $banner['title'] : 'TENTANG KAMI';
$subtitle = isset($banner['subtitle']) ? $banner['subtitle'] : 'Mengenal lebih dekat profil, visi, misi, dan komitmen profesionalisme kami.';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Perusahaan - PT. POLARISTEK ADHI PERSADA</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Efek Gulir Halus saat Anchor Link diklik */
        html {
            scroll-behavior: smooth;
        }

        /* --- Kustomisasi Logo Navbar --- */
        .navbar-brand img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }
        .navbar-brand:hover img {
            transform: scale(1.05);
        }

        /* Hero Section Dinamis yang terhubung ke database */
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('<?= $bg_img; ?>');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 80px 0;
        }
        .card-feature {
            border: none;
            transition: 0.3s;
            border-top: 4px solid #ffc107;
        }
        .card-feature:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .vision-mission-box {
            background-color: #f8f9fa;
            border-left: 5px solid #ffc107;
        }

        /* --- Kustomisasi Dropdown & Efek Hover --- */
        @media all and (min-width: 992px) {
            .navbar .dropdown:hover > .dropdown-menu {
                display: block;
            }
        }

        /* Efek berubah warna saat kursor mendekati item menu */
        .dropdown-menu .dropdown-item:hover, 
        .dropdown-menu .dropdown-item:focus {
            background-color: #ffc107 !important; /* Warna latar belakang (Kuning) */
            color: #000 !important;               /* Warna teks (Hitam) */
            transition: 0.2s ease-in-out;
        }
    </style>
</head>
<body>

<!-- Memanggil Navbar Global dari File Terpisah -->
<?php include '../koneksi/navbar.php'; ?>

<!-- Hero Section Dinamis -->
<header class="hero-section text-center">
    <div class="container">
        <h1 class="fw-bold display-5"><?= htmlspecialchars($title); ?></h1>
        <p class="lead text-light"><?= htmlspecialchars($subtitle); ?></p>
    </div>
</header>

<!-- TOMBOL KONTROL ADMIN (Hanya muncul jika admin sudah login) -->
<?php if (isset($_SESSION['status_login']) && $_SESSION['status_login'] == true): ?>
<div class="bg-warning py-2 shadow-sm">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span class="fw-bold text-dark"><i class="fas fa-user-shield me-2"></i> Mode Admin Aktif</span>
        <div class="d-flex gap-2">
            <!-- Tautan diarahkan ke folder admin -->
            <a href="../admin/admin_banner_profil.php" class="btn btn-dark btn-sm fw-bold">
                <i class="fas fa-image me-1"></i> Kelola Background Header
            </a>
            <a href="edit_profil.php" class="btn btn-dark btn-sm fw-bold">
                <i class="fas fa-edit me-1"></i> Edit Profil Perusahaan
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Profil & Sejarah Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <!-- Menampilkan Foto/Gambar Profil dari Database -->
                <img src="../img/<?= htmlspecialchars($profil['gambar_profil']); ?>" alt="Profil Perusahaan" class="img-fluid rounded shadow-lg w-100" style="max-height: 400px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/600x400';">
            </div>
            <div class="col-lg-6">
                <span class="badge bg-warning text-dark mb-2 fw-bold">PROFIL PERUSAHAAN</span>
                <h2 class="fw-bold mb-3"><?= htmlspecialchars($profil['judul_profil']); ?></h2>
                <p class="text-muted" style="line-height: 1.8;"><?= nl2br(htmlspecialchars($profil['deskripsi_profil'])); ?></p>
                
                <h5 class="fw-bold mt-4 text-dark"><i class="fas fa-history text-warning me-2"></i> Sejarah Singkat</h5>
                <p class="text-muted small" style="line-height: 1.7;"><?= nl2br(htmlspecialchars($profil['sejarah'])); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Visi & Misi Section (Diberi id="visimisi" sebagai target tujuan scroll) -->
<section id="visimisi" class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="p-4 shadow-sm bg-white rounded h-100 vision-mission-box">
                    <div class="text-warning mb-3">
                        <i class="fas fa-eye fa-2x"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Visi Perusahaan</h3>
                    <p class="text-muted"><?= nl2br(htmlspecialchars($profil['visi'])); ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-4 shadow-sm bg-white rounded h-100 vision-mission-box">
                    <div class="text-warning mb-3">
                        <i class="fas fa-bullseye fa-2x"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Misi Perusahaan</h3>
                    <p class="text-muted"><?= nl2br(htmlspecialchars($profil['misi'])); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Keunggulan / Core Values Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-secondary mb-2">MENGAPA MEMILIH KAMI</span>
            <h2 class="fw-bold">Keunggulan & Nilai Utama</h2>
            <hr class="w-25 mx-auto border-warning border-2">
        </div>
        <div class="row g-4">
            <?php while ($row = mysqli_fetch_assoc($query_keunggulan)): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card card-feature p-3 h-100 bg-white shadow-sm">
                        <div class="card-body text-center">
                            <div class="text-warning mb-3">
                                <i class="fas <?= htmlspecialchars($row['icon']); ?> fa-3x"></i>
                            </div>
                            <h5 class="fw-bold"><?= htmlspecialchars($row['judul']); ?></h5>
                            <p class="text-muted small mt-2"><?= htmlspecialchars($row['deskripsi']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- Memanggil Footer Global -->
<?php include '../koneksi/footer.php'; ?>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>