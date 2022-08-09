-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2022 at 02:33 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `main_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `products_db`
--

CREATE TABLE `products_db` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `image` varchar(250) NOT NULL,
  `stock` int(50) NOT NULL,
  `price` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products_db`
--

INSERT INTO `products_db` (`id`, `name`, `brand`, `image`, `stock`, `price`) VALUES
(1, 'Tocino', 'pampanga', './images/productPicturesPage/pampangatocino.png', 50, 54.00),
(2, 'Embotido Roll', 'pampanga', './images/productPicturesPage/pampangaembutido.png', 50, 55.00),
(3, 'Corned Beef', 'pampanga', './images/productPicturesPage/pampangacornedbeef.png', 50, 34.00),
(4, 'Chicken Pops', 'pampanga', './images/productPicturesPage/pampangachicken.png', 50, 63.00),
(5, 'Idol Cheesedog', 'cdo', './images/productPicturesPage/cdocheesedog.png', 50, 44.00),
(6, 'Beef Tapa', 'cdo', './images/productPicturesPage/cdobeef.png', 50, 73.00),
(7, 'Funtastyk Young Pork Tocino', 'cdo', './images/productPicturesPage/cdotocino.png', 50, 57.00),
(8, 'Bingo Chicken Nuggets', 'cdo', './images/productPicturesPage/cdochicken.png', 50, 43.00),
(9, 'Tender Juicy Hotdog Classic', 'tender', './images/productPicturesPage/tenderclassic.png', 50, 170.00),
(10, 'Tender Juicy Hotdog Classic Cheese', 'tender', './images/productPicturesPage/tenderclassiccheese.png', 50, 170.00),
(11, 'Tender Juicy Hotdog Jumbo', 'tender', './images/productPicturesPage/tenderjumbo.png', 50, 170.00),
(12, 'Tender Juicy Hotdog Cocktail', 'tender', './images/productPicturesPage/tendercocktail.png', 50, 170.00),
(13, 'MJB Tapa', 'mjb', './images/productPicturesPage/mjbtapa.png', 50, 56.00),
(14, 'MJB Sisig', 'mjb', './images/productPicturesPage/mjbsisig.png', 50, 68.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products_db`
--
ALTER TABLE `products_db`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products_db`
--
ALTER TABLE `products_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
