-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Jul 2026 pada 18.10
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `company_profile_polaristek`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'admin', '$2y$10$kS2zAY3IwaOqMv/3E5VDO.qd9JoYK0kV.6Z3wp.NjViGBb544kbXG', 'Administrator');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keunggulan_perusahaan`
--

CREATE TABLE `keunggulan_perusahaan` (
  `id` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `keunggulan_perusahaan`
--

INSERT INTO `keunggulan_perusahaan` (`id`, `icon`, `judul`, `deskripsi`) VALUES
(1, 'fa-award', 'Berpengalaman', 'Didukung oleh tim tenaga ahli yang berpengalaman di bidangnya masing-masing.'),
(2, 'fa-shield-alt', 'Legalitas Terjamin', 'Memiliki perizinan lengkap dan sah sesuai dengan peraturan perundang-undangan yang telah ditentukan.'),
(3, 'fa-clock', 'Tepat Waktu', 'Komitmen tinggi dalam menyelesaikan setiap proyek sesuai dengan jadwal yang disepakati.'),
(4, 'fa-handshake', 'Harga Kompetitif', 'Memberikan penawaran harga terbaik dengan tetap menjaga kualitas hasil pekerjaan.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kontak_kami`
--

CREATE TABLE `kontak_kami` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subjek` varchar(150) NOT NULL,
  `pesan` text NOT NULL,
  `balasan` text DEFAULT NULL,
  `status_pesan` varchar(20) DEFAULT 'Belum Dibalas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kontak_kami`
--

INSERT INTO `kontak_kami` (`id`, `nama`, `email`, `subjek`, `pesan`, `balasan`, `status_pesan`) VALUES
(1, 'Firman', 'firman@gmail.com', 'Ingin pemakai jasa perusahaan anda', 'Rencana saya mau membangun rumah jadi saya mau menggunakan jasa perusahaan ada untuk mendisainnya', NULL, 'Belum Dibalas'),
(3, 'daliyono', 'dayono111@gmail.com', 'Ingin pemakai jasa perusahaan anda', 'Mendisain Rumah saya', NULL, 'Belum Dibalas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `legalitas`
--

CREATE TABLE `legalitas` (
  `id` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `detail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `legalitas`
--

INSERT INTO `legalitas` (`id`, `icon`, `kategori`, `judul`, `detail`) VALUES
(1, 'fa-file-contract', 'Akta Pendirian', 'Akta Notaris Pendirian Badan Usaha', 'Disahkan oleh Notaris setempat dengan nomor SK Kemenkumham RI tentang pengesahan badan usaha.'),
(2, 'fa-building', 'Perizinan Berusaha', 'Nomor Induk Berusaha (NIB)', 'Terdaftar melalui sistem OSS (Online Single Submission) dengan KBLI bidang jasa konsultansi teknik.'),
(3, 'fa-certificate', 'Sertifikasi', 'Sertifikat Badan Usaha (SBU)', 'SBU Perencanaan dan Pengawasan Konstruksi yang diterbitkan oleh lembaga berwenang.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lokasi_kantor`
--

CREATE TABLE `lokasi_kantor` (
  `id` int(11) NOT NULL,
  `nama_kantor` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `embed_map` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lokasi_kantor`
--

INSERT INTO `lokasi_kantor` (`id`, `nama_kantor`, `alamat`, `telepon`, `email`, `embed_map`) VALUES
(1, 'PT. POLARISTEK ADHI PERSADA', 'Jl. Sanggiringan III No.28 Komp.CRE Banjarbaru Kalimantan Selatan', '0511- 4774695', 'polaristek02@gmail.com', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.564261826924!2d114.8448372!3d-3.4555518999999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de6810058693541%3A0xe1ca776a72b29df8!2skantor!5e0!3m2!1sid!2sid!4v1785378412114!5m2!1sid!2sid\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"strict-origin-when-cross-origin\"></iframe>');

-- --------------------------------------------------------

--
-- Struktur dari tabel `page_banners`
--

CREATE TABLE `page_banners` (
  `id` int(11) NOT NULL,
  `page_name` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `subtitle` text DEFAULT NULL,
  `background_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `page_banners`
--

INSERT INTO `page_banners` (`id`, `page_name`, `title`, `subtitle`, `background_image`) VALUES
(1, 'profil_perusahaan', 'TENTANG KAMI', 'Mengenal lebih dekat profil, visi, misi, dan komitmen profesionalisme kami.', 'bg_profil_1785424032.png'),
(2, 'bidang_perencanaan', 'BIDANG PERENCANAAN', 'Eksplorasi hasil karya perancangan profesional kami.', 'bg_perencanaan_1785427091.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `page_banner_perencanaan`
--

CREATE TABLE `page_banner_perencanaan` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` text NOT NULL,
  `background_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `page_banner_perencanaan`
--

INSERT INTO `page_banner_perencanaan` (`id`, `title`, `subtitle`, `background_image`) VALUES
(1, 'BIDANG PERENCANAAN', 'Perencanaan tanpa tindakan adalah sia-sia; tindakan tanpa perencanaan adalah Bayangan', 'bg_perencanaan_1785427435.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `portofolio`
--

CREATE TABLE `portofolio` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `portofolio_manajemen`
--

CREATE TABLE `portofolio_manajemen` (
  `id` int(11) NOT NULL,
  `nama_proyek` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `foto2` varchar(255) DEFAULT NULL,
  `foto3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `portofolio_manajemen`
--

INSERT INTO `portofolio_manajemen` (`id`, `nama_proyek`, `kategori`, `deskripsi`, `foto`, `foto2`, `foto3`) VALUES
(1, 'Jasa Konsultansi Manajemen Konstruksi Pembangunaan Gedung Lembaga Pemasyarakatan Kabupaten Tanah Bumbu Tahun 2017', 'Gedung', 'Tujuan utama dari Jasa Konsultansi Manajemen Konstruksi (MK) pada proyek ini adalah mengendalikan dan mengawasi jalannya pembangunan Lapas agar tepat mutu, tepat waktu, tepat biaya, dan tertib administrasi.Secara khusus, proyek ini sangat krusial karena pembangunan fisik Lapas Batulicin di Kabupaten Tanah Bumbu bertujuan untuk mengatasi masalah kelebihan kapasitas ekstrem di Lapas Kelas IIB Kotabaru', 'manajemen_6a68d5e3a7c26.jpg', NULL, NULL),
(2, 'Jasa Konsultan Perencana Penataan Area Dan Fasilitas Infrastruktur (Overpass Pasar Panas Dan 3 Jembatan) Tahun 2025', 'Gedung', 'dfdfdfdfd', 'manajemen_6a6ae6ec1a979.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `portofolio_pengawasan`
--

CREATE TABLE `portofolio_pengawasan` (
  `id` int(11) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `nama_proyek` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `foto2` varchar(255) DEFAULT NULL,
  `foto3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `portofolio_pengawasan`
--

INSERT INTO `portofolio_pengawasan` (`id`, `kategori`, `nama_proyek`, `deskripsi`, `foto`, `foto2`, `foto3`) VALUES
(2, 'Gedung', 'Pengawasan Pembangunan Gedung Kantor PT.Bank Pembangunan Daerah Kalimantan Selatan Cabang Rantau. Tahun 2014', 'Tujuan pengawasan pembangunan Gedung Kantor PT Bank Pembangunan Daerah Kalimantan Selatan (Bank Kalsel) Cabang Rantau adalah untuk memastikan kualitas fisik bangunan sesuai standar, mengendalikan anggaran serta waktu pelaksanaan, dan menjamin fungsi operasional bank berjalan optimal', '6a68d10140324-21.JPG', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `portofolio_perencanaan`
--

CREATE TABLE `portofolio_perencanaan` (
  `id` int(11) NOT NULL,
  `kategori` enum('Gedung','Jalan dan Jembatan','Tata Lingkungan') NOT NULL,
  `nama_proyek` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `foto2` varchar(255) DEFAULT NULL,
  `foto3` varchar(255) DEFAULT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `portofolio_perencanaan`
--

INSERT INTO `portofolio_perencanaan` (`id`, `kategori`, `nama_proyek`, `deskripsi`, `foto`, `foto2`, `foto3`, `tanggal_input`) VALUES
(3, 'Jalan dan Jembatan', 'Perencanaan Pembangunan Jembatan Paket IV', 'Pekerjaan Perencanaan Pembangunan Jembatan Paket IV tujuannya adalah supaya untuk mempermudah akses jalan menuju antar desa sekitar  dan masyarakat sekitar kususnya supaya roda ekonomi masyarat sekitar lebih mudah di capai.', '6a6896154b7d1-1.JPG', NULL, NULL, '2026-07-28 11:44:21'),
(4, 'Jalan dan Jembatan', 'Perencanaan Site Development Kantor Sekretariat Daerah / Gubernur Prov. Kalsel', 'Tujuan utama Perencanaan Site Development Kantor Sekretariat Daerah / Gubernur Provinsi Kalimantan Selatan adalah untuk menyusun rencana tata letak kawasan perkantoran yang terintegrasi, fungsional, aman, dan laik fungsi guna mendukung kelancaran tata kelola pemerintahan pelayanan publik', '6a6896c5a82d9-2.JPG', NULL, NULL, '2026-07-28 11:47:17'),
(6, 'Gedung', ' Pekerjaan Re-Design Pembangunan Gedung Utama RSUD Banjarmasin Tahun 2018', 'Tujuan pekerjaan penataan ulang rancangan atau re-design pembangunan gedung fasilitas kesehatan adalah meningkatkan mutu layanan medis, menyesuaikan kapasitas ruang dengan kebutuhan teknologi modern, serta mengoptimalkan fungsi dan keamanan bangunan', '6a68997ac0504-4.JPG', NULL, NULL, '2026-07-28 11:58:50'),
(7, 'Gedung', 'Perencanaan Pembangunan Asrama Mahasiswa/wi Universitas Lambung Mangkurat Tahun 2018', 'Tujuan pembangunan dan renovasi asrama mahasiswa Universitas Lambung Mangkurat (ULM) oleh PT Adaro Energy Tbk adalah menyediakan tempat tinggal gratis, membentuk karakter kepemimpinan, serta meringankan beban biaya hidup mahasiswa penerima beasiswa Adaro Bright Future Leader (IBFL)', '6a689a0c90d0c-5.JPG', NULL, NULL, '2026-07-28 12:01:16'),
(8, 'Gedung', 'Rehabilitasi Teknis Pasar Murataka BarabaiKabupaten Hulu Sungai Tengah Tahun 2017', 'Tujuan rehabilitasi dan penataan ulang area Pasar Murakata Barabai oleh Dinas Perdagangan Kabupaten Hulu Sungai Tengah adalah untuk memfungsikan kembali bangunan yang terbengkalai, meningkatkan pendapatan asli daerah, serta menyediakan fasilitas publik yang aman.', '6a689b0f5ae7a-6.JPG', NULL, NULL, '2026-07-28 12:05:35'),
(9, 'Gedung', 'Konsultan Perencanaan Rehabilitasi Gedung Poliklinik/eks IGD', 'Tujuan diadakannya konsultan perencanaan rehabilitasi Gedung Poliklinik/eks IGD di RSUD Brigjend H. Hasan Basry Kandangan adalah untuk menyusun dokumen desain teknis, menghitung Rencana Anggaran Biaya (RAB), serta menyiapkan spesifikasi teknis secara profesional sebelum pekerjaan fisik rehabilitasi dimulai', '6a689ba8d78c0-7.JPG', NULL, NULL, '2026-07-28 12:08:08'),
(10, 'Gedung', 'Perencanaan Pembangunan Dermaga Belangian Tahun 2018', 'Tujuan utama dari Perencanaan Pembangunan Dermaga Belangian oleh Sarana dan Prasarana (Sarpras) Dinas Kehutanan Provinsi Kalimantan Selatan adalah menyediakan infrastruktur penunjang utama guna mengembangkan kawasan Geopark Meratus, khususnya destinasi Ekowisata Puncak Kahung dan Desa Wisata Belangian.', '6a689c7f9e1bc-8.JPG', NULL, NULL, '2026-07-28 12:11:43'),
(11, 'Gedung', 'Perencanaan Area Terminal VIP Bandara Tjilik Riwut Palangkaraya ', 'Tujuan perencanaan area terminal VIP di Bandar Udara Tjilik Riwut Palangka Raya adalah untuk menyediakan fasilitas khusus bagi pejabat negara atau daerah, meningkatkan standar pelayanan, serta menjamin kelancaran dan keamanan protokoler kedatangan maupun keberangkatan', '6a689d425a2ac-9.JPG', NULL, NULL, '2026-07-28 12:14:58'),
(12, 'Gedung', 'Pembangunan Sarana dan Prasarana Pendukung Mesjid Al Jihad (Review Design)  Tahun 2022', 'Tujuan utama dari kegiatan Pembangunan Sarana dan Prasarana Pendukung Masjid Al Jihad (Review Design) Tahun 2022 yang diadakan oleh Bidang Cipta Karya Dinas Pekerjaan Umum dan Penataan Ruang (PUPR) Provinsi Kalimantan Selatan adalah meninjau kembali, memperbarui, dan menyempurnakan dokumen perencanaan teknis/desain arsitektur agar pembangunan fasilitas pendukung fisik Masjid Al Jihad berjalan secara tepat mutu, tepat fungsi, aman, dan sesuai dengan kebutuhan riil jemaah di lapangan', '6a689e1d225e9-10.JPG', NULL, NULL, '2026-07-28 12:18:37'),
(13, 'Gedung', 'Perencanaan Pembangunan Kantor BIN Daerah Kalsel  Tahun 2022', 'Tujuan perencanaan dan pembangunan Gedung Markas Komando Badan Intelijen Negara Daerah (BINDA) Kalimantan Selatan oleh Dinas Pekerjaan Umum dan Penataan Ruang (PUPR) melalui Bidang Cipta Karya adalah memberikan bentuk apresiasi serta dukungan kepada instansi vertikal pemerintah, memperkuat sinergi antarpemangku kepentingan, dan meningkatkan efektivitas tugas pengamanan daerah', '6a689e930e037-11.JPG', NULL, NULL, '2026-07-28 12:20:35'),
(14, 'Gedung', 'Perencanaan Pembangunan Gedung Majelis Ulama Indonesia Kab. Tapin ', 'Tujuan perencanaan pembangunan gedung Majelis Ulama Indonesia (MUI) Kabupaten Tapin oleh Bidang Cipta Karya Dinas Pekerjaan Umum dan Penataan Ruang (PUPR) adalah untuk menyediakan fasilitas kantor yang representatif, meningkatkan kualitas pelayanan keagamaan kepada masyarakat, serta memperkuat sinergi antara ulama dan pemerintah daerah di Kabupaten Tapin', '6a689f3d7e400-12.JPG', NULL, NULL, '2026-07-28 12:23:25'),
(15, 'Gedung', 'Perencanaan Pembangunan Gedung Majelis Ulama Indonesia Kab. Tapin Tahun 2022', 'Tujuan perencanaan pembangunan gedung Majelis Ulama Indonesia (MUI) Kabupaten Tapin oleh Bidang Cipta Karya Dinas Pekerjaan Umum dan Penataan Ruang (PUPR) adalah untuk menyediakan fasilitas kantor yang representatif, meningkatkan kualitas pelayanan keagamaan kepada masyarakat, serta memperkuat sinergi antara ulama dan pemerintah daerah di Kabupaten Tapin', '6a689fa531d73-13.JPG', NULL, NULL, '2026-07-28 12:25:09'),
(16, 'Gedung', 'Review Desain Pembangunan Masjid RSUD  Kab. Tapin  Tahun 2022', 'Tujuan utama dari Review Desain Pembangunan Masjid RSUD Kab. Tapin oleh Dinas Pekerjaan Umum Bidang Cipta Karya adalah untuk memastikan dokumen perencanaan teknis (DED) telah memenuhi standar keandalan bangunan gedung Pemerintah, aman secara struktur, efisien secara anggaran, serta fungsional untuk melayani pasien, pengunjung, dan civitas hospitalia sambil beribadah ke agamaan ketika Jam Waktunya', '6a68a07d2acb2-14.JPG', NULL, NULL, '2026-07-28 12:28:45'),
(17, 'Gedung', 'DED Bangunan Kantor PMD Perencanaan dan Disain Teknis Pembangunan Kantor Mtn. Sesuai dengan RFQ dan Drawing Tahun 2024', 'Tujuan dari pembangunan atau pengadaan Kantor Mtn. (Maintenance Office) berdasarkan standar umum Request for Quotation (RFQ) dan cetak biru teknis (Drawing) di lingkungan operasional Grup Adaro adalah menyediakan fasilitas pusat kendali operasional, administrasi, dan logistik guna mendukung aktivitas perawatan (maintenance) aset, alat berat, serta infrastruktur tambang secara efektif dan aman', '6a68a3f706948-15.JPG', NULL, NULL, '2026-07-28 12:43:35'),
(18, 'Gedung', 'Perencanaan Pembangunan  Pagar Permanen Poltekes Banjarmasin Tahun 2024', 'Tujuan Perencanaan Pembangunan Pagar Permanen oleh Politeknik Kesehatan Kemenkes Banjarmasin di Banjarbaru adalah untuk penyediaan dan peningkatan prasarana bidang pendidikan tinggi, meningkatkan layanan sarana dan prasarana internal, serta pengamanan dan penataan batas aset fisik kampus', '6a68a4a77553e-16.JPG', NULL, NULL, '2026-07-28 12:46:31'),
(19, 'Gedung', 'Jasa Konsultansi Perencanaan-Jasa Desain Arsitektural Hemodialisis RSUD Datu Sanggul  Tahun 2024', 'Tujuan utama dari pengadaan Jasa Konsultansi Perencanaan-Jasa Desain Arsitektural Hemodialisis RSUD Datu Sanggul oleh Pemerintah Kabupaten Tapin adalah untuk menghasilkan dokumen perencanaan teknis (detail engineering design/DED) yang komprehensif, aman, dan memenuhi standar regulasi kesehatan guna membangun atau merehabilitasi ruang pelayanan cuci darah (hemodialisis) di RSUD Datu Sanggul.', '6a68a52f9112f-17.JPG', NULL, NULL, '2026-07-28 12:48:47'),
(20, 'Gedung', 'Project Jasa Konsultan Pembuatan Detail Engineering Design Mess Non Staff CPBL Kelanis  Tahun 2024', 'Project Jasa Konsultan Pembuatan Detail Engineering Design (DED) Mess Non-Staff yang diadakan oleh PT Adaro adalah Akomodasi non-staff di industri pertambangan umumnya merujuk pada hunian untuk pekerja lapangan atau operasional (seperti operator, mekanik, dan teknisi). Konsultan arsitektur dan teknik sipil bertugas menerjemahkan kebutuhan operasional Adaro ke dalam cetak biru bangunan yang efisien dan aman', '6a68a637bcccd-18.JPG', NULL, NULL, '2026-07-28 12:53:11'),
(21, 'Gedung', 'Jasa Konsultan Perencana Penataan Area Dan Fasilitas Infrastruktur (Overpass Pasar Panas Dan 3 Jembatan) Tahun 2025', 'Tujuan utama dari pengadaan Jasa Konsultan Perencana Penataan Area Dan Fasilitas Infrastruktur (Overpass Pasar Panas Dan 3 Jembatan) yang diadakan oleh PT Adaro Kawasan Pasar Panas (perbatasan Kalimantan Selatan dan Kalimantan Tengah) merupakan titik krusial di mana jalan angkutan logistik Adaro berinteraksi langsung dengan jalan negara. Keberadaan overpass (jembatan layang) dan 3 jembatan ini dirancang untuk memastikan operasional tambang berjalan konstan tanpa mengorbankan keselamatan publik', '6a68a6f47097b-19.JPG', '2_6a6b478ce9e86-24.JPG', '3_6a6b478cea27d-25.JPG', '2026-07-28 12:56:20'),
(22, 'Gedung', 'Jasa Review Masterplan Gedung Utama Poltekkes Kemenkes Banjarmasin TA.2025', 'Secara umum, tujuan utama dari Jasa Review Masterplan Gedung Utama Poltekkes Kemenkes Banjarmasin TA.2025 yang diadakan oleh Poltekkes Banjarmasin adalah untuk menilai, memperbarui, dan menyelaraskan cetak biru pengembangan fisik kampus agar sesuai dengan pertumbuhan akademik terbaru, regulasi tata bangunan terkini, serta standar fasilitas kesehatan modern di Indonesia', '6a68a776e6adc-20.JPG', '2_6a6aea69c590f-29.JPG', '3_6a6aea69c5e84-28.JPG', '2026-07-28 12:58:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_perusahaan`
--

CREATE TABLE `profil_perusahaan` (
  `id` int(11) NOT NULL,
  `badge` varchar(100) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `uraian` text NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `slider_banner`
--

CREATE TABLE `slider_banner` (
  `id` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `deskripsi` text NOT NULL,
  `link_teks` varchar(50) DEFAULT 'Lihat Detail',
  `link_url` varchar(255) DEFAULT '#'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `slider_banner`
--

INSERT INTO `slider_banner` (`id`, `gambar`, `judul`, `deskripsi`, `link_teks`, `link_url`) VALUES
(1, '6a6a9da28f0d8.png', 'Perencanaan & Pengawasan Konstruksi', 'Solusi profesional untuk kebutuhan arsitektur dan pembangunan struktur terbaik', 'Lihat Profil Perusahaan Kami', 'tentangkami/profile_perusahaan.php'),
(2, '6a6b52e89e38a.jpeg', 'Perencanaan Desain Arsitektur Yang Profesional', 'Mentransformasi visi menjadi ruang hidup yang abadi Arsitektur terukur, perencanaan jujur, hasil maksimal', 'Lihat Portofolio Bidang Perencanaan', 'portofolio/bidang_perencanaan.php'),
(3, '6a69c28a9a6c4.jpg', 'Pengawasan Pelaksanaan Supervisi dalam proyek arsitektur dan sipil', 'Mengawal visi desain dari lembar kertas hingga bangunan berdiri kokoh serta transparansi di lapangan, ketepatan waktu, dan efisiensi anggaran', 'Lihat Portofolio Bidang Pengawasan', 'portofolio/bidang_pengawasan.php'),
(4, '6a6b733ad150c.png', 'Manajemen Konstruksi Mencakup Tema Perencanaan dan Pengawasan, Kerja Keras Tim, Serta Keselamatan Kerja', 'Manajemen yang baik mengubah rencana di atas kertas menjadi bangunan yang nyata', 'Lihat Portopolio Manajemen Konstruksi', 'bidang_manajemen');

-- --------------------------------------------------------

--
-- Struktur dari tabel `struktur_organisasi`
--

CREATE TABLE `struktur_organisasi` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `struktur_organisasi`
--

INSERT INTO `struktur_organisasi` (`id`, `nama`, `jabatan`, `deskripsi`, `foto`) VALUES
(10, 'Budi Antara, ST', 'Direktur Utama', 'Bertanggung jawab penuh atas arah kebijakan strategis dan operasional perusahaan secara keseluruhan.', '6a68715775e19-Direktur.JPG'),
(11, 'Putra Wibwo, ST', 'Wakil Direktur', 'membantu Direktur Utama dalam mengelola operasional harian perusahaan atau instansi, serta memimpin jalannya roda organisasi secara keseluruhan saat Direktur Utama berhalangan hadir', '6a69632dd5b3a.jpg'),
(12, 'Appien Taufani, ST', 'Kepala Bidanng Pengawasan', 'Memastikan setiap pelaksanaan konstruksi di lapangan berjalan sesuai spesifikasi teknis dan standar mutu.', '6a68730c764d4-vvvee.JPG'),
(17, 'Nurhandayani Ramli, ST', 'Kepala Bidang Perencanaan', 'Memimpin tim teknis dalam menyusun seluruh dokumen perencanaan, rancangan teknis, anggaran, dan strategi proyek dari tahap awal hingga siap dilelangkan atau dibangun', '6a6963df30a26.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tentang_kami`
--

CREATE TABLE `tentang_kami` (
  `id` int(11) NOT NULL,
  `judul_profil` varchar(255) NOT NULL,
  `deskripsi_profil` text NOT NULL,
  `sejarah` text NOT NULL,
  `visi` text NOT NULL,
  `misi` text NOT NULL,
  `gambar_profil` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tentang_kami`
--

INSERT INTO `tentang_kami` (`id`, `judul_profil`, `deskripsi_profil`, `sejarah`, `visi`, `misi`, `gambar_profil`) VALUES
(1, 'PT. POLARISTEK ADHI PERSADA', 'PT. POLARISTEK ADHI PERSADA adalah badan usaha yang bergerak di bidang layanan jasa konsultansi teknik, perencanaan, dan pengawasan konstruksi yang berkomitmen memberikan hasil karya terbaik dan profesional.', 'Berdiri sejak tahun profesional, PT. POLARISTEK ADHI PERSADA telah menangani berbagai proyek perencanaan gedung, jalan, dan tata lingkungan baik instansi swasta maupun pemerintah.', 'Menjadi konsultan perencana dan pengawas konstruksi yang terpercaya, profesional, serta diandalkan di Indonesia.', '1. Memberikan pelayanan jasa konsultansi yang bermutu tinggi dan tepat waktu.\r\n2. Mengutamakan keselamatan, efisiensi, serta estetika dalam setiap perancangan.\r\n3. Mengembangkan sumber daya manusia yang kompeten dan berintegritas.', 'profil_1785326179.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `testimoni`
--

CREATE TABLE `testimoni` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `jabatan` varchar(150) NOT NULL,
  `jenis` enum('teks','video') NOT NULL DEFAULT 'teks',
  `isi_testimoni` text NOT NULL,
  `embed_video` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `testimoni`
--

INSERT INTO `testimoni` (`id`, `nama`, `jabatan`, `jenis`, `isi_testimoni`, `embed_video`, `foto`) VALUES
(1, 'Firmansyah', 'Karyawan ', 'video', 'Saya sangat senang dan puas menggunakan jasa PT.Polaristek Adhi Persada ', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/OdifSe1cLwc?si=4TvVX8JZbGc71Yld\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `keunggulan_perusahaan`
--
ALTER TABLE `keunggulan_perusahaan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kontak_kami`
--
ALTER TABLE `kontak_kami`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `legalitas`
--
ALTER TABLE `legalitas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `lokasi_kantor`
--
ALTER TABLE `lokasi_kantor`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `page_banners`
--
ALTER TABLE `page_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `page_banner_perencanaan`
--
ALTER TABLE `page_banner_perencanaan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `portofolio`
--
ALTER TABLE `portofolio`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `portofolio_manajemen`
--
ALTER TABLE `portofolio_manajemen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `portofolio_pengawasan`
--
ALTER TABLE `portofolio_pengawasan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `portofolio_perencanaan`
--
ALTER TABLE `portofolio_perencanaan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `profil_perusahaan`
--
ALTER TABLE `profil_perusahaan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `slider_banner`
--
ALTER TABLE `slider_banner`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `struktur_organisasi`
--
ALTER TABLE `struktur_organisasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tentang_kami`
--
ALTER TABLE `tentang_kami`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `testimoni`
--
ALTER TABLE `testimoni`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `keunggulan_perusahaan`
--
ALTER TABLE `keunggulan_perusahaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `kontak_kami`
--
ALTER TABLE `kontak_kami`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `legalitas`
--
ALTER TABLE `legalitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `lokasi_kantor`
--
ALTER TABLE `lokasi_kantor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `page_banners`
--
ALTER TABLE `page_banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `page_banner_perencanaan`
--
ALTER TABLE `page_banner_perencanaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `portofolio`
--
ALTER TABLE `portofolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `portofolio_manajemen`
--
ALTER TABLE `portofolio_manajemen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `portofolio_pengawasan`
--
ALTER TABLE `portofolio_pengawasan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `portofolio_perencanaan`
--
ALTER TABLE `portofolio_perencanaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `profil_perusahaan`
--
ALTER TABLE `profil_perusahaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `slider_banner`
--
ALTER TABLE `slider_banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `struktur_organisasi`
--
ALTER TABLE `struktur_organisasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `tentang_kami`
--
ALTER TABLE `tentang_kami`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `testimoni`
--
ALTER TABLE `testimoni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
