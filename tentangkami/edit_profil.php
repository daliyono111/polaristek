<?php
// Mulai session dan hubungkan database dari folder tentangkami
session_start();
include '../koneksi/koneksi.php';

// --- 1. PROSES SIMPAN / UPDATE PROFIL PERUSAHAAN ---
if (isset($_POST['simpan_profil'])) {
    $judul_profil       = mysqli_real_escape_string($conn, $_POST['judul_profil']);
    $deskripsi_profil   = mysqli_real_escape_string($conn, $_POST['deskripsi_profil']);
    $sejarah            = mysqli_real_escape_string($conn, $_POST['sejarah']);
    $visi               = mysqli_real_escape_string($conn, $_POST['visi']);
    $misi               = mysqli_real_escape_string($conn, $_POST['misi']);
    
    $nama_file = $_FILES['gambar_profil']['name'];
    $tmp_file  = $_FILES['gambar_profil']['tmp_name'];
    $folder    = '../img/';

    if (!empty($nama_file)) {
        $ekstensi = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
        $ekstensi_valid = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ekstensi, $ekstensi_valid)) {
            $nama_baru = 'profil_' . time() . '.' . $ekstensi;
            
            $q_lama = mysqli_query($conn, "SELECT gambar_profil FROM tentang_kami WHERE id = 1");
            $d_lama = mysqli_fetch_assoc($q_lama);
            if (!empty($d_lama['gambar_profil']) && file_exists($folder . $d_lama['gambar_profil'])) {
                unlink($folder . $d_lama['gambar_profil']);
            }

            move_uploaded_file($tmp_file, $folder . $nama_baru);

            $query = "UPDATE tentang_kami SET 
                      judul_profil = '$judul_profil', 
                      deskripsi_profil = '$deskripsi_profil', 
                      sejarah = '$sejarah', 
                      visi = '$visi', 
                      misi = '$misi', 
                      gambar_profil = '$nama_baru' 
                      WHERE id = 1";
        } else {
            echo "<script>alert('Format gambar harus JPG, JPEG, PNG, atau WEBP!'); window.location='edit_profil.php';</script>";
            exit;
        }
    } else {
        $query = "UPDATE tentang_kami SET 
                  judul_profil = '$judul_profil', 
                  deskripsi_profil = '$deskripsi_profil', 
                  sejarah = '$sejarah', 
                  visi = '$visi', 
                  misi = '$misi' 
                  WHERE id = 1";
    }

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Profil perusahaan berhasil diperbarui!'); window.location='edit_profil.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data profil!');</script>";
    }
}

// --- 2. PROSES TAMBAH / EDIT KEUNGGULAN ---
if (isset($_POST['simpan_keunggulan'])) {
    $id_keunggulan = $_POST['id_keunggulan'];
    $icon          = mysqli_real_escape_string($conn, $_POST['icon']);
    $judul         = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi     = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    if ($id_keunggulan == "") {
        // Tambah Data Baru
        $q_insert = "INSERT INTO keunggulan_perusahaan (icon, judul, deskripsi) VALUES ('$icon', '$judul', '$deskripsi')";
        mysqli_query($conn, $q_insert);
        echo "<script>alert('Keunggulan baru berhasil ditambahkan!'); window.location='edit_profil.php';</script>";
    } else {
        // Update Data
        $q_update = "UPDATE keunggulan_perusahaan SET icon='$icon', judul='$judul', deskripsi='$deskripsi' WHERE id='$id_keunggulan'";
        mysqli_query($conn, $q_update);
        echo "<script>alert('Keunggulan berhasil diperbarui!'); window.location='edit_profil.php';</script>";
    }
}

// --- 3. PROSES HAPUS KEUNGGULAN ---
if (isset($_GET['hapus_keunggulan'])) {
    $id_hps = $_GET['hapus_keunggulan'];
    mysqli_query($conn, "DELETE FROM keunggulan_perusahaan WHERE id = '$id_hps'");
    echo "<script>alert('Keunggulan berhasil dihapus!'); window.location='edit_profil.php';</script>";
}

// Ambil data profil saat ini
$query_profil = mysqli_query($conn, "SELECT * FROM tentang_kami WHERE id = 1");
$profil = mysqli_fetch_assoc($query_profil);

// Ambil data untuk form edit keunggulan jika tombol edit diklik
$edit_id_k = ""; $edit_icon = ""; $edit_jdl = ""; $edit_desc = "";
if (isset($_GET['edit_keunggulan'])) {
    $edit_id_k = $_GET['edit_keunggulan'];
    $q_k_edit = mysqli_query($conn, "SELECT * FROM keunggulan_perusahaan WHERE id = '$edit_id_k'");
    $r_k = mysqli_fetch_assoc($q_k_edit);
    if ($r_k) {
        $edit_icon = $r_k['icon'];
        $edit_jdl  = $r_k['judul'];
        $edit_desc = $r_k['deskripsi'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Profil & Keunggulan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-cogs text-warning me-2"></i> Kelola Halaman Tentang Kami</h2>
        <a href="profile_perusahaan.php" class="btn btn-dark fw-bold"><i class="fas fa-eye me-1"></i> Lihat Halaman Web</a>
    </div>

    <!-- BAGIAN 1: FORM EDIT PROFIL UTAMA -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="mb-0"><i class="fas fa-edit me-2 text-warning"></i> Form Edit Profil, Sejarah, Visi & Misi</h5>
        </div>
        <div class="card-body p-4">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Profil Perusahaan</label>
                    <input type="text" name="judul_profil" class="form-control" value="<?= htmlspecialchars($profil['judul_profil'] ?? ''); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Deskripsi / Uraian Profil</label>
                    <textarea name="deskripsi_profil" class="form-control" rows="4" required><?= htmlspecialchars($profil['deskripsi_profil'] ?? ''); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Sejarah Singkat</label>
                    <textarea name="sejarah" class="form-control" rows="3" required><?= htmlspecialchars($profil['sejarah'] ?? ''); ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Visi Perusahaan</label>
                        <textarea name="visi" class="form-control" rows="3" required><?= htmlspecialchars($profil['visi'] ?? ''); ?></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Misi Perusahaan</label>
                        <textarea name="misi" class="form-control" rows="3" required><?= htmlspecialchars($profil['misi'] ?? ''); ?></textarea>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Ganti Foto / Gambar Profil</label>
                    <?php if (!empty($profil['gambar_profil'])): ?>
                        <div class="mb-2">
                            <img src="../img/<?= htmlspecialchars($profil['gambar_profil']); ?>" alt="Foto Saat Ini" class="img-thumbnail" width="150">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="gambar_profil" class="form-control">
                    <small class="text-muted">Format: JPG, JPEG, PNG, WEBP. Kosongkan jika tidak ingin mengubah foto.</small>
                </div>

                <button type="submit" name="simpan_profil" class="btn btn-warning fw-bold px-4">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan Profil
                </button>
            </form>
        </div>
    </div>

    <!-- BAGIAN 2: KELOLA KEUNGGULAN & NILAI UTAMA -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-secondary text-white py-3">
            <h5 class="mb-0"><i class="fas fa-star me-2 text-warning"></i> Kelola Keunggulan & Nilai Utama</h5>
        </div>
        <div class="card-body p-4">
            
            <!-- Form Tambah / Edit Keunggulan -->
            <form action="" method="POST" class="border p-3 rounded mb-4 bg-white">
                <input type="hidden" name="id_keunggulan" value="<?= $edit_id_k; ?>">
                <h6 class="fw-bold mb-3"><?= ($edit_id_k == "") ? "+ Tambah Keunggulan Baru" : "Edit Keunggulan"; ?></h6>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nama Icon FontAwesome</label>
                        <input type="text" name="icon" class="form-control" placeholder="Contoh: fa-award atau fa-shield-alt" value="<?= htmlspecialchars($edit_icon); ?>" required>
                        <small class="text-muted">Lihat kode icon di <a href="https://fontawesome.com/search" target="_blank">FontAwesome</a></small>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Judul Keunggulan</label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Berpengalaman" value="<?= htmlspecialchars($edit_jdl); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Deskripsi Singkat</label>
                        <input type="text" name="deskripsi" class="form-control" placeholder="Penjelasan singkat..." value="<?= htmlspecialchars($edit_desc); ?>" required>
                    </div>
                </div>

                <button type="submit" name="simpan_keunggulan" class="btn btn-dark fw-bold">
                    <i class="fas fa-plus me-1"></i> <?= ($edit_id_k == "") ? "Simpan Keunggulan" : "Perbarui Keunggulan"; ?>
                </button>
                <?php if ($edit_id_k != ""): ?>
                    <a href="edit_profil.php" class="btn btn-secondary">Batal Edit</a>
                <?php endif; ?>
            </form>

            <!-- Tabel Daftar Keunggulan -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Icon</th>
                            <th width="25%">Judul</th>
                            <th width="40%">Deskripsi</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        $q_tampil_k = mysqli_query($conn, "SELECT * FROM keunggulan_perusahaan");
                        while ($row_k = mysqli_fetch_assoc($q_tampil_k)):
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="text-center">
                                <i class="fas <?= htmlspecialchars($row_k['icon']); ?> fa-2x text-warning"></i><br>
                                <small class="text-muted"><?= htmlspecialchars($row_k['icon']); ?></small>
                            </td>
                            <td class="fw-bold"><?= htmlspecialchars($row_k['judul']); ?></td>
                            <td><?= htmlspecialchars($row_k['deskripsi']); ?></td>
                            <td>
                                <a href="edit_profil.php?edit_keunggulan=<?= $row_k['id']; ?>" class="btn btn-sm btn-primary mb-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="edit_profil.php?hapus_keunggulan=<?= $row_k['id']; ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Yakin ingin menghapus keunggulan ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>