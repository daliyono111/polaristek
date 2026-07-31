<?php 
// 0. Mulai Session untuk mendeteksi status login admin
session_start();

// 1. Memanggil koneksi database dari folder koneksi
include 'koneksi/koneksi.php';

// 2. Ambil data profil perusahaan untuk ditampilkan sekilas di beranda
$query_profil = mysqli_query($conn, "SELECT * FROM tentang_kami WHERE id = 1");
$profil = mysqli_fetch_assoc($query_profil);

// 3. Ambil data keunggulan perusahaan
$query_keunggulan = mysqli_query($conn, "SELECT * FROM keunggulan_perusahaan");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - PT. POLARISTEK ADHI PERSADA</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* --- Pengaturan Navbar Fixed di Atas --- */
        .smart-navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1030;
        }

        /* Kondisi Awal (Di paling atas): Background hitam navbar transparan (hilang) */
        .smart-navbar .navbar, 
        .smart-navbar nav {
            background-color: transparent !important;
            transition: background-color 0.4s ease, box-shadow 0.4s ease;
        }

        /* Kondisi saat halaman DIGULIR KE BAWAH: Background hitam navbar MUNCUL kembali */
        .smart-navbar.nav-scrolled .navbar,
        .smart-navbar.nav-scrolled nav {
            background-color: #212529 !important; /* Warna hitam/gelap standar */
            box-shadow: 0 4px 6px rgba(0,0,0,0.1) !important;
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

        /* --- Kustomisasi Slider (Hero Carousel) --- */
        .carousel-item {
            height: 88vh;
            min-height: 500px;
            background-color: #000;
            overflow: hidden;
            position: relative;
        }

        /* Elemen Gambar Latar Belakang di Dalam Slide (Diturunkan agar logo dinding tidak terpotong) */
        .carousel-item .slide-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center 68%;
            background-repeat: no-repeat;
        }
        
        /* --- KEYFRAMES ANIMASI GAMBAR LATAR BELAKANG --- */
        @keyframes slideImagePopZoom {
            0% { transform: scale(0.2); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }

        @keyframes slideImageRightLeft {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideImageBottomUp {
            from { transform: translateY(100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .carousel-item.active .bg-slide-1 {
            animation: slideImagePopZoom 1s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }

        .carousel-item.active .bg-slide-2 {
            animation: slideImageRightLeft 1.2s ease-out forwards;
        }

        .carousel-item.active .bg-slide-3 {
            animation: slideImageBottomUp 1.2s ease-out forwards;
        }

        /* --- KEYFRAMES ANIMASI TEKS --- */
        @keyframes moveRightToLeft {
            from { opacity: 0; transform: translateX(100px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes moveBottomToTopDesc {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes moveBottomToTopBtn {
            from { opacity: 0; transform: translateY(60px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Posisi Teks: Rata Kiri, Tanpa Kotak Background */
        .carousel-caption {
            position: absolute;
            top: 54%;
            left: 8% !important;
            right: auto !important;
            transform: translateY(-50%);
            background: transparent !important;
            padding: 0 !important;
            width: 90%;
            max-width: 700px;
            margin: 0 !important;
            text-align: left !important;
            z-index: 2;
        }

        .carousel-caption h2 {
            font-size: 2.3rem !important; 
        }

        .carousel-caption p {
            font-size: 1.05rem !important;
        }

        .carousel-item.active .animated-title {
            animation: moveRightToLeft 1s ease-out forwards;
        }

        .carousel-item.active .animated-desc {
            animation: moveBottomToTopDesc 1.2s ease-out forwards;
        }

        .carousel-item.active .animated-btn {
            animation: moveBottomToTopBtn 1.4s ease-out forwards;
        }

        /* Memastikan tombol edit & hapus admin berada di lapisan paling atas agar bisa diklik */
        .carousel-caption .admin-action-box {
            position: relative;
            z-index: 10;
        }
        .carousel-caption .admin-action-box a {
            position: relative;
            z-index: 11;
        }

        /* --- EFEK GARIS KUNING MELUNCUR SEKALI DI BAWAH SLIDER --- */
        .garis-meluncur-bawah {
            position: relative;
            width: 100%;
            height: 12px; /* Diperbesar menjadi 6px agar lebih kelihatan */
            background-color: transparent;
            overflow: hidden;
            z-index: 10;
        }

        .garis-meluncur-bawah::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 0%;
            background-color: #ffc107; /* Warna kuning */
            animation: slideAndStopGaris 5.2s ease-out forwards;
        }

        @keyframes slideAndStopGaris {
            0% {
                width: 0%;
                left: 0;
            }
            100% {
                width: 100%;
                left: 0;
            }
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

        @media all and (min-width: 992px) {
            .navbar .dropdown:hover > .dropdown-menu {
                display: block;
            }
        }

        .dropdown-menu .dropdown-item:hover, 
        .dropdown-menu .dropdown-item:focus {
            background-color: #ffc107 !important;
            color: #000 !important;
            transition: 0.2s ease-in-out;
        }
    </style>
</head>
<body>

<!-- Memanggil Navbar Global -->
<div id="navbarWrapper" class="smart-navbar">
    <?php include 'koneksi/navbar.php'; ?>
</div>

<!-- Hero Section Slider Dinamis dari Database -->
<div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
    <div class="carousel-inner">
        <?php
        $query_slider = mysqli_query($conn, "SELECT * FROM slider_banner ORDER BY id DESC");
        $no = 0;
        if (mysqli_num_rows($query_slider) > 0) {
            while ($slide = mysqli_fetch_assoc($query_slider)) {
                $active = ($no == 0) ? 'active' : '';
                
                // Menentukan kelas animasi latar belakang berdasarkan urutan
                $bg_anim_class = 'bg-slide-1';
                $mod = $no % 3;
                if ($mod == 1) {
                    $bg_anim_class = 'bg-slide-2';
                } elseif ($mod == 2) {
                    $bg_anim_class = 'bg-slide-3';
                }
        ?>
                <div class="carousel-item <?= $active; ?>">
                    <!-- Gambar Latar Belakang dengan Animasi Bergerak & Posisi Turun -->
                    <div class="slide-bg <?= $bg_anim_class; ?>" style="background-image: url('img/<?= htmlspecialchars($slide['gambar']); ?>');"></div>
                    
                    <!-- Lapisan Transparan Gelap Tipis di Atas Gambar agar teks terbaca jelas -->
                    <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.35); z-index: 1;"></div>
                    
                    <div class="carousel-caption d-flex flex-column justify-content-center align-items-start">
                        <h2 class="fw-bold text-white mb-2 animated-title"><?= htmlspecialchars($slide['judul']); ?></h2>
                        <p class="text-light mb-3 animated-desc"><?= htmlspecialchars($slide['deskripsi']); ?></p>
                        
                        <?php if (!empty($slide['link_url']) && $slide['link_url'] != '#'): ?>
                            <a href="<?= htmlspecialchars($slide['link_url']); ?>" class="btn btn-warning fw-bold text-dark px-3 py-2 animated-btn" style="font-size: 0.95rem;"><?= htmlspecialchars($slide['link_teks']); ?></a>
                        <?php endif; ?>

                        <!-- Tombol Edit & Hapus Slider untuk Admin -->
                        <?php if (isset($_SESSION['status_login']) && $_SESSION['status_login'] == true): ?>
                            <div class="mt-4 pt-3 border-top border-secondary w-100 text-start admin-action-box">
                                <a href="admin/edit_slider.php?id=<?= $slide['id']; ?>" class="btn btn-sm btn-outline-light me-2"><i class="fas fa-edit me-1"></i> Edit Slide Ini</a>
                                <a href="admin/hapus_slider.php?id=<?= $slide['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus slide ini?')"><i class="fas fa-trash me-1"></i> Hapus Slide Ini</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
        <?php
                $no++;
            }
        } else {
            echo '<div class="carousel-item active text-center text-white d-flex align-items-center justify-content-center" style="background: #222;">
                    <div class="container py-5">
                        <h2 class="text-warning">Belum ada banner slider.</h2>
                        <p>Silakan login sebagai admin untuk menambah data banner slider.</p>
                    </div>
                  </div>';
        }
        ?>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- GARIS KUNING MELUNCUR SEKALI LALU DIAM DI BAWAH SLIDER -->
<div class="garis-meluncur-bawah"></div>

<?php if (isset($_SESSION['status_login']) && $_SESSION['status_login'] == true): ?>
    <div class="container text-end my-3">
        <a href="admin/tambah_slider.php" class="btn btn-warning fw-bold text-dark shadow-sm">
            <i class="fas fa-plus-circle me-2"></i> Tambah Banner Slider Baru
        </a>
    </div>
<?php endif; ?>

<!-- Sambutan / Sekilas Profil Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <img src="img/<?= htmlspecialchars($profil['gambar_profil']); ?>" alt="Profil Perusahaan" class="img-fluid rounded shadow-lg w-100" style="max-height: 400px; object-fit: cover;">
            </div>
            <div class="col-lg-6">
                <span class="badge bg-warning text-dark mb-2 fw-bold">SELAMAT DATANG</span>
                <h2 class="fw-bold mb-3"><?= htmlspecialchars($profil['judul_profil']); ?></h2>
                <p class="text-muted" style="line-height: 1.8;"><?= nl2br(htmlspecialchars($profil['deskripsi_profil'])); ?></p>
                <a href="tentangkami/profile_perusahaan.php" class="btn btn-dark mt-3 px-4 py-2 rounded-pill fw-semibold">Baca Selengkapnya <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Keunggulan Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-secondary mb-2">MENGAPA MEMILIH KAMI</span>
            <h2 class="fw-bold">Keunggulan & Nilai Utama</h2>
            <hr class="w-25 mx-auto border-warning border-2">
        </div>
        <div class="row g-4">
            <?php if ($query_keunggulan && mysqli_num_rows($query_keunggulan) > 0): ?>
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
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Data keunggulan belum tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Memanggil Footer Global -->
<?php include 'koneksi/footer.php'; ?>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script JavaScript: Di atas transparan, saat digulir ke bawah background hitam muncul -->
<script>
    const navbarWrapper = document.getElementById('navbarWrapper');

    window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > 30) {
            // Jika halaman digulir ke bawah, background hitam navbar muncul
            navbarWrapper.classList.add('nav-scrolled');
        } else {
            // Jika kembali ke paling atas, background hitam navbar hilang (transparan)
            navbarWrapper.classList.remove('nav-scrolled');
        }
    });
</script>
</body>
</html>