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

// Hapus file fisik gambar
if (file_exists('../img/' . $slide['gambar'])) {
    unlink('../img/' . $slide['gambar']);
}

// Hapus dari database
$query = mysqli_query($conn, "DELETE FROM slider_banner WHERE id = '$id'");
if ($query) {
    echo "<script>alert('Slider berhasil dihapus!'); window.location='../index.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus slider.'); window.location='../index.php';</script>";
}
?>