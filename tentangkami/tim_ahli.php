<?php 
// 0. Mulai Session untuk mendeteksi status login admin
session_start();

// 1. Memanggil koneksi database dari folder tentangkami (naik satu tingkat)
include '../koneksi/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tim Ahli Kami - PT. POLARISTEK ADHI PERSADA</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Efek Gulir Halus */
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

        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 80px 0;
        }

        .expert-card {
            border: none;
            border-left: 5px solid #ffc107;
            transition: 0.3s;
        }
        .expert-card:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* --- Kustomisasi Kontainer Berjalan Otomatis (Auto-Scroll) --- */
        .scroll-container {
            height: 450px;
            overflow: hidden;
            position: relative;
        }

        .scroll-track {
            display: flex;
            flex-direction: column;
            position: absolute;
            width: 100%;
            animation: scrollUp 25s linear infinite;
        }

        /* Berhenti otomatis saat kursor diarahkan ke kotak */
        .scroll-container:hover .scroll-track {
            animation-play-state: paused;
        }

        /* Keyframes untuk pergerakan dari bawah ke atas */
        @keyframes scrollUp {
            0% {
                transform: translateY(0);
            }
            100% {
                transform: translateY(-50%);
            }
        }

        /* --- Kustomisasi Dropdown & Efek Hover --- */
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

<!-- Memanggil Navbar Global dari File Terpisah -->
<?php include '../koneksi/navbar.php'; ?>

<!-- Hero Section -->
<header class="hero-section text-center">
    <div class="container">
        <h1 class="fw-bold display-5">TIM AHLI KAMI</h1>
        <p class="lead text-light">Didukung oleh tenaga profesional, tersertifikasi, dan berpengalaman di bidangnya.</p>
    </div>
</header>

<!-- Daftar Tim Ahli Section dengan Efek Berjalan Otomatis dari Bawah ke Atas -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-warning text-dark mb-2 fw-bold">KARTU KOMPETENSI</span>
            <h2 class="fw-bold">Bidang Keahlian Profesional</h2>
            <p class="text-muted">Daftar tenaga ahli bersertifikat yang siap menangani berbagai proyek konstruksi.</p>
            <hr class="w-25 mx-auto border-warning border-2">
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Wrapper Auto Scroll -->
                <div class="scroll-container shadow-sm bg-white rounded p-3 border">
                    <div class="scroll-track">
                        
                        <!-- SET PERTAMA -->
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-drafting-compass fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Ahli Arsitektur</h5><p class="mb-0 text-muted small">Merancang konsep tata letak bangunan estetis dan fungsional.</p></div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-building fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Ahli Teknik Bangunan Gedung</h5><p class="mb-0 text-muted small">Mengawasi struktur ketahanan fisik bangunan bertingkat.</p></div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-hard-hat fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Ahli Konstruksi K3</h5><p class="mb-0 text-muted small">Memastikan penerapan keselamatan dan kesehatan kerja aman.</p></div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-cogs fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Ahli Mekanikal Elektrikal</h5><p class="mb-0 text-muted small">Menangani sistem kelistrikan, tata udara, dan pemipaan.</p></div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-bolt fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Ahli Electrikal</h5><p class="mb-0 text-muted small">Spesialis instalasi jaringan daya listrik arus kuat dan lemah.</p></div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-road fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Ahli Teknik Jalan Dan Jembatan</h5><p class="mb-0 text-muted small">Perencanaan infrastruktur transportasi darat secara presisi.</p></div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-leaf fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Ahli Teknik Lingkungan</h5><p class="mb-0 text-muted small">Analisis dampak lingkungan dan pengelolaan limbah pembangunan.</p></div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-tasks fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Ahli Manajemen Proyek</h5><p class="mb-0 text-muted small">Pengelolaan alur kerja dan efisiensi biaya operasional proyek.</p></div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-project-diagram fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Ahli Manajemen Konstruksi</h5><p class="mb-0 text-muted small">Koordinasi teknis pelaksanaan pembangunan hingga serah terima.</p></div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-city fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Ahli Planologi</h5><p class="mb-0 text-muted small">Perencanaan wilayah kota dan penataan tata ruang terintegrasi.</p></div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-users fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Dan Lain-Lain</h5><p class="mb-0 text-muted small">Dukungan tenaga ahli multidisiplin lainnya sesuai kebutuhan.</p></div>
                            </div>
                        </div>

                        <!-- SET KEDUA (Duplikat persis agar perputaran animasi infinite berjalan mulus tanpa jeda putus) -->
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-drafting-compass fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Ahli Arsitektur</h5><p class="mb-0 text-muted small">Merancang konsep tata letak bangunan estetis dan fungsional.</p></div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-building fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Ahli Teknik Bangunan Gedung</h5><p class="mb-0 text-muted small">Mengawasi struktur ketahanan fisik bangunan bertingkat.</p></div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-hard-hat fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Ahli Konstruksi K3</h5><p class="mb-0 text-muted small">Memastikan penerapan keselamatan dan kesehatan kerja aman.</p></div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-cogs fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Ahli Mekanikal Elektrikal</h5><p class="mb-0 text-muted small">Menangani sistem kelistrikan, tata udara, dan pemipaan.</p></div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-bolt fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Ahli Electrikal</h5><p class="mb-0 text-muted small">Spesialis instalasi jaringan daya listrik arus kuat dan lemah.</p></div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-road fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Ahli Teknik Jalan Dan Jembatan</h5><p class="mb-0 text-muted small">Perencanaan infrastruktur transportasi darat secara presisi.</p></div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-leaf fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Ahli Teknik Lingkungan</h5><p class="mb-0 text-muted small">Analisis dampak lingkungan dan pengelolaan limbah pembangunan.</p></div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-tasks fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Ahli Manajemen Proyek</h5><p class="mb-0 text-muted small">Pengelolaan alur kerja dan efisiensi biaya operasional proyek.</p></div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-project-diagram fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Ahli Manajemen Konstruksi</h5><p class="mb-0 text-muted small">Koordinasi teknis pelaksanaan pembangunan hingga serah terima.</p></div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-city fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Ahli Planologi</h5><p class="mb-0 text-muted small">Perencanaan wilayah kota dan penataan tata ruang terintegrasi.</p></div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 mb-2 expert-card bg-light">
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-3"><i class="fas fa-users fa-2x"></i></div>
                                <div><h5 class="mb-1 fw-bold">Dan Lain-Lain</h5><p class="mb-0 text-muted small">Dukungan tenaga ahli multidisiplin lainnya sesuai kebutuhan.</p></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Memanggil Footer Global -->
<?php include '../koneksi/footer.php'; ?>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>