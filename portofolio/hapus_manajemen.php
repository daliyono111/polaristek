<?php 
// 0. Mulai Session untuk mendeteksi status login admin
session_start();

// Jika belum login, alihkan ke halaman bidang manajemen
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    header("Location: bidang_manajemen.php");
    exit();
}

// 1. Memanggil koneksi database
include '../koneksi/koneksi.php';

// Cek apakah parameter ID ada di URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Ambil data file foto sebelum dihapus dari database
    $query_old = mysqli_query($conn, "SELECT foto FROM portofolio_manajemen WHERE id = '$id'");
    $data = mysqli_fetch_assoc($query_old);

    if ($data) {
        $foto = $data['foto'];
        
        // Hapus file fisik gambar dari folder penyimpanan jika ada
        if (!empty($foto) && file_exists('../img/' . $foto)) {
            unlink('../img/' . $foto);
        }

        // Hapus data dari database
        $query_delete = mysqli_query($conn, "DELETE FROM portofolio_manajemen WHERE id = '$id'");

        if ($query_delete) {
            header("Location: bidang_manajemen.php?pesan=sukses_hapus");
            exit();
        } else {
            echo "<script>alert('Gagal menghapus data dari database!'); window.location='bidang_manajemen.php';</script>";
        }
    } else {
        header("Location: bidang_manajemen.php");
        exit();
    }
} else {
    header("Location: bidang_manajemen.php");
    exit();
}
?>