<?php 
// 0. Mulai Session untuk mendeteksi status login admin
session_start();

// 1. Memanggil koneksi database dari folder tentangkami (naik satu tingkat)
include '../koneksi/koneksi.php';

// 2. Mengambil data legalitas dari database MySQL
$query = "SELECT * FROM legalitas ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Legalitas - PT. POLARISTEK ADHI PERSADA</title>
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

        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 80px 0;
        }
        .legal-card {
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-left: 4px solid #ffc107;
        }
        .legal-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        /* --- Kustomisasi Dropdown Multi-Level & Efek Hover --- */
        @media all and (min-width: 992px) {
            .navbar .dropdown:hover > .dropdown-menu {
                display: block;
            }
            .navbar .dropdown-submenu:hover > .dropdown-menu {
                display: block;
            }
        }

        /* Mengatur posisi sub-menu bertingkat */
        .dropdown-submenu {
            position: relative;
        }
        
        /* Menempelkan sub-menu tingkat kedua rapat ke sebelah kiri tanpa jarak */
        .dropdown-submenu > .dropdown-menu {
            top: 0;
            left: auto;
            right: 100%;
            margin-top: -6px;
            margin-right: 0px; 
        }

        /* Efek berubah warna saat kursor mendekati item menu/sub-menu */
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

<!-- Hero Section -->
<header class="hero-section text-center">
    <div class="container">
        <h1 class="fw-bold display-5">LEGALITAS PERUSAHAAN</h1>
        <p class="lead text-light">Fondasi utama yang menopang kelangsungan dan keberlanjutan operasional perusahaan.</p>
    </div>
</header>

<!-- Content Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto text-center">
                <p class="text-muted">
                    Perusahaan tidak hanya perlu memiliki ide bisnis yang kuat, tetapi juga harus memastikan fondasi legalitas yang kokoh. Berikut adalah dokumen resmi perizinan PT. POLARISTEK ADHI PERSADA.
                </p>
                <hr class="w-25 mx-auto border-warning border-2">
            </div>
        </div>

        <div class="row g-4">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($item = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card legal-card h-100 shadow-sm p-3 bg-white">
                            <div class="card-body">
                                <div class="text-warning mb-3">
                                    <i class="fas <?= htmlspecialchars($item['icon']); ?> fa-2x"></i>
                                </div>
                                <span class="badge bg-secondary mb-2"><?= htmlspecialchars($item['kategori']); ?></span>
                                <h5 class="card-title fw-bold text-dark"><?= htmlspecialchars($item['judul']); ?></h5>
                                <p class="card-text text-muted small mt-2"><?= htmlspecialchars($item['detail']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada data legalitas yang tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Memanggil Footer Global -->
<?php include '../koneksi/footer.php'; ?>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>