-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 12, 2025 at 03:53 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pinjamruangan`
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
  `waktu_mulai` time DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
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
('DPK-00001', 'Bagian Umum', 'bank', 'Ruangan-01', 'asiapp', '2025-04-19 21:47:12', '2025-04-19', '21:47:00', '23:49:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1899-12-31 00:00:00', 'Selesai', 10, 'perlu', NULL),
('DPK-00002', 'Bagian Umum', 'bank', 'Ruangan-01', 'asiapp', '2025-04-21 11:20:00', '2025-04-21', '11:19:00', '13:25:00', '2025-04-21 12:05:38', '0000-00-00 00:00:00', '2025-04-21 16:33:21', 'Selesai', 5, 'tidak', NULL),
('DPK-00003', 'Bagian Umum', 'bank', 'Ruangan-02', 'sdada', '2025-04-21 12:25:36', '2025-04-21', '12:25:00', '12:30:00', '2025-04-21 12:25:36', '0000-00-00 00:00:00', '2025-04-21 16:33:21', 'Selesai', 10, 'tidak', NULL),
('DPK-00004', 'nazri', 'pemerintah', 'Ruangan-03', 'Mantap', '2025-05-12 08:47:21', '2025-05-12', '08:47:00', '11:50:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Menunggu', 6, 'perlu', 'makanan_ringan'),
('DPK-00005', 'nazri', 'pemerintah', 'Ruangan-02', 'Mantap', '2025-05-12 09:15:13', '2025-05-12', '09:15:00', '09:15:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Menunggu', 6, 'perlu', 'makanan_berat');

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
('nazri', 'Nazri@example.com', 'nazri', '1bbd886460827015e5d605ed44252251', 'Pengguna Ruangan'),
('umum', 'nurlitasgn87@gmail.com', 'Bagian Umum', '215e95f88936b204603dfcff01e9f614', 'Bagian Umum');

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
