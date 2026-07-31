<?php
// Memanggil koneksi database
include '../koneksi/koneksi.php';

$pesan = "";

// Jika tombol simpan ditekan
if (isset($_POST['submit'])) {
    $nama      = mysqli_real_escape_string($conn, $_POST['nama']);
    $jabatan   = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // Konfigurasi Upload Foto
    $nama_file = $_FILES['foto']['name'];
    $ukuran_file = $_FILES['foto']['size'];
    $tmp_file  = $_FILES['foto']['tmp_name'];
    
    $ekstensi_diizinkan = array('png', 'jpg', 'jpeg', 'JPG', 'PNG');
    $x = explode('.', $nama_file);
    $ekstensi = strtolower(end($x));

    if (!empty($nama_file)) {
        if (in_array($ekstensi, $ekstensi_diizinkan) === true) {
            if ($ukuran_file < 2048000) { // Maksimal 2MB
                // Buat nama file unik agar tidak ada nama yang sama persis
                $nama_file_baru = uniqid() . '-' . $nama_file;
                $tujuan = '../img/' . $nama_file_baru;

                if (move_uploaded_file($tmp_file, $tujuan)) {
                    // Simpan nama file baru ke database
                    $query = "INSERT INTO struktur_organisasi (nama, jabatan, deskripsi, foto) VALUES ('$nama', '$jabatan', '$deskripsi', '$nama_file_baru')";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        $pesan = "<div class='alert alert-success'>Data berhasil disimpan! <a href='struktur_organisasi.php' class='alert-link'>Lihat Hasil</a></div>";
                    } else {
                        $pesan = "<div class='alert alert-danger'>Gagal menyimpan ke database: " . mysqli_error($conn) . "</div>";
                    }
                } else {
                    $pesan = "<div class='alert alert-danger'>Gagal mengunggah file foto ke folder img.</div>";
                }
            } else {
                $pesan = "<div class='alert alert-warning'>Ukuran file terlalu besar! Maksimal 2MB.</div>";
            }
        } else {
            $pesan = "<div class='alert alert-warning'>Ekstensi file tidak diizinkan! Hanya boleh JPG, JPEG, atau PNG.</div>";
        }
    } else {
        // Jika tidak upload foto
        $query = "INSERT INTO struktur_organisasi (nama, jabatan, deskripsi, foto) VALUES ('$nama', '$jabatan', '$deskripsi', '')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $pesan = "<div class='alert alert-success'>Data berhasil disimpan tanpa foto! <a href='struktur_organisasi_3.php' class='alert-link'>Lihat Hasil</a></div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Struktur Organisasi</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white text-center py-3">
                    <h4 class="mb-0 fw-bold">Form Input Pengurus Organisasi</h4>
                </div>
                <div class="card-body p-4">
                    
                    <?= $pesan; ?>

                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-bold">Nama Lengkap & Gelar</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Contoh: Putra Wibowo, ST" required>
                        </div>
                        <div class="mb-3">
                            <label for="jabatan" class="form-label fw-bold">Jabatan</label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Contoh: Direktur Utama" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-bold">Deskripsi Tugas</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Tuliskan deskripsi singkat tugas..."></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="foto" class="form-label fw-bold">Upload Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                            <div class="form-text">Format: JPG, JPEG, PNG (Maksimal 2MB).</div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" name="submit" class="btn btn-warning fw-bold text-dark">Simpan Data</button>
                            <a href="struktur_organisasi.php" class="btn btn-secondary">Kembali ke Struktur Organisasi</a>
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