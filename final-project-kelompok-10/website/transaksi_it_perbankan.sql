-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2023 at 02:18 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `transaksi_it_perbankan`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_transaksi_bank`
--

CREATE TABLE `data_transaksi_bank` (
  `id` bigint(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `kota` text DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `nilai_saldo` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_transaksi_bank`
--

INSERT INTO `data_transaksi_bank` (`id`, `user_id`, `nama`, `no_hp`, `kota`, `alamat`, `nilai_saldo`) VALUES
(1, 0, 'Felix', '', '', '', 2500000),
(2, 0, 'Muhammad Daffa Aditya', '', '', '', 5000000),
(3, 0, 'Ridwan', '', '', '', 4000000),
(4, 0, 'Afrizal', '', '', '', 5500000),
(5, 0, 'Umar', '', '', '', 7000000),
(6, 4, 'Admin Academy Rakamin', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `histori_transaksi`
--

CREATE TABLE `histori_transaksi` (
  `id` int(11) NOT NULL,
  `bank_id` bigint(20) NOT NULL,
  `tanggal_transaksi` datetime DEFAULT NULL,
  `jenis_transaksi` varchar(255) DEFAULT NULL,
  `jumlah_transaksi` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `histori_transaksi`
--

INSERT INTO `histori_transaksi` (`id`, `bank_id`, `tanggal_transaksi`, `jenis_transaksi`, `jumlah_transaksi`) VALUES
(1, 0, '2023-09-19 17:35:05', 'Pembelian', '300000.00'),
(2, 0, '2023-09-19 17:35:05', 'Pemasukan', '2000000.00'),
(3, 0, '2023-09-19 17:37:58', 'Gaji', '2500000.00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hash_password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `hash_password`) VALUES
(4, 'admin', 'admin@gmail.com', '$2y$10$TUf3Myl4mVfDnpfXYagZieW.mSQpYkA9MsgzRd4eSVhWhhyAuWX7y');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_transaksi_bank`
--
ALTER TABLE `data_transaksi_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `histori_transaksi`
--
ALTER TABLE `histori_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_transaksi_bank`
--
ALTER TABLE `data_transaksi_bank`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `histori_transaksi`
--
ALTER TABLE `histori_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
