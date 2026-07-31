<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: ../login.php");
    exit;
}
include '../koneksi/koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM slider_banner WHERE id = '$id'");
$slide = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $link_teks = mysqli_real_escape_string($conn, $_POST['link_teks']);
    $link_url = mysqli_real_escape_string($conn, $_POST['link_url']);

    // Cek apakah admin mengganti gambar
    if ($_FILES['gambar']['name'] != "") {
        $nama_file = $_FILES['gambar']['name'];
        $tmp_file = $_FILES['gambar']['tmp_name'];
        $ekstensi = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
        $nama_baru = uniqid() . '.' . $ekstensi;

        if (move_uploaded_file($tmp_file, '../img/' . $nama_baru)) {
            // Hapus gambar lama jika ada
            if (file_exists('../img/' . $slide['gambar'])) {
                unlink('../img/' . $slide['gambar']);
            }
            $query = "UPDATE slider_banner SET gambar='$nama_baru', judul='$judul', deskripsi='$deskripsi', link_teks='$link_teks', link_url='$link_url' WHERE id='$id'";
        }
    } else {
        $query = "UPDATE slider_banner SET judul='$judul', deskripsi='$deskripsi', link_teks='$link_teks', link_url='$link_url' WHERE id='$id'";
    }

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Slider berhasil diperbarui!'); window.location='../index.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Slider Banner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0 p-4">
                <h3 class="fw-bold mb-4">Edit Banner Slider</h3>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Banner</label>
                        <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($slide['judul']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi / Sub-teks</label>
                        <textarea name="deskripsi" class="form-control" rows="3" required><?= htmlspecialchars($slide['deskripsi']); ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Teks Tombol</label>
                            <input type="text" name="link_teks" class="form-control" value="<?= htmlspecialchars($slide['link_teks']); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">URL / Link Tombol</label>
                            <input type="text" name="link_url" class="form-control" value="<?= htmlspecialchars($slide['link_url']); ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Gambar Saat Ini:</label><br>
                        <img src="../img/<?= htmlspecialchars($slide['gambar']); ?>" class="img-thumbnail mb-2" style="height: 100px;">
                        <input type="file" name="gambar" class="form-control">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
                    </div>
                    <button type="submit" name="update" class="btn btn-warning fw-bold text-dark px-4">Perbarui Slider</button>
                    <a href="../index.php" class="btn btn-secondary px-3">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>