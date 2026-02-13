-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2026 at 05:51 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penggajian`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_gaji`
--

CREATE TABLE `detail_gaji` (
  `no` int(11) DEFAULT NULL,
  `no_ref` varchar(20) DEFAULT NULL,
  `nominal` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_gaji`
--

INSERT INTO `detail_gaji` (`no`, `no_ref`, `nominal`) VALUES
(1, 'RF1816033', 13000000),
(1, 'RF1816033', 5000000),
(1, 'RF7880671', 5000000),
(4, 'RF7880671', 250000),
(3, 'RF7880671', 500000);

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `kode_karyawan` varchar(20) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `no_tlp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_rekening` varchar(30) DEFAULT NULL,
  `rek_bank` varchar(50) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `id_perusahaan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`kode_karyawan`, `nama`, `alamat`, `jabatan`, `no_tlp`, `email`, `no_rekening`, `rek_bank`, `id`, `id_perusahaan`) VALUES
('KR99322', 'Cantika', 'Ciputat', 'Admin', '08156917771', 'cantika@gmail.com', '7729911112', 'BCA', NULL, 1),
('KR99382', 'Fahmi ', 'Jakarta Timur', 'Staff IT', '088219841990', 'fahmi@gmail.com', '12988383933', 'Mandiri', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `keterangan_gaji`
--

CREATE TABLE `keterangan_gaji` (
  `no` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `jenis` enum('debit','kredit') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `keterangan_gaji`
--

INSERT INTO `keterangan_gaji` (`no`, `keterangan`, `jenis`) VALUES
(1, 'Gaji Pokok', 'debit'),
(2, 'Tunjangan Transport', 'debit'),
(3, 'Potongan Pajak', 'kredit'),
(4, 'Potongan BPJS', 'kredit');

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `perusahaan`
--

INSERT INTO `perusahaan` (`id`, `nama`, `alamat`, `no_telepon`, `email`) VALUES
(1, 'PT. Cinta Sejati', 'Jakarta selatan', '02192838893', 'ptcintasejati@gmail.com'),
(2, 'PT. Gudang Garam', 'Jakarta Timur', '021839992911', 'ptgudanggaram@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `slip_gaji`
--

CREATE TABLE `slip_gaji` (
  `no_ref` varchar(20) NOT NULL,
  `tgl` date DEFAULT NULL,
  `total_gaji` double DEFAULT NULL,
  `kode_karyawan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `slip_gaji`
--

INSERT INTO `slip_gaji` (`no_ref`, `tgl`, `total_gaji`, `kode_karyawan`) VALUES
('RF1816033', '2025-06-05', 0, 'KR99382'),
('RF7880671', '2025-06-05', 0, 'KR99322');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_gaji`
--
ALTER TABLE `detail_gaji`
  ADD KEY `no` (`no`),
  ADD KEY `no_ref` (`no_ref`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`kode_karyawan`),
  ADD KEY `id` (`id`),
  ADD KEY `fk_perusahaan` (`id_perusahaan`);

--
-- Indexes for table `keterangan_gaji`
--
ALTER TABLE `keterangan_gaji`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slip_gaji`
--
ALTER TABLE `slip_gaji`
  ADD PRIMARY KEY (`no_ref`),
  ADD KEY `kode_karyawan` (`kode_karyawan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keterangan_gaji`
--
ALTER TABLE `keterangan_gaji`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_gaji`
--
ALTER TABLE `detail_gaji`
  ADD CONSTRAINT `detail_gaji_ibfk_1` FOREIGN KEY (`no`) REFERENCES `keterangan_gaji` (`no`),
  ADD CONSTRAINT `detail_gaji_ibfk_2` FOREIGN KEY (`no_ref`) REFERENCES `slip_gaji` (`no_ref`);

--
-- Constraints for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `fk_perusahaan` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id`),
  ADD CONSTRAINT `karyawan_ibfk_1` FOREIGN KEY (`id`) REFERENCES `perusahaan` (`id`);

--
-- Constraints for table `slip_gaji`
--
ALTER TABLE `slip_gaji`
  ADD CONSTRAINT `slip_gaji_ibfk_1` FOREIGN KEY (`kode_karyawan`) REFERENCES `karyawan` (`kode_karyawan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
