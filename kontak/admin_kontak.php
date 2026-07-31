<?php
// Mulai session dan koneksi database
session_start();
include '../koneksi/koneksi.php';

// Validasi akses khusus admin
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: kontak.php");
    exit;
}

// Proses Tambah / Edit Lokasi Kantor
if (isset($_POST['simpan_lokasi'])) {
    $id = $_POST['id'] ?? '';
    $nama_kantor = mysqli_real_escape_string($conn, $_POST['nama_kantor']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $embed_map = mysqli_real_escape_string($conn, $_POST['embed_map']); // Berisi tag <iframe ...> dari Google Maps

    if ($id == "") {
        // Insert data baru
        $query = "INSERT INTO lokasi_kantor (nama_kantor, alamat, telepon, email, embed_map) VALUES ('$nama_kantor', '$alamat', '$telepon', '$email', '$embed_map')";
    } else {
        // Update data
        $query = "UPDATE lokasi_kantor SET nama_kantor='$nama_kantor', alamat='$alamat', telepon='$telepon', email='$email', embed_map='$embed_map' WHERE id='$id'";
    }

    if (mysqli_query($conn, $query)) {
        header("Location: admin_kontak.php?pesan=sukses");
        exit;
    } else {
        $error = "Gagal menyimpan data: " . mysqli_error($conn);
    }
}

// Proses Hapus Lokasi
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM lokasi_kantor WHERE id='$id'");
    header("Location: admin_kontak.php?pesan=dihapus");
    exit;
}

// Ambil data untuk diedit jika ada parameter ?id=...
$edit_data = null;
if (isset($_GET['aksi']) && $_GET['aksi'] == 'edit') {
    $id_edit = $_GET['id'];
    $result_edit = mysqli_query($conn, "SELECT * FROM lokasi_kantor WHERE id='$id_edit'");
    $edit_data = mysqli_fetch_assoc($result_edit);
}

// Ambil semua daftar lokasi kantor
$result_lokasi = mysqli_query($conn, "SELECT * FROM lokasi_kantor ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Lokasi Kantor & Maps - Admin</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<!-- Navbar Sederhana Admin -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#"><i class="fas fa-user-shield me-2"></i> Panel Admin - Polaristek</a>
        <a href="kontak.php" class="btn btn-outline-light btn-sm"><i class="fas fa-arrow-left me-1"></i> Kembali ke Halaman Kontak</a>
    </div>
</nav>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-dark"><i class="fas fa-map-marked-alt text-warning me-2"></i> Kelola Lokasi Kantor & Google Maps</h2>
            <p class="text-muted">Tambah, ubah, atau hapus titik lokasi kantor dan embed peta Google Maps yang tampil di halaman kontak.</p>
        </div>
    </div>

    <?php if (isset($_GET['pesan'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> Data lokasi kantor berhasil diperbarui!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-1"></i> <?= $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Form Tambah / Edit -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-3 text-dark h5">
                    <?= $edit_data ? '<i class="fas fa-edit me-1 text-primary"></i> Edit Lokasi' : '<i class="fas fa-plus-circle me-1 text-warning"></i> Tambah Lokasi Baru'; ?>
                </h4>
                <form action="" method="POST">
                    <input type="hidden" name="id" value="<?= $edit_data['id'] ?? ''; ?>">
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Kantor / Cabang</label>
                        <input type="text" name="nama_kantor" class="form-control" placeholder="Contoh: Kantor Pusat Jakarta" value="<?= htmlspecialchars($edit_data['nama_kantor'] ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Jl. Contoh No. 123, Kota..." required><?= htmlspecialchars($edit_data['alamat'] ?? ''); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">No. Telepon</label>
                        <input type="text" name="telepon" class="form-control" placeholder="021-xxxxxxxx" value="<?= htmlspecialchars($edit_data['telepon'] ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="info@domain.com" value="<?= htmlspecialchars($edit_data['email'] ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Embed Google Maps (&lt;iframe&gt;)</label>
                        <textarea name="embed_map" class="form-control" rows="4" placeholder="Tempel kode iframe dari Google Maps di sini..." required><?= htmlspecialchars($edit_data['embed_map'] ?? ''); ?></textarea>
                        <small class="text-muted d-mt-1" style="font-size: 0.8rem;">Tips: Buka Google Maps -> Bagikan -> Sematkan Peta -> Salin HTML.</small>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" name="simpan_lokasi" class="btn btn-warning fw-bold text-dark py-2">
                            <?= $edit_data ? 'Simpan Perubahan' : 'Tambah Lokasi'; ?>
                        </button>
                        <?php if ($edit_data): ?>
                            <a href="admin_kontak.php" class="btn btn-secondary py-2">Batal Edit</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Daftar Lokasi Kantor -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-3 text-dark h5"><i class="fas fa-list me-1 text-warning"></i> Daftar Lokasi Tersimpan</h4>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama & Kontak</th>
                                <th>Alamat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result_lokasi) > 0): ?>
                                <?php $no = 1; while ($row = mysqli_fetch_assoc($result_lokasi)): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td>
                                        <strong class="text-dark"><?= htmlspecialchars($row['nama_kantor']); ?></strong><br>
                                        <small class="text-muted"><i class="fas fa-phone me-1"></i> <?= htmlspecialchars($row['telepon']); ?></small><br>
                                        <small class="text-muted"><i class="fas fa-envelope me-1"></i> <?= htmlspecialchars($row['email']); ?></small>
                                    </td>
                                    <td>
                                        <span class="small text-muted"><?= nl2br(htmlspecialchars($row['alamat'])); ?></span>
                                    </td>
                                    <td class="text-center">
                                        <a href="admin_kontak.php?aksi=edit&id=<?= $row['id']; ?>" class="btn btn-sm btn-primary mb-1">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="admin_kontak.php?aksi=hapus&id=<?= $row['id']; ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Yakin ingin menghapus lokasi kantor ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada data lokasi kantor. Silakan input melalui form di samping.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>