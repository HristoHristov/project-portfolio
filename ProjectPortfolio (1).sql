-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 24, 2015 at 01:02 PM
-- Server version: 5.5.43-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ProjectPortfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE IF NOT EXISTS `pictures` (
  `picture_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `picture_name` varchar(200) NOT NULL,
  PRIMARY KEY (`picture_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `pictures`
--

INSERT INTO `pictures` (`picture_id`, `project_id`, `picture_name`) VALUES
(28, 21, 'slide-4.jpg'),
(29, 21, 'slide-2.jpg'),
(30, 21, 'blackgreyredstripe.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(50) NOT NULL,
  `project_isPublic` tinyint(1) NOT NULL,
  `project_user_id` int(11) NOT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `project_name`, `project_isPublic`, `project_user_id`) VALUES
(21, 'E-Books', 0, 24),
(22, 'Pesho', 0, 24),
(23, 'Gosho', 0, 24),
(24, 'Niki', 0, 24),
(25, 'Radul4o', 0, 24);

-- --------------------------------------------------------

--
-- Table structure for table `repositories`
--

CREATE TABLE IF NOT EXISTS `repositories` (
  `repository_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `repository_path` int(11) NOT NULL,
  `file_type` int(11) NOT NULL,
  `file_name` int(11) NOT NULL,
  PRIMARY KEY (`repository_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`) VALUES
(24, 'HristoHristov', 'hristo_d_hristo@mail.bg', '$2y$10$NAZ1vCO.RDdMtECz5eh.vOLnjkbRj6LDi3pX4nyF106gFTzwy6Am2'),
(29, 'kaspar', 'kaspR@abv.bg', '$2y$10$84Ha3VKEyaXSZ.ia3Z9LyeiuybcngXMtEYWk0uuYdQS2zIH/gg7rS'),
(30, 'Administrator', 'Admin@abv.bg', '$2y$10$NAZ1vCO.RDdMtECz5eh.vOLnjkbRj6LDi3pX4nyF106gFTzwy6Am2'),
(31, 'PeterPetkov', 'pesho@abv.bg', '$2y$10$WLCNU7p82hA6iK9/KjFXhusHSQJtucDNSa8t6FSc74T3wI2Zkj0ne'),
(32, 'GeriNikol', 'geri@abv.bg', '$2y$10$/MbA/jTYd83mVIZfw7F52.vqOGelSOpts/GksFMU9KQzbRVKl.o9C'),
(33, 'RusiVidenliev', 'rusi@abv.bg', '$2y$10$RWwwIbfciEHi2dCzpXR7n.fcTKh7QQ32Ur/uQNVBL3fLeR62hCleO'),
(34, 'fasd', 'fsadf@fdasd.bg', '$2y$10$r2m4B1v3kuIRQunyiLjTnOTviLhH8ahgRKf67Myu2j2w53ZsKbDka'),
(35, 'fsafsfdsaf', 'asdfasdfssfds@fsadfds.bg', '$2y$10$Qto38kugk..xqn9.Dxj/uuK3lJJDoJqMSXuMdQDLewPslRjopiJDS'),
(36, 'fasfdsdfsad', 'fsada@asdf.bg', '$2y$10$8cpTK4uEvoCwyf8uk0hrturc66cqf4Oo5dcgfqm3A2NgzNEGCho7a'),
(37, 'fasdfadsdasdsadas', 'fsdfa@asdfasdfs.dsa', '$2y$10$0KUQ9CVlS41EKbhV2wFj4O0Qcd9OD4BVuNcfTqn1yDnQj8Z405v5S');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
