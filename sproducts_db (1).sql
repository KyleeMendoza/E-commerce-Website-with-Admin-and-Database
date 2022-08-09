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
-- Table structure for table `sproducts_db`
--

CREATE TABLE `sproducts_db` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `stock` int(50) NOT NULL,
  `price` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sproducts_db`
--

INSERT INTO `sproducts_db` (`id`, `name`, `brand`, `image`, `stock`, `price`) VALUES
(1, 'Tocino', 'pampanga', './images/productPicturesPage/pampangatocino.png', 50, 52),
(2, 'Embotido Roll', 'pampanga', './images/productPicturesPage/pampangaembutido.png', 50, 50),
(3, 'Corned Beef', 'pampanga', './images/productPicturesPage/pampangacornedbeef.png', 50, 32),
(4, 'Chicken Pops', 'pampanga', './images/productPicturesPage/pampangachicken.png', 50, 60),
(5, 'Idol Cheesedog', 'cdo', './images/productPicturesPage/cdocheesedog.png', 50, 41),
(6, 'Beef Tapa', 'cdo', './images/productPicturesPage/cdobeef.png', 50, 70),
(7, 'Funtastyk Young Pork Tocino', 'cdo', './images/productPicturesPage/cdotocino.png', 50, 54),
(8, 'Bingo Chicken Nuggets', 'cdo', './images/productPicturesPage/cdochicken.png', 50, 40),
(9, 'Tender Juicy Hotdog Classic', 'tender', './images/productPicturesPage/tenderclassic.png', 50, 127),
(10, 'Tender Juicy Hotdog Classic Cheese', 'tender', './images/productPicturesPage/tenderclassiccheese.png', 50, 127),
(11, 'Tender Juicy Hotdog Jumbo', 'tender', './images/productPicturesPage/tenderjumbo.png', 50, 127),
(12, 'Tender Juicy Hotdog Cocktail', 'tender', './images/productPicturesPage/tendercocktail.png', 50, 127),
(13, 'MJB Tapa', 'mjb', './images/productPicturesPage/mjbtapa.png', 50, 53),
(14, 'MJB Sisig', 'mjb', './images/productPicturesPage/mjbsisig.png', 50, 63);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sproducts_db`
--
ALTER TABLE `sproducts_db`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sproducts_db`
--
ALTER TABLE `sproducts_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
