<?php
session_start();
if (isset($_SESSION['status_login']) && $_SESSION['status_login'] == true) {
    header("Location: ../portofolio/bidang_perencanaan.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator - PT. POLARISTEK ADHI PERSADA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-dark d-flex align-items-center justify-content-center" style="height: 100vh;">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-sm-5">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-dark">ADMIN LOGIN</h3>
                        <p class="text-muted small">PT. POLARISTEK ADHI PERSADA</p>
                    </div>

                    <form action="proses_login.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label fw-semibold small">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required autocomplete="off">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold small">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                                <!-- Input password dengan ID pendukung -->
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                                <!-- Tombol Toggle Password -->
                                <span class="input-group-text bg-light" id="toggle-password" style="cursor: pointer;" title="Sembunyikan/Tampilkan Password">
                                    <i class="fas fa-eye text-muted" id="icon-toggle"></i>
                                </span>
                            </div>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" name="login" class="btn btn-warning fw-bold text-dark py-2">MASUK</button>
                        </div>
                        <div class="text-center">
                            <a href="../portofolio/bidang_perencanaan.php" class="text-decoration-none small text-muted"><i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda Portofolio</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script JavaScript untuk Toggle Lihat/Sembunyikan Password -->
<script>
    const togglePassword = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password');
    const iconToggle = document.getElementById('icon-toggle');

    togglePassword.addEventListener('click', function () {
        // Ubah tipe atribut input dari password ke text, atau sebaliknya
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Ubah ikon mata (fa-eye menjadi fa-eye-slash)
        if (type === 'password') {
            iconToggle.classList.remove('fa-eye-slash');
            iconToggle.classList.add('fa-eye');
        } else {
            iconToggle.classList.remove('fa-eye');
            iconToggle.classList.add('fa-eye-slash');
        }
    });
</script>

</body>
</html>