<?php
include '../koneksi/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil nama file foto berdasarkan ID
    $query = mysqli_query($conn, "SELECT foto FROM portofolio_perencanaan WHERE id = '$id'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $file_foto = '../img/' . $data['foto'];
        // Hapus file fisik gambar jika ada
        if (file_exists($file_foto)) {
            unlink($file_foto);
        }

        // Hapus data dari database
        $hapus = mysqli_query($conn, "DELETE FROM portofolio_perencanaan WHERE id = '$id'");

        if ($hapus) {
            echo "<script>alert('Data berhasil dihapus!'); window.location='bidang_perencanaan.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data dari database!'); window.location='bidang_perencanaan.php';</script>";
        }
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location='bidang_perencanaan.php';</script>";
    }
} else {
    header("Location: bidang_perencanaan.php");
}
?>