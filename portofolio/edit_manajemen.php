<?php
// Memanggil koneksi database
include '../koneksi/koneksi.php';

$pesan = "";

// Cek apakah ada parameter ID di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID Proyek Manajemen tidak ditemukan!'); window.location='bidang_manajemen.php';</script>";
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Ambil data berdasarkan ID dari tabel portofolio_manajemen
$query_data = mysqli_query($conn, "SELECT * FROM portofolio_manajemen WHERE id = '$id'");
$data = mysqli_fetch_assoc($query_data);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan di database!'); window.location='bidang_manajemen.php';</script>";
    exit();
}

// Jika tombol update ditekan
if (isset($_POST['update'])) {
    $nama_proyek = mysqli_real_escape_string($conn, $_POST['nama_proyek']);
    $kategori    = mysqli_real_escape_string($conn, $_POST['kategori']);
    $deskripsi   = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $ekstensi_diizinkan = array('png', 'jpg', 'jpeg', 'JPG', 'PNG', 'webp', 'WEBP');
    
    // Query bagian foto dinamis
    $update_bagian_foto = "";

    // ================= 1. PROSES FOTO UTAMA =================
    if (!empty($_FILES['foto']['name'])) {
        $nama_file   = $_FILES['foto']['name'];
        $ukuran_file = $_FILES['foto']['size'];
        $tmp_file    = $_FILES['foto']['tmp_name'];
        
        $x = explode('.', $nama_file);
        $ekstensi = strtolower(end($x));

        if (in_array($ekstensi, $ekstensi_diizinkan) === true) {
            if ($ukuran_file < 2048000) {
                // Hapus foto lama jika ada
                if (!empty($data['foto'])) {
                    $file_lama = '../img/' . $data['foto'];
                    if (file_exists($file_lama)) { unlink($file_lama); }
                }

                $nama_file_baru = uniqid() . '-' . basename($nama_file);
                if (move_uploaded_file($tmp_file, '../img/' . $nama_file_baru)) {
                    $update_bagian_foto .= ", foto = '$nama_file_baru'";
                } else {
                    $pesan = "<div class='alert alert-danger'>Gagal mengunggah foto utama baru.</div>";
                }
            } else {
                $pesan = "<div class='alert alert-warning'>Ukuran foto utama terlalu besar! Maksimal 2MB.</div>";
            }
        } else {
            $pesan = "<div class='alert alert-warning'>Ekstensi foto utama tidak diizinkan!</div>";
        }
    }

    // ================= 2. PROSES FOTO 2 =================
    if (empty($pesan) && !empty($_FILES['foto2']['name'])) {
        $nama_file2   = $_FILES['foto2']['name'];
        $ukuran_file2 = $_FILES['foto2']['size'];
        $tmp_file2    = $_FILES['foto2']['tmp_name'];
        
        $x2 = explode('.', $nama_file2);
        $ekstensi2 = strtolower(end($x2));

        if (in_array($ekstensi2, $ekstensi_diizinkan) === true) {
            if ($ukuran_file2 < 2048000) {
                if (!empty($data['foto2'])) {
                    $file_lama2 = '../img/' . $data['foto2'];
                    if (file_exists($file_lama2)) { unlink($file_lama2); }
                }

                $nama_file_baru2 = '2_' . uniqid() . '-' . basename($nama_file2);
                if (move_uploaded_file($tmp_file2, '../img/' . $nama_file_baru2)) {
                    $update_bagian_foto .= ", foto2 = '$nama_file_baru2'";
                }
            } else {
                $pesan = "<div class='alert alert-warning'>Ukuran foto tambahan 2 terlalu besar! Maksimal 2MB.</div>";
            }
        } else {
            $pesan = "<div class='alert alert-warning'>Ekstensi foto tambahan 2 tidak diizinkan!</div>";
        }
    }

    // ================= 3. PROSES FOTO 3 =================
    if (empty($pesan) && !empty($_FILES['foto3']['name'])) {
        $nama_file3   = $_FILES['foto3']['name'];
        $ukuran_file3 = $_FILES['foto3']['size'];
        $tmp_file3    = $_FILES['foto3']['tmp_name'];
        
        $x3 = explode('.', $nama_file3);
        $ekstensi3 = strtolower(end($x3));

        if (in_array($ekstensi3, $ekstensi_diizinkan) === true) {
            if ($ukuran_file3 < 2048000) {
                if (!empty($data['foto3'])) {
                    $file_lama3 = '../img/' . $data['foto3'];
                    if (file_exists($file_lama3)) { unlink($file_lama3); }
                }

                $nama_file_baru3 = '3_' . uniqid() . '-' . basename($nama_file3);
                if (move_uploaded_file($tmp_file3, '../img/' . $nama_file_baru3)) {
                    $update_bagian_foto .= ", foto3 = '$nama_file_baru3'";
                }
            } else {
                $pesan = "<div class='alert alert-warning'>Ukuran foto tambahan 3 terlalu besar! Maksimal 2MB.</div>";
            }
        } else {
            $pesan = "<div class='alert alert-warning'>Ekstensi foto tambahan 3 tidak diizinkan!</div>";
        }
    }

    // Eksekusi query update jika tidak ada error pada file
    if (empty($pesan)) {
        $query = "UPDATE portofolio_manajemen SET kategori = '$kategori', nama_proyek = '$nama_proyek', deskripsi = '$deskripsi' $update_bagian_foto WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        
        if ($result) {
            echo "<script>alert('Data portofolio manajemen beserta slider foto berhasil diperbarui!'); window.location='bidang_manajemen.php';</script>";
            exit();
        } else {
            $pesan = "<div class='alert alert-danger'>Gagal memperbarui database: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Portofolio Bidang Manajemen - PT. POLARISTEK ADHI PERSADA</title>
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
                    <h4 class="mb-0 fw-bold">Form Edit Portofolio Bidang Manajemen</h4>
                </div>
                <div class="card-body p-4">
                    
                    <?= $pesan; ?>

                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="kategori" class="form-label fw-bold">Pilih Kategori Sub-Menu</label>
                            <select class="form-select" id="kategori" name="kategori" required>
                                <option value="" disabled>-- Pilih Kategori Manajemen --</option>
                                <option value="Gedung" <?= ($data['kategori'] == 'Gedung') ? 'selected' : ''; ?>>Gedung</option>
                                <option value="Jalan dan Jembatan" <?= ($data['kategori'] == 'Jalan dan Jembatan') ? 'selected' : ''; ?>>Jalan dan Jembatan</option>
                                <option value="Tata Lingkungan" <?= ($data['kategori'] == 'Tata Lingkungan') ? 'selected' : ''; ?>>Tata Lingkungan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nama_proyek" class="form-label fw-bold">Nama Proyek / Kegiatan</label>
                            <input type="text" class="form-control" id="nama_proyek" name="nama_proyek" value="<?= htmlspecialchars($data['nama_proyek']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-bold">Deskripsi Proyek</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?= htmlspecialchars($data['deskripsi']); ?></textarea>
                        </div>
                        
                        <!-- Pratinjau Foto-Foto Saat Ini -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">Foto-Foto Saat Ini:</label>
                            </div>
                            <div class="col-md-4 text-center mb-2">
                                <span class="d-block small text-muted mb-1">Foto Utama (Slide 1)</span>
                                <img src="../img/<?= htmlspecialchars($data['foto']); ?>" alt="Foto 1" class="img-thumbnail rounded" style="height: 100px; width: 100%; object-fit: cover;" onerror="this.src='https://via.placeholder.com/150';">
                            </div>
                            <div class="col-md-4 text-center mb-2">
                                <span class="d-block small text-muted mb-1">Foto 2 (Slide 2)</span>
                                <?php if (!empty($data['foto2'])): ?>
                                    <img src="../img/<?= htmlspecialchars($data['foto2']); ?>" alt="Foto 2" class="img-thumbnail rounded" style="height: 100px; width: 100%; object-fit: cover;" onerror="this.src='https://via.placeholder.com/150';">
                                <?php else: ?>
                                    <div class="border rounded bg-light text-muted small d-flex align-items-center justify-content-center" style="height: 100px;">Belum ada</div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4 text-center mb-2">
                                <span class="d-block small text-muted mb-1">Foto 3 (Slide 3)</span>
                                <?php if (!empty($data['foto3'])): ?>
                                    <img src="../img/<?= htmlspecialchars($data['foto3']); ?>" alt="Foto 3" class="img-thumbnail rounded" style="height: 100px; width: 100%; object-fit: cover;" onerror="this.src='https://via.placeholder.com/150';">
                                <?php else: ?>
                                    <div class="border rounded bg-light text-muted small d-flex align-items-center justify-content-center" style="height: 100px;">Belum ada</div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Input Ganti Foto Utama -->
                        <div class="mb-3">
                            <label for="foto" class="form-label fw-bold">Ganti Foto Utama (Opsional)</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                            <div class="form-text">Biarkan kosong jika tidak ingin mengubah foto utama.</div>
                        </div>

                        <!-- Input Ganti Foto 2 -->
                        <div class="mb-3">
                            <label for="foto2" class="form-label fw-bold">Ganti / Tambah Foto 2 (Opsional)</label>
                            <input type="file" class="form-control" id="foto2" name="foto2">
                            <div class="form-text">Biarkan kosong jika tidak ingin mengubah foto kedua.</div>
                        </div>

                        <!-- Input Ganti Foto 3 -->
                        <div class="mb-4">
                            <label for="foto3" class="form-label fw-bold">Ganti / Tambah Foto 3 (Opsional)</label>
                            <input type="file" class="form-control" id="foto3" name="foto3">
                            <div class="form-text">Biarkan kosong jika tidak ingin mengubah foto ketiga. Format: JPG, JPEG, PNG, WEBP. Maks 2MB.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" name="update" class="btn btn-warning fw-bold text-dark">Simpan Perubahan</button>
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