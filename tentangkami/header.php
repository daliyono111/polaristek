<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - CV. POLA ARSITEK KONSULTAN</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1920&q=80');
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

<!-- Navbar dengan Multi-Level Dropdown Portofolio -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">CV. POLA ARSITEK KONSULTAN</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <!-- BERANDA -->
                <li class="nav-item"><a class="nav-link" href="../index.php">BERANDA</a></li>

                <!-- TENTANG KAMI (Dropdown) -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="tentangDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        TENTANG KAMI
                    </a>
                    <ul class="dropdown-menu shadow" aria-labelledby="tentangDropdown">
                        <li><a class="dropdown-item" href="profil_perusahaan.php">Profil Perusahaan</a></li>
                        <li><a class="dropdown-item" href="#">Visi Misi</a></li>
                        <li><a class="dropdown-item" href="#">Struktur Organisasi</a></li>
                        <li><a class="dropdown-item" href="legalitas.php">Legalitas Perusahaan</a></li>
                        <li><a class="dropdown-item" href="#">Tim Ahli Kami</a></li>
                    </ul>
                </li>

                <!-- PORTOFOLIO (Multi-Level Dropdown) -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="portofolioDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        PORTOFOLIO
                    </a>
                    <ul class="dropdown-menu shadow" aria-labelledby="portofolioDropdown">
                        
                        <!-- 1. Bidang Perencanaan -->
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">Bidang Perencanaan</a>
                            <ul class="dropdown-menu shadow">
                                <li><a class="dropdown-item" href="#">Gedung</a></li>
                                <li><a class="dropdown-item" href="#">Jalan dan Jembatan</a></li>
                                <li><a class="dropdown-item" href="#">Tata Lingkungan</a></li>
                            </ul>
                        </li>

                        <!-- 2. Bidang Pengawasan -->
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">Bidang Pengawasan</a>
                            <ul class="dropdown-menu shadow">
                                <li><a class="dropdown-item" href="#">Gedung</a></li>
                                <li><a class="dropdown-item" href="#">Jalan dan Jembatan</a></li>
                                <li><a class="dropdown-item" href="#">Tata Lingkungan</a></li>
                            </ul>
                        </li>

                        <!-- 3. Bidang Manajemen Konstruksi -->
                        <li><a class="dropdown-item" href="#">Bidang Manajemen Konstruksi</a></li>

                    </ul>
                </li>

                <!-- KONTAK KAMI -->
                <li class="nav-item"><a class="nav-link" href="#">KONTAK KAMI</a></li>
            </ul>
        </div>
    </div>
</nav>