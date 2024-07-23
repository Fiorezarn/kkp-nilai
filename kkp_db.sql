-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2024 at 12:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kkp_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id_guru` int(11) NOT NULL,
  `nama_guru` varchar(255) NOT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `no_telp` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id_guru`, `nama_guru`, `nip`, `no_telp`) VALUES
(1, 'Adian Ali', '802131231123', '0923213123123'),
(2, 'Sugiono', '13123313', '1231231');

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` int(6) UNSIGNED NOT NULL,
  `nama_jurusan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `nama_jurusan`) VALUES
(1, 'TKP'),
(2, 'BKP'),
(3, 'TKJT'),
(4, 'PMI'),
(5, 'BDP'),
(6, 'MPLB'),
(7, 'LPS'),
(8, 'AKL');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(6) UNSIGNED NOT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `tingkatan` enum('X','XI','XII') NOT NULL,
  `id_jurusan` int(6) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `tingkatan`, `id_jurusan`) VALUES
(1, 'TKP I', 'X', 1),
(2, 'TKP II', 'XI', 1),
(3, 'TKJT I', 'X', 3),
(4, 'TKJT II', 'XI', 3),
(5, 'PM I', 'X', 4),
(6, 'PM II', 'XI', 4),
(7, 'MPLB I', 'X', 6),
(8, 'MPLB II', 'XI', 6),
(9, 'LPS I', 'X', 7),
(10, 'LPS II', 'XI', 7),
(11, 'AK I', 'X', 8),
(12, 'AK II', 'XI', 8),
(13, 'TKP III', 'XII', 1),
(14, 'BKP I', 'XII', 2),
(15, 'TKJT III', 'XII', 3),
(16, 'BDP I', 'XII', 5),
(17, 'PM I', 'XII', 4),
(18, 'OTKP I', 'XII', 6),
(19, 'PSY I', 'XII', 7),
(20, 'AKL I', 'XII', 8);

-- --------------------------------------------------------

--
-- Table structure for table `kelas_mapel`
--

CREATE TABLE `kelas_mapel` (
  `id_kelas` int(6) UNSIGNED NOT NULL,
  `id_mapel` int(6) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas_mapel`
--

INSERT INTO `kelas_mapel` (`id_kelas`, `id_mapel`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 47),
(1, 51),
(1, 52),
(1, 53),
(1, 54),
(1, 55),
(1, 56),
(1, 57),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 41),
(2, 42),
(2, 43),
(2, 44),
(2, 45),
(2, 51),
(2, 52),
(2, 56),
(2, 57),
(3, 9),
(3, 10),
(3, 11),
(3, 41),
(3, 42),
(3, 43),
(3, 44),
(3, 45),
(3, 47),
(3, 51),
(3, 52),
(3, 53),
(3, 54),
(3, 55),
(3, 56),
(3, 57),
(4, 12),
(4, 13),
(4, 14),
(4, 41),
(4, 42),
(4, 43),
(4, 44),
(4, 45),
(4, 51),
(4, 52),
(4, 56),
(4, 57),
(5, 15),
(5, 16),
(5, 17),
(5, 41),
(5, 42),
(5, 43),
(5, 44),
(5, 45),
(5, 47),
(5, 51),
(5, 52),
(5, 53),
(5, 54),
(5, 55),
(5, 56),
(5, 57),
(6, 18),
(6, 19),
(6, 20),
(6, 41),
(6, 42),
(6, 43),
(6, 44),
(6, 45),
(6, 51),
(6, 52),
(6, 56),
(6, 57),
(7, 21),
(7, 22),
(7, 23),
(7, 41),
(7, 42),
(7, 43),
(7, 44),
(7, 45),
(7, 47),
(7, 51),
(7, 52),
(7, 53),
(7, 54),
(7, 55),
(7, 56),
(7, 57),
(8, 24),
(8, 25),
(8, 26),
(8, 41),
(8, 42),
(8, 43),
(8, 44),
(8, 45),
(8, 51),
(8, 52),
(8, 56),
(8, 57),
(9, 27),
(9, 28),
(9, 29),
(9, 41),
(9, 42),
(9, 43),
(9, 44),
(9, 45),
(9, 47),
(9, 51),
(9, 52),
(9, 53),
(9, 54),
(9, 55),
(9, 56),
(9, 57),
(10, 30),
(10, 31),
(10, 32),
(10, 41),
(10, 42),
(10, 43),
(10, 44),
(10, 45),
(10, 51),
(10, 52),
(10, 56),
(10, 57),
(11, 33),
(11, 34),
(11, 35),
(11, 41),
(11, 42),
(11, 43),
(11, 44),
(11, 45),
(11, 47),
(11, 51),
(11, 52),
(11, 53),
(11, 54),
(11, 55),
(11, 56),
(11, 57),
(12, 36),
(12, 37),
(12, 38),
(12, 41),
(12, 42),
(12, 43),
(12, 44),
(12, 45),
(12, 51),
(12, 52),
(12, 56),
(12, 57),
(13, 1),
(13, 2),
(13, 3),
(13, 41),
(13, 42),
(13, 43),
(13, 44),
(13, 45),
(13, 56),
(13, 57),
(14, 4),
(14, 5),
(14, 6),
(14, 41),
(14, 42),
(14, 43),
(14, 44),
(14, 45),
(14, 56),
(14, 57),
(15, 9),
(15, 10),
(15, 11),
(15, 41),
(15, 42),
(15, 43),
(15, 44),
(15, 45),
(15, 56),
(15, 57),
(16, 27),
(16, 28),
(16, 29),
(16, 41),
(16, 42),
(16, 43),
(16, 44),
(16, 45),
(16, 56),
(16, 57),
(17, 15),
(17, 16),
(17, 17),
(17, 41),
(17, 42),
(17, 43),
(17, 44),
(17, 45),
(17, 56),
(17, 57),
(18, 24),
(18, 25),
(18, 26),
(18, 41),
(18, 42),
(18, 43),
(18, 44),
(18, 45),
(18, 56),
(18, 57),
(19, 30),
(19, 31),
(19, 32),
(19, 41),
(19, 42),
(19, 43),
(19, 44),
(19, 45),
(19, 56),
(19, 57),
(20, 33),
(20, 34),
(20, 35),
(20, 41),
(20, 42),
(20, 43),
(20, 44),
(20, 45),
(20, 56),
(20, 57);

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` int(6) UNSIGNED NOT NULL,
  `nama_mapel` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`id_mapel`, `nama_mapel`) VALUES
(1, 'Proses Bisnis di bidang akuntansi dan keuangan lembaga'),
(2, 'Perkembangan teknologi di industri dan dunia kerja serta isu-isu terkini di bidang akuntansi dan keu'),
(3, 'Profil pekerjaan/profesi dan peluang usaha di bidang akuntansi dan keuangan lembaga'),
(4, 'Ekonomi Bisnis dan administrasi umum'),
(5, 'Akuntansi perusahaan jasa, dagang, dan manufaktur'),
(6, 'Akuntansi lembaga/instansi pemerintah'),
(7, 'Akuntansi keuangan'),
(8, 'Komputer akuntansi'),
(9, 'Perpajakan'),
(10, 'PKK'),
(11, 'Mata pelajaran pilihan'),
(12, 'Bahasa Jepang diganti jadi Bahasa Inggris Jurusan'),
(13, 'Ekonomi bisnis dan administrasi umum'),
(14, 'Marketing'),
(15, 'Customer service'),
(16, 'Komunikasi bisnis'),
(17, 'Pengelolaan bisnis retail'),
(18, 'Strategi marketing visual merchandising'),
(19, 'Pengemasan dan pendistribusian produk'),
(20, 'Administrasi transaksi'),
(21, 'Projek kreatif dan kewirausahaan'),
(22, 'Proses bisnis pada pekerjaan konstruksi dan perumahan'),
(23, 'Perkembangan teknologi dan dunia kerja konstruksi dan perumahan'),
(24, 'Profesi dan kewirausahaan, serta peluang usaha pada pekerjaan konstruksi dan perumahan'),
(25, 'K3LH dan budaya kerja industri'),
(26, 'Perencanaan pekerjaan konstruksi dan perumahan'),
(27, 'Pelaksanaan pekerjaan konstruksi perumahan'),
(28, 'Pengawasan pekerjaan konstruksi perumahan'),
(29, 'Estimasi biaya konstruksi dan perumahan'),
(30, 'Dasar program keahlian LPS'),
(31, 'Ekonomi Islam'),
(32, 'Layanan lembaga keuangan syariah'),
(33, 'Akuntansi perbankan syariah'),
(34, 'Komputer akuntansi'),
(35, 'Dasar program keahlian TKJT'),
(36, 'Perencanaan dan pengalamatan jaringan'),
(37, 'Teknologi jaringan kabel dan nirkabel'),
(38, 'Keamanan jaringan'),
(39, 'Pemasangan dan konfigurasi perangkat jaringan (S4)'),
(40, 'Administrasi sistem jaringan'),
(41, 'Pendidikan Agama dan Budi Pekerti'),
(42, 'Pendidikan Pancasila'),
(43, 'Bahasa Indonesia'),
(44, 'Matematika'),
(45, 'Bahasa Inggris'),
(46, 'Penjas'),
(47, 'Seni Budaya'),
(48, 'Muatan Lokal'),
(49, 'IPA'),
(50, 'IPS'),
(51, 'Penjas/Orkes'),
(52, 'Sejarah'),
(53, 'Muatan Lokal - Bahasa Jerman'),
(54, 'Informatika'),
(55, 'IPAS'),
(56, 'Bahasa Jepang'),
(57, 'Mata pelajaran khusus jurusan');

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `kd` int(11) NOT NULL,
  `tipe` varchar(50) NOT NULL,
  `tugas_1` int(11) DEFAULT NULL,
  `tugas_2` int(11) DEFAULT NULL,
  `tugas_3` int(11) DEFAULT NULL,
  `tugas_4` int(11) DEFAULT NULL,
  `tugas_5` int(11) DEFAULT NULL,
  `tugas_6` int(11) DEFAULT NULL,
  `uh_1` int(11) DEFAULT NULL,
  `uh_2` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id_nilai`, `id_siswa`, `id_mapel`, `kd`, `tipe`, `tugas_1`, `tugas_2`, `tugas_3`, `tugas_4`, `tugas_5`, `tugas_6`, `uh_1`, `uh_2`) VALUES
(1, 5, 1, 1, 'pengetahuan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nilai_siswa`
--

CREATE TABLE `nilai_siswa` (
  `id_nilai` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `nis` int(11) NOT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `id_jurusan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nama_siswa`, `nis`, `id_kelas`, `id_jurusan`) VALUES
(1, 'Sony Wakwa111', 0, 0, 0),
(5, 'sadasdasd', 12132131, 1, 1),
(6, 'ajaw ngentot', 0, 3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `reg_date`) VALUES
(1, 'admin', 'admin', 'admin', '2024-07-20 17:01:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `id_jurusan` (`id_jurusan`);

--
-- Indexes for table `kelas_mapel`
--
ALTER TABLE `kelas_mapel`
  ADD PRIMARY KEY (`id_kelas`,`id_mapel`),
  ADD KEY `id_mapel` (`id_mapel`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id_jurusan` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`id_jurusan`) REFERENCES `jurusan` (`id_jurusan`);

--
-- Constraints for table `kelas_mapel`
--
ALTER TABLE `kelas_mapel`
  ADD CONSTRAINT `kelas_mapel_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`),
  ADD CONSTRAINT `kelas_mapel_ibfk_2` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
