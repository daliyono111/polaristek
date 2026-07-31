<?php
session_start();
include '../koneksi/koneksi.php';

$aksi = $_GET['aksi'] ?? '';

if ($aksi == 'tambah') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subjek = mysqli_real_escape_string($conn, $_POST['subjek']);
    $pesan = mysqli_real_escape_string($conn, $_POST['pesan']);

    $query = "INSERT INTO kontak_kami (nama, email, subjek, pesan, status_pesan) VALUES ('$nama', '$email', '$subjek', '$pesan', 'Belum Dibalas')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Pesan Anda berhasil dikirim!'); window.location='kontak.php';</script>";
    } else {
        echo "Gagal mengirim pesan: " . mysqli_error($conn);
    }
} 
elseif ($aksi == 'balas') {
    // Admin membalas pesan
    if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
        header("Location: kontak.php");
        exit;
    }

    $id = $_POST['id'];
    $balasan = mysqli_real_escape_string($conn, $_POST['balasan']);
    $email_tujuan = $_POST['email_tujuan'];
    $nama_tujuan = $_POST['nama_tujuan'] ?? 'Pelanggan';

    // 1. Update status dan balasan ke database
    $query = "UPDATE kontak_kami SET balasan='$balasan', status_pesan='Sudah Dibalas' WHERE id='$id'";
    
    if (mysqli_query($conn, $query)) {
        // 2. Kirim Email ke Pengunjung menggunakan fungsi mail() PHP
        $pengirim_email = "admin@polaristek.co.id"; // Sesuaikan dengan email domain Anda
        $subjek_email = "Balasan Pesan dari PT. POLARISTEK ADHI PERSADA";
        
        $pesan_email = "Halo " . htmlspecialchars($nama_tujuan) . ",\n\n";
        $pesan_email .= "Terima kasih telah menghubungi PT. POLARISTEK ADHI PERSADA. Berikut adalah balasan dari admin kami:\n\n";
        $pesan_email .= "--------------------------------------------------\n";
        $pesan_email .= $balasan . "\n";
        $pesan_email .= "--------------------------------------------------\n\n";
        $pesan_email .= "Pesan ini dikirim otomatis oleh sistem.\n";

        $headers = "From: PT. POLARISTEK ADHI PERSADA <" . $pengirim_email . ">\r\n";
        $headers .= "Reply-To: " . $pengirim_email . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        // Eksekusi pengiriman email
        @mail($email_tujuan, $subjek_email, $pesan_email, $headers);

        echo "<script>
            alert('Balasan berhasil disimpan dan dikirim ke email pengunjung!');
            window.location='kontak.php';
        </script>";
    } else {
        echo "Gagal menyimpan balasan: " . mysqli_error($conn);
    }
} 
elseif ($aksi == 'hapus') {
    if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
        header("Location: kontak.php");
        exit;
    }

    $id = $_GET['id'];
    $query = "DELETE FROM kontak_kami WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: kontak.php?status=sukses_hapus");
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
} 
else {
    header("Location: kontak.php");
}
?>