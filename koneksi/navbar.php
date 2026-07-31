<?php
// Mencegah error Notice jika session sudah aktif sebelumnya
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Tentukan base URL atau path relatif otomatis yang aman dari folder manapun
$root_path = '';
$current_dir = isset($_SERVER['PHP_SELF']) ? basename(dirname($_SERVER['PHP_SELF'])) : '';

// Jika file dipanggil dari dalam subfolder (seperti tentangkami, portofolio, login, atau kontak)
if ($current_dir == 'tentangkami' || $current_dir == 'portofolio' || $current_dir == 'login' || $current_dir == 'kontak') {
    $root_path = '../';
}

$current_page = isset($_SERVER['PHP_SELF']) ? basename($_SERVER['PHP_SELF']) : '';
?>

<style>
/* --- Pengaturan Menu Navigasi, Garis Bawah, & Efek Panah Kecil --- */
.navbar-nav .nav-item {
    position: relative;
}

.navbar-nav .nav-link {
    color: #fff !important;
    transition: color 0.3s ease;
    padding-bottom: 12px !important;
}

/* Garis Bawah */
.navbar-nav .nav-link::after {
    content: '';
    position: absolute;
    width: 0 !important;
    height: 3px;
    bottom: 0;
    left: 0 !important;
    background-color: #ffc107 !important;
    transition: width 0.3s ease-in-out;
    transform: none !important;
}

/* Efek Segitiga / Panah Kecil di Atas Garis */
.navbar-nav .nav-link::before {
    content: '';
    position: absolute;
    bottom: 3px; 
    left: 50%;
    transform: translateX(-50%) scale(0);
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-bottom: 6px solid #ffc107; 
    transition: transform 0.3s ease-in-out;
    z-index: 5;
}

/* Memunculkan garis dan teks kuning saat di-hover atau aktif pada menu biasa */
.navbar-nav .nav-link:hover::after,
.navbar-nav .nav-link.active::after {
    width: 100% !important;
}

.navbar-nav .nav-link:hover::before,
.navbar-nav .nav-link.active::before {
    transform: translateX(-50%) scale(1);
}

.navbar-nav .nav-link:hover,
.navbar-nav .nav-link.active {
    color: #ffc107 !important;
}

/* Khusus untuk menu dropdown Portofolio/Tentang Kami saat di-hover atau ketika sub-menu-nya aktif */
.navbar-nav .dropdown.show > .nav-link::after,
.navbar-nav .dropdown:hover > .nav-link::after,
.navbar-nav .dropdown-toggle.active::after {
    width: 100% !important;
}

.navbar-nav .dropdown.show > .nav-link::before,
.navbar-nav .dropdown:hover > .nav-link::before,
.navbar-nav .dropdown-toggle.active::before {
    transform: translateX(-50%) scale(1);
}

.navbar-nav .dropdown.show > .nav-link,
.navbar-nav .dropdown:hover > .nav-link,
.navbar-nav .dropdown-toggle.active {
    color: #ffc107 !important;
}

/* --- KUSTOMISASI WARNA HOVER & AKTIF PADA SUB-MENU DROPDOWN --- */
.dropdown-menu {
    border: none;
    padding: 8px 0;
}

.dropdown-menu .dropdown-item {
    color: #333;
    padding: 8px 16px;
    transition: background-color 0.2s ease, color 0.2s ease;
}

.dropdown-menu .dropdown-item:hover,
.dropdown-menu .dropdown-item:focus {
    background-color: #ffc107 !important; 
    color: #000 !important;             
    font-weight: 500;
}

.dropdown-menu .dropdown-item.active, 
.dropdown-menu .dropdown-item:active {
    background-color: #343a40 !important; 
    color: #ffc107 !important;           
    font-weight: bold;
}

/* --- FITUR PENCARIAN INTERAKTIF (EXPANDABLE) --- */
.search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-wrapper .search-input {
    width: 38px;
    height: 38px;
    padding-left: 35px;
    transition: width 0.4s ease-in-out, background-color 0.3s ease;
    cursor: pointer;
    background-color: transparent;
    color: #fff;
    border-color: #6c757d;
    border-radius: 20px;
}

.search-wrapper .search-input:focus {
    width: 170px;
    background-color: #212529;
    color: #fff;
    cursor: text;
    border-color: #ffc107;
    box-shadow: none;
}

.search-wrapper .search-icon {
    position: absolute;
    left: 12px;
    color: #adb5bd;
    pointer-events: none;
    transition: color 0.3s ease;
}

.search-wrapper .search-input:focus ~ .search-icon {
    color: #ffc107;
}

/* --- FITUR DROPDOWN MUNCUL OTOMATIS SAAT HOVER --- */
@media all and (min-width: 992px) {
    .navbar-nav .dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0;
    }
}
</style>

<!-- Navbar Global -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <!-- Logo & Brand -->
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="<?= $root_path; ?>index.php">
            <img src="<?= $root_path; ?>img/Logopola.JPG" alt="Logo PT. POLARISTEK ADHI PERSADA" style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px;">
            <span>PT. POLARISTEK ADHI PERSADA</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-lg-center">
                
                <!-- BERANDA -->
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'index.php') ? 'active' : ''; ?>" href="<?= $root_path; ?>index.php">BERANDA</a>
                </li>

                <!-- TENTANG KAMI (Dropdown Hover) -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= ($current_dir == 'tentangkami') ? 'active' : ''; ?>" href="#" id="tentangDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        TENTANG KAMI
                    </a>
                    <ul class="dropdown-menu shadow" aria-labelledby="tentangDropdown">
                        <li><a class="dropdown-item <?= ($current_page == 'profile_perusahaan.php') ? 'active' : ''; ?>" href="<?= $root_path; ?>tentangkami/profile_perusahaan.php">Profil Perusahaan</a></li>
                        <li><a class="dropdown-item" href="<?= $root_path; ?>tentangkami/profile_perusahaan.php#visimisi">Visi Misi</a></li>
                        <li><a class="dropdown-item <?= ($current_page == 'struktur_organisasi.php') ? 'active' : ''; ?>" href="<?= $root_path; ?>tentangkami/struktur_organisasi.php">Struktur Organisasi</a></li>
                        <li><a class="dropdown-item <?= ($current_page == 'legalitas.php') ? 'active' : ''; ?>" href="<?= $root_path; ?>tentangkami/legalitas.php">Legalitas Perusahaan</a></li>
                        <li><a class="dropdown-item <?= ($current_page == 'tim_ahli.php') ? 'active' : ''; ?>" href="<?= $root_path; ?>tentangkami/tim_ahli.php">Tim Ahli Kami</a></li>
                    </ul>
                </li>

                <!-- PORTOFOLIO (Dropdown Hover) -->
                <li class="nav-item dropdown">
                    <?php 
                        $is_portofolio_active = ($current_dir == 'portofolio' && $current_page != 'testimoni.php');
                    ?>
                    <a class="nav-link dropdown-toggle <?= $is_portofolio_active ? 'active' : ''; ?>" href="#" id="portofolioDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        PORTOFOLIO
                    </a>
                    <ul class="dropdown-menu shadow" aria-labelledby="portofolioDropdown">
                        <li><a class="dropdown-item <?= ($current_page == 'bidang_perencanaan.php') ? 'active' : ''; ?>" href="<?= $root_path; ?>portofolio/bidang_perencanaan.php">Bidang Perencanaan</a></li>
                        <li><a class="dropdown-item <?= ($current_page == 'bidang_pengawasan.php') ? 'active' : ''; ?>" href="<?= $root_path; ?>portofolio/bidang_pengawasan.php">Bidang Pengawasan</a></li>
                        <li><a class="dropdown-item <?= ($current_page == 'bidang_manajemen.php') ? 'active' : ''; ?>" href="<?= $root_path; ?>portofolio/bidang_manajemen.php">Bidang Manajemen Konstruksi</a></li>
                        <li><a class="dropdown-item <?= ($current_page == 'testimoni.php') ? 'active' : ''; ?>" href="<?= $root_path; ?>portofolio/testimoni.php">Testimoni</a></li>
                    </ul>
                </li>

                <!-- KONTAK KAMI -->
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'kontak.php') ? 'active' : ''; ?>" href="<?= $root_path; ?>kontak/kontak.php">KONTAK KAMI</a>
                </li>

                <!-- TOMBOL LOGIN / STATUS ADMIN -->
                <?php if (isset($_SESSION['status_login']) && $_SESSION['status_login'] == true): ?>
                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle text-warning fw-bold" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-shield me-1"></i> <?= htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Admin'); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item text-danger fw-semibold" href="<?= $root_path; ?>login/logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-outline-warning btn-sm px-3 mt-1 mt-lg-0" href="<?= $root_path; ?>login/login.php"><i class="fas fa-sign-in-alt me-1"></i> Login</a>
                    </li>
                <?php endif; ?>

                <!-- FORM PENCARIAN (SEARCH) -->
                <li class="nav-item ms-lg-2 my-2 my-lg-0">
                    <form action="<?= $root_path; ?>pencarian.php" method="GET" class="search-wrapper">
                        <input class="form-control form-control-sm search-input" type="search" name="q" placeholder="" aria-label="Search" required title="Ketik untuk mencari...">
                        <i class="fas fa-search search-icon"></i>
                    </form>
                </li>

            </ul>
        </div>
    </div>
</nav>