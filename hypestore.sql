-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2026 at 06:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hypestore`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`) VALUES
(1, 'admin', 'admin@gmail.com', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `author` varchar(200) NOT NULL,
  `price` varchar(200) NOT NULL,
  `stock` int(11) NOT NULL,
  `cover` varchar(200) NOT NULL,
  `description` varchar(400) NOT NULL,
  `id_category` int(11) NOT NULL,
  `rating` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `price`, `stock`, `cover`, `description`, `id_category`, `rating`) VALUES
(1, 'The Intelligent Investor', 'Benjamin Graham', '250000', 67, 'theintelligentinvestor.jpg', 'The Intelligent Investor by Benjamin Graham, first published in 1949, is a widely acclaimed book on value investing. The book provides strategies on how to successfully use value investing in the stock market. Historically, the book has been one of the most popular books on investing and Graham\'s legacy remains.', 4, 5),
(3, 'Harry Potter', 'J. K. Rowling', '127000', 21, 'harrypotter.jpg', 'Harry Potter is a series of seven children\'s fantasy novels written by British author J. K. Rowling. The novels chronicle the lives of a young wizard, Harry Potter, and his friends, Ron Weasley and Hermione Granger, among others, all of whom are students at Hogwarts School of Witchcraft and Wizardry.', 3, 4.5),
(4, 'Security Analysis', 'Benjamin Graham', '311000', 10, 'Security_analysis.jpg', 'Security analysis is the evaluation of investments to determine their intrinsic value and risk. Originating from the foundational 1934 book Security Analysis by Benjamin Graham and David Dodd, it provides a systematic framework designed to separate market speculation from true, fact-based investment.', 4, 5),
(5, 'Dari Warung Menuju Alfamart', 'Alberthiene Endah', '120000', 24, 'dariwarung.jpg', '\"Dari Warung Menuju Alfamart\" adalah kisah perjalanan bisnis inspiratif dari pendirinya, Djoko Susanto. Ia memulai kerajaan ritelnya dari sebuah warung kelontong kecil di Pasar Arjuna, Jakarta, sebelum mengakuisisi jaringan Alfa Minimart dan meresmikan gerai pertamanya di Tangerang, Banten, pada tahun 1999.', 7, NULL),
(6, 'Steve Jobs', 'Walter Isaacson', '400000', 8, 'stevejobs.jpg', 'Steve Jobs is the authorized self-titled biography of American business magnate and Apple co-founder Steve Jobs. The book was written at the request of Jobs by Walter Isaacson, a former executive at CNN and Time who had previously written best-selling biographies of Benjamin Franklin and Albert Einstein.', 7, 5),
(7, 'Diary of a Wimpy Kid', 'Jeff Kinney', '300000', 39, 'diaryofawimpykid.jpg', 'Diary of a Wimpy Kid is an American illustrated children\'s novel series and media franchise created by author and cartoonist Jeff Kinney. The series follows Greg Heffley, a middle-schooler who illustrates his daily life in a diary. The characters of the book were first designed in 1998.', 8, 5),
(8, 'The Anarchist Handbook', 'Michael Malice', '500000', 20, 'anarchist.jpg', 'Anarchism has been both a vision of a peaceful, cooperative society—and an ideology of revolutionary terror. Since the term itself—anarchism—is a negation, there is a great deal of disagreement on what the positive alternative would look like. The black flag comes in many colors.The Anarchist Handbook is an opportunity for all these many varied voices to speak for themselves, from across the decad', 5, 5),
(9, 'Animal Farm', 'George Orwell', '300000', 11, 'animalfarm.jpg', 'Animal Farm is a satirical allegorical dystopian novella, in the form of a beast fable, by George Orwell, first published in England on 17 August 1945.', 3, 5),
(10, '1984', 'George Orwell', '300000', 5, '1984.jpg', 'Nineteen Eighty-Four is a dystopian speculative fiction novel by the English writer George Orwell. It was published on 8 June 1949 by Secker & Warburg as Orwell\'s ninth and final completed book. Thematically, it centres on totalitarianism, mass surveillance and repressive regimentation of people and behaviours.', 3, 5),
(11, 'Fahrenheit 451', 'Ray Bradbury', '200000', 17, 'fahrenheit.jpg', 'Fahrenheit 451 is a 1953 dystopian novel by American writer Ray Bradbury. It presents a future American society where books have been outlawed and \"firemen\" burn any that are found.', 3, NULL),
(12, 'Thus Spoke Zarathustra', 'Friedrich Nietzsche', '350000', 8, 'thusspoke.jpg', 'Thus Spoke Zarathustra: A Book for All and None, also translated as Thus Spake Zarathustra, is a work of philosophical fiction written by German philosopher Friedrich Nietzsche and published in four volumes between 1883 and 1885', 5, 5),
(13, 'Clean Code', 'Robert Cecil Martin', '200000', 50, 'cleancode.jpg', 'Bestselling author Robert C. Martin brings new life and updated code to his beloved Clean Code book With Clean Code, Second Edition, Robert C. Martin (\"Uncle Bob\") reinvigorates the classic guide to software craftsmanship with updated insights, broader scope, and enriched content.', 1, NULL),
(14, 'Laskar Pelangi', 'Andrea Hirata', '200000', 21, 'laskarpelangi.jpg', 'Laskar Pelangi adalah novel fenomenal karya Andrea Hirata (2005) dan film adaptasi populer garapan Riri Riza (2008). Kisahnya menceritakan perjuangan 10 anak dari keluarga miskin di Belitung yang bersekolah di SD Muhammadiyah Gantong yang nyaris ditutup, namun tetap gigih mengejar mimpi dengan bimbingan Ibu Muslimo dan Pak Harfan.', 3, 4),
(15, 'Madilog', 'Tan Malaka', '150000', 41, 'madilog.jpg', 'Pada tahun 1943, di tengah situasi perang dan penjajahan, Tan Malaka menuliskan sebuah buku yang kelak menempati posisi penting dalam sejarah pemikiran Indonesia. Buku itu berjudul Madilog: Materialisme, Dialektika, dan Logika.', 5, NULL),
(16, 'How to Win Friends and Influence People', 'Dale Carnegie', '250000', 10, 'howtowin.png', 'How to Win Friends and Influence People is a 1936 self-help book written by Dale Carnegie. Over 30 million copies have been sold worldwide, making it one of the best-selling books of all time. Carnegie had been conducting business education courses in New York since 1912.', 9, NULL),
(17, 'Python Crash Course', 'Eric Matthes', '200000', 20, 'python.png', 'Python Crash Course is the world\'s bestselling programming book, with over 1,500,000 copies sold to date! Python Crash Course is the world\'s best-selling guide to the Python programming language.', 1, NULL),
(18, 'Rich Dad Poor Dad', 'Robert Kiyosaki', '200000', 11, 'richdad.jpg', 'Rich Dad Poor Dad: What the Rich Teach Their Kids About Money That the Poor and Middle Class Do Not! is a 1997 book written by Robert Kiyosaki.', 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` varchar(400) NOT NULL,
  `color` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `color`) VALUES
(1, 'Informatics', 'Informatics is the interdisciplinary study of how information is collected, organized, stored, and processed, bridging the gap between computer systems, data science, and human behavior to transform raw information into actionable knowledge.', 'primary'),
(2, 'History', 'History is the continuous, recorded study of past events, societies, and human experiences that seeks to explain how we evolved, why the world functions as it does today, and what lessons we can learn for the future.', 'success'),
(3, 'Novels', 'A novel is a fictional, long-form narrative written in prose that explores the human experience through a structured blend of setting, character arcs, and plot.', 'warning'),
(4, 'Economics', 'Economics is the social science that studies how individuals, businesses, and societies allocate scarce resources to satisfy unlimited wants and needs.', 'danger'),
(5, 'Philosophy', 'Philosophy is the systematic, rational, and critical study of fundamental questions regarding existence, knowledge, values, reason, mind, and language.', 'dark'),
(7, 'Biography', 'A biography is a detailed, factual account of a real person\'s life, experiences, and achievements, typically written by someone else and often structured in chronological order to highlight the subject\'s personal and professional journey', 'secondary'),
(8, 'Comics', 'Comics are an artistic and visual medium that tells stories or conveys ideas by combining sequential images with text, typically arranged in a series of panels.', 'danger'),
(9, 'Self-Help', 'Self-help is the practice of individuals actively striving to improve their own lives, overcome personal challenges, or build new skills independently, often using resources like books, guides, or peer support groups.', 'success');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `tax` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` varchar(300) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(100) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `id_user`, `subtotal`, `tax`, `total`, `name`, `email`, `phone`, `address`, `created_at`, `status`) VALUES
(2, 2, 550000, 55000, 605000, 'Nevan Garreth Adrianson', 'nevan@gmail.com', '08116767420', 'Wall Street, NYC', '2026-06-20 21:17:59', 'Completed'),
(3, 1, 770000, 77000, 847000, 'Hype', 'hype@gmail.com', '08197800652', 'Little Saint Island', '2026-06-20 23:46:11', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `id_order`, `id_book`, `quantity`, `price`, `subtotal`) VALUES
(1, 2, 9, 1, 300000, 300000),
(2, 2, 16, 1, 250000, 250000),
(3, 3, 5, 1, 120000, 120000),
(4, 3, 7, 1, 300000, 300000),
(5, 3, 12, 1, 350000, 350000);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `id_user`, `id_book`, `rating`) VALUES
(1, 1, 1, 5),
(2, 1, 4, 5),
(3, 1, 3, 4),
(4, 1, 10, 5),
(5, 1, 6, 5),
(6, 1, 12, 5),
(7, 1, 14, 4),
(8, 1, 8, 5),
(9, 2, 3, 5),
(10, 2, 9, 5),
(11, 1, 7, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Hype', 'hype@gmail.com', '34393b55098ba242deac56c14196656c35e9b8994d20eb4427dab9b3f8b14524'),
(2, 'Tram12', 'tram@gmail.com', '322870bbce0fd7203dea49243c20cf3d60579b663e651cccad81586874bb1781');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_books_categories` (`id_category`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cart_users` (`id_user`),
  ADD KEY `fk_cart_books` (`id_book`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_users` (`id_user`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_details_books` (`id_book`),
  ADD KEY `fk_order_details_orders` (`id_order`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_user` (`id_user`,`id_book`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_categories` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_books` FOREIGN KEY (`id_book`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `fk_cart_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_order_details_books` FOREIGN KEY (`id_book`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `fk_order_details_orders` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
