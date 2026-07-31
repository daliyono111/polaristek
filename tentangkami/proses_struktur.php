<?php
session_start();
include '../koneksi/koneksi.php';

// Pastikan hanya admin yang bisa mengakses skrip proses ini[cite: 6]
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: struktur_organisasi.php");
    exit;
}

$aksi = $_GET['aksi'] ?? '';

// Fungsi helper untuk menangani proses upload file gambar
function uploadFoto() {
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    // Cek apakah ada file yang di-upload
    if ($error === 4) {
        return null; // Tidak ada file baru yang dipilih
    }

    // Validasi ekstensi file yang diperbolehkan
    $ekstensiValid = ['jpg', 'jpeg', 'png', 'webp', 'JPG', 'JPEG', 'PNG'];
    $ekstensiFile = explode('.', $namaFile);
    $ekstensiFile = strtolower(end($ekstensiFile));

    if (!in_array($ekstensiFile, $ekstensiValid)) {
        echo "<script>alert('Format file tidak didukung! Harap upload file gambar (JPG, JPEG, PNG, WEBP).'); window.location='struktur_organisasi.php';</script>";
        exit;
    }

    // Batasi ukuran file (maksimal 2MB)
    if ($ukuranFile > 2000000) {
        echo "<script>alert('Ukuran gambar terlalu besar! Maksimal 2MB.'); window.location='struktur_organisasi.php';</script>";
        exit;
    }

    // Generate nama file baru yang unik untuk menghindari tabrakan nama file
    $namaFileBaru = uniqid() . '.' . $ekstensiFile;
    
    // Karena file proses ini berada di dalam folder 'tentangkami/', path tujuan naik satu tingkat ke '../img/'
    if (move_uploaded_file($tmpName, '../img/' . $namaFileBaru)) {
        return $namaFileBaru;
    } else {
        return false;
    }
}

if ($aksi == 'tambah') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']); // Ditangkap dengan benar[cite: 6]

    // Panggil fungsi upload foto
    $foto = uploadFoto();
    if (!$foto) {
        $foto = ""; // Jika kosong
    }

    $query = "INSERT INTO struktur_organisasi (nama, jabatan, foto, deskripsi) VALUES ('$nama', '$jabatan', '$foto', '$deskripsi')";
    if (mysqli_query($conn, $query)) {
        header("Location: struktur_organisasi.php?pesan=sukses_tambah");
    } else {
        echo "Gagal menambah data: " . mysqli_error($conn);
    }
} 
elseif ($aksi == 'edit') {
    $id = $_POST['id'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']); // Ditangkap dengan benar[cite: 6]
    $fotoLama = $_POST['foto_lama'];

    // Cek apakah admin mengupload foto baru
    $fotoBaru = uploadFoto();
    
    if ($fotoBaru === null) {
        // Jika tidak upload foto baru, gunakan foto lama
        $fotoKeluaran = $fotoLama;
    } else {
        // Jika ada foto baru, hapus foto lama dari folder fisik (jika ada)
        if (!empty($fotoLama) && file_exists('../img/' . $fotoLama)) {
            @unlink('../img/' . $fotoLama);
        }
        $fotoKeluaran = $fotoBaru;
    }

    $query = "UPDATE struktur_organisasi SET nama='$nama', jabatan='$jabatan', foto='$fotoKeluaran', deskripsi='$deskripsi' WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: struktur_organisasi.php?pesan=sukses_edit");
    } else {
        echo "Gagal mengedit data: " . mysqli_error($conn);
    }
} 
elseif ($aksi == 'hapus') {
    $id = $_GET['id'];

    // Ambil data nama file foto terlebih dahulu untuk dihapus file fisiknya
    $data = mysqli_query($conn, "SELECT foto FROM struktur_organisasi WHERE id='$id'");
    $row = mysqli_fetch_assoc($data);
    
    if ($row && !empty($row['foto'])) {
        $fileFoto = '../img/' . $row['foto'];
        if (file_exists($fileFoto)) {
            @unlink($fileFoto); // Hapus file fisik gambar dari folder
        }
    }

    $query = "DELETE FROM struktur_organisasi WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: struktur_organisasi.php?pesan=sukses_hapus");
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
}
else {
    header("Location: struktur_organisasi.php");
}
?>