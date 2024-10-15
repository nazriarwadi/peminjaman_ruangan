-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 08, 2024 at 01:24 AM
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
  `ruangan_dipinjam` varchar(15) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `waktu_pengajuan` datetime NOT NULL,
  `waktu_penyetujuan` datetime NOT NULL,
  `waktu_pembatalan` datetime NOT NULL,
  `waktu_pengembalian` datetime NOT NULL,
  `status_pinjam` varchar(15) NOT NULL,
  `jumlah_orang` int NOT NULL,
  `konsumsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_peminjaman`
--

INSERT INTO `tb_peminjaman` (`id_peminjaman`, `peminjam`, `ruangan_dipinjam`, `keterangan`, `waktu_pengajuan`, `waktu_penyetujuan`, `waktu_pembatalan`, `waktu_pengembalian`, `status_pinjam`, `jumlah_orang`, `konsumsi`) VALUES
('DPK-00001', 'Bagian Umum', 'Ruangan-01', 'rapat', '2024-10-01 13:51:49', '2024-10-01 13:52:21', '0000-00-00 00:00:00', '2024-10-01 14:33:13', 'Selesai', 0, ''),
('DPK-00002', 'Bagian Umum', 'Ruangan-02', 'rapat', '2024-10-01 14:30:18', '2024-10-01 14:31:38', '0000-00-00 00:00:00', '2024-10-01 14:32:12', 'Selesai', 0, ''),
('DPK-00003', 'Bagian Umum', 'Ruangan-01', 'rapat', '2024-10-03 09:17:10', '2024-10-03 09:18:26', '0000-00-00 00:00:00', '2024-10-03 09:55:21', 'Selesai', 0, ''),
('DPK-00005', 'Bagian Umum', 'Ruangan-01', 'rapat', '2024-10-03 09:55:31', '2024-10-03 10:13:40', '0000-00-00 00:00:00', '2024-10-04 09:15:18', 'Selesai', 0, ''),
('DPK-00006', 'Bagian Umum', 'Ruangan-02', 'rapat', '2024-10-03 10:10:33', '2024-10-03 10:10:45', '0000-00-00 00:00:00', '2024-10-04 09:14:38', 'Selesai', 10, 'makanan_berat'),
('DPK-00007', 'Bagian Umum', 'Ruangan-01', 'rapat', '2024-10-04 09:15:24', '0000-00-00 00:00:00', '2024-10-04 09:21:55', '0000-00-00 00:00:00', 'Dibatalkan', 15, 'makanan_berat'),
('DPK-00008', 'Bagian Umum', 'Ruangan-01', 'rapat', '2024-10-05 23:43:38', '2024-10-05 23:43:53', '0000-00-00 00:00:00', '2024-10-05 23:48:27', 'Selesai', 15, 'makanan_ringan'),
('DPK-00009', 'Bagian Umum', 'Ruangan-03', 'rapat', '2024-10-05 23:51:33', '2024-10-05 23:52:08', '0000-00-00 00:00:00', '2024-10-07 00:24:33', 'Selesai', 20, 'makanan_berat'),
('DPK-00010', 'User', 'Ruangan-01', 'rapat', '2024-10-06 22:20:27', '2024-10-06 22:50:25', '0000-00-00 00:00:00', '2024-10-07 00:24:06', 'Selesai', 15, 'makanan_berat'),
('DPK-00011', 'Nurlita', 'Ruangan-03', 'rapat', '2024-10-07 00:25:55', '2024-10-07 00:26:51', '0000-00-00 00:00:00', '2024-10-07 00:28:28', 'Selesai', 10, 'makanan_berat'),
('DPK-00012', 'Bagian Umum', 'Ruangan-01', 'rapat', '2024-10-07 16:23:15', '2024-10-07 16:23:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Disetujui', 15, 'makanan_berat');

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
('R001', 'Ruangan-01', 'Sedang digunakan'),
('R002', 'Ruangan-02', 'Tersedia'),
('R003', 'Ruangan-03', 'Tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tap`
--

CREATE TABLE `tb_tap` (
  `id` int NOT NULL,
  `id_kartu` varchar(20) NOT NULL,
  `nama_ruangan` varchar(15) NOT NULL,
  `waktu_akses` datetime NOT NULL,
  `waktu_tutup` datetime NOT NULL,
  `status_akses` varchar(10) NOT NULL DEFAULT 'Dibuka'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `username` varchar(10) NOT NULL,
  `fullname` varchar(25) NOT NULL,
  `password` varchar(35) NOT NULL,
  `level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`username`, `fullname`, `password`, `level`) VALUES
('Nurlita', 'Nurlita', '202cb962ac59075b964b07152d234b70', 'Pengguna Ruangan'),
('umum', 'Bagian Umum', '215e95f88936b204603dfcff01e9f614', 'Bagian Umum'),
('user', 'User', 'ae671ecd4ebee177c57dfbfbbf28cd83', 'Pengguna Ruangan');

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
-- Indexes for table `tb_tap`
--
ALTER TABLE `tb_tap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_tap`
--
ALTER TABLE `tb_tap`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
