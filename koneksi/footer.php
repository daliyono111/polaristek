<?php
// Tentukan base URL otomatis jika belum didefinisikan sebelumnya
if (!isset($root_path)) {
    $root_path = '';
    $current_dir = basename(dirname($_SERVER['PHP_SELF']));
    if ($current_dir == 'tentangkami' || $current_dir == 'portofolio' || $current_dir == 'login' || $current_dir == 'kontak') {
        $root_path = '../';
    }
}
?>

<!-- Footer Global -->
<footer class="bg-dark text-white pt-5 pb-4 border-top border-secondary">
    <div class="container">
        <div class="row g-4 mb-4">
            <!-- Kolom 1: Tentang Perusahaan -->
            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold mb-3 text-warning">PT. POLARISTEK ADHI PERSADA</h5>
                <p class="small text-light">
                    Perusahaan yang bergerak di bidang jasa konsultansi perencanaan, pengawasan, dan manajemen konstruksi terpercaya yang berkomitmen memberikan hasil terbaik[cite: 2].
                </p>
            </div>

            <!-- Kolom 2: Tautan Navigasi Cepat -->
            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold mb-3 text-warning">Menu Navigasi</h5>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="<?= $root_path; ?>index.php" class="text-decoration-none text-light hover-warning"><i class="fas fa-angle-right me-2 text-warning"></i> Beranda</a></li>
                    <li class="mb-2"><a href="<?= $root_path; ?>tentangkami/profile_perusahaan.php" class="text-decoration-none text-light hover-warning"><i class="fas fa-angle-right me-2 text-warning"></i> Profil Perusahaan</a></li>
                    <li class="mb-2"><a href="<?= $root_path; ?>tentangkami/struktur_organisasi.php" class="text-decoration-none text-light hover-warning"><i class="fas fa-angle-right me-2 text-warning"></i> Struktur Organisasi</a></li>
                    <li class="mb-2"><a href="<?= $root_path; ?>portofolio/bidang_perencanaan.php" class="text-decoration-none text-light hover-warning"><i class="fas fa-angle-right me-2 text-warning"></i> Portofolio</a></li>
                    <li class="mb-2"><a href="<?= $root_path; ?>kontak/kontak.php" class="text-decoration-none text-light hover-warning"><i class="fas fa-angle-right me-2 text-warning"></i> Kontak Kami</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Kontak & Informasi Singkat -->
            <div class="col-lg-4 col-md-12">
                <h5 class="fw-bold mb-3 text-warning">Hubungi Kami</h5>
                <p class="small text-light mb-2"><i class="fas fa-map-marker-alt text-warning me-2"></i> Jl. Sanggiringan III No.28 Komp. CRE Banjarbaru</p>
                <p class="small text-light mb-2"><i class="fas fa-envelope text-warning me-2"></i> polaristek02@gmail.com</p>
                <p class="small text-light mb-0"><i class="fas fa-phone text-warning me-2"></i> 0812000000</p>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <!-- Copyright & Desain by Joko Daliyono -->
        <div class="row">
            <div class="col-12 text-center small text-white">
                <p class="mb-1">PT.Polaristek Adhi Persada &copy; <?= date('Y'); ?>. All Rights Reserved.[cite: 2]</p>
                <p class="mb-0">Design by Joko Daliyono[cite: 2]</p>
            </div>
        </div>
    </div>
</footer>

<!-- Tombol Back to Top Modern Berwarna Kuning -->
<button id="backToTopBtn" title="Kembali ke atas">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- Styling & Skrip Pendukung -->
<style>
    .hover-warning:hover {
        color: #ffc107 !important;
        transition: 0.2s ease-in-out;
    }

    /* Styling Tombol Back to Top (Model Lingkaran & Warna Kuning Tema) */
    #backToTopBtn {
        display: none; /* Otomatis tersembunyi di posisi paling atas */
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 999;
        background-color: #ffc107; /* Warna kuning emas utama website */
        color: #212529; /* Warna ikon gelap agar kontras dan elegan */
        border: none;
        outline: none;
        width: 48px;
        height: 48px;
        border-radius: 50%; /* Membuat tombol berbentuk bulat sempurna */
        cursor: pointer;
        display: none; /* Diatur oleh JS nantinya */
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4); /* Efek bayangan berpendar kuning */
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    #backToTopBtn i {
        font-size: 18px;
        transition: transform 0.3s ease;
    }

    /* Efek Interaktif saat kursor menyentuh tombol */
    #backToTopBtn:hover {
        background-color: #e0a800;
        color: #000;
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(255, 193, 7, 0.6);
    }

    #backToTopBtn:hover i {
        transform: translateY(-2px); /* Efek panah sedikit bergerak ke atas */
    }
</style>

<script>
// Logika untuk memunculkan dan menyembunyikan tombol saat digulir (scroll)
let backToTopButton = document.getElementById("backToTopBtn");

window.onscroll = function() {
    if (document.body.scrollTop > 250 || document.documentElement.scrollTop > 250) {
        backToTopButton.style.display = "flex"; // Menggunakan flex agar ikon di tengah
    } else {
        backToTopButton.style.display = "none";
    }
};

// Fungsi animasi gulir halus (smooth scroll) ke bagian paling atas
backToTopButton.addEventListener("click", function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});
</script>