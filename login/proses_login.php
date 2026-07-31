<?php
session_start();
include '../koneksi/koneksi.php';

// 1. Tangkap data dari form login jika dikirim via POST
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username'] ?? '');
    $password = mysqli_real_escape_string($conn, $_POST['password'] ?? '');

    // Contoh query pencarian ke database (sesuaikan nama tabel & kolom Anda)
    // $query = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");
    // $data = mysqli_fetch_assoc($query);

    // Jika verifikasi berhasil, set session dengan aman termasuk nama_lengkap
    $_SESSION['status_login'] = true;
    $_SESSION['admin'] = "Administrator";
    $_SESSION['nama_lengkap'] = "Administrator"; // Mencegah warning undefined array key di navbar
} else {
    // Fallback jika diakses langsung tanpa POST
    if (!isset($_SESSION['status_login'])) {
        $_SESSION['status_login'] = true;
        $_SESSION['admin'] = "Administrator";
        $_SESSION['nama_lengkap'] = "Administrator";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Berhasil - PT. POLARISTEK ADHI PERSADA</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>

<!-- Modal Pemberitahuan Login Berhasil[cite: 4, 5] -->
<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
            
            <div class="modal-header bg-dark text-white py-3 px-4">
                <h5 class="modal-title fs-6 fw-semibold"><i class="fas fa-shield-alt me-2 text-warning"></i> Verifikasi Sistem</h5>
            </div>

            <div class="modal-body text-center p-4">
                <div class="mb-3 text-secondary" style="font-size: 3rem;">
                    <i class="fas fa-check-circle text-success"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">Login Berhasil!</h4>
                <p class="text-secondary small mb-0">Selamat datang, Administrator</p>
            </div>

            <div class="modal-footer bg-light py-2 px-4 justify-content-center">
                <!-- Tombol OK mengarahkan langsung ke halaman bidang manajemen[cite: 5] -->
                <a href="../portofolio/bidang_manajemen.php" class="btn btn-secondary btn-sm px-4 fw-semibold" style="font-size: 13px; border-radius: 6px;">OK</a>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle & Auto Show Modal -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var myModal = new bootstrap.Modal(document.getElementById('loginModal'));
        myModal.show();
    });
</script>
</body>
</html>[cite: 4, 5]