<?php
// Sesuaikan path koneksi database Anda
include '../koneksi/koneksi.php'; 

// --- 1. PROSES SIMPAN / EDIT ---
if (isset($_POST['simpan'])) {
    $id     = $_POST['id'];
    $badge  = mysqli_real_escape_string($koneksi, $_POST['badge']);
    $judul  = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $uraian = mysqli_real_escape_string($koneksi, $_POST['uraian']);
    
    $nama_file = $_FILES['foto']['name'];
    $ukuran    = $_FILES['foto']['size'];
    $tmp_file  = $_FILES['foto']['tmp_name'];
    
    // Jika user menggunggah foto baru
    if (!empty($nama_file)) {
        $ekstensi = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
        $ekstensi_diizinkan = array('jpg', 'jpeg', 'png', 'webp');
        
        if (in_array($ekstensi, $ekstensi_diizinkan) === true) {
            // Buat nama file unik agar tidak bentrok
            $foto_baru = 'profil_' . time() . '.' . $ekstensi;
            $folder = '../img/'; // Sesuaikan folder penyimpanan foto Anda

            // Ambil foto lama jika mau dihapus dari folder (opsional)
            if ($id != "") {
                $query_lama = mysqli_query($koneksi, "SELECT foto FROM profil_perusahaan WHERE id = '$id'");
                $d_lama = mysqli_fetch_array($query_lama);
                if (file_exists($folder . $d_lama['foto'])) {
                    unlink($folder . $d_lama['foto']);
                }
            }

            move_uploaded_file($tmp_file, $folder . $foto_baru);

            if ($id == "") {
                // INSERT DATA BARU
                $query = "INSERT INTO profil_perusahaan (badge, judul, uraian, foto) VALUES ('$badge', '$judul', '$uraian', '$foto_baru')";
            } else {
                // UPDATE DATA DENGAN FOTO
                $query = "UPDATE profil_perusahaan SET badge='$badge', judul='$judul', uraian='$uraian', foto='$foto_baru' WHERE id='$id'";
            }
            mysqli_query($koneksi, $query);
            echo "<script>alert('Data berhasil disimpan!'); window.location='profil.php';</script>";
        } else {
            echo "<script>alert('Ekstensi file foto harus JPG, JPEG, PNG, atau WEBP!');</script>";
        }
    } else {
        // JIKA TIDAK GANTI FOTO
        if ($id != "") {
            $query = "UPDATE profil_perusahaan SET badge='$badge', judul='$judul', uraian='$uraian' WHERE id='$id'";
            mysqli_query($koneksi, $query);
            echo "<script>alert('Data berhasil diperbarui!'); window.location='profil.php';</script>";
        } else {
            echo "<script>alert('Foto wajib diunggah untuk data baru!');</script>";
        }
    }
}

// --- 2. PROSES HAPUS ---
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    // Ambil info foto untuk dihapus filenya
    $q_foto = mysqli_query($koneksi, "SELECT foto FROM profil_perusahaan WHERE id = '$id'");
    $d_foto = mysqli_fetch_array($q_foto);
    $file_foto = '../img/' . $d_foto['foto'];
    if (file_exists($file_foto)) {
        unlink($file_foto);
    }

    mysqli_query($koneksi, "DELETE FROM profil_perusahaan WHERE id = '$id'");
    echo "<script>alert('Data berhasil dihapus!'); window.location='profil.php';</script>";
}

// --- 3. AMBIL DATA UNTUK EDIT ---
$edit_badge = ""; $edit_judul = ""; $edit_uraian = ""; $edit_id = ""; $edit_foto = "";
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $q_edit = mysqli_query($koneksi, "SELECT * FROM profil_perusahaan WHERE id = '$edit_id'");
    $row_edit = mysqli_fetch_array($q_edit);
    $edit_badge  = $row_edit['badge'];
    $edit_judul  = $row_edit['judul'];
    $edit_uraian = $row_edit['uraian'];
    $edit_foto   = $row_edit['foto'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Profil Perusahaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">
    <h2 class="mb-4">Kelola Bagian Profil Perusahaan</h2>

    <!-- FORM INPUT / EDIT -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-dark text-white"><?= ($edit_id == "") ? "Tambah Data Baru" : "Edit Data"; ?></div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $edit_id; ?>">
                
                <div class="mb-3">
                    <label class="form-label">Teks Badge (Contoh: SELAMAT DATANG)</label>
                    <input type="text" name="badge" class="form-control" value="<?= htmlspecialchars($edit_badge); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul Utama (Contoh: PT. POLARISTEK ADHI PERSADA)</label>
                    <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($edit_judul); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Uraian / Deskripsi</label>
                    <textarea name="uraian" class="form-control" rows="4" required><?= htmlspecialchars($edit_uraian); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Perusahaan / Gedung</label>
                    <?php if ($edit_foto != ""): ?>
                        <div class="mb-2">
                            <img src="../img/<?= $edit_foto; ?>" width="120" class="img-thumbnail">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="foto" class="form-control">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto.</small>
                </div>

                <button type="submit" name="simpan" class="btn btn-warning fw-bold">Simpan Data</button>
                <?php if ($edit_id != ""): ?>
                    <a href="profil.php" class="btn btn-secondary">Batal</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- TABEL DATA -->
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">Daftar Profil Perusahaan</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Foto</th>
                            <th width="20%">Badge & Judul</th>
                            <th width="45%">Uraian</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        $sql = mysqli_query($koneksi, "SELECT * FROM profil_perusahaan");
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><img src="../img/<?= $row['foto']; ?>" width="100" class="img-fluid rounded"></td>
                            <td>
                                <span class="badge bg-warning text-dark mb-1"><?= $row['badge']; ?></span>
                                <h6 class="fw-bold"><?= $row['judul']; ?></h6>
                            </td>
                            <td><?= $row['uraian']; ?></td>
                            <td>
                                <a href="profil.php?edit=<?= $row['id']; ?>" class="btn btn-sm btn-primary mb-1">Edit</a>
                                <a href="profil.php?hapus=<?= $row['id']; ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>