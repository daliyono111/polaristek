<?php
// Mulai session dan panggil koneksi database
session_start();
include '../koneksi/koneksi.php';

// Ambil data testimoni dari database
$query_testi = mysqli_query($conn, "SELECT * FROM testimoni ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimoni - PT. POLARISTEK ADHI PERSADA</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 80px 0;
        }
    </style>
</head>
<body class="bg-light">

<!-- Memanggil Navbar Global -->
<?php include '../koneksi/navbar.php'; ?>

<!-- Hero Section -->
<header class="hero-section text-center">
    <div class="container">
        <h1 class="fw-bold display-5">TESTIMONI KLIEN</h1>
        <p class="lead text-light">Ulasan dan kepercayaan dari mitra kerja serta klien yang telah bekerja sama dengan kami.</p>
    </div>
</header>

<!-- Content Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark"><i class="fas fa-quote-left text-warning me-2"></i> Apa Kata Mereka</h2>
            <p class="text-muted">Berikut adalah daftar testimoni teks maupun video dari proyek-proyek yang telah kami selesaikan.</p>
            
            <!-- Tombol Kelola khusus Admin -->
            <?php if (isset($_SESSION['status_login']) && $_SESSION['status_login'] == true): ?>
                <a href="../admin/admin_testimoni.php" class="btn btn-dark btn-sm fw-bold mt-2">
                    <i class="fas fa-cog me-1"></i> Kelola Testimoni
                </a>
            <?php endif; ?>
        </div>

        <div class="row g-4">
            <?php if ($query_testi && mysqli_num_rows($query_testi) > 0): ?>
                <?php while ($t = mysqli_fetch_assoc($query_testi)): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow-sm p-4 rounded-4 bg-white">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <!-- Jika jenis video dan ada embed -->
                                    <?php if ($t['jenis'] == 'video' && !empty($t['embed_video'])): ?>
                                        <div class="ratio ratio-16x9 mb-3 rounded overflow-hidden shadow-sm">
                                            <?= $t['embed_video']; ?>
                                        </div>
                                    <?php endif; ?>

                                    <p class="text-muted fst-italic mb-4">"<?= nl2br(htmlspecialchars($t['isi_testimoni'])); ?>"</p>
                                </div>
                                
                                <div class="d-flex align-items-center border-top pt-3">
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark"><?= htmlspecialchars($t['nama']); ?></h6>
                                        <small class="text-muted"><?= htmlspecialchars($t['jabatan']); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center text-muted py-5">
                    <p>Belum ada data testimoni yang tersedia saat ini.</p>
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