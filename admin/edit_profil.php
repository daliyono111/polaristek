<?php
// Mulai session dan hubungkan database
session_start();
include 'koneksi/koneksi.php';

// Pastikan hanya admin yang bisa mengakses (opsional, sesuaikan dengan session login Anda)
// if (!isset($_SESSION['status_login'])) { header("location: ../login/login.php"); exit; }

// --- PROSES SIMPAN / UPDATE DATA ---
if (isset($_POST['simpan'])) {
    $judul_profil       = mysqli_real_escape_string($conn, $_POST['judul_profil']);
    $deskripsi_profil   = mysqli_real_escape_string($conn, $_POST['deskripsi_profil']);
    $sejarah            = mysqli_real_escape_string($conn, $_POST['sejarah']);
    $visi               = mysqli_real_escape_string($conn, $_POST['visi']);
    $misi               = mysqli_real_escape_string($conn, $_POST['misi']);
    
    // Cek apakah ada file gambar baru yang diunggah
    $nama_file = $_FILES['gambar_profil']['name'];
    $tmp_file  = $_FILES['gambar_profil']['tmp_name'];
    $folder    = '../img/'; // Sesuaikan letak folder penyimpanan gambar Anda

    if (!empty($nama_file)) {
        $ekstensi = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
        $ekstensi_valid = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ekstensi, $ekstensi_valid)) {
            $nama_baru = 'profil_' . time() . '.' . $ekstensi;
            
            // Ambil gambar lama untuk dihapus dari folder
            $q_lama = mysqli_query($conn, "SELECT gambar_profil FROM tentang_kami WHERE id = 1");
            $d_lama = mysqli_fetch_assoc($q_lama);
            if (!empty($d_lama['gambar_profil']) && file_exists($folder . $d_lama['gambar_profil'])) {
                unlink($folder . $d_lama['gambar_profil']);
            }

            // Upload gambar baru
            move_uploaded_file($tmp_file, $folder . $nama_baru);

            // Update dengan gambar baru
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
        // Update tanpa mengganti gambar
        $query = "UPDATE tentang_kami SET 
                  judul_profil = '$judul_profil', 
                  deskripsi_profil = '$deskripsi_profil', 
                  sejarah = '$sejarah', 
                  visi = '$visi', 
                  misi = '$misi' 
                  WHERE id = 1";
    }

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Profil perusahaan berhasil diperbarui!'); window.location='profile_perusahaan.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}

// Ambil data saat ini untuk ditampilkan di form
$query_profil = mysqli_query($conn, "SELECT * FROM tentang_kami WHERE id = 1");
$profil = mysqli_fetch_assoc($query_profil);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil Perusahaan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0"><i class="fas fa-edit me-2 text-warning"></i> Form Kelola & Edit Profil Perusahaan</h5>
                    <a href="profile_perusahaan.php" class="btn btn-sm btn-outline-warning">Lihat Halaman</a>
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
                            <small class="text-muted">Format yang diizinkan: JPG, JPEG, PNG, WEBP. Kosongkan jika tidak ingin mengubah foto.</small>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" name="simpan" class="btn btn-warning fw-bold px-4">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>