-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 13, 2025 at 02:15 AM
-- Server version: 8.0.30
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pinjamkelas`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_peminjaman`
--

CREATE TABLE `tb_peminjaman` (
  `id_peminjaman` varchar(10) NOT NULL,
  `peminjam` varchar(25) NOT NULL,
  `instansi` varchar(255) DEFAULT NULL,
  `ruangan_dipinjam` varchar(15) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `waktu_pengajuan` datetime NOT NULL,
  `tanggal_peminjaman` date DEFAULT NULL,
  `waktu_mulai` datetime DEFAULT NULL,
  `waktu_selesai` datetime DEFAULT NULL,
  `waktu_penyetujuan` datetime NOT NULL,
  `waktu_pembatalan` datetime NOT NULL,
  `waktu_pengembalian` datetime NOT NULL,
  `status_pinjam` varchar(15) NOT NULL,
  `jumlah_orang` int NOT NULL,
  `konsumsi` varchar(255) NOT NULL,
  `menu_konsumsi` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_peminjaman`
--

INSERT INTO `tb_peminjaman` (`id_peminjaman`, `peminjam`, `instansi`, `ruangan_dipinjam`, `keterangan`, `waktu_pengajuan`, `tanggal_peminjaman`, `waktu_mulai`, `waktu_selesai`, `waktu_penyetujuan`, `waktu_pembatalan`, `waktu_pengembalian`, `status_pinjam`, `jumlah_orang`, `konsumsi`, `menu_konsumsi`) VALUES
('DPK-00001', 'Bagian Umum', NULL, 'Ruangan-01', 'rapat', '2024-10-01 13:51:49', NULL, NULL, NULL, '2024-10-01 13:52:21', '0000-00-00 00:00:00', '2024-10-01 14:33:13', 'Selesai', 0, '', NULL),
('DPK-00002', 'Bagian Umum', NULL, 'Ruangan-02', 'rapat', '2024-10-01 14:30:18', NULL, NULL, NULL, '2024-10-01 14:31:38', '0000-00-00 00:00:00', '2024-10-01 14:32:12', 'Selesai', 0, '', NULL),
('DPK-00003', 'Bagian Umum', NULL, 'Ruangan-01', 'rapat', '2024-10-03 09:17:10', NULL, NULL, NULL, '2024-10-03 09:18:26', '0000-00-00 00:00:00', '2024-10-03 09:55:21', 'Selesai', 0, '', NULL),
('DPK-00005', 'Bagian Umum', NULL, 'Ruangan-01', 'rapat', '2024-10-03 09:55:31', NULL, NULL, NULL, '2024-10-03 10:13:40', '0000-00-00 00:00:00', '2024-10-04 09:15:18', 'Selesai', 0, '', NULL),
('DPK-00006', 'Bagian Umum', NULL, 'Ruangan-02', 'rapat', '2024-10-03 10:10:33', NULL, NULL, NULL, '2024-10-03 10:10:45', '0000-00-00 00:00:00', '2024-10-04 09:14:38', 'Selesai', 10, 'makanan_berat', NULL),
('DPK-00007', 'Bagian Umum', NULL, 'Ruangan-01', 'rapat', '2024-10-04 09:15:24', NULL, NULL, NULL, '0000-00-00 00:00:00', '2024-10-04 09:21:55', '0000-00-00 00:00:00', 'Dibatalkan', 15, 'makanan_berat', NULL),
('DPK-00008', 'Bagian Umum', NULL, 'Ruangan-01', 'rapat', '2024-10-05 23:43:38', NULL, NULL, NULL, '2024-10-05 23:43:53', '0000-00-00 00:00:00', '2024-10-05 23:48:27', 'Selesai', 15, 'makanan_ringan', NULL),
('DPK-00009', 'Bagian Umum', NULL, 'Ruangan-03', 'rapat', '2024-10-05 23:51:33', NULL, NULL, NULL, '2024-10-05 23:52:08', '0000-00-00 00:00:00', '2024-10-07 00:24:33', 'Selesai', 20, 'makanan_berat', NULL),
('DPK-00010', 'User', NULL, 'Ruangan-01', 'rapat', '2024-10-06 22:20:27', NULL, NULL, NULL, '2024-10-06 22:50:25', '0000-00-00 00:00:00', '2024-10-07 00:24:06', 'Selesai', 15, 'makanan_berat', NULL),
('DPK-00011', 'Nurlita', NULL, 'Ruangan-03', 'rapat', '2024-10-07 00:25:55', NULL, NULL, NULL, '2024-10-07 00:26:51', '0000-00-00 00:00:00', '2024-10-07 00:28:28', 'Selesai', 10, 'makanan_berat', NULL),
('DPK-00012', 'Bagian Umum', NULL, 'Ruangan-01', 'rapat', '2024-10-07 16:23:15', NULL, NULL, NULL, '2024-10-07 16:23:25', '0000-00-00 00:00:00', '2024-10-08 10:01:46', 'Selesai', 15, 'makanan_berat', NULL),
('DPK-00013', 'Indah', NULL, 'Ruangan-01', 'rapat', '2024-10-08 16:11:35', NULL, NULL, NULL, '2024-10-08 16:12:29', '0000-00-00 00:00:00', '2024-10-27 15:18:09', 'Selesai', 18, 'makanan_berat', NULL),
('DPK-00014', 'User', NULL, 'Ruangan-02', 'hugjhg', '2024-10-09 14:27:23', NULL, NULL, NULL, '2024-10-27 15:17:58', '0000-00-00 00:00:00', '2024-10-27 15:18:05', 'Selesai', 15, 'makanan_ringan', NULL),
('DPK-00015', 'Bagian Umum', 'B', 'Ruangan-01', 'rapat', '2024-10-29 13:42:52', NULL, NULL, NULL, '0000-00-00 00:00:00', '2024-10-29 15:39:49', '0000-00-00 00:00:00', 'Dibatalkan', 20, 'perlu', NULL),
('DPK-00016', 'Bagian Umum', 'B', 'Ruangan-02', 'rapat', '2024-10-29 13:57:27', NULL, NULL, NULL, '2024-10-29 15:47:14', '0000-00-00 00:00:00', '2024-10-29 15:47:19', 'Selesai', 20, 'tidak', NULL),
('DPK-00017', 'Bagian Umum', 'a', 'Ruangan-02', 'rapat', '2024-10-29 14:00:02', NULL, NULL, NULL, '2024-10-29 15:41:34', '0000-00-00 00:00:00', '2024-10-29 15:47:09', 'Selesai', 15, 'perlu', NULL),
('DPK-00018', 'Bagian Umum', 'B', 'Ruangan-02', 'rapat', '2024-10-29 16:13:06', NULL, NULL, NULL, '2024-11-01 10:14:53', '0000-00-00 00:00:00', '2024-11-01 10:15:37', 'Selesai', 15, 'perlu', NULL),
('DPK-00019', 'Bagian Umum', 'C', 'Ruangan-02', 'rapat', '2024-11-01 09:33:11', NULL, NULL, NULL, '2024-11-01 10:15:05', '0000-00-00 00:00:00', '2024-11-01 10:15:43', 'Selesai', 18, 'perlu', NULL),
('DPK-00020', 'Bagian Umum', 'B', 'Ruangan-02', 'rapat', '2024-11-01 10:02:17', '2024-11-09', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-11-01 10:15:16', '0000-00-00 00:00:00', '2024-11-01 10:15:48', 'Selesai', 10, 'tidak', NULL),
('DPK-00021', 'Bagian Umum', 'C', 'Ruangan-03', 'rapat', '2024-11-01 10:04:01', '2024-11-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-11-01 10:15:25', '0000-00-00 00:00:00', '2024-11-01 10:15:52', 'Selesai', 18, 'tidak', NULL),
('DPK-00022', 'Bagian Umum', 'A', 'Ruangan-03', 'rapat', '2024-11-01 10:07:59', '2024-11-20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-11-01 10:15:31', '0000-00-00 00:00:00', '2024-11-01 10:15:59', 'Selesai', 15, 'perlu', NULL),
('DPK-00023', 'Bagian Umum', 'A', 'Ruangan-03', 'rapat', '2024-11-01 10:16:42', '2024-11-30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-11-04 14:31:23', '0000-00-00 00:00:00', '2024-11-04 14:31:44', 'Selesai', 20, 'tidak', NULL),
('DPK-00024', 'Bagian Umum', 'C', 'Ruangan-03', 'rapat', '2024-11-04 14:31:23', '2024-11-05', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-11-10 11:02:31', '0000-00-00 00:00:00', '2024-11-10 11:11:33', 'Selesai', 10, 'tidak', NULL),
('DPK-00025', 'Bagian Umum', 'B', 'Ruangan-01', 'rapat', '2024-11-10 10:59:29', '2024-11-12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-11-10 10:59:29', '0000-00-00 00:00:00', '2024-11-10 11:02:05', 'Selesai', 15, 'tidak', NULL),
('DPK-00026', 'Bagian Umum', 'B', 'Ruangan-01', 'rapat', '2024-11-10 11:13:09', '2024-11-11', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-11-10 11:13:09', '0000-00-00 00:00:00', '2024-11-10 11:20:59', 'Selesai', 10, 'tidak', NULL),
('DPK-00027', 'Bagian Umum', 'B', 'Ruangan-02', 'rapat', '2024-11-10 11:20:59', '2024-11-12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-11-10 11:21:29', '0000-00-00 00:00:00', '2024-11-10 11:21:34', 'Selesai', 10, 'perlu', NULL),
('DPK-00028', 'Bagian Umum', 'C', 'Ruangan-03', 'rapat', '2024-11-10 11:33:18', '2024-11-12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-11-10 11:33:18', '0000-00-00 00:00:00', '2024-11-10 11:37:43', 'Selesai', 10, 'perlu', NULL),
('DPK-00029', 'User', 'A', 'Ruangan-02', 'Rapat', '2024-11-10 11:37:22', '2024-11-14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-11-10 11:37:35', '0000-00-00 00:00:00', '2024-11-10 11:39:17', 'Selesai', 28, 'tidak', NULL),
('DPK-00030', 'Nurlita', 'A', 'Ruangan-03', 'Rapat', '2024-11-10 11:40:37', '2024-11-11', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-11-10 11:48:35', '0000-00-00 00:00:00', '2024-11-10 11:52:32', 'Selesai', 28, 'perlu', NULL),
('DPK-00031', 'Nurlita', 'A', 'Ruangan-03', 'Rapat', '2024-11-10 11:53:04', '2024-11-11', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-11-10 11:53:10', '0000-00-00 00:00:00', '2024-11-10 11:53:39', 'Selesai', 28, 'tidak', NULL),
('DPK-00032', 'Nurlita', 'A', 'Ruangan-03', 'Rapat', '2024-11-10 11:59:39', '2024-11-13', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-11-10 12:00:00', '0000-00-00 00:00:00', '2024-11-10 12:00:25', 'Selesai', 28, 'tidak', NULL),
('DPK-00033', 'Nurlita', 'A', 'Ruangan-02', 'Rapat', '2024-11-10 12:55:46', '2024-11-14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-11-10 12:55:51', '0000-00-00 00:00:00', '2024-11-10 21:05:18', 'Selesai', 28, 'tidak', NULL),
('DPK-00034', 'Bagian Umum', 'B', 'Ruangan-01', 'rapat', '2024-11-10 21:25:25', '2024-11-13', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-11-10 21:25:41', '0000-00-00 00:00:00', '2024-11-10 21:28:22', 'Selesai', 10, 'tidak', NULL),
('DPK-00035', 'Bagian Umum', 'A', 'Ruangan-01', 'rapat', '2024-11-10 21:28:22', '2024-11-12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-11-10 21:28:28', '0000-00-00 00:00:00', '2024-11-10 21:30:27', 'Selesai', 10, 'perlu', NULL),
('DPK-00036', 'Bagian Umum', 'C', 'Ruangan-03', 'rapat', '2024-11-10 21:40:43', '2024-11-13', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-11-10 21:40:43', '0000-00-00 00:00:00', '2024-11-11 11:09:19', 'Selesai', 15, 'tidak', NULL),
('DPK-00037', 'umum', 'A', 'Ruangan-03', 'rapat', '2024-11-10 21:41:25', '2024-11-18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-11-11 11:11:40', '0000-00-00 00:00:00', '2025-01-13 14:34:46', 'Selesai', 20, 'tidak', NULL),
('DPK-00038', 'Bagian Umum', 'A', 'Ruangan-02', 'rapat', '2024-11-11 11:10:55', '2024-11-12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-12-10 16:25:41', '0000-00-00 00:00:00', '2025-01-13 14:46:14', 'Selesai', 10, 'tidak', NULL),
('DPK-00039', 'Bagian Umum', 'B', 'Ruangan-01', 'rapat', '2024-12-10 08:40:13', '2024-12-11', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-12-10 08:40:13', '0000-00-00 00:00:00', '2025-01-13 14:46:23', 'Selesai', 10, 'tidak', NULL),
('DPK-00040', 'Bagian Umum', 'B', 'Ruangan-01', 'rapat', '2024-12-10 16:28:32', '2024-12-11', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Menunggu', 10, 'perlu', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_ruangan`
--

CREATE TABLE `tb_ruangan` (
  `id_ruangan` varchar(10) NOT NULL,
  `nama_ruangan` varchar(15) NOT NULL,
  `status` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_ruangan`
--

INSERT INTO `tb_ruangan` (`id_ruangan`, `nama_ruangan`, `status`) VALUES
('R001', 'Ruangan-01', 'Tersedia'),
('R002', 'Ruangan-02', 'Tersedia'),
('R003', 'Ruangan-03', 'Tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `username` varchar(10) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fullname` varchar(25) NOT NULL,
  `password` varchar(35) NOT NULL,
  `level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`username`, `email`, `fullname`, `password`, `level`) VALUES
('lita', 'nurlitaptri87@gmail.com', 'Nurlita', '202cb962ac59075b964b07152d234b70', 'Bagian Umum'),
('Nurlita', 'nurlitaptri87@gmail.com', 'Nurlita', '202cb962ac59075b964b07152d234b70', 'Pengguna Ruangan'),
('umum', 'nurlitasgn87@gmail.com', 'Bagian Umum', '215e95f88936b204603dfcff01e9f614', 'Bagian Umum'),
('user', NULL, 'User', 'ae671ecd4ebee177c57dfbfbbf28cd83', 'Pengguna Ruangan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_peminjaman`
--
ALTER TABLE `tb_peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`);

--
-- Indexes for table `tb_ruangan`
--
ALTER TABLE `tb_ruangan`
  ADD PRIMARY KEY (`id_ruangan`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
