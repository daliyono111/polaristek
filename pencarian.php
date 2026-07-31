<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'koneksi/koneksi.php';

$keyword = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian - PT. POLARISTEK ADHI PERSADA</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .card-result { border: none; transition: 0.3s; border-left: 4px solid #ffc107; }
        .card-result:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .img-result { width: 100px; height: 75px; object-fit: cover; border-radius: 6px; }
        .video-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 6px; background: #000; }
        .video-container iframe, .video-container video { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
    </style>
</head>
<body>

<!-- Memanggil Navbar Global -->
<?php include 'koneksi/navbar.php'; ?>

<div class="container my-5" style="padding-top: 70px;">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Hasil Pencarian untuk: "<span class="text-warning"><?= htmlspecialchars($keyword); ?></span>"</h2>
            <hr>
        </div>
    </div>

    <?php 
    if (!empty($keyword)) {
        $semua_hasil = [];

        // Daftar seluruh tabel di database (tabel video yang sebelumnya error sudah dihapus/disesuaikan)
        $tabel_list = [
            'portofolio_perencanaan' => 'Portofolio Perencanaan',
            'portofolio_pengawasan' => 'Portofolio Pengawasan',
            'portofolio_manajemen' => 'Portofolio Manajemen',
            'testimoni' => 'Testimoni',
            'tentang_kami' => 'Tentang Kami',
            'struktur_organisasi' => 'Struktur Organisasi',
            'profil_perusahaan' => 'Profil Perusahaan',
            'legalitas' => 'Legalitas / Kantor',
            'kontak_kami' => 'Kontak Kami',
            'keunggulan_perusahaan' => 'Keunggulan Perusahaan'
        ];

        foreach ($tabel_list as $tabel => $sumberNama) {
            $cek_kolom = @mysqli_query($conn, "SHOW COLUMNS FROM `$tabel`");
            if ($cek_kolom) {
                $kolom_tersedia = [];
                while($col = mysqli_fetch_assoc($cek_kolom)) {
                    $kolom_tersedia[] = $col['Field'];
                }

                $where_clauses = [];
                foreach ($kolom_tersedia as $kol) {
                    if (!in_array($kol, ['id', 'foto', 'gambar', 'gambar_profil', 'file', 'video', 'embed_video', 'link', 'tanggal_input'])) {
                        $where_clauses[] = "`$kol` LIKE '%$keyword%'";
                    }
                }

                if (!empty($where_clauses)) {
                    $sql = "SELECT *, '$sumberNama' AS sumber_tabel FROM `$tabel` WHERE " . implode(' OR ', $where_clauses);
                    $result = @mysqli_query($conn, $sql);
                    if ($result) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $row['available_columns'] = $kolom_tersedia;
                            $semua_hasil[] = $row;
                        }
                    }
                }
            }
        }

        if (count($semua_hasil) > 0) {
            echo '<p class="text-muted mb-4">Ditemukan <b>' . count($semua_hasil) . '</b> hasil kecocokan data dari seluruh bagian website.</p>';
            
            echo '<div class="row g-4">';
            foreach ($semua_hasil as $data) {
                $cols = $data['available_columns'];

                $judul = 'Hasil Data';
                foreach (['nama_proyek', 'judul', 'judul_profil', 'nama', 'nama_kantor', 'subjek'] as $c) {
                    if (in_array($c, $cols) && !empty($data[$c])) {
                        $judul = $data[$c];
                        break;
                    }
                }

                $deskripsi = '';
                foreach (['deskripsi', 'detail', 'uraian', 'deskripsi_profil', 'isi_testimoni', 'pesan', 'alamat'] as $c) {
                    if (in_array($c, $cols) && !empty($data[$c])) {
                        $deskripsi = $data[$c];
                        break;
                    }
                }

                $kategori = (in_array('kategori', $cols) && !empty($data['kategori'])) ? $data['kategori'] : '';
                $tanggal = (in_array('tanggal_input', $cols) && !empty($data['tanggal_input'])) ? $data['tanggal_input'] : '';

                $foto = '';
                foreach (['foto', 'gambar', 'gambar_profil'] as $c) {
                    if (in_array($c, $cols) && !empty($data[$c])) {
                        $foto = $data[$c];
                        break;
                    }
                }

                // Deteksi kolom embed_video khusus untuk testimoni atau tabel lain yang memilikinya
                $embed_video = (in_array('embed_video', $cols) && !empty($data['embed_video'])) ? $data['embed_video'] : '';
                ?>
                <div class="col-12">
                    <div class="card card-result shadow-sm p-3 bg-white">
                        <div class="row align-items-center">
                            
                            <?php if (!empty($foto)): ?>
                                <div class="col-md-2 text-center mb-3 mb-md-0">
                                    <img src="img/<?= htmlspecialchars($foto); ?>" alt="Media" class="img-result shadow-sm" onerror="this.style.display='none'">
                                </div>
                                <div class="col-md-10">
                            <?php elseif (!empty($embed_video)): ?>
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <div class="video-container shadow-sm">
                                        <!-- Menampilkan elemen iframe atau video dari kolom embed_video -->
                                        <?= $embed_video; ?>
                                    </div>
                                </div>
                                <div class="col-md-8">
                            <?php else: ?>
                                <div class="col-12">
                            <?php endif; ?>

                                <span class="badge bg-dark mb-2"><?= htmlspecialchars($data['sumber_tabel']); ?></span>
                                <?php if (!empty($kategori)): ?>
                                    <span class="badge bg-warning text-dark mb-2"><?= htmlspecialchars($kategori); ?></span>
                                <?php endif; ?>

                                <h4 class="fw-bold text-dark mb-2"><?= htmlspecialchars($judul); ?></h4>
                                
                                <?php if (!empty($deskripsi)): ?>
                                    <p class="text-muted mb-2" style="line-height: 1.6;">
                                        <?= htmlspecialchars(substr($deskripsi, 0, 250)); ?><?php if(strlen($deskripsi) > 250) echo '...'; ?>
                                    </p>
                                <?php endif; ?>

                                <?php if (!empty($tanggal)): ?>
                                    <small class="text-muted d-block mt-2">
                                        <i class="far fa-calendar-alt me-1"></i> Ditambahkan pada: <?= htmlspecialchars($tanggal); ?>
                                    </small>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            echo '</div>';
        } else {
            echo '<div class="alert alert-warning text-center py-5">
                    <i class="fas fa-exclamation-circle fa-2x mb-3"></i>
                    <h5>Maaf, data dengan kata kunci "<strong>' . htmlspecialchars($keyword) . '</strong>" tidak ditemukan di seluruh tabel database.</h5>
                  </div>';
        }
    } else {
        echo '<div class="alert alert-info text-center py-4">Silakan masukkan kata kunci pada kolom pencarian di atas.</div>';
    }
    ?>
</div>

<!-- Memanggil Footer Global -->
<?php include 'koneksi/footer.php'; ?>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>