<?php
// Memanggil koneksi database
include '../koneksi/koneksi.php';

$pesan = "";

// Jika tombol simpan ditekan
if (isset($_POST['submit'])) {
    $kategori    = mysqli_real_escape_string($conn, $_POST['kategori']);
    $nama_proyek = mysqli_real_escape_string($conn, $_POST['nama_proyek']);
    $deskripsi   = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $ekstensi_diizinkan = array('png', 'jpg', 'jpeg', 'JPG', 'PNG', 'webp', 'WEBP');
    
    // ================= FOTO UTAMA =================
    $nama_file   = $_FILES['foto']['name'];
    $ukuran_file = $_FILES['foto']['size'];
    $tmp_file    = $_FILES['foto']['tmp_name'];
    $nama_file_baru = "";

    // ================= FOTO 2 (Opsional) =================
    $nama_file2   = $_FILES['foto2']['name'];
    $ukuran_file2 = $_FILES['foto2']['size'];
    $tmp_file2    = $_FILES['foto2']['tmp_name'];
    $nama_file_baru2 = NULL;

    // ================= FOTO 3 (Opsional) =================
    $nama_file3   = $_FILES['foto3']['name'];
    $ukuran_file3 = $_FILES['foto3']['size'];
    $tmp_file3    = $_FILES['foto3']['tmp_name'];
    $nama_file_baru3 = NULL;

    if (!empty($nama_file)) {
        $x = explode('.', $nama_file);
        $ekstensi = strtolower(end($x));

        if (in_array($ekstensi, $ekstensi_diizinkan) === true) {
            if ($ukuran_file < 2048000) { // Maksimal 2MB
                $nama_file_baru = uniqid() . '-' . basename($nama_file);
                $tujuan = '../img/' . $nama_file_baru;

                if (move_uploaded_file($tmp_file, $tujuan)) {
                    
                    // --- Proses Upload Foto 2 (Jika diisi) ---
                    if (!empty($nama_file2)) {
                        $x2 = explode('.', $nama_file2);
                        $ekstensi2 = strtolower(end($x2));
                        if (in_array($ekstensi2, $ekstensi_diizinkan) && $ukuran_file2 < 2048000) {
                            $nama_file_baru2 = '2_' . uniqid() . '-' . basename($nama_file2);
                            move_uploaded_file($tmp_file2, '../img/' . $nama_file_baru2);
                        }
                    }

                    // --- Proses Upload Foto 3 (Jika diisi) ---
                    if (!empty($nama_file3)) {
                        $x3 = explode('.', $nama_file3);
                        $ekstensi3 = strtolower(end($x3));
                        if (in_array($ekstensi3, $ekstensi_diizinkan) && $ukuran_file3 < 2048000) {
                            $nama_file_baru3 = '3_' . uniqid() . '-' . basename($nama_file3);
                            move_uploaded_file($tmp_file3, '../img/' . $nama_file_baru3);
                        }
                    }

                    // Simpan ke database portofolio_manajemen
                    $f2_val = $nama_file_baru2 ? "'$nama_file_baru2'" : "NULL";
                    $f3_val = $nama_file_baru3 ? "'$nama_file_baru3'" : "NULL";

                    $query = "INSERT INTO portofolio_manajemen (kategori, nama_proyek, deskripsi, foto, foto2, foto3) 
                              VALUES ('$kategori', '$nama_proyek', '$deskripsi', '$nama_file_baru', $f2_val, $f3_val)";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        $pesan = "<div class='alert alert-success'>Data portofolio manajemen beserta slider foto berhasil disimpan!</div>";
                    } else {
                        $pesan = "<div class='alert alert-danger'>Gagal menyimpan ke database: " . mysqli_error($conn) . "</div>";
                    }
                } else {
                    $pesan = "<div class='alert alert-danger'>Gagal mengunggah file foto utama ke folder img.</div>";
                }
            } else {
                $pesan = "<div class='alert alert-warning'>Ukuran foto utama terlalu besar! Maksimal 2MB.</div>";
            }
        } else {
            $pesan = "<div class='alert alert-warning'>Ekstensi foto utama tidak diizinkan! Hanya boleh JPG, JPEG, PNG, atau WEBP.</div>";
        }
    } else {
        $pesan = "<div class='alert alert-warning'>Foto utama wajib diunggah!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Portofolio Bidang Manajemen - PT. POLARISTEK ADHI PERSADA</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white text-center py-3">
                    <h4 class="mb-0 fw-bold">Form Input Portofolio Bidang Manajemen</h4>
                </div>
                <div class="card-body p-4">
                    
                    <?= $pesan; ?>

                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="kategori" class="form-label fw-bold">Pilih Kategori Sub-Menu</label>
                            <select class="form-select" id="kategori" name="kategori" required>
                                <option value="" selected disabled>-- Pilih Kategori Manajemen --</option>
                                <option value="Gedung">Gedung</option>
                                <option value="Jalan dan Jembatan">Jalan dan Jembatan</option>
                                <option value="Tata Lingkungan">Tata Lingkungan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nama_proyek" class="form-label fw-bold">Nama Proyek / Kegiatan</label>
                            <input type="text" class="form-control" id="nama_proyek" name="nama_proyek" placeholder="Contoh: Manajemen Konstruksi Pembangunan..." required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-bold">Deskripsi Proyek</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Tuliskan detail atau deskripsi proyek manajemen..." required></textarea>
                        </div>
                        
                        <!-- Input Foto Utama (Wajib) -->
                        <div class="mb-3">
                            <label for="foto" class="form-label fw-bold">Foto Utama Proyek (Slide 1 - Cover)</label>
                            <input type="file" class="form-control" id="foto" name="foto" required>
                            <div class="form-text">Format yang didukung: JPG, JPEG, PNG, WEBP. Maksimal 2MB.</div>
                        </div>

                        <!-- Input Foto 2 (Opsional untuk Slider) -->
                        <div class="mb-3">
                            <label for="foto2" class="form-label fw-bold">Foto Tambahan 2 (Opsional - Untuk Slider)</label>
                            <input type="file" class="form-control" id="foto2" name="foto2">
                            <div class="form-text">Akan tampil sebagai slide kedua di modal detail.</div>
                        </div>

                        <!-- Input Foto 3 (Opsional untuk Slider) -->
                        <div class="mb-4">
                            <label for="foto3" class="form-label fw-bold">Foto Tambahan 3 (Opsional - Untuk Slider)</label>
                            <input type="file" class="form-control" id="foto3" name="foto3">
                            <div class="form-text">Akan tampil sebagai slide ketiga di modal detail.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" name="submit" class="btn btn-warning fw-bold text-dark">Simpan Portofolio</button>
                            <a href="bidang_manajemen.php" class="btn btn-secondary">Kembali ke Halaman Manajemen</a>
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