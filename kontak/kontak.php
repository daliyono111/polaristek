<?php 
// 0. Mulai Session untuk mendeteksi status login admin
session_start();

// 1. Memanggil koneksi database
include '../koneksi/koneksi.php';

// 2. Mengambil data pesan/kontak dari database
$query_pesan = "SELECT * FROM kontak_kami ORDER BY id DESC";
$result = mysqli_query($conn, $query_pesan);

// 3. Mengambil data lokasi kantor dan Google Maps dari database
$query_lokasi = mysqli_query($conn, "SELECT * FROM lokasi_kantor");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Kami - PT. POLARISTEK ADHI PERSADA</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 80px 0;
        }
        .map-container iframe {
            width: 100%;
            height: 250px;
            border: 0;
            border-radius: 8px;
        }
        .map-wrapper {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        /* Tombol Aksi Soft */
        .btn-soft-edit {
            color: #495057; background-color: #f8f9fa; border: 1px solid #ced4da;
        }
        .btn-soft-edit:hover { color: #000; background-color: #e2e6ea; }
        .btn-soft-delete {
            color: #6c757d; background-color: #f8f9fa; border: 1px solid #ced4da;
        }
        .btn-soft-delete:hover { color: #dc3545; background-color: #fdf2f2; border-color: #f5c6cb; }
    </style>
</head>
<body>

<!-- Memanggil Navbar Global -->
<?php include '../koneksi/navbar.php'; ?>

<!-- Hero Section -->
<header class="hero-section text-center">
    <div class="container">
        <h1 class="fw-bold display-5">KONTAK KAMI</h1>
        <p class="lead text-light">Hubungi kami atau kunjungi kantor kami untuk informasi kerja sama lebih lanjut.</p>
    </div>
</header>

<!-- Tombol Akses Kelola Lokasi & Maps Khusus Admin -->
<?php if (isset($_SESSION['status_login']) && $_SESSION['status_login'] == true): ?>
<div class="bg-warning py-2 shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        <span class="fw-bold text-dark"><i class="fas fa-user-shield me-2"></i> Mode Admin Aktif</span>
        <a href="admin_kontak.php" class="btn btn-dark btn-sm fw-bold">
            <i class="fas fa-map-marker-alt me-1"></i> Kelola / Tambah Lokasi Kantor & Maps
        </a>
    </div>
</div>
<?php endif; ?>

<!-- Content Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-5">
            <!-- Informasi Kontak & Google Maps Dinamis dari Database -->
            <div class="col-lg-6">
                <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                    <h3 class="fw-bold mb-4 text-dark"><i class="fas fa-info-circle text-warning me-2"></i> Informasi & Lokasi Kantor</h3>
                    
                    <?php if (mysqli_num_rows($query_lokasi) > 0): ?>
                        <?php while ($lok = mysqli_fetch_assoc($query_lokasi)): ?>
                            <div class="mb-4 pb-3 border-bottom">
                                <h4 class="fw-bold text-dark h5 mb-3"><i class="fas fa-building text-warning me-2"></i> <?= htmlspecialchars($lok['nama_kantor']); ?></h4>
                                <p class="text-muted mb-2"><i class="fas fa-map-marker-alt text-warning me-3"></i> <?= nl2br(htmlspecialchars($lok['alamat'])); ?></p>
                                <p class="text-muted mb-2"><i class="fas fa-phone text-warning me-3"></i> <?= htmlspecialchars($lok['telepon']); ?></p>
                                <p class="text-muted mb-3"><i class="fas fa-envelope text-warning me-3"></i> <?= htmlspecialchars($lok['email']); ?></p>

                                <h6 class="fw-bold mb-2">Lokasi di Peta</h6>
                                <div class="map-wrapper mb-2">
                                    <?= $lok['embed_map']; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-muted">Belum ada data lokasi kantor yang ditambahkan. Silakan login sebagai admin untuk menambahkannya.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Form Kirim Pesan untuk Pengunjung -->
            <div class="col-lg-6">
                <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                    <h3 class="fw-bold mb-4 text-dark"><i class="fas fa-paper-plane text-warning me-2"></i> Kirim Pesan</h3>
                    <form action="proses_kontak.php?aksi=tambah" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama Anda" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Subjek</label>
                            <input type="text" name="subjek" class="form-control" placeholder="Perihal pesan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pesan</label>
                            <textarea name="pesan" class="form-control" rows="4" placeholder="Tuliskan pesan Anda di sini..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning fw-bold w-100 py-2">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bagian Khusus Admin: Dashboard Kelola, Edit, & Balas Pesan Masuk -->
        <?php if (isset($_SESSION['status_login']) && $_SESSION['status_login'] == true): ?>
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm p-4 rounded-4">
                    <h3 class="fw-bold mb-3 text-dark"><i class="fas fa-inbox text-warning me-2"></i> Dashboard Admin: Kelola & Balas Pesan Masuk</h3>
                    <p class="text-muted small">Daftar pesan dari pengunjung beserta status dan riwayat balasannya.</p>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Pengirim</th>
                                    <th>Subjek & Pesan</th>
                                    <th>Status</th>
                                    <th>Balasan Admin</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                                    <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td>
                                            <strong class="text-dark"><?= htmlspecialchars($row['nama']); ?></strong><br>
                                            <small class="text-muted"><?= htmlspecialchars($row['email']); ?></small>
                                        </td>
                                        <td>
                                            <span class="fw-semibold text-primary"><?= htmlspecialchars($row['subjek']); ?></span><br>
                                            <span class="small text-muted"><?= nl2br(htmlspecialchars($row['pesan'])); ?></span>
                                        </td>
                                        <td>
                                            <?php if (isset($row['status_pesan']) && $row['status_pesan'] == 'Sudah Dibalas'): ?>
                                                <span class="badge bg-success">Sudah Dibalas</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">Belum Dibalas</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($row['balasan'])): ?>
                                                <span class="small text-dark"><?= nl2br(htmlspecialchars($row['balasan'])); ?></span>
                                            <?php else: ?>
                                                <span class="small text-muted fst-italic">Belum ada balasan</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <!-- Tombol Edit Modal -->
                                            <button class="btn btn-sm btn-soft-edit px-2 mb-1" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id']; ?>">
                                                <i class="fas fa-edit text-secondary"></i> Edit
                                            </button>
                                            <!-- Tombol Balas Modal -->
                                            <button class="btn btn-sm btn-success px-2 mb-1" data-bs-toggle="modal" data-bs-target="#modalBalas<?= $row['id']; ?>">
                                                <i class="fas fa-reply"></i> Balas
                                            </button>
                                            <!-- Tombol Hapus -->
                                            <a href="proses_kontak.php?aksi=hapus&id=<?= $row['id']; ?>" class="btn btn-sm btn-soft-delete px-2 mb-1" onclick="return confirm('Yakin ingin menghapus pesan ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit Pesan -->
                                    <div class="modal fade" id="modalEdit<?= $row['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <form action="proses_kontak.php?aksi=edit" method="POST">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold">Edit Pesan Kontak</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Nama</label>
                                                            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($row['nama']); ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Email</label>
                                                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($row['email']); ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Subjek</label>
                                                            <input type="text" name="subjek" class="form-control" value="<?= htmlspecialchars($row['subjek']); ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Pesan</label>
                                                            <textarea name="pesan" class="form-control" rows="3" required><?= htmlspecialchars($row['pesan']); ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-warning fw-bold">Simpan Perubahan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Modal Balas Pesan -->
                                    <div class="modal fade" id="modalBalas<?= $row['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <form action="proses_kontak.php?aksi=balas" method="POST">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-success text-white">
                                                        <h5 class="modal-title fw-bold"><i class="fas fa-reply me-2"></i> Balas Pesan untuk <?= htmlspecialchars($row['nama']); ?></h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                        <input type="hidden" name="email_tujuan" value="<?= htmlspecialchars($row['email']); ?>">
                                                        <input type="hidden" name="nama_tujuan" value="<?= htmlspecialchars($row['nama']); ?>">
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label text-muted small">Pesan dari Pengunjung:</label>
                                                            <div class="p-2 bg-light rounded border small"><?= nl2br(htmlspecialchars($row['pesan'])); ?></div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Tulis Balasan / Solusi</label>
                                                            <textarea name="balasan" class="form-control" rows="4" placeholder="Tulis balasan pesan di sini..." required><?= htmlspecialchars($row['balasan'] ?? ''); ?></textarea>
                                                        </div>

                                                        <div class="alert alert-info small mb-0">
                                                            <i class="fas fa-info-circle me-1"></i> Menyimpan balasan akan memperbarui status pesan menjadi <b>"Sudah Dibalas"</b> dan mengirimkan email otomatis ke pengunjung.
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-success fw-bold">Kirim / Simpan Balasan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">Belum ada pesan masuk.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Memanggil Footer Global -->
<?php include '../koneksi/footer.php'; ?>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>