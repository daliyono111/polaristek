<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: ../login.php");
    exit;
}
include '../koneksi/koneksi.php';

if (isset($_POST['submit'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $link_teks = mysqli_real_escape_string($conn, $_POST['link_teks']);
    $link_url = mysqli_real_escape_string($conn, $_POST['link_url']);

    // Upload Gambar
    $nama_file = $_FILES['gambar']['name'];
    $ukuran_file = $_FILES['gambar']['size'];
    $tmp_file = $_FILES['gambar']['tmp_name'];
    $ekstensi = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
    $ekstensi_diizinkan = ['jpg', 'jpeg', 'png', 'webp'];

    if (in_array($ekstensi, $ekstensi_diizinkan)) {
        $nama_baru = uniqid() . '.' . $ekstensi;
        if (move_uploaded_file($tmp_file, '../img/' . $nama_baru)) {
            $query = "INSERT INTO slider_banner (gambar, judul, deskripsi, link_teks, link_url) VALUES ('$nama_baru', '$judul', '$deskripsi', '$link_teks', '$link_url')";
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Slider berhasil ditambahkan!'); window.location='../index.php';</script>";
            } else {
                echo "<script>alert('Gagal menyimpan ke database.');</script>";
            }
        } else {
            echo "<script>alert('Gagal mengupload gambar.');</script>";
        }
    } else {
        echo "<script>alert('Ekstensi gambar tidak diizinkan (Gunakan JPG, JPEG, PNG, WEBP).');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Slider Banner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0 p-4">
                <h3 class="fw-bold mb-4">Tambah Banner Slider Baru</h3>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Banner</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi / Sub-teks</label>
                        <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Teks Tombol (Cth: Lihat Legalitas)</label>
                            <input type="text" name="link_teks" class="form-control" value="Lihat Detail">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">URL / Link Tombol</label>
                            <input type="text" name="link_url" class="form-control" value="#">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Gambar Banner (Rekomendasi Landscape 1920x1080)</label>
                        <input type="file" name="gambar" class="form-control" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-warning fw-bold text-dark px-4">Simpan Slider</button>
                    <a href="../index.php" class="btn btn-secondary px-3">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>