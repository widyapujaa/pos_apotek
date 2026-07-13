-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2026 at 02:47 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_apotek`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail_transaksi` char(8) NOT NULL,
  `id_transaksi` char(8) NOT NULL,
  `id_obat` char(8) NOT NULL,
  `harga_obat` double NOT NULL,
  `jumlah` int(10) NOT NULL,
  `sub_total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail_transaksi`, `id_transaksi`, `id_obat`, `harga_obat`, `jumlah`, `sub_total`) VALUES
('DT001', 'TR001', 'OB001', 10000, 1, 10000),
('DT002', 'TR001', 'OB005', 20000, 1, 20000),
('DT003', 'TR002', 'OB004', 18000, 3, 54000),
('DT004', 'TR002', 'OB008', 10000, 3, 30000),
('DT005', 'TR003', 'OB004', 18000, 1, 18000),
('DT006', 'TR004', 'OB007', 20000, 2, 40000),
('DT007', 'TR004', 'OB001', 10000, 2, 20000),
('DT008', 'TR005', 'OB008', 10000, 2, 20000),
('DT009', 'TR006', 'OB001', 10000, 3, 30000),
('DT010', 'TR006', 'OB007', 20000, 3, 60000),
('DT011', 'TR007', 'OB006', 20000, 1, 20000),
('DT012', 'TR008', 'OB004', 18000, 3, 54000);

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` char(8) NOT NULL,
  `nama_karyawan` varchar(55) NOT NULL,
  `email` varchar(55) NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `alamat` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nama_karyawan`, `email`, `no_telepon`, `alamat`) VALUES
('KR001', 'I Gusti Lanang Widya Puja', 'ggungde0@gmail.com', '081237016824', 'jl tukad Balian'),
('KR002', 'Ayet Nugraha', 'ayet0@gmail.', '0891728', 'tukad'),
('KR003', 'Alex', 'alex@gmanil.com', '081237015824', 'tukad balian'),
('KR004', 'puja', 'thelanang2020@gmail.com', '081237015824', 'tukad balian'),
('KR005', 'gungde', 'gungdeti08@gmail.com', '081237016824', 'jl tukad balian'),
('KR006', 'I wayan ngurah Kasir', 'adidaskawe3@gmail.com', '081237016824', 'jl i wayan ngurah kasih'),
('KR007', 'gung mobile ', 'gungmobile08@gmail.com', '08123729', 'jl mobile');

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id_obat` char(8) NOT NULL,
  `id_supplier` char(8) NOT NULL,
  `nama_obat` varchar(55) NOT NULL,
  `kategori_obat` enum('Obat Bebas','Obat Keras','Obat Bebas Terbatas','') NOT NULL,
  `stok_obat` int(10) NOT NULL,
  `harga_obat` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id_obat`, `id_supplier`, `nama_obat`, `kategori_obat`, `stok_obat`, `harga_obat`) VALUES
('OB001', 'SP001', 'Paracetamol', 'Obat Bebas', 79, 10000),
('OB002', 'SP002', 'Panadol', 'Obat Bebas', 4, 10000),
('OB003', 'SP002', 'Antibiotik', 'Obat Keras', 2, 10000),
('OB004', 'SP003', 'Ibuprofen', 'Obat Bebas Terbatas', 43, 18000),
('OB005', 'SP008', 'Amoxicillin', 'Obat Keras', 21, 20000),
('OB006', 'SP007', 'Omeprazole', 'Obat Keras', 254, 20000),
('OB007', 'SP008', 'OBH Combi', 'Obat Bebas', 45, 20000),
('OB008', 'SP005', 'Metformin', 'Obat Keras', 15, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` char(8) NOT NULL,
  `nama_pelanggan` varchar(55) NOT NULL,
  `email` varchar(55) NOT NULL,
  `no_telepon` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `email`, `no_telepon`) VALUES
('PL001', 'Ayet Nugraha', 'ayet0@gmail.com', '081237015824'),
('PL002', 'Pelanggan Umum', 'Umum', '-'),
('PL003', 'Lanag Wicaksana', 'thelanang2021@gmail.com', '081237016824'),
('PL004', 'Muhamad resqy', 'resqy0@gmail.com', '081237015821'),
('PL005', 'Ketut Marta', 'martha0@gmail.com', '081237016822'),
('PL006', 'kadek endra', 'endra0@gmail.com', '081237016824'),
('PL007', 'krisna kernok', 'kernok0@gmail.com', '081237016824'),
('PL008', 'dwi antara', 'antara0@gmail.com', '0812370168242');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` char(8) NOT NULL,
  `nama_perusahaan` varchar(55) NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `alamat` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_perusahaan`, `no_telepon`, `alamat`) VALUES
('SP001', 'PT Abadi Tama', '081237016824', 'jl tukad balian gg damai no 20'),
('SP002', 'PT Antarmuka Pengguna', '081237016824', 'jl tukad balian gg damai'),
('SP003', 'PT Sehat Medika Nusantara', '082145678901', 'Jl. Teuku Umar No. 156, Denpasar'),
('SP004', 'CV Farma Sentosa', '081338765421', 'Jl. Imam Bonjol No. 45, Denpasar'),
('SP005', 'PT Medika Prima Indonesia', '085234567890', 'Jl. Diponegoro No. 17, Denpasar'),
('SP006', 'CV Anugerah Farma Bali', '081999887766', 'Jl. Mahendradatta No. 120, Denpasar'),
('SP007', 'PT Kimia Sejahtera', '082233445566', 'Jl. Raya Sesetan No. 99, Denpasar'),
('SP008', 'PT Nusantara Healthcare', '081287654321', 'Jl. Ahmad Yani Utara No. 52, Denpasar');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` char(8) NOT NULL,
  `id_pelanggan` char(8) NOT NULL,
  `tgl_transaksi` datetime NOT NULL,
  `kategori_pelanggan` set('Umum','Member') NOT NULL,
  `foto_resep` varchar(55) DEFAULT NULL,
  `total` double NOT NULL,
  `bayar` double NOT NULL,
  `kembalian` double NOT NULL,
  `id_karyawan` char(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pelanggan`, `tgl_transaksi`, `kategori_pelanggan`, `foto_resep`, `total`, `bayar`, `kembalian`, `id_karyawan`) VALUES
('TR001', 'PL002', '2026-07-13 20:33:45', 'Umum', 'resep_1783946025.png', 30000, 30000, 0, 'KR006'),
('TR002', 'PL001', '2026-07-13 20:34:49', 'Member', 'resep_1783946089.jpeg', 84000, 100000, 16000, 'KR006'),
('TR003', 'PL003', '2026-07-13 20:35:49', 'Member', NULL, 18000, 20000, 2000, 'KR006'),
('TR004', 'PL002', '2026-07-13 20:37:28', 'Umum', NULL, 60000, 80000, 20000, 'KR006'),
('TR005', 'PL002', '2026-07-13 20:38:00', 'Umum', 'resep_1783946280.png', 20000, 20000, 0, 'KR006'),
('TR006', 'PL005', '2026-07-13 20:40:40', 'Member', NULL, 90000, 95000, 5000, 'KR006'),
('TR007', 'PL004', '2026-07-13 20:41:53', 'Member', 'resep_1783946513.jpeg', 20000, 20000, 0, 'KR006'),
('TR008', 'PL003', '2026-07-13 20:42:18', 'Member', NULL, 54000, 55000, 1000, 'KR006');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(55) NOT NULL,
  `password` varchar(65) NOT NULL,
  `role` varchar(20) NOT NULL,
  `id_karyawan` char(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `role`, `id_karyawan`) VALUES
('admin', '$2y$10$ycyIvSfrhQzYDns0xQw3s.H0UK9t8BZock64BNdzvyKBeYFoOXvRO', 'Admin', 'KR001'),
('Ayet', '$2y$10$5M4NrIc0BrXg3FFPBXsV3O/PMGRRZM83Op0XdtRLOj9sGfkoa./7K', 'Admin', 'KR002'),
('gung mobile', '$2y$10$aHZB8Ss4TJ7l1b0usdXNd.g.4XkoKrNn7aR.WsLBCT6RaN6zrsGFe', 'Admin', 'KR007'),
('Kasir', '$2y$10$OFW4bkFaw.TUkfP0H.7MA.lZqds0ueJDWGOhNTTWDhjabilK.TQLm', 'Kasir', 'KR005'),
('puja stocker', '$2y$10$ShcXdtRShz7qMXDcTDJG5uAojbvi4WOnFmRyxdGvBhVAx/zQrdhdC', 'Stocker', 'KR004'),
('wayan kasir', '$2y$10$DpadaUI2SpJBbcYrYs5yqOj3hGltFo0D/APeia5S9MueKtM7YsJ6y', 'Kasir', 'KR006');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail_transaksi`),
  ADD KEY `detail_transaksi_ke_obat` (`id_obat`),
  ADD KEY `detail_transaksi_ke_transaksi` (`id_transaksi`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`),
  ADD KEY `Obat_ke_supplier` (`id_supplier`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `transaksi_karyawan` (`id_karyawan`),
  ADD KEY `transaksi_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ke_obat` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`),
  ADD CONSTRAINT `detail_transaksi_ke_transaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`);

--
-- Constraints for table `obat`
--
ALTER TABLE `obat`
  ADD CONSTRAINT `Obat_ke_supplier` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_karyawan` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`),
  ADD CONSTRAINT `transaksi_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
