-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2024 at 03:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `groovenest`
--

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `genre_ID` int(10) UNSIGNED NOT NULL,
  `genre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`genre_ID`, `genre`) VALUES
(1, 'Alt-Rock'),
(2, 'Rap'),
(3, 'Hip-hop'),
(4, 'Hard-Rock'),
(5, 'Jazz'),
(6, 'Blues'),
(7, 'Classic Country'),
(8, 'Modern Country'),
(9, 'Pop'),
(10, 'Grunge');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_ID` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `summary` text DEFAULT NULL,
  `content` text NOT NULL,
  `image_link` mediumtext DEFAULT NULL,
  `user_ID` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_ID`, `title`, `summary`, `content`, `image_link`, `user_ID`, `date`) VALUES
(1, 'The Album of the Year?', 'Ants From Up There has been on constant replay for me, what\'s so good about it?', 'Ants From Up There, the second album by British band Black Country, New Road, is an extraordinary blend of emotion, innovation, and musicianship. Released in 2022, the album breaks away from traditional genre boundaries, weaving together post-rock, art rock, and experimental pop, all while maintaining an emotional core that resonates deeply with listeners. What makes Ants From Up There stand out is its raw vulnerability, particularly in its lyrics. The album’s themes of longing, loss, and personal struggle are poetically expressed by lead vocalist Isaac Wood, whose departure from the band shortly before the album’s release adds another layer of poignancy. Songs like \"The Place Where He Inserted the Blade\" and \"Concorde\" are hauntingly beautiful, with intricate arrangements that build into cathartic crescendos. The band’s musicianship is another highlight. Their use of violin, saxophone, and unconventional song structures makes each track feel like an emotional journey. The music shifts from delicate melodies to grand, sweeping moments, creating a sense of tension and release that keeps you engaged throughout the album. Ants From Up There is not just an album; it\'s an experience that draws you in and leaves you reflecting on its beauty long after it ends.', 'https://media.pitchfork.com/photos/61649694110e7cd222907396/master/pass/Black-Country-New-Road.jpg', 1, '2024-11-26'),
(2, 'Louder Than Life 2024', 'Metal Festival in Louisville, KY. 10th Anniversary this year, got phone stolen. 5/10 might not go again.', 'This year I decided to go again to a huge rock/metal festival in my hometown called Louder than Life. I got to see almost 50 bands, had some fun experiences, got to mosh, and got to see some of the bands I\'ve wanted to see since I was young. However, a significant downer for me was when I got my phone pickpocketed and stolen, and in addition to that the culture around the festival was significantly different. Not sure that I will actually go again unless it\'s it includes my absolute favorite bands.', 'https://images.squarespace-cdn.com/content/v1/6043f3491f30ca562809c10b/1a3c2358-01c4-44fd-875e-bc62e9d4a607/LTL24_SocialAssets_1200x1500.jpg?format=1500', 3, '2024-11-26'),
(9, 'Learning how to make a post', 'Here is a guide to creating a post.', 'Here is a guide to making a post. \r\n1. Type your title and give a brief summary\r\n2. Pick a Genre that describes your post.\r\n3. Upload an image link to your post.\r\n4. Type your content and then upload it!', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ8vZh3-7FoXfKF7q4Y9xc8XiuGl7ohegaP8w&s', 5, '2024-12-09'),
(10, 'Creating Music', 'My Journey of Making Music', 'I have been to a recording studio twice and I really enjoy making music. Overall, I have been playing for a couple years and I want to get better at doing it!', 'https://upayasound.com/wp-content/uploads/2022/01/recording-music-studio-scaled.jpg', 4, '2024-12-09');

-- --------------------------------------------------------

--
-- Table structure for table `post_r_genres`
--

CREATE TABLE `post_r_genres` (
  `post_ID` int(10) UNSIGNED NOT NULL,
  `genre_ID` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_r_genres`
--

INSERT INTO `post_r_genres` (`post_ID`, `genre_ID`) VALUES
(1, 1),
(2, 1),
(9, 1),
(10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ID` int(10) UNSIGNED NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `firstname` varchar(30) DEFAULT NULL,
  `lastname` varchar(30) DEFAULT NULL,
  `role` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ID`, `email`, `password`, `firstname`, `lastname`, `role`) VALUES
(1, 'land.toml32@gmail.com', '$2y$10$7eysqcPidAak5xiIhQDxXu7231t4lRbVnplKzuhurBKohwceUqZ6a', 'Landen', 'Tomlin', 2),
(2, 'hoffmeierm1@mymail.nku.edu', '$2y$10$7eysqcPidAak5xiIhQDxXu7231t4lRbVnplKzuhurBKohwceUqZ6a', 'Michael', 'HoffMeier', 1),
(3, 'harrisj46@mymail.nku.edu', '$2y$10$QNtCa5NW5/D508yCrJiZNuVIDwpKurjDMaURjPQtVunI9x7UK4Hv2', 'Josh', 'Harris', 1),
(4, 'user@email.com', '$2y$10$ROdGxodelc1myaZCCRpOBeUxqKX4MAsi3KGtOFH0HAJXuTW9ZMKyW', 'User', 'NotAdmin', 1),
(5, 'admin@email.com', '$2y$10$1nYX/t0sZYIpKLfkETHEyO0aEoaMRgOyplW8/evj5yF.W7PdkbMgq', 'Admin', 'IsAdmin', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`genre_ID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexes for table `post_r_genres`
--
ALTER TABLE `post_r_genres`
  ADD PRIMARY KEY (`post_ID`,`genre_ID`),
  ADD KEY `post_ID` (`post_ID`),
  ADD KEY `genre_ID` (`genre_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_r_genres`
--
ALTER TABLE `post_r_genres`
  ADD CONSTRAINT `post_r_genres_ibfk_1` FOREIGN KEY (`post_ID`) REFERENCES `posts` (`post_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_r_genres_ibfk_2` FOREIGN KEY (`genre_ID`) REFERENCES `genres` (`genre_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
