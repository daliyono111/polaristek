<?php
session_start();
include '../koneksi/koneksi.php';

// Validasi Login Admin
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("location: login.php");
    exit;
}

// Proses Tambah / Edit Banner
if (isset($_POST['simpan'])) {
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
    $page_name = 'profil_perusahaan';

    $nama_file = $_FILES['background_image']['name'];
    $tmp_file = $_FILES['background_image']['tmp_name'];

    if (!empty($nama_file)) {
        $ext = pathinfo($nama_file, PATHINFO_EXTENSION);
        $nama_baru = 'bg_profil_' . time() . '.' . $ext;
        $dir = '../img/'; // Folder img berada di luar folder admin (root project)

        // Jika Edit, hapus foto lama jika ada
        if ($id != "") {
            $q_lama = mysqli_query($conn, "SELECT background_image FROM page_banners WHERE id = '$id'");
            $d_lama = mysqli_fetch_assoc($q_lama);
            if (!empty($d_lama['background_image']) && file_exists($dir . $d_lama['background_image'])) {
                unlink($dir . $d_lama['background_image']);
            }
        }

        move_uploaded_file($tmp_file, $dir . $nama_baru);

        if ($id == "") {
            // INSERT (Tambah)
            $query = "INSERT INTO page_banners (page_name, title, subtitle, background_image) VALUES ('$page_name', '$title', '$subtitle', '$nama_baru')";
        } else {
            // UPDATE (Edit dengan Gambar Baru)
            $query = "UPDATE page_banners SET title='$title', subtitle='$subtitle', background_image='$nama_baru' WHERE id='$id'";
        }
    } else {
        // UPDATE (Edit tanpa ganti gambar)
        $query = "UPDATE page_banners SET title='$title', subtitle='$subtitle' WHERE id='$id'";
    }

    mysqli_query($conn, $query);
    header("location: admin_banner_profil.php");
    exit;
}

// Proses Hapus
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $q_lama = mysqli_query($conn, "SELECT background_image FROM page_banners WHERE id = '$id'");
    $d_lama = mysqli_fetch_assoc($q_lama);
    if (!empty($d_lama['background_image']) && file_exists('../img/' . $d_lama['background_image'])) {
        unlink('../img/' . $d_lama['background_image']);
    }

    mysqli_query($conn, "DELETE FROM page_banners WHERE id = '$id'");
    header("location: admin_banner_profil.php");
    exit;
}

// Ambil data untuk mode Edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];
    $q_edit = mysqli_query($conn, "SELECT * FROM page_banners WHERE id = '$id_edit'");
    $edit_data = mysqli_fetch_assoc($q_edit);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Background Profil Perusahaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="fw-bold mb-4">Kelola Background & Teks "Profil Perusahaan"</h2>
    
    <!-- Tombol kembali diarahkan ke file profil_perusahaan.php di dalam folder tentangkami -->
    <a href="../tentangkami/profile_perusahaan.php" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left me-1"></i> Kembali ke Profil Perusahaan</a>

    <!-- Form Tambah / Edit -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3"><?= $edit_data ? 'Edit Background' : 'Tambah Background Baru'; ?></h5>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $edit_data['id'] ?? ''; ?>">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Judul Utama (Contoh: TENTANG KAMI)</label>
                    <input type="text" class="form-control" name="title" value="<?= $edit_data['title'] ?? ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Sub Judul (Deskripsi Singkat)</label>
                    <textarea class="form-control" name="subtitle" rows="2" required><?= $edit_data['subtitle'] ?? ''; ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Gambar Background (Hero Image)</label>
                    <?php if ($edit_data && !empty($edit_data['background_image'])): ?>
                        <div class="mb-2">
                            <img src="../img/<?= $edit_data['background_image']; ?>" width="150" class="rounded shadow-sm">
                        </div>
                    <?php endif; ?>
                    <input type="file" class="form-control" name="background_image" <?= $edit_data ? '' : 'required'; ?>>
                    <div class="form-text">Format: JPG, PNG, WEBP.</div>
                </div>
                <button type="submit" name="simpan" class="btn btn-warning fw-bold px-4">Simpan Data</button>
                <?php if ($edit_data): ?>
                    <a href="admin_banner_profil.php" class="btn btn-outline-secondary">Batal</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Daftar Background Aktif</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">No</th>
                            <th>Preview</th>
                            <th>Judul & Subjudul</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sql = mysqli_query($conn, "SELECT * FROM page_banners WHERE page_name='profil_perusahaan' ORDER BY id DESC");
                        if (mysqli_num_rows($sql) > 0) {
                            while ($row = mysqli_fetch_assoc($sql)) {
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><img src="../img/<?= $row['background_image']; ?>" width="120" height="60" class="object-fit-cover rounded"></td>
                            <td>
                                <strong><?= htmlspecialchars($row['title']); ?></strong><br>
                                <small class="text-muted"><?= htmlspecialchars($row['subtitle']); ?></small>
                            </td>
                            <td class="text-center">
                                <a href="admin_banner_profil.php?edit=<?= $row['id']; ?>" class="btn btn-sm btn-warning text-dark fw-bold"><i class="fas fa-edit"></i></a>
                                <a href="admin_banner_profil.php?hapus=<?= $row['id']; ?>" class="btn btn-sm btn-danger fw-bold" onclick="return confirm('Yakin ingin menghapus background ini?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo '<tr><td colspan="4" class="text-center text-muted">Belum ada data background banner.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>