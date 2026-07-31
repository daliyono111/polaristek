<?php 
// 0. Mulai Session untuk mendeteksi status login admin
session_start();

// 1. Memanggil koneksi database dari folder tentangkami (naik satu tingkat)
include '../koneksi/koneksi.php';

// 2. Mengambil data struktur organisasi dari database
$query = "SELECT * FROM struktur_organisasi ORDER BY id ASC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi - PT. POLARISTEK ADHI PERSADA</title>
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
        .org-card {
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-top: 4px solid #ffc107;
        }
        .org-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .org-avatar {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #ffc107;
            margin-bottom: 15px;
        }

        /* --- Kustomisasi Tombol Aksi Admin yang Lebih Soft/Selaras --- */
        .btn-soft-edit {
            color: #495057;
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            transition: all 0.2s ease-in-out;
        }
        .btn-soft-edit:hover {
            color: #000;
            background-color: #e2e6ea;
            border-color: #dae0e5;
        }

        .btn-soft-delete {
            color: #6c757d;
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            transition: all 0.2s ease-in-out;
        }
        .btn-soft-delete:hover {
            color: #dc3545;
            background-color: #fdf2f2;
            border-color: #f5c6cb;
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

        .dropdown-submenu {
            position: relative;
        }
        
        .dropdown-submenu > .dropdown-menu {
            top: 0;
            left: auto;
            right: 100%;
            margin-top: -6px;
            margin-right: 0px; 
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
        <h1 class="fw-bold display-5">STRUKTUR ORGANISASI</h1>
        <p class="lead text-light">Susunan kepengurusan dan manajemen profesional PT. POLARISTEK ADHI PERSADA.</p>
    </div>
</header>

<!-- Content Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <span class="badge bg-warning text-dark mb-2 fw-bold">TIM MANAJEMEN</span>
                <h2 class="fw-bold">Pimpinan & Jajaran Pengurus</h2>
                <p class="text-muted">
                    Didukung oleh tenaga ahli yang berpengalaman dan berkompeten tinggi di bidang perencanaan serta pengawasan konstruksi.
                </p>
                <hr class="w-25 mx-auto border-warning border-2">
            </div>
        </div>

        <!-- Tombol Tambah Data Khusus Admin -->
        <?php if (isset($_SESSION['status_login']) && $_SESSION['status_login'] == true): ?>
            <div class="row mb-4">
                <div class="col-12 text-start">
                    <button class="btn btn-warning fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="fas fa-plus-circle me-2"></i> Tambah Anggota Struktur
                    </button>
                </div>
            </div>
        <?php endif; ?>

        <div class="row g-4 justify-content-center">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card org-card h-100 shadow-sm p-3 bg-white text-center d-flex flex-column justify-content-between">
                            <div class="card-body">
                                <img src="../img/<?= !empty($row['foto']) ? htmlspecialchars($row['foto']) : 'default.jpg'; ?>" alt="Foto Pengurus" class="org-avatar shadow-sm" onerror="this.src='https://via.placeholder.com/100';">
                                <h5 class="card-title fw-bold text-dark mb-1"><?= htmlspecialchars($row['nama']); ?></h5>
                                <span class="badge bg-secondary mb-3"><?= htmlspecialchars($row['jabatan']); ?></span>
                                <p class="card-text text-muted small"><?= htmlspecialchars($row['deskripsi']); ?></p>
                            </div>

                            <!-- Tombol Edit & Hapus khusus Admin dengan gaya soft/selaras -->
                            <?php if (isset($_SESSION['status_login']) && $_SESSION['status_login'] == true): ?>
                                <div class="card-footer bg-white border-0 pt-0">
                                    <hr class="text-muted opacity-25 mb-2">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-soft-edit px-3" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id']; ?>">
                                            <i class="fas fa-edit me-1 text-secondary"></i> Edit
                                        </button>
                                        <a href="proses_struktur.php?aksi=hapus&id=<?= $row['id']; ?>" class="btn btn-sm btn-soft-delete px-3" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash me-1"></i> Hapus
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Modal Edit untuk setiap data -->
                    <?php if (isset($_SESSION['status_login']) && $_SESSION['status_login'] == true): ?>
                    <div class="modal fade" id="modalEdit<?= $row['id']; ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="proses_struktur.php?aksi=edit" method="POST" enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Edit Anggota Struktur</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                        <input type="hidden" name="foto_lama" value="<?= $row['foto']; ?>">
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nama Lengkap</label>
                                            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($row['nama']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Jabatan</label>
                                            <input type="text" name="jabatan" class="form-control" value="<?= htmlspecialchars($row['jabatan']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Ganti Foto (Opsional)</label>
                                            <input type="file" name="foto" class="form-control" accept="image/*">
                                            <small class="text-muted">Format: JPG, PNG, JPEG. Biarkan kosong jika tidak ingin mengubah foto.</small>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Deskripsi</label>
                                            <textarea name="deskripsi" class="form-control" rows="3"><?= htmlspecialchars($row['deskripsi']); ?></textarea>
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
                    <?php endif; ?>

                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada data struktur organisasi yang tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Modal Tambah Data (Khusus Admin) -->
<?php if (isset($_SESSION['status_login']) && $_SESSION['status_login'] == true): ?>
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="proses_struktur.php?aksi=tambah" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Anggota Struktur Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-start">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" placeholder="Contoh: Direktur Utama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Upload Foto</label>
                        <input type="file" name="foto" class="form-control" accept="image/*" required>
                        <small class="text-muted">Pilih file gambar (JPG, PNG, JPEG)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Keterangan singkat (opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning fw-bold">Tambah Data</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<!-- Memanggil Footer Global -->
<?php include '../koneksi/footer.php'; ?>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>