<?php
// Memanggil koneksi database
include '../koneksi/koneksi.php';

// Cek apakah parameter ID tersedia di URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Ambil nama file foto terlebih dahulu dari database untuk dihapus dari folder img
    $query_cek = "SELECT foto FROM portofolio_pengawasan WHERE id = '$id'";
    $result_cek = mysqli_query($conn, $query_cek);

    if (mysqli_num_rows($result_cek) > 0) {
        $data = mysqli_fetch_assoc($result_cek);
        $foto = $data['foto'];

        // Hapus file fisik foto dari folder img jika filenya ada
        if (!empty($foto) && file_exists('../img/' . $foto)) {
            unlink('../img/' . $foto);
        }

        // Hapus data dari tabel database
        $query_hapus = "DELETE FROM portofolio_pengawasan WHERE id = '$id'";
        $result_hapus = mysqli_query($conn, $query_hapus);

        if ($result_hapus) {
            header("Location: bidang_pengawasan.php?pesan=sukses_hapus");
            exit();
        } else {
            echo "Gagal menghapus data: " . mysqli_error($conn);
        }
    } else {
        header("Location: bidang_pengawasan.php");
        exit();
    }
} else {
    header("Location: bidang_pengawasan.php");
    exit();
}
?>