-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2024 at 01:14 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dealer_onlinee`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(1, 'Matic'),
(2, 'Sport'),
(3, 'Moped'),
(4, 'Offroad');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama_produk`, `kategori_id`, `harga`, `deskripsi`, `gambar`) VALUES
(1, 'Yamaha XSR', 2, 40000000.00, 'Yamaha XSR 155 adalah motor sport berdesain klasik yang tersedia di Indonesia. Motor ini ditenagai oleh mesin Petrol berkapasitas 155 cc dengan transmisi Manual. XSR 155 memiliki ground clearance 170 mm dan desain flat seat yang klasik namun tetap memberikan kenyamanan dalam perjalanan. Motor ini juga dilengkapi dengan fitur modern seperti lampu LED di depan dan belakang, serta layar speedometer digital. XSR 155 tersedia dalam tiga pilihan warna dan hanya hadir dalam satu varian.', 'xsr-155.png'),
(2, 'Yamaha YZ125X', 1, 45000000.00, 'Yamaha YZ125X di Indonesia adalah motorcross yang dirancang untuk balap off-road dan trail riding, dibekali mesin 2-tak 125cc yang powerful dan ringan, serta memiliki kerangka aluminum yang kokoh dan ringan, dengan harga berkisar antara Rp 40-50 jutaan, tergantung pada lokasi dan dealer yang menjualnya, membuatnya menjadi pilihan yang tepat bagi penggemar off-road dan trail riding.\r\n\r\n', 'YZ125X.png'),
(3, 'Yamah Jupiter Z1', 3, 15000000.00, 'Yamaha Jupiter Z1 adalah motor bebek yang dilengkapi dengan mesin 4-tak 115cc, SOHC, 2-valve, yang mampu menghasilkan tenaga 9,5 hp dan torsi 9,9 Nm, serta memiliki fitur-fitur seperti transmisi 4-percepatan, rem cakram depan dan belakang, serta suspensi depan teleskopik dan belakang monoshock, serta memiliki kapasitas tangki bensin 4,2 liter dan berat 104 kg, membuatnya menjadi salah satu motor bebek yang populer di Indonesia.\r\n\r\n', 'JUPITERZ1.png'),
(4, 'Yamaha R25', 1, 80000000.00, 'Yamaha R25 adalah motor sport fairing yang dilengkapi dengan mesin 2-silinder, 4-tak, DOHC, 250cc yang mampu menghasilkan tenaga 36 hp dan torsi 22,6 Nm, serta memiliki fitur-fitur seperti transmisi 6-percepatan, rem cakram depan dan belakang, serta suspensi depan upside down dan belakang monoshock, serta dilengkapi dengan teknologi seperti Assist and Slipper Clutch, serta memiliki kapasitas tangki bensin 14,3 liter dan berat 166 kg, membuatnya menjadi salah satu motor sport fairing yang populer di Indonesia.', 'R25.png'),
(5, 'Yamaha Nmax', 1, 28000000.00, 'Yamaha NMAX adalah skuter matik premium yang dilengkapi dengan mesin 155cc, 4-tak, SOHC, 4-valve, yang mampu menghasilkan tenaga 15,1 hp dan torsi 14,4 Nm, serta memiliki fitur-fitur seperti transmisi V-Belt Automatic, rem cakram depan dan belakang, serta suspensi depan teleskopik dan belakang unit swing, serta dilengkapi dengan teknologi seperti Variable Valve Actuation (VVA) dan Blue Core, serta memiliki kapasitas tangki bensin 6,6 liter dan berat 127 kg, membuatnya menjadi salah satu skuter matik yang populer di Indonesia.', '../uploads/maxi.png');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_transaksi`
--

CREATE TABLE `riwayat_transaksi` (
  `id` int(11) NOT NULL,
  `transaksi_id` int(11) NOT NULL,
  `nama_pembeli` varchar(100) NOT NULL,
  `email_pembeli` varchar(100) NOT NULL,
  `alamat_pembeli` text NOT NULL,
  `no_hp_pembeli` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat_transaksi`
--

INSERT INTO `riwayat_transaksi` (`id`, `transaksi_id`, `nama_pembeli`, `email_pembeli`, `alamat_pembeli`, `no_hp_pembeli`) VALUES
(18, 42, 'user', 'user@gmail.com', 'user', '123456789');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `tanggal_transaksi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `id_pengguna`, `id_produk`, `jumlah`, `total_harga`, `tanggal_transaksi`) VALUES
(42, 1, 3, 1, 15.00, '2024-07-03 23:14:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `email`, `role`) VALUES
(1, 'user', '$2y$10$d5KIPZPCHxtSDO.tkI.TEedFA3Ap8//FGz0.Oa8M12IhaZVn46FR6', 'randy', 'user@gmail.com', 'user'),
(2, 'admin', '$2y$10$CI2fqxkoF5neJWV5GwQFVe0Il6un7YTGqrxGDrvaBIdJWErexcW12', 'admin-dealer', 'admin@gmail.com', 'admin'),
(4, 'test', '$2y$10$BD.UMadpzBsC0vG0kE75T.S.rqaF4F/Acn2jbnOoqvAHYhaPHlfui', 'test', 'test@gmail.com', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `users_profile`
--

CREATE TABLE `users_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `foto_ktp` varchar(255) DEFAULT NULL,
  `foto_kk` varchar(255) DEFAULT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_profile`
--

INSERT INTO `users_profile` (`id`, `user_id`, `username`, `password`, `nama`, `foto_ktp`, `foto_kk`, `alamat`, `no_hp`) VALUES
(1, 1, '', '', 'user', '', '', 'bandung', '0813456'),
(3, 4, '', '', 'Testing', 'Capture.PNG', 'lauk 2.PNG', 'idk', '123123123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `riwayat_transaksi`
--
ALTER TABLE `riwayat_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `riwayat_transaksi_ibfk_1` (`transaksi_id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_profile`
--
ALTER TABLE `users_profile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `riwayat_transaksi`
--
ALTER TABLE `riwayat_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users_profile`
--
ALTER TABLE `users_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`);

--
-- Constraints for table `riwayat_transaksi`
--
ALTER TABLE `riwayat_transaksi`
  ADD CONSTRAINT `riwayat_transaksi_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`);

--
-- Constraints for table `users_profile`
--
ALTER TABLE `users_profile`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
