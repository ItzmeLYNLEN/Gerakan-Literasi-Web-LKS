-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2023 at 02:47 PM
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
-- Database: `db_komunitas_literasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `slug`) VALUES
(1, 'Puisi', 'puisi'),
(2, 'Cerpen', 'cerpen'),
(3, 'Naskah Drama', 'naskah-drama'),
(4, 'Quotes', 'quotes'),
(5, 'Novel', 'novel');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `like` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `title`, `slug`, `body`, `thumbnail`, `like`, `views`, `category_id`, `user_id`, `created_at`) VALUES
(1, 'History Of Lamborghinii', 'history-of-lamborghinii', 'pada Januari tahun 1994 silam perusahaan berlogo banteng ngamuk itu resmi dibeli oleh anak dari Presiden ke-2 RI Soeharto, yakni Hutomo Mandala Putra alias Tommy Soeharto. Bersama dengan konglomerat Indonesia Setiawan Jody, Tommy menggelontorkan uang sebesar US$ 40 juta untuk membeli perusahaan Lamborghini melalui perusahaan Megatech.\r\n\"Megatech juga bermaksud menggunakan teknologi mesin Lamborghini untuk membangun sebuah mobil komersial di Indonesia,\r\n\r\nAwal mula dibelinya perusahaan supercar ini bermula ketika Chrysler sebagai pemilik Lamborghini tidak kuat meneruskan kepemilikan perusahaan ini di tengah tekanan ekonomi.\r\nPada 21 Januari 1994, Lamborghini pun beralih ke sebuah perusahaan berbasis di Bermuda bernama Megatech. Namun, pada saat itu jurnal sejarah Lamborghini hanya menyebut pembelinya sebagai unknown Indonesian.\r\nKemudian, diketahui jika Megatech ini dimiliki oleh Tommy dan Jody. Keduanya memiliki sekitar  60 persen saham, sementara sisanya dipegang sebuah perusahaan Malaysia, MyCom Berhad.\r\nSelain Lamborghini, Megatech juga tercatat sebagai pemilik perusahaan Vector. Ini adalah salah satu merek supercar Amerika yang cukup bergaung namanya pada masa itu, tetapi tidak berumur lama.Setelah resmi memiliki Lamborghini, Djody langsung menunjuk Mike Kimberly sebagai presiden dan direktur pelaksana.\r\n\r\nKepemilikan perusahaan supercar Lamborghini berakhir di tangan Tommy dan Jody pada tahun 1998, saat Indonesia mengalami krisis moneter.\r\nLamborghini kemudian  dipegang VW-Audi hingga kini. Meski dijual, Megatech pada saat itu disebut justru mendapatkan untung besar.\r\nSebab, mereka menjual perusahaan Lamborghini dengan harga 110 juta dolar AS dan nilainya menjadi berkali-kali lipat mengingat tingginya nilai dolar saat krisis moneter itu.', 'lambo.jpg', NULL, NULL, 5, 1, '2023-06-18 04:57:19'),
(2, 'Merpati', 'merpati', 'Merpati jemputlah kekasih tatkala ia bertanya jawablah karena cinta Rayu dan cium sambutlah dengan senyum gamit dan kepakkan sayapmu terbanglah sampai tujuh', 'e27e2fdc6fa15f68853e0cfd326c6959.jpg', NULL, NULL, 1, 2, '2023-06-18 11:46:07'),
(3, 'Koin Hitam', 'koin-hitam', 'Kupandangi koin perak yang telah menghitam itu. Tergeletak di meja. Kau tahu, sejak dulu aku tak mau keping koin itu. Tapi tiap kali aku datang ke rumahmu hendak mengembalikannya, yang ada hanya istrimu. Senyumnya yang manis menyuruhku masuk, matanya yang gelisah melirik ke halaman, takut ada yang memergoki.  Setelah kau mati, aku pun sudah berusaha membuang jauh-jauh koin itu berkali-kali. Membuangnya ke selokan. Membuangnya ke tempat sampah. Bahkan sampai jauh ke luar kota. Tapi koin itu selalu saja kembali. Begitu saja: tiba-tiba sudah tergeletak di meja. ', 'licensed-image.jpeg', NULL, NULL, 2, 2, '2023-06-18 12:41:01'),
(4, 'Quotes epep', 'quotes-epep', '“Mabar boleh, ibadah jangan sampai terlewat“  “Jarak bisa memisahkan, tapi party selalu bisa menyatukan kita“  “Hidup itu kayak zona aman, harus terus bergerak atau tereliminasi“', 'Kata-Kata-Bijak-Anak-Free-Fire-768x432.jpg', NULL, NULL, 4, 2, '2023-06-18 12:44:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('1','2') NOT NULL,
  `photo` varchar(255) NOT NULL,
  `role` enum('admin','writter','member','') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `gender`, `photo`, `role`, `created_at`) VALUES
(1, 'dappa', 'lynlen', 'anjime2006@gmail.com', 'zee', '1', '', 'admin', '2023-06-18 04:18:16'),
(2, 'Hapis', 'Robot', 'mio@gmail.com', '123', '1', 'zee.jpg', 'writter', '2023-06-18 05:26:04'),
(3, 'Riski', 'Sule', 'sungutlele@gmail.com', 'qqq', '1', 'zee.jpg', 'member', '2023-06-18 05:27:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
