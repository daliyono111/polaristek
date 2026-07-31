<?php
session_start();
include '../koneksi/koneksi.php';

// Validasi akses admin
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: ../portofolio/testimoni.php");
    exit;
}

// Proses Simpan (Tambah / Edit)
if (isset($_POST['simpan_testimoni'])) {
    $id = $_POST['id'] ?? '';
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $jenis = $_POST['jenis'];
    $isi_testimoni = mysqli_real_escape_string($conn, $_POST['isi_testimoni']);
    $embed_video = mysqli_real_escape_string($conn, $_POST['embed_video']);

    if ($id == "") {
        $query = "INSERT INTO testimoni (nama, jabatan, jenis, isi_testimoni, embed_video) VALUES ('$nama', '$jabatan', '$jenis', '$isi_testimoni', '$embed_video')";
    } else {
        $query = "UPDATE testimoni SET nama='$nama', jabatan='$jabatan', jenis='$jenis', isi_testimoni='$isi_testimoni', embed_video='$embed_video' WHERE id='$id'";
    }

    if (mysqli_query($conn, $query)) {
        header("Location: admin_testimoni.php?pesan=sukses");
        exit;
    }
}

// Proses Hapus
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM testimoni WHERE id='$id'");
    header("Location: admin_testimoni.php?pesan=dihapus");
    exit;
}

// Ambil data untuk edit
$edit_data = null;
if (isset($_GET['aksi']) && $_GET['aksi'] == 'edit') {
    $id_edit = $_GET['id'];
    $result_edit = mysqli_query($conn, "SELECT * FROM testimoni WHERE id='$id_edit'");
    $edit_data = mysqli_fetch_assoc($result_edit);
}

$result_testi = mysqli_query($conn, "SELECT * FROM testimoni ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Testimoni - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#"><i class="fas fa-user-shield me-2"></i> Panel Admin - Testimoni</a>
        <a href="../portofolio/testimoni.php" class="btn btn-outline-light btn-sm">Kembali ke Situs</a>
    </div>
</nav>

<div class="container py-4">
    <h2 class="fw-bold mb-4"><i class="fas fa-comments text-warning me-2"></i> Kelola Testimoni Teks & Video</h2>
    
    <div class="row g-4">
        <!-- Form Input -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 rounded-4">
                <h4 class="fw-bold mb-3 h5"><?= $edit_data ? 'Edit Testimoni' : 'Tambah Testimoni Baru'; ?></h4>
                <form action="" method="POST">
                    <input type="hidden" name="id" value="<?= $edit_data['id'] ?? ''; ?>">
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Klien / Pelanggan</label>
                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($edit_data['nama'] ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jabatan / Perusahaan</label>
                        <input type="text" name="jabatan" class="form-control" placeholder="Contoh: Direktur PT Maju Jaya" value="<?= htmlspecialchars($edit_data['jabatan'] ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jenis Testimoni</label>
                        <select name="jenis" class="form-select" required>
                            <option value="teks" <?= (isset($edit_data['jenis']) && $edit_data['jenis'] == 'teks') ? 'selected' : ''; ?>>Teks</option>
                            <option value="video" <?= (isset($edit_data['jenis']) && $edit_data['jenis'] == 'video') ? 'selected' : ''; ?>>Video (YouTube Embed)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Isi Testimoni / Ulasan</label>
                        <textarea name="isi_testimoni" class="form-control" rows="3" required><?= htmlspecialchars($edit_data['isi_testimoni'] ?? ''); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Embed Video (Opsional jika jenis Video)</label>
                        <textarea name="embed_video" class="form-control" rows="2" placeholder='<iframe src="https://www.youtube.com/embed/..." ...></iframe>'><?= htmlspecialchars($edit_data['embed_video'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit" name="simpan_testimoni" class="btn btn-warning fw-bold w-100 py-2">Simpan Testimoni</button>
                    <?php if ($edit_data): ?>
                        <a href="admin_testimoni.php" class="btn btn-secondary w-100 mt-2">Batal</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 rounded-4">
                <h4 class="fw-bold mb-3 h5">Daftar Testimoni</h4>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama & Jabatan</th>
                                <th>Jenis</th>
                                <th>Ulasan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; while ($row = mysqli_fetch_assoc($result_testi)): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($row['nama']); ?></strong><br>
                                    <small class="text-muted"><?= htmlspecialchars($row['jabatan']); ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-<?= ($row['jenis'] == 'video') ? 'danger' : 'primary'; ?>">
                                        <?= strtoupper($row['jenis']); ?>
                                    </span>
                                </td>
                                <td><small><?= substr(htmlspecialchars($row['isi_testimoni']), 0, 80); ?>...</small></td>
                                <td class="text-center">
                                    <a href="admin_testimoni.php?aksi=edit&id=<?= $row['id']; ?>" class="btn btn-sm btn-primary mb-1"><i class="fas fa-edit"></i></a>
                                    <a href="admin_testimoni.php?aksi=hapus&id=<?= $row['id']; ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Hapus testimoni ini?')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>