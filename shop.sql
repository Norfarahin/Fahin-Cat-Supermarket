-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2022 at 05:11 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart1`
--

CREATE TABLE `cart1` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `quantity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(100) NOT NULL,
  `pin` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `email`, `password`, `phone`, `address`, `city`, `state`, `pin`) VALUES
(16, 'cha', 'cha123@gmail.com', '202cb962ac59075b964b07152d234b70', '012686745', 'No.97, Jln Tiang Dua', 'Melaka', 'Melaka', 75460),
(17, 'farahyn', 'farahyn@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '0124536782', 'No.98,Kampung Kandang', 'Melaka Tengah', 'Melaka', 75460),
(18, 'alin', 'lin@gmail.com', '202cb962ac59075b964b07152d234b70', '012456734', 'NO.9887, Jln Permatang Pasir', 'Melaka Tengah', 'Melaka', 75460),
(19, 'fatihah', 'tehah@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '0132354674', 'No.76, Jalan Parit Jawa.', 'Muar', 'Johor', 84150),
(20, 'Hafizah Ali', 'pijah@gmail.com', '0bb4aec1710521c12ee76289d9440817', '0114567439', 'No.56,Taman Mutiara,Jalan Kamek', 'Miri', 'Sarawak', 98000),
(21, 'amir', 'amir@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '013546728', 'No.987,Jalan Duyung,', 'Melaka Tengah', 'Melaka', 75460),
(22, 'Hafizah ali', 'hafizah0611@gmail.com', '629d2344763652e75d374c5ba50acd52', '0194594072', 'lot 5750, taman desa senadin, fasa 3c, jalan maingold, lorong sena 1d', 'miri', 'sarawak', 98000);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` decimal(8,2) DEFAULT NULL,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  `shipping_status` varchar(100) DEFAULT 'Preparing to ship',
  `tracknum` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`, `shipping_status`, `tracknum`) VALUES
(36, 17, 'farahyn', '0124536782', 'farahyn@gmail.com', 'credit card', 'No.98,Kampung Kandang, Kampung Alai, Melaka Tengah, Melaka,75460', 'Rantai Kucing (1) ', '15.00', '2022-05-18', 'paid', 'Product had been delivered', 'ZR1661872345'),
(39, 21, 'amir', '013546728', 'amir@gmail.com', 'credit card', 'No.987,Jalan Lipat Kajang,, Kampung Kandang, Melaka Tengah, Melaka,75460', 'Whiskas Kitten (1), Smartheart Cat Licks (2) ', '24.50', '2022-07-24', 'paid', 'Product had been delivered', 'ZR1661552487\r\n'),
(56, 17, 'farahyn zacky', '0124536782', 'farahyn@gmail.com', 'credit card', 'No.98,Kampung Kandang, Melaka Tengah, Melaka, 75460', ',Bola (1) ', '15.80', '2022-08-26', 'paid', 'Product had been shipped by courier', 'ZR1661452234'),
(58, 19, 'fatihah mansor', '0132354674', 'tehah@gmail.com', 'credit card', 'No.76, Jalan Parit Jawa, Muar, Johor, 84150', ',Smartheart Cat Licks (1) ', '16.50', '2022-08-26', 'paid', 'Product had been shipped by courier', 'ZR1661454092'),
(60, 16, 'cha', '012686745', 'cha123@gmail.com', 'credit card', 'No.97, Jln Tiang Dua, Melaka, Melaka, 75460', ',Whiskas Kitten (1) ,Whiskas (1) ', '31.40', '2022-08-30', 'paid', 'Preparing to ship', 'ZR1661861301'),
(62, 16, 'cha', '012686745', 'cha123@gmail.com', 'credit card', 'No.97, Jln Tiang Dua, Melaka, Melaka, 75460', ',Whiskas (1) ', '29.90', '2022-08-30', 'paid', 'Preparing to ship', 'ZR1661863305'),
(63, 22, 'Hafizah ali', '0194594072', 'hafizah0611@gmail.com', 'credit card', 'lot 5750, taman desa senadin, fasa 3c, jalan maingold, lorong sena 1d, miri, sarawak, 98000', ',Royal Canin Hair & Skin (2) ,Smartheart Cat Licks (5) ', '601.10', '2022-08-30', 'paid', 'Preparing to ship', 'ZR1661866719'),
(64, 17, 'Farahin zakariyah', '0124536782', 'farahyn@gmail.com', 'credit card', 'No.98,Kampung Kandang, Melaka Tengah, Melaka, 75460', ',Whiskas Kitten (1) ', '11.50', '2022-09-01', 'paid', 'Ready to ship', 'ZR1662006265');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `image` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `stock` int(100) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `image`, `category`, `type`, `stock`, `date`) VALUES
(23, 'Royal Canin Adult', 'Dry Food 2kg', '79.00', 'adult.jpg', 'Food', 'Dry', 70, '2023-08-19'),
(24, 'Tooth Brush', 'Tooth Brush For Cat', '15.00', 'dental.jpg', 'Care', 'Dental', 10, '2024-02-02'),
(25, 'Fido', 'Shampoo Cat', '15.50', 'syampoo.jpg', 'Care', 'Syampoo', 15, '2023-06-27'),
(26, 'Rantai Kucing', 'Rantai Dileher Kucing', '5.00', 'rantai.jpg', 'Accessories', 'Collars, Tags & Leashes', 10, '0000-00-00'),
(29, 'Botol Air', 'Botol Air Kucing 5ml', '5.00', 'botol.jpg', 'Accessories', 'Bowls & Feeders', 29, '0000-00-00'),
(30, 'Mangkuk Kucing', 'Mangkuk Kucing Dewasa untuk 2 ekor', '10.00', 'mangkuk.jpg', 'Accessories', 'Bowls & Feeders', 40, '0000-00-00'),
(31, 'Purina Adult', 'Makanan kucing dewasa 1kg', '48.90', 'purinadult.jpg', 'Food', 'Dry', 150, '2023-05-16'),
(32, 'Purina Kitten', 'Makanan Anak Kucing bawah 12 bulan 500g', '49.90', 'purinakitten.jpg', 'Food', 'Dry', 200, '2024-03-20'),
(33, 'Pembersih Telinga ', 'Pembersih Telinga Haiwan 5ml', '15.90', 'pembersihtelinga.jpg', 'Care', 'Ear Cleaner', 20, '2025-02-11'),
(34, 'Tilam', 'Tilam Kucing Bulat', '89.90', 'bed.jpg', 'Accessories', 'Bed', 10, '0000-00-00'),
(35, 'Sangkar', 'Sangkar Kucing ', '150.00', 'sangkar.jpg', 'Accessories', 'Carries', 15, '0000-00-00'),
(36, 'Tuna Smart Heart', 'Tuna Tin 400g', '5.50', 'tunatin.jpg', 'Food', 'Canned or Wet', 50, '2023-10-18'),
(37, 'Spray Kutu', 'Spray Kutu Haiwan 5ml', '15.50', 'spraykutu.jpg', 'Care', 'Flea Treatment', 35, '2025-07-09'),
(38, 'Stick Bulu', 'Mainan Stick Bulu Kucing', '4.50', 'stick.jpg', 'Accessories', 'Toys', 25, '0000-00-00'),
(39, 'Sikat', 'Sikat Bulu Kucing', '10.00', 'sikat.jpg', 'Care', 'Toys', 10, '0000-00-00'),
(40, 'Prodiet Kitten', 'Fresh Tuna 85gram', '10.80', 'prodietkitten.jpg', 'Food', 'Moist', 40, '2023-09-10'),
(41, 'Ketip Kuku', 'Ketip Kuku Kucing', '10.60', 'ketipkuku.jpg', 'Care', 'Toys', 10, '0000-00-00'),
(42, 'Mouth Spray', 'Healthy Teeth, Gums for Cat', '32.50', 'dentalcare.jpg', 'Care', 'Dental', 100, '2024-01-31'),
(43, 'PowerCat', 'PowerCat 1.3kg Tuna', '19.80', 'PowerCatTuna.jpg', 'Food', 'Dry', 150, '2025-05-13'),
(44, 'Bola', 'Bola Tikus', '5.80', 'bola.jpg', 'Accessories', 'Toys', 49, '0000-00-00'),
(45, 'Smart Heart', 'Smart Heart Adult 1kg Salmon', '29.80', 'smartheartadult.jpg', 'Food', 'Dry', 150, '2024-08-12'),
(46, 'Royal Canin Hair & Skin', 'Royal Canin Hair & Skin 4kg', '276.80', 'royalcanin.jpg', 'Food', 'Dry', 298, '2024-11-20'),
(47, 'Whiskas', 'Junior 2-12 months 1.1kg', '19.90', 'whiskas.jpg', 'Food', 'Dry', 147, '2024-10-12'),
(48, 'Whiskas Kitten', 'Tuna 85g 2-12 months', '1.50', 'wetkitten.jpg', 'Food', 'Moist', 26, '2024-02-18'),
(49, 'Smartheart Cat Licks', 'Smartheart Cat Licks 15g', '6.50', 'treat.jpg', 'Food', 'Moist', 10, '2023-07-11'),
(50, 'growth booster', '😻penambahan selera kucing\r\n😻tumbesaran kucing semakin membesar\r\n😻bulu semakin lebat dan cantik\r\n😻keguguran bulu semakin berkurang\r\n😻kucing semakin aktif dan sihat\r\n😻Kulit sihat tanpa kurap/kutu\r\n😻kucing sihat penyakit spt selsema', '58.00', 'booster.jpg', 'Care', 'Medicine', 20, '2023-09-12');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `email`, `password`, `gender`, `phone`, `address`) VALUES
(1, 'staff', 'admin@gmail.com', '698d51a19d8a121ce581499d7b701668', 'Female', '0174567242', 'Kedah');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart1`
--
ALTER TABLE `cart1`
  ADD PRIMARY KEY (`id`,`user_id`,`pid`) USING BTREE,
  ADD KEY `pid` (`pid`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart1`
--
ALTER TABLE `cart1`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart1`
--
ALTER TABLE `cart1`
  ADD CONSTRAINT `cart1_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `cart1_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `customer` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customer` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
