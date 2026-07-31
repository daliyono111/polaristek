<?php 
// 0. Mulai Session untuk mendeteksi status login admin[cite: 4]
session_start();

// 1. Memanggil koneksi database dari folder perencanaan (naik satu tingkat)[cite: 4]
include '../koneksi/koneksi.php';

// 2. Ambil data background/banner terbaru dari tabel page_banner_perencanaan
$q_banner = mysqli_query($conn, "SELECT * FROM page_banner_perencanaan ORDER BY id DESC LIMIT 1");
$banner = mysqli_fetch_assoc($q_banner);

// Nilai default jika belum ada data banner di database
$bg_img = isset($banner['background_image']) && !empty($banner['background_image']) ? '../img/' . $banner['background_image'] : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1920&q=80';
$title = isset($banner['title']) ? $banner['title'] : 'BIDANG PERENCANAAN';
$subtitle = isset($banner['subtitle']) ? $banner['subtitle'] : 'Eksplorasi hasil karya perancangan profesional kami.';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bidang Perencanaan - PT. POLARISTEK ADHI PERSADA[cite: 4]</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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
            padding: 70px 0;
        }

        /* --- Style Kartu Portofolio --- */
        .project-card {
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            background-color: #000;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            height: 320px;
        }
        .project-card:hover {
            transform: translateY(-5px);
        }
        .project-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.75;
            transition: opacity 0.3s ease;
        }
        .project-card:hover img {
            opacity: 0.6;
        }
        .project-card .card-img-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.9) 10%, rgba(0,0,0,0.3) 60%, transparent 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 25px;
        }

        /* Tombol Filter */
        .filter-btn {
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 6px;
            transition: all 0.2s ease-in-out;
        }

        /* --- Styling Tambahan untuk Thumbnail & Zoom --- */
        .thumb-img {
            width: 75px;
            height: 55px;
            object-fit: cover;
            cursor: pointer;
            border-radius: 6px;
            border: 2px solid #dee2e6;
            transition: all 0.2s ease;
        }
        .thumb-img:hover, .thumb-img.active-thumb {
            border-color: #ffc107;
            transform: scale(1.05);
        }
        .main-preview-img {
            cursor: zoom-in;
            transition: opacity 0.2s ease;
        }
        .main-preview-img:hover {
            opacity: 0.95;
        }

        /* Tombol Close X Teks Bersih & Jelas */
        .btn-close-custom {
            background: transparent;
            border: none;
            color: #ffffff;
            font-size: 3rem;
            font-weight: 300;
            line-height: 1;
            cursor: pointer;
            transition: color 0.2s ease, transform 0.2s ease;
            text-shadow: 0 2px 4px rgba(0,0,0,0.8);
        }
        .btn-close-custom:hover {
            color: #ffc107;
            transform: scale(1.1);
        }

        /* --- Kustomisasi Dropdown Multi-Level --- */
        @media all and (min-width: 992px) {
            .navbar .dropdown:hover > .dropdown-menu {
                display: block;
            }
            .navbar .dropdown-submenu:hover > .dropdown-menu {
                display: block;
            }
        }
        .dropdown-submenu {
            position: relative;
        }
        .dropdown-submenu > .dropdown-menu {
            top: 0;
            left: auto;
            right: 100%;
            margin-top: -6px;
        }
        .dropdown-menu .dropdown-item:hover, 
        .dropdown-menu .dropdown-item:focus {
            background-color: #ffc107 !important;
            color: #000 !important;
        }
    </style>
</head>
<body class="bg-light">

<!-- Memanggil Navbar Global dari File Terpisah[cite: 4] -->
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
            <!-- Tautan ke manajemen background banner perencanaan -->
            <a href="../admin/admin_banner_perencanaan.php" class="btn btn-dark btn-sm fw-bold">
                <i class="fas fa-image me-1"></i> Kelola Background Header
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Content Section dengan Tombol Filter -->
<section class="py-5">
    <div class="container">
        
        <!-- Tombol Kategori (Filter Menu) -->
        <div class="d-flex flex-wrap justify-content-center gap-2 mb-4" id="filterButtons">
            <button class="btn btn-warning filter-btn active" data-filter="all">All</button>
            <button class="btn btn-dark filter-btn" data-filter="Gedung">Gedung</button>
            <button class="btn btn-dark filter-btn" data-filter="Jalan dan Jembatan">Jalan dan Jembatan</button>
            <button class="btn btn-dark filter-btn" data-filter="Tata Lingkungan">Tata Lingkungan</button>
        </div>

        <!-- Tombol Tambah Data Khusus Admin yang Sudah Login[cite: 4] -->
        <?php if (isset($_SESSION['status_login']) && $_SESSION['status_login'] == true): ?>
            <div class="mb-4 text-end">
                <a href="tambah_perencanaan.php" class="btn btn-warning fw-bold text-dark px-4 shadow-sm" style="border-radius: 6px;">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Data Perencanaan
                </a>
            </div>
        <?php endif; ?>

        <!-- Daftar Proyek (Looping dari Database)[cite: 4] -->
        <div class="row g-4" id="portfolioList">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM portofolio_perencanaan ORDER BY id DESC");
            if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    $kategoriClass = trim($row['kategori']); 
                    ?>
                    <div class="col-md-4 project-item" data-category="<?= $kategoriClass; ?>">
                        <div class="card project-card text-white border-0">
                            <img src="../img/<?= htmlspecialchars($row['foto']); ?>" alt="Foto Proyek" onerror="this.src='https://via.placeholder.com/400x300';">
                            <div class="card-img-overlay">
                                <div>
                                    <span class="badge bg-warning text-dark mb-2 px-2 py-1 fw-bold text-uppercase" style="font-size: 10px;"><?= htmlspecialchars($row['kategori']); ?></span>
                                    <h5 class="card-title fw-bold text-white mb-2" style="font-size: 1.1rem; line-height: 1.4;"><?= htmlspecialchars($row['nama_proyek']); ?></h5>
                                </div>
                                <a href="#" class="btn btn-outline-light btn-sm w-100 fw-bold mt-2 py-1" style="font-size: 12px; border-radius: 4px;" data-bs-toggle="modal" data-bs-target="#detailModal<?= $row['id']; ?>">VIEW MORE</a>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Detail dengan Thumbnail Interaktif di Bawah & Zoom -->
                    <div class="modal fade" id="detailModal<?= $row['id']; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0 shadow-lg">
                                <!-- Header Modal Hitam -->
                                <div class="modal-header bg-dark text-white py-3 px-4">
                                    <h5 class="modal-title fs-6 fw-semibold text-truncate pe-3"><?= htmlspecialchars($row['nama_proyek']); ?></h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                
                                <!-- Body Modal (Layout Kiri-Kanan) -->
                                <div class="modal-body p-4">
                                    <div class="row align-items-center g-4">
                                        
                                        <!-- Kolom Kiri: Foto Utama Besar & Thumbnail Kecil di Bawah -->
                                        <div class="col-md-6">
                                            <!-- Foto Utama -->
                                            <div class="mb-2 shadow-sm rounded overflow-hidden bg-black text-center" style="height: 230px;">
                                                <img id="mainImage<?= $row['id']; ?>" src="../img/<?= htmlspecialchars($row['foto']); ?>" class="w-100 h-100 main-preview-img" style="object-fit: cover;" alt="Foto Utama" data-bs-toggle="modal" data-bs-target="#zoomModal<?= $row['id']; ?>" onerror="this.src='https://via.placeholder.com/400x300';">
                                            </div>
                                            <div class="text-center text-muted small mb-2" style="font-size: 11px;"><i class="fas fa-search-plus me-1"></i> Klik foto untuk memperbesar</div>

                                            <!-- Thumbnail Kecil di Bawah -->
                                            <div class="d-flex gap-2 justify-content-center overflow-auto py-1">
                                                <!-- Thumbnail 1 -->
                                                <?php if (!empty($row['foto'])): ?>
                                                    <img src="../img/<?= htmlspecialchars($row['foto']); ?>" class="thumb-img active-thumb" onclick="gantiFoto(<?= $row['id']; ?>, '../img/<?= htmlspecialchars($row['foto']); ?>', this, 0)" alt="Thumb 1">
                                                <?php endif; ?>

                                                <!-- Thumbnail 2 -->
                                                <?php if (!empty($row['foto2'])): ?>
                                                    <img src="../img/<?= htmlspecialchars($row['foto2']); ?>" class="thumb-img" onclick="gantiFoto(<?= $row['id']; ?>, '../img/<?= htmlspecialchars($row['foto2']); ?>', this, 1)" alt="Thumb 2">
                                                <?php endif; ?>

                                                <!-- Thumbnail 3 -->
                                                <?php if (!empty($row['foto3'])): ?>
                                                    <img src="../img/<?= htmlspecialchars($row['foto3']); ?>" class="thumb-img" onclick="gantiFoto(<?= $row['id']; ?>, '../img/<?= htmlspecialchars($row['foto3']); ?>', this, 2)" alt="Thumb 3">
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <!-- Kolom Kanan: Teks, Badge, & Deskripsi -->
                                        <div class="col-md-6">
                                            <span class="badge bg-warning text-dark mb-2 px-2 py-1 fw-bold text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;"><?= htmlspecialchars($row['kategori']); ?> / Perencanaan</span>
                                            <h4 class="fw-bold text-dark mb-3" style="font-size: 1.25rem; line-height: 1.4;"><?= htmlspecialchars($row['nama_proyek']); ?></h4>
                                            <p class="text-secondary small mb-0" style="line-height: 1.6; text-align: justify;"><?= nl2br(htmlspecialchars($row['deskripsi'])); ?></p>
                                        </div>

                                    </div>
                                </div>

                                <!-- Footer Modal dengan Tombol Edit & Hapus (Hanya Tampil Jika Login) -->
                                <div class="modal-footer bg-light py-2 px-4 d-flex justify-content-between align-items-center">
                                    <div>
                                        <?php if (isset($_SESSION['status_login']) && $_SESSION['status_login'] == true): ?>
                                            <a href="edit_perencanaan.php?id=<?= $row['id']; ?>" class="btn btn-outline-secondary btn-sm px-3 fw-semibold text-dark border-secondary-subtle" style="font-size: 13px;"><i class="fas fa-edit me-1 text-muted"></i> Edit</a>
                                            <a href="proses_hapus.php?id=<?= $row['id']; ?>" class="btn btn-outline-danger btn-sm px-3 fw-semibold border-danger-subtle" style="font-size: 13px;" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fas fa-trash me-1"></i> Hapus</a>
                                        <?php endif; ?>
                                    </div>
                                    <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal" style="font-size: 13px; font-weight: 500;">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Popup Zoom Foto Layar Penuh (Bergeser Otomatis / Autoplay) -->
                    <div class="modal fade" id="zoomModal<?= $row['id']; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-fullscreen">
                            <div class="modal-content bg-black bg-opacity-95 border-0">
                                <div class="modal-body position-relative d-flex align-items-center justify-content-center p-0">
                                    
                                    <!-- Tombol Close X Teks Saja Tanpa Lingkaran -->
                                    <button type="button" class="btn-close-custom position-absolute top-0 end-0 m-4 z-3" data-bs-dismiss="modal" aria-label="Close">&times;</button>

                                    <!-- Carousel untuk Zoom & Bergeser Otomatis (Interval 3000ms / 3 detik) -->
                                    <div id="zoomCarousel<?= $row['id']; ?>" class="carousel slide w-100 h-100 d-flex align-items-center" data-bs-ride="carousel" data-bs-interval="3000">
                                        <div class="carousel-inner h-100">
                                            <!-- Slide 1 -->
                                            <div class="carousel-item active h-100 text-center">
                                                <div class="d-flex align-items-center justify-content-center h-100 p-0">
                                                    <img src="../img/<?= htmlspecialchars($row['foto']); ?>" class="img-fluid rounded shadow-lg" style="max-height: 98vh; max-width: 98vw; width: auto; height: auto; object-fit: contain;" alt="Zoom 1">
                                                </div>
                                            </div>

                                            <!-- Slide 2 (Jika ada) -->
                                            <?php if (!empty($row['foto2'])): ?>
                                                <div class="carousel-item h-100 text-center">
                                                    <div class="d-flex align-items-center justify-content-center h-100 p-0">
                                                        <img src="../img/<?= htmlspecialchars($row['foto2']); ?>" class="img-fluid rounded shadow-lg" style="max-height: 98vh; max-width: 98vw; width: auto; height: auto; object-fit: contain;" alt="Zoom 2">
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Slide 3 (Jika ada) -->
                                            <?php if (!empty($row['foto3'])): ?>
                                                <div class="carousel-item h-100 text-center">
                                                    <div class="d-flex align-items-center justify-content-center h-100 p-0">
                                                        <img src="../img/<?= htmlspecialchars($row['foto3']); ?>" class="img-fluid rounded shadow-lg" style="max-height: 98vh; max-width: 98vw; width: auto; height: auto; object-fit: contain;" alt="Zoom 3">
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Tombol Panah Navigasi Kiri & Kanan (Hanya muncul jika foto lebih dari 1) -->
                                        <?php if (!empty($row['foto2']) || !empty($row['foto3'])): ?>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#zoomCarousel<?= $row['id']; ?>" data-bs-slide="prev" style="width: 8%;">
                                                <span class="carousel-control-prev-icon bg-dark bg-opacity-50 p-4 rounded-circle" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#zoomCarousel<?= $row['id']; ?>" data-bs-slide="next" style="width: 8%;">
                                                <span class="carousel-control-next-icon bg-dark bg-opacity-50 p-4 rounded-circle" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }
            } else {
                echo '<div class="col-12 text-center"><p class="text-muted fst-italic">Belum ada data portofolio yang diinput ke dalam database.</p></div>';
            }
            ?>
        </div>

    </div>
</section>

<!-- Memanggil Footer Global[cite: 4] -->
<?php include '../koneksi/footer.php'; ?>

<!-- Bootstrap JS & Skrip Filter Interaktif serta Sinkronisasi Zoom Carousel -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Fungsi untuk mengganti foto utama dan menyinkronkan slide zoom saat thumbnail diklik
    function gantiFoto(id, pathFoto, elementThumb, slideIndex) {
        document.getElementById('mainImage' + id).src = pathFoto;

        let zoomCarouselEl = document.getElementById('zoomCarousel' + id);
        if (zoomCarouselEl) {
            let carouselInstance = bootstrap.Carousel.getOrCreateInstance(zoomCarouselEl);
            carouselInstance.to(slideIndex);
        }

        let container = elementThumb.parentElement;
        let thumbs = container.getElementsByClassName('thumb-img');
        for (let t of thumbs) {
            t.classList.remove('active-thumb');
        }
        elementThumb.classList.add('active-thumb');
    }

    // Skrip Filter Kategori
    document.addEventListener("DOMContentLoaded", function () {
        const filterButtons = document.querySelectorAll("#filterButtons button");
        const portfolioItems = document.querySelectorAll(".project-item");

        filterButtons.forEach(button => {
            button.addEventListener("click", function () {
                filterButtons.forEach(btn => {
                    btn.classList.remove("btn-warning");
                    btn.classList.add("btn-dark");
                });
                this.classList.remove("btn-dark");
                this.classList.add("btn-warning");

                const filterValue = this.getAttribute("data-filter");

                portfolioItems.forEach(item => {
                    if (filterValue === "all" || item.getAttribute("data-category") === filterValue) {
                        item.style.display = "block";
                    } else {
                        item.style.display = "none";
                    }
                });
            });
        });
    });
</script>
</body>
</html>