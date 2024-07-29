-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 17, 2024 at 11:12 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sfp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `adminId` int NOT NULL AUTO_INCREMENT,
  `userId` int NOT NULL,
  PRIMARY KEY (`adminId`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminId`, `userId`) VALUES
(1, 30);

-- --------------------------------------------------------

--
-- Table structure for table `advisor`
--

DROP TABLE IF EXISTS `advisor`;
CREATE TABLE IF NOT EXISTS `advisor` (
  `advisorId` int NOT NULL AUTO_INCREMENT,
  `userId` int NOT NULL,
  `expertiseArea` varchar(15) NOT NULL,
  `experience` int NOT NULL,
  `rating` int NOT NULL,
  PRIMARY KEY (`advisorId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `advisor`
--

INSERT INTO `advisor` (`advisorId`, `userId`, `expertiseArea`, `experience`, `rating`) VALUES
(1, 5, 'Technology', 10, 4),
(2, 6, 'Technology', 7, 2),
(3, 7, 'Art', 30, 5),
(4, 9, 'Art', 25, 5),
(5, 10, 'Comics', 11, 4),
(6, 11, 'Comics', 19, 3),
(7, 12, 'Film', 16, 4),
(8, 13, 'Film', 13, 5),
(9, 14, 'Music', 12, 4),
(10, 15, 'Music', 17, 4),
(11, 16, 'Fashion', 23, 4),
(12, 17, 'Fashion', 10, 3),
(13, 18, 'Technology', 7, 3),
(14, 19, 'Technology', 24, 5),
(15, 20, 'Food', 16, 5),
(16, 21, 'Food', 12, 5),
(17, 22, 'Litreature', 13, 5),
(18, 23, 'Litreature', 12, 4),
(19, 24, 'Photography', 15, 4),
(20, 25, 'Photography', 8, 4),
(21, 26, 'Education', 9, 4),
(22, 27, 'Education', 6, 3);

-- --------------------------------------------------------

--
-- Table structure for table `backer`
--

DROP TABLE IF EXISTS `backer`;
CREATE TABLE IF NOT EXISTS `backer` (
  `backerId` int NOT NULL AUTO_INCREMENT,
  `userId` int NOT NULL,
  PRIMARY KEY (`backerId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `backer`
--

INSERT INTO `backer` (`backerId`, `userId`) VALUES
(1, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

DROP TABLE IF EXISTS `content`;
CREATE TABLE IF NOT EXISTS `content` (
  `contentId` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `body` text,
  `status` varchar(50) DEFAULT NULL,
  `lastUpdated` timestamp NULL DEFAULT NULL,
  `last_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`contentId`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`contentId`, `title`, `type`, `body`, `status`, `lastUpdated`, `last_updated`) VALUES
(1, 'Backer Guide PDF', 'pdf', 'path/to/backer_guide.pdf', 'published', '2024-07-04 13:42:06', '2024-07-04 16:42:06'),
(2, 'Backer Announcement', 'announcement', 'We have a new project for backers!', 'published', '2024-07-04 13:42:06', '2024-07-04 16:42:06'),
(3, 'Entrepreneur Guide PDF', 'pdf', 'path/to/entrepreneur_guide.pdf', 'published', '2024-07-04 13:42:49', '2024-07-04 16:42:49'),
(4, 'Entrepreneur Announcement', 'announcement', 'New funding opportunities for entrepreneurs!', 'published', '2024-07-04 13:42:49', '2024-07-04 16:42:49'),
(5, 'Advisor Guide PDF', 'pdf', 'path/to/advisor_guide.pdf', 'published', '2024-07-04 13:43:15', '2024-07-04 16:43:15'),
(6, 'Advisor Announcement', 'announcement', 'import', 'draft', '2024-07-04 13:43:15', '2024-07-04 17:12:36');

-- --------------------------------------------------------

--
-- Table structure for table `contribution`
--

DROP TABLE IF EXISTS `contribution`;
CREATE TABLE IF NOT EXISTS `contribution` (
  `contributionId` int NOT NULL AUTO_INCREMENT,
  `backerId` int DEFAULT NULL,
  `projectId` int DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `transactionType` varchar(50) DEFAULT NULL,
  `contributionStatus` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `MERCHANTTxRef` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `CHAPAtx_ref` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  PRIMARY KEY (`contributionId`),
  KEY `backerId` (`backerId`),
  KEY `projectId` (`projectId`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contribution`
--

INSERT INTO `contribution` (`contributionId`, `backerId`, `projectId`, `amount`, `date`, `transactionType`, `contributionStatus`, `MERCHANTTxRef`, `CHAPAtx_ref`) VALUES
(1, 1, 1, 10000.00, '2024-05-08 05:46:24', 'contribution', 'success', 'chewatatest-6669', ''),
(2, 1, 4, 3000.00, '2024-05-17 09:11:17', 'contribution', 'success', 'chewatatest-6670', ''),
(3, 1, 6, 10000.00, '2024-07-03 10:23:17', 'refund', 'success', 'chewatatest-6671', ''),
(4, 2, 6, 6000.00, '2024-07-03 03:41:22', 'refund', 'success', 'chewatatest-6672', ''),
(5, 1, 7, 20000.00, '2024-06-05 10:26:43', 'contribution', 'success', 'chewatatest-6673', ''),
(6, 2, 7, 15000.00, '2024-06-01 10:26:43', 'contribution', 'success', 'chewatatest-6674', ''),
(7, NULL, 7, 33250.00, '2024-07-03 10:28:45', 'payout', 'success', 'chewatatest-6676', ''),
(8, 1, 6, 10000.00, '2024-06-04 10:39:58', 'contribution', 'success', 'chewatatest-6675', ''),
(9, 2, 6, 6000.00, '2024-06-02 10:39:58', 'contribution', 'success', 'chewatatest-6667', ''),
(10, 1, 2, 3000.00, '2024-06-18 12:20:14', 'contribution', 'success', 'chewatatest-6668', ''),
(11, 2, 2, 2000.00, '2024-06-07 12:20:14', 'contribution', 'success', 'chewatatest-6657', ''),
(12, NULL, 2, 4750.00, '2024-07-03 12:22:04', 'payout', 'success', 'chewatatest-6647', '');

-- --------------------------------------------------------

--
-- Table structure for table `dispute`
--

DROP TABLE IF EXISTS `dispute`;
CREATE TABLE IF NOT EXISTS `dispute` (
  `disputeId` int NOT NULL AUTO_INCREMENT,
  `reportingUserId` int DEFAULT NULL,
  `reportedUserId` int DEFAULT NULL,
  `disputeType` enum('Service','Payment','Misrepresentation','Review Dispute','Disagreement','Harassment','Fund Misuse','Communication','Other') DEFAULT NULL,
  `description` text,
  `status` varchar(50) DEFAULT NULL,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `resolution` text,
  `resolutionMethod` enum('Warning','Mediation','Suspension','Permanent Ban','Refund') DEFAULT NULL,
  PRIMARY KEY (`disputeId`),
  KEY `reportingUserId` (`reportingUserId`),
  KEY `reportedUserId` (`reportedUserId`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dispute`
--

INSERT INTO `dispute` (`disputeId`, `reportingUserId`, `reportedUserId`, `disputeType`, `description`, `status`, `createdAt`, `resolution`, `resolutionMethod`) VALUES
(1, 1, 20, 'Service', 'Advisor did not provide the agreed services.', 'resolved', '2024-07-04 15:13:20', 'Advisor issued a warning after investigation confirmed failure to provide agreed services. Advised to comply with service agreements.', 'Warning'),
(2, 2, 1, 'Misrepresentation', 'Backer claims entrepreneur provided false information about the project.', 'resolved', '2024-07-04 15:13:20', 'Entrepreneur issued a warning after investigation confirmed the information provided was inaccurate. Advised to correct the project details.', 'Warning'),
(3, 1, 2, 'Review Dispute', 'Entrepreneur disputes negative review left by backer.', 'resolved', '2024-07-04 15:13:20', 'Facilitated a mediation session between entrepreneur and backer to resolve the issue. Review updated to reflect a fair assessment.', 'Mediation'),
(4, 1, 5, 'Disagreement', 'Advisor and entrepreneur have a disagreement over project direction.', 'resolved', '2024-07-04 15:13:20', 'Mediated a discussion between advisor and entrepreneur to align on the project direction and resolve misunderstandings.', 'Mediation'),
(5, 1, 7, 'Service', 'Backer reports advisor\'s advice led to project failure.', 'resolved', '2024-07-04 15:13:20', 'Advisor issued a warning after investigation found advice contributed to project failure. Entrepreneur advised to seek multiple opinions.', 'Warning'),
(6, 1, 24, 'Harassment', 'Entrepreneur reports harassment by an advisor.', 'resolved', '2024-07-04 15:13:20', 'Advisor\'s account terminated and legal action initiated due to confirmed harassment. Zero tolerance policy enforced.', ''),
(7, 3, 2, 'Fund Misuse', 'Backer claims entrepreneur misused the funds.', 'resolved', '2024-07-04 15:13:20', 'Entrepreneur\'s account suspended pending investigation results into fund misuse. Backer advised on the investigation process.', ''),
(8, 5, 1, 'Communication', 'Advisor reports entrepreneur not responding to communication.', 'resolved', '2024-07-04 15:13:20', 'Entrepreneur issued a warning for failing to maintain communication with the advisor. Advised to improve communication practices.', 'Warning'),
(9, 3, NULL, 'Payment', 'Backer disputes refund process handled by the system.', 'resolved', '2024-07-04 15:13:20', 'Processed a full refund to the backer after verifying the dispute. System updated for proper refund procedures.', 'Refund'),
(10, 3, 1, 'Misrepresentation', 'The entrepreneur misrepresented project milestones to backers.', 'open', '2024-07-04 15:13:20', NULL, NULL),
(11, 1, 2, 'Review Dispute', 'The entrepreneur disputes the accuracy of a negative backer review.', 'open', '2024-07-04 15:13:20', NULL, NULL),
(12, 7, 1, 'Disagreement', 'The advisor and entrepreneur cannot agree on the project budget.', 'open', '2024-07-04 15:13:20', NULL, NULL),
(13, 1, 20, 'Service', 'The advice provided by the advisor resulted in project delays.', 'open', '2024-07-04 15:13:20', NULL, NULL),
(14, 7, 1, 'Communication', 'The advisor has not responded to entrepreneur queries for over two weeks.', 'open', '2024-07-04 15:13:20', NULL, NULL),
(15, 2, NULL, 'Payment', 'Backer claims they are eligible for a refund due to project cancellation.', 'open', '2024-07-04 15:13:20', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `entrepreneur`
--

DROP TABLE IF EXISTS `entrepreneur`;
CREATE TABLE IF NOT EXISTS `entrepreneur` (
  `entId` int NOT NULL AUTO_INCREMENT,
  `userId` int NOT NULL,
  PRIMARY KEY (`entId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `entrepreneur`
--

INSERT INTO `entrepreneur` (`entId`, `userId`) VALUES
(1, 1),
(2, 4),
(3, 30),
(8, 40);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `msgId` int NOT NULL AUTO_INCREMENT,
  `senderId` int NOT NULL,
  `receiverId` int NOT NULL,
  `content` text NOT NULL,
  `timeStamps` datetime NOT NULL,
  PRIMARY KEY (`msgId`),
  KEY `senderId` (`senderId`),
  KEY `recieverId` (`receiverId`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msgId`, `senderId`, `receiverId`, `content`, `timeStamps`) VALUES
(1, 3, 1, 'Hello', '2024-06-07 10:36:00'),
(2, 5, 1, 'Hi', '2024-06-07 10:36:00'),
(30, 1, 3, 'Hello', '2024-06-07 10:38:19'),
(33, 1, 5, 'hello', '2024-06-07 11:27:58'),
(34, 1, 3, 'Hi', '2024-06-20 06:02:33'),
(35, 5, 1, 'hello', '2024-06-25 07:28:14'),
(36, 5, 1, 'i am your advisor', '2024-06-25 07:35:04'),
(37, 1, 5, 'ok', '2024-06-25 07:37:08'),
(38, 1, 5, 'what is the procedure', '2024-06-25 07:37:52'),
(39, 1, 5, 'ok', '2024-06-28 08:52:20'),
(40, 1, 3, '', '2024-07-08 09:49:27'),
(41, 1, 5, 'hello', '2024-07-15 16:57:18'),
(42, 1, 3, 'Hello', '2024-07-17 09:36:29');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
CREATE TABLE IF NOT EXISTS `notification` (
  `notifId` int NOT NULL AUTO_INCREMENT,
  `userId` int NOT NULL,
  `notifType` varchar(15) NOT NULL,
  `content` text NOT NULL,
  `status` varchar(10) NOT NULL,
  `timeStamps` datetime NOT NULL,
  PRIMARY KEY (`notifId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notifId`, `userId`, `notifType`, `content`, `status`, `timeStamps`) VALUES
(1, 1, 'backer', 'New backer supported your project!', 'seen', '2024-05-14 00:00:00'),
(2, 1, 'message', 'New message has been received!', 'seen', '2024-05-10 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `projectId` int NOT NULL AUTO_INCREMENT,
  `entId` int NOT NULL,
  `title` varchar(25) NOT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `category` varchar(25) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL,
  `fundingGoals` int NOT NULL,
  `currentFunds` int NOT NULL,
  `status` varchar(15) NOT NULL,
  PRIMARY KEY (`projectId`),
  KEY `FK_ent` (`entId`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`projectId`, `entId`, `title`, `description`, `category`, `startDate`, `endDate`, `fundingGoals`, `currentFunds`, `status`) VALUES
(1, 1, 'SFP', 'A crowd funding platform in order to fund startups in Ethiopia', 'Technology', '2024-04-01 00:00:00', '2024-05-30 00:00:00', 100000, 20000, 'IN PROGRESS'),
(2, 1, 'Jegnaw', 'An Ethiopian comic book about a war hero who lived during the battle of Adwa.', 'Comic', '2024-04-02 00:00:00', '2024-04-24 00:00:00', 50000, 50000, 'COMPLETED'),
(3, 1, 'Chessly', 'This is a great chess website where users can learn chess principles and practice with other fellow users.', 'Technology', '2024-05-15 00:00:00', '2024-07-10 00:00:00', 75000, 0, 'PENDING'),
(4, 1, 'Leather', 'We will create a great leather made shoes, bags belts and all sort of things.', 'Fashion', '2024-05-01 07:20:21', '2024-05-31 11:30:19', 25000, 22000, 'IN PROGRESS'),
(5, 1, 'The struggles of a MAN', 'it is a short film about a life of a man from birth to death.', 'Film', '2024-06-01 11:00:00', '2024-07-01 11:00:00', 35000, 35000, 'COMPLETED'),
(6, 1, 'Walk the Earth - Africa\'s', 'With your support, \"Walk the Earth\" will be my third photographic book, after \"Light and Dust\" and \"One Life”. This will be my first book entirely ded', 'Photography', '2024-06-08 09:28:00', '2024-07-26 09:28:00', 56000, 16000, 'IN PROGRESS'),
(7, 1, 'Tastelli Kids: Squeezable', 'What is Tastelli?\r\nThree years ago, two business school friends and I founded Tastelli with the goal of launching healthy, on-the-go, jelly snacks made in Korea. Our first product, Tastelli Drinkable Konjac Jelly, is a 10-calorie sugar free jelly snack with collagen and antioxidants. Since launching, we have expanded to have four flavors and can be found in over 1,000 stores in 20+ states. We have also been featured in Inc. Magainze, Buzzfeed and various health magazines. \r\n\r\nOne of the most common questions we get asked about Tastelli Drinkable Konjac Jelly is \"can my kid drink this?\" While technically Tastelli is safe for kids, it wasn\'t made for kids. Kids don\'t really care about a snack with 10 calories and certainly don\'t need collagen at their age. However, kids loved the product! For the past few years, we\'ve read so many positive reviews about children\'s reactions to Tastelli and were tagged in numerous photos and videos of them delighted by the fruity flavors. \r\n\r\nInspired by the overwhelming love from our youngest customers, we created a product especially for them! \r\n\r\nIntroducing Tastelli Kids \r\nTastelli Kids is an all natural fruit jel packaged in a convenient pouch. Fortified with fiber and vitamins, it\'s the perfect fruity snack for kids. We\'ve tested the formula ourselves and with dozens of kids and can say it\'s absolutely delicious. Our first two flavors are apple and mango. ', 'Food', '2024-06-04 11:45:00', '2024-06-28 11:45:00', 5000, 0, 'PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `projectteam`
--

DROP TABLE IF EXISTS `projectteam`;
CREATE TABLE IF NOT EXISTS `projectteam` (
  `memberId` int NOT NULL AUTO_INCREMENT,
  `projectId` int NOT NULL,
  `memberEmail` varchar(500) NOT NULL,
  PRIMARY KEY (`memberId`),
  KEY `projectId` (`projectId`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projectteam`
--

INSERT INTO `projectteam` (`memberId`, `projectId`, `memberEmail`) VALUES
(1, 3, 'haile@gmail.com'),
(2, 3, ' alem@gmail.com'),
(3, 4, 'aseb@gmail.com'),
(4, 4, 'elsa@gmail.com'),
(5, 4, 'bemni@gmail.com'),
(6, 7, 'alem@gmail.com'),
(7, 7, 'haile1@gmail.com'),
(8, 7, 'elsa@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

DROP TABLE IF EXISTS `request`;
CREATE TABLE IF NOT EXISTS `request` (
  `requestId` int NOT NULL AUTO_INCREMENT,
  `entId` int NOT NULL,
  `advisorId` int NOT NULL,
  `projectId` int NOT NULL,
  `purposeOfAdvising` text NOT NULL,
  `advisingMethod` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `preferredTime` datetime DEFAULT NULL,
  `additionalInformation` text,
  `requestDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `response` text,
  `requestStatus` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT 'PENDING',
  PRIMARY KEY (`requestId`),
  KEY `entId` (`entId`),
  KEY `advisorId` (`advisorId`),
  KEY `projectId` (`projectId`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`requestId`, `entId`, `advisorId`, `projectId`, `purposeOfAdvising`, `advisingMethod`, `preferredTime`, `additionalInformation`, `requestDate`, `response`, `requestStatus`) VALUES
(1, 1, 1, 1, 'To get more funding', 'In-Chat', '2024-06-02 10:46:00', '', '2024-05-29 16:40:30', NULL, 'PENDING'),
(2, 1, 19, 6, 'Waiting for Aproval', NULL, NULL, NULL, '2024-05-30 06:49:45', NULL, 'PENDING'),
(4, 1, 15, 7, 'Waiting for Aproval', NULL, NULL, NULL, '2024-05-30 08:51:47', NULL, 'PENDING'),
(5, 1, 3, 32, 'Waiting for Aproval', NULL, NULL, NULL, '2024-05-31 16:36:16', NULL, 'PENDING'),
(6, 1, 1, 2, 'asas', 'In-Chat', '2024-06-05 19:48:00', 'ewrfaw', '2024-05-31 16:48:16', NULL, 'PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `commentId` int NOT NULL AUTO_INCREMENT,
  `projectId` int NOT NULL,
  `userId` int NOT NULL,
  `content` varchar(150) NOT NULL,
  `response` text,
  `rating` int NOT NULL,
  `timeStamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rtimeStamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`commentId`),
  KEY `userId` (`userId`),
  KEY `projectId` (`projectId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`commentId`, `projectId`, `userId`, `content`, `response`, `rating`, `timeStamp`, `rtimeStamp`) VALUES
(1, 1, 2, 'It is a good Project, But its UI is not Great.', 'assD', 3, '2024-04-11 10:43:35', '2024-05-31 16:52:14'),
(2, 1, 3, 'It is a usless project, Don\'t waste people money!', 'ok', 1, '2024-04-15 15:24:46', '2024-05-11 18:58:32'),
(3, 2, 3, 'It is a great project.', 'thanks', 4, '2024-05-16 00:00:00', '2024-05-20 17:09:17'),
(4, 3, 2, 'it is amazing!', 'thanks', 5, '2024-05-02 00:00:00', '2024-05-20 18:25:19');

-- --------------------------------------------------------

--
-- Table structure for table `uploadedfile`
--

DROP TABLE IF EXISTS `uploadedfile`;
CREATE TABLE IF NOT EXISTS `uploadedfile` (
  `uploadId` int NOT NULL AUTO_INCREMENT,
  `projectId` int NOT NULL,
  `type` varchar(50) NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY (`uploadId`),
  KEY `projectId` (`projectId`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uploadedfile`
--

INSERT INTO `uploadedfile` (`uploadId`, `projectId`, `type`, `content`) VALUES
(1, 3, 'IMAGE', '/Final_project_code/Entrepernuer/Upload/Bard_Generated_Image.jpg'),
(2, 4, 'PDF', '/Final_project_code/Entrepernuer/Upload/Chapter-4.pdf'),
(3, 5, 'IMAGE', '/Final_project_code/Entrepernuer/Upload/advisor.jpg'),
(4, 6, 'IMAGE', '/Final_project_code/Entrepernuer/Upload/Walk_the_earth_book.jpg'),
(5, 7, 'IMAGE', '/Final_project_code/Entrepernuer/Upload/Tastelli_Kids.jpg'),
(6, 1, 'IMAGE', '/Final_project_code/Entrepernuer/Upload/Bard_Generated_Image.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `useractivitylog`
--

DROP TABLE IF EXISTS `useractivitylog`;
CREATE TABLE IF NOT EXISTS `useractivitylog` (
  `activityId` int NOT NULL AUTO_INCREMENT,
  `userId` int DEFAULT NULL,
  `activityType` varchar(100) DEFAULT NULL,
  `description` text,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`activityId`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=1402 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `useractivitylog`
--

INSERT INTO `useractivitylog` (`activityId`, `userId`, `activityType`, `description`, `timestamp`) VALUES
(1, 1, 'login', 'User logged in', '2024-07-02 11:51:13'),
(2, 1, 'project_creation', 'User created a new project titled \"SFP\"', '2024-07-02 11:51:13'),
(3, 2, 'contribution_made', 'User contributed 3000 ETB to project \"Leather\"', '2024-07-02 11:51:13'),
(4, 1, 'password_change', 'User changed password', '2024-07-02 11:51:13'),
(6, 16, 'project_approve', 'Advisor approved project \"Leather\"', '2024-07-02 11:51:13'),
(7, 4, 'user_suspend', 'Admin suspended user account for violation of terms', '2024-07-02 11:51:13'),
(9, 1, 'login', 'User logged in', '2024-07-02 14:34:54'),
(24, 5, 'login', 'User logged in', '2024-07-02 14:44:39'),
(26, 5, 'advising_accept', 'Advisor accepted advising request for project SFP', '2024-07-02 14:44:54'),
(44, 5, 'login', 'User logged in', '2024-07-02 15:09:25'),
(48, 2, 'login', 'User logged in', '2024-07-02 15:13:01'),
(52, 5, 'login', 'User logged in', '2024-07-02 15:21:02'),
(54, 2, 'login', 'User logged in', '2024-07-02 15:21:14'),
(60, 30, 'login', 'User logged in', '2024-07-02 15:55:18'),
(65, 30, 'login', 'User logged in', '2024-07-03 07:00:27'),
(154, 30, 'login', 'User logged in', '2024-07-03 09:14:12'),
(258, 30, 'login', 'User logged in', '2024-07-03 12:07:18'),
(267, 30, 'login', 'User logged in', '2024-07-03 12:53:21'),
(275, 30, 'login', 'User logged in', '2024-07-03 17:57:21'),
(278, 30, 'login', 'User logged in', '2024-07-04 09:30:39'),
(372, 30, 'login', 'User logged in', '2024-07-05 05:55:24'),
(472, 1, 'login', 'User logged in', '2024-07-06 04:45:42'),
(502, 30, 'login', 'User logged in', '2024-07-06 05:11:26'),
(539, 30, 'login', 'User logged in', '2024-07-06 11:19:11'),
(554, 30, 'login', 'User logged in', '2024-07-07 05:15:20'),
(677, 30, 'login', 'User logged in', '2024-07-07 08:31:09'),
(684, 30, 'login', 'User logged in', '2024-07-07 08:36:14'),
(707, 2, 'login', 'User logged in', '2024-07-07 09:07:01'),
(728, 2, 'login', 'User logged in', '2024-07-07 09:31:59'),
(753, NULL, 'failed_login', 'Failed login attempt', '2024-07-07 10:05:46'),
(754, 30, 'login', 'User logged in', '2024-07-07 10:06:39'),
(764, 1, 'login', 'User logged in', '2024-07-07 10:16:48'),
(771, 30, 'login', 'User logged in', '2024-07-07 10:30:27'),
(792, 2, 'login', 'User logged in', '2024-07-07 16:24:00'),
(800, 2, 'login', 'User logged in', '2024-07-07 19:23:29'),
(815, 2, 'login', 'User logged in', '2024-07-08 06:24:04'),
(825, 2, 'login', 'User logged in', '2024-07-08 06:40:29'),
(848, 1, 'login', 'User logged in', '2024-07-08 09:47:00'),
(855, 1, 'message_sent', 'User sent a message to userId 3', '2024-07-08 09:49:27'),
(924, NULL, 'failed_login', 'Failed login attempt', '2024-07-08 10:58:34'),
(925, 5, 'login', 'User logged in', '2024-07-08 10:59:05'),
(927, 1, 'login', 'User logged in', '2024-07-08 11:15:19'),
(948, 5, 'login', 'User logged in', '2024-07-08 11:16:11'),
(959, 5, 'advising_accept', 'Advisor accepted advising request for project SFP', '2024-07-08 11:18:11'),
(963, 5, 'advising_accept', 'Advisor accepted advising request for project Jegnaw', '2024-07-08 11:18:34'),
(968, 2, 'login', 'User logged in', '2024-07-08 11:20:51'),
(1011, 5, 'login', 'User logged in', '2024-07-08 11:33:45'),
(1013, 5, 'advising_accept', 'Advisor accepted advising request for project Jegnaw', '2024-07-08 11:33:50'),
(1017, 5, 'advising_accept', 'Advisor accepted advising request for project SFP', '2024-07-08 11:34:58'),
(1020, 5, 'advising_accept', 'Advisor accepted advising request for project SFP', '2024-07-08 11:37:00'),
(1022, 5, 'advising_accept', 'Advisor accepted advising request for project Jegnaw', '2024-07-08 11:37:05'),
(1025, 5, 'advising_accept', 'Advisor accepted advising request for project SFP', '2024-07-08 11:37:58'),
(1029, 5, 'advising_accept', 'Advisor accepted advising request for project SFP', '2024-07-08 11:40:51'),
(1034, 5, 'advising_accept', 'Advisor accepted advising request for project Jegnaw', '2024-07-08 11:42:01'),
(1038, 5, 'advising_accept', 'Advisor accepted advising request for project SFP', '2024-07-08 11:44:41'),
(1041, 5, 'advising_accept', 'Advisor accepted advising request for project Jegnaw', '2024-07-08 11:46:20'),
(1044, 5, 'advising_accept', 'Advisor accepted advising request for project SFP', '2024-07-08 11:47:38'),
(1046, 5, 'advising_accept', 'Advisor accepted advising request for project Jegnaw', '2024-07-08 11:50:23'),
(1050, 5, 'advising_accept', 'Advisor accepted advising request for project SFP', '2024-07-08 11:52:51'),
(1054, 5, 'advising_accept', 'Advisor accepted advising request for project Jegnaw', '2024-07-08 11:53:32'),
(1057, 5, 'advising_accept', 'Advisor accepted advising request for project SFP', '2024-07-08 11:53:46'),
(1062, 1, 'login', 'User logged in', '2024-07-08 11:54:50'),
(1072, 30, 'login', 'User logged in', '2024-07-08 11:55:22'),
(1076, 30, 'login', 'User logged in', '2024-07-08 12:10:10'),
(1104, 2, 'login', 'User logged in', '2024-07-08 12:16:47'),
(1154, 30, 'login', 'User logged in', '2024-07-08 13:52:13'),
(1157, 2, 'login', 'User logged in', '2024-07-08 13:53:31'),
(1160, 30, 'failed_login', 'Failed login attempt', '2024-07-08 13:55:08'),
(1161, 30, 'login', 'User logged in', '2024-07-08 13:55:18'),
(1163, 2, 'login', 'User logged in', '2024-07-11 08:57:55'),
(1212, NULL, 'account_creation', 'User account created', '2024-07-14 08:33:52'),
(1213, 40, 'failed_login', 'Failed login attempt', '2024-07-14 08:34:22'),
(1214, NULL, 'account_creation', 'User account created', '2024-07-14 08:36:07'),
(1215, 40, 'failed_login', 'Failed login attempt', '2024-07-14 08:36:28'),
(1216, 40, 'account_creation', 'User account created', '2024-07-14 08:44:24'),
(1217, 40, 'login', 'User logged in', '2024-07-14 08:44:39'),
(1231, 41, 'account_creation', 'User account created', '2024-07-14 10:43:02'),
(1232, 1, 'login', 'User logged in', '2024-07-14 10:48:58'),
(1240, 40, 'login', 'User logged in', '2024-07-15 13:40:50'),
(1401, 2, 'logout', 'User logged out', '2024-07-17 11:06:02'),
(1400, 2, 'login', 'User logged in', '2024-07-17 10:28:48'),
(1399, 2, 'logout', 'User logged out', '2024-07-17 10:04:11'),
(1398, 2, 'login', 'User logged in', '2024-07-17 10:03:36'),
(1397, 1, 'logout', 'User logged out', '2024-07-17 09:49:11'),
(1396, 1, 'message_sent', 'User sent a message to userId 3', '2024-07-17 09:36:29'),
(1395, 1, 'notification_read', 'User read a notification', '2024-07-17 09:23:42'),
(1394, 1, 'login', 'User logged in', '2024-07-17 09:22:40'),
(1393, 1, 'login', 'User logged in', '2024-07-16 10:10:40'),
(1392, 2, 'logout', 'User logged out', '2024-07-16 09:35:29'),
(1391, 2, 'login', 'User logged in', '2024-07-16 09:21:27'),
(1390, 1, 'logout', 'User logged out', '2024-07-16 09:21:15'),
(1389, 1, 'login', 'User logged in', '2024-07-16 09:13:03'),
(1258, 5, 'login', 'User logged in', '2024-07-15 13:44:33'),
(1388, 5, 'logout', 'User logged out', '2024-07-16 06:10:58'),
(1387, 1, 'login', 'User logged in', '2024-07-16 06:10:33'),
(1386, 5, 'logout', 'User logged out', '2024-07-16 06:08:09'),
(1385, 2, 'login', 'User logged in', '2024-07-16 06:07:53'),
(1384, 5, 'logout', 'User logged out', '2024-07-16 06:07:42'),
(1264, 5, 'advising_accept', 'Advisor accepted advising request for project SFP', '2024-07-15 13:45:02'),
(1383, 30, 'login', 'User logged in', '2024-07-16 06:07:27'),
(1382, 5, 'logout', 'User logged out', '2024-07-16 06:07:18'),
(1381, 5, 'login', 'User logged in', '2024-07-16 06:06:11'),
(1380, 2, 'logout', 'User logged out', '2024-07-16 06:05:52'),
(1379, 30, 'login', 'User logged in', '2024-07-16 06:05:20'),
(1378, 2, 'logout', 'User logged out', '2024-07-16 06:05:06'),
(1274, 1, 'login', 'User logged in', '2024-07-15 13:54:39'),
(1377, 2, 'logout', 'User logged out', '2024-07-16 06:04:53'),
(1376, 2, 'login', 'User logged in', '2024-07-16 06:04:31'),
(1375, 2, 'login', 'User logged in', '2024-07-16 06:03:02'),
(1374, 2, 'logout', 'User logged out', '2024-07-15 20:29:25'),
(1373, 2, 'login', 'User logged in', '2024-07-15 19:37:07'),
(1372, 2, 'logout', 'User logged out', '2024-07-15 19:36:49'),
(1371, 2, 'logout', 'User logged out', '2024-07-15 19:05:36'),
(1370, 2, 'logout', 'User logged out', '2024-07-15 19:05:24'),
(1286, 5, 'login', 'User logged in', '2024-07-15 13:59:07'),
(1369, 1, 'login', 'User logged in', '2024-07-15 19:05:16'),
(1368, 30, 'login', 'User logged in', '2024-07-15 19:05:02'),
(1367, 2, 'login', 'User logged in', '2024-07-15 19:04:49'),
(1366, NULL, 'logout', 'User logged out', '2024-07-15 19:01:33'),
(1365, 1, 'logout', 'User logged out', '2024-07-15 19:01:29'),
(1364, 1, 'login', 'User logged in', '2024-07-15 19:00:02'),
(1363, 30, 'logout', 'User logged out', '2024-07-15 18:54:56'),
(1362, 30, 'login', 'User logged in', '2024-07-15 18:54:39'),
(1361, 2, 'login', 'User logged in', '2024-07-15 18:54:18'),
(1298, 1, 'login', 'User logged in', '2024-07-15 15:17:00'),
(1360, 5, 'login', 'User logged in', '2024-07-15 18:53:55'),
(1359, 1, 'login', 'User logged in', '2024-07-15 18:53:36'),
(1358, 30, 'login', 'User logged in', '2024-07-15 18:29:45'),
(1357, NULL, 'logout', 'User logged out', '2024-07-15 18:25:07'),
(1356, NULL, 'logout', 'User logged out', '2024-07-15 18:23:20'),
(1355, NULL, 'logout', 'User logged out', '2024-07-15 18:23:14'),
(1354, 30, 'login', 'User logged in', '2024-07-15 18:23:03'),
(1306, 1, 'login', 'User logged in', '2024-07-15 15:20:11'),
(1353, 30, 'login', 'User logged in', '2024-07-15 18:19:17'),
(1352, 2, 'login', 'User logged in', '2024-07-15 18:15:12'),
(1309, 1, 'login', 'User logged in', '2024-07-15 15:23:18'),
(1310, 1, 'login', 'User logged in', '2024-07-15 15:23:37'),
(1311, 1, 'login', 'User logged in', '2024-07-15 15:26:20'),
(1312, 1, 'failed_login', 'Failed login attempt', '2024-07-15 15:26:38'),
(1313, 1, 'login', 'User logged in', '2024-07-15 15:26:55'),
(1314, 5, 'login', 'User logged in', '2024-07-15 15:27:09'),
(1315, 1, 'login', 'User logged in', '2024-07-15 15:30:17'),
(1316, 1, 'login', 'User logged in', '2024-07-15 15:31:57'),
(1317, 1, 'login', 'User logged in', '2024-07-15 15:35:19'),
(1318, 5, 'login', 'User logged in', '2024-07-15 15:35:58'),
(1351, 30, 'login', 'User logged in', '2024-07-15 18:14:27'),
(1350, 30, 'login', 'User logged in', '2024-07-15 18:14:14'),
(1349, 1, 'login', 'User logged in', '2024-07-15 16:58:35'),
(1348, 5, 'login', 'User logged in', '2024-07-15 16:58:21'),
(1347, NULL, 'logout', 'User logged out', '2024-07-15 16:57:41'),
(1346, 1, 'message_sent', 'User sent a message to userId 5', '2024-07-15 16:57:18'),
(1345, 1, 'login', 'User logged in', '2024-07-15 16:49:52'),
(1344, NULL, 'logout', 'User logged out', '2024-07-15 16:49:42'),
(1330, 1, 'login', 'User logged in', '2024-07-15 15:37:16'),
(1343, 5, 'advising_accept', 'Advisor accepted advising request for project Jegnaw', '2024-07-15 16:39:55'),
(1332, 1, 'login', 'User logged in', '2024-07-15 15:50:10'),
(1333, 5, 'login', 'User logged in', '2024-07-15 15:50:35'),
(1342, 5, 'login', 'User logged in', '2024-07-15 16:39:26'),
(1341, 5, 'failed_login', 'Failed login attempt', '2024-07-15 16:39:13'),
(1337, 2, 'login', 'User logged in', '2024-07-15 16:20:06'),
(1338, 30, 'login', 'User logged in', '2024-07-15 16:21:31'),
(1340, NULL, 'logout', 'User logged out', '2024-07-15 16:38:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userId` int NOT NULL AUTO_INCREMENT,
  `fName` varchar(50) NOT NULL,
  `mName` varchar(50) NOT NULL,
  `lName` varchar(50) NOT NULL,
  `gender` char(6) NOT NULL,
  `dob` date NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `phone` int NOT NULL,
  `accountType` varchar(25) NOT NULL,
  `profileImage` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '/Final_project_code/Home/uploads/Avatar-Profile.png',
  `userStatus` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'active',
  `business_name` text,
  `account_name` text,
  `subaccount_id` text,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `account_activation_hush` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `reset_token_hash` (`reset_token_hash`),
  UNIQUE KEY `account_activation_hush` (`account_activation_hush`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `fName`, `mName`, `lName`, `gender`, `dob`, `username`, `password`, `email`, `phone`, `accountType`, `profileImage`, `userStatus`, `business_name`, `account_name`, `subaccount_id`, `reset_token_hash`, `reset_token_expires_at`, `account_activation_hush`) VALUES
(1, 'Musie', 'Merseeahazen', 'yeshitila', 'Male', '2001-02-13', 'Musie', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'theimpalervlad910@gmail.com', 953477032, 'Entrepreneur', '/Final_project_code/Home/uploads/Avatar-Profile.png', 'active', 'HarmoniVibe Ventures', 'Musie Merseeahazen Yeshitila', '4793d655-8ab7-46cf-a885-16e841ff0e46', NULL, NULL, NULL),
(2, 'Alazer', 'Girma', 'Mengistu', 'Male', '1988-09-01', 'Alex', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'alex103@gmail.com', 955123856, 'Backer', '/Final_project_code/Home/uploads/Backer.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Eleni', 'Mesay', 'Mule', 'Female', '2000-01-17', 'Eleni Mesay Mule', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'Eleni8@gmail.com', 985947626, 'Backer', '/Final_project_code/Home/uploads/Backer.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Yohannes', 'Alemu', 'Desalegn', 'Male', '2002-01-30', 'Yohannes Alemu Desalegn', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'jo@gmail.com', 921376653, 'Entrepreneur', '/Final_project_code/Home/uploads/Avatar-Profile.png', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Elias', 'HaileEyesus', 'Asefa', 'Male', '1976-03-30', 'Elias HaileEyesus Asefa', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'elaasse@gmail.com', 927659324, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Yonatan', 'Kinfe', 'Alem', 'Male', '1984-11-11', 'Yonatan Kinfe Alem', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'yonatan@gmail.com', 943767243, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Ashenafi', 'Berhan', 'Abebe', 'Male', '1970-01-01', 'Ashenafi Berhan Abebe', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'Asheu1@gmail.com', 911753259, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Genet', 'Fikadu', 'Assefa', 'Female', '1972-02-05', 'Genet Fikadu Assefa', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'genet123@gmail.com', 914753259, 'Backer', '/Final_project_code/Home/uploads/Backer.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'Genet', 'Fekadu', 'Asefa', 'Female', '1973-03-10', 'Genet Fekadu Asefa', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'geni4@gmail.com', 913753259, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Ermias', 'Kebede', 'Mulugeta', 'Male', '1974-04-15', 'Ermias Kebede Mulugeta', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'ermias@gmail.com', 915753259, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'Zenebech', 'Tadesse', 'Haile', 'Female', '1975-05-20', 'Zenebech Tadesse Haile', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'zenebech@gmail.com', 916753259, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'Worknesh', 'Mekonnen', 'Gemechu', 'Female', '1976-06-25', 'Worknesh Mekonnen Gemechu', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'workneshgemechu@gmail.com', 917753259, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'Sisay', 'Lemma', 'Tesfaye', 'Male', '1972-02-05', 'Sisay Lemma Tesfaye', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'sisay@gmail.com', 918753259, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'Selamawit', 'Gebremedhin', 'Getachew', 'Female', '1977-07-30', 'Selamawit Gebremedhin Getachew', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'selamawit@gmail.com', 919753259, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'Yared', 'Abera', 'Tewodros', 'Male', '1978-08-02', 'Yared Abera Tewodros', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'yared@gmail.com', 921753259, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'Hiwot', 'Mulugeta', 'Mekonnen', 'Female', '1979-09-06', 'Hiwot Mulugeta Mekonnen', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'hiwot@gmail.com', 922753259, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'Abenet', 'Teshome', 'Girma', 'Male', '1980-10-11', 'Abenet', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'abenetgirma@gmail.com', 931753259, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'Tsion', 'Hailu', 'Alemayehou', 'Female', '1981-11-16', 'Tsion Hailu Alemayehou', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'tsion@gmail.com', 941753259, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'Melkamu', 'Taye', 'Tsegaye', 'Male', '1982-12-21', 'Melkamu Taye Tsegaye', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'melkamu@gmail.com', 951753259, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'Mahlet', 'Haile', 'Kassahun', 'Female', '1983-01-26', 'Mahlet Haile Kassahun', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'mahlet@gmail.com', 961753259, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'Getachew', 'Wolde', 'Baye', 'Male', '1984-02-03', 'Getachew Wolde Baye', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'getachew@gmail.com', 971753259, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'Almaz', 'Negash', 'Mengistu', 'Female', '1985-02-05', 'Almaz Negash Mengistu', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'almaz@gmail.com', 981753259, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'Tesfaye', 'Habtemariam', 'Seyoum', 'Male', '1986-02-05', 'Tesfaye Habtemariam Seyoum', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'tesfaye@gmail.com', 991753259, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'Tirhas', 'Gebremedhin', 'Abebe', 'Female', '1987-02-05', 'Tirhas Gebremedhin Abebe', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'tirhasabebe@gmail.com', 911753256, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'Amanuel', 'Belay', 'Yohannes', 'Male', '1977-02-05', 'Amanuel', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'amanuel@gmail.com', 911753255, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'Kidus', 'Gebre', 'Alemayehu', 'Male', '1995-02-05', 'Kidus Gebre Alemayehu', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'kidus@gmail.com', 911753254, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'Fikir', 'Ayele', 'Seifu', 'Female', '1999-07-25', 'Fikir', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'fikir@gmail.com', 912753259, 'Advisor', '/Final_project_code/Home/uploads/Advisor.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'Halie', 'Tesfaye', 'Giyorgis', 'Male', '1995-01-20', 'Haile', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'haile1@gmail.com', 911346790, 'Admin', '/Final_project_code/Home/uploads/Admin.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(33, 'Yohannes', 'Gossaye', 'Zewde', 'Male', '2001-05-23', 'John', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'bodywon80@gmail.com', 953422606, 'Entrepreneur', '/Final_project_code/Home/uploads/Avatar-Profile.png', 'active', NULL, NULL, NULL, NULL, NULL, '8f1a222649fd796442a2baecde511941879ce0405d781d9f168876ce38e82aab'),
(34, 'zerbiba', 'rodas', 'alemayhu', 'Female', '1988-04-20', 'zeriba', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'zeriba@gmail.com', 932422606, 'Backer', '/Final_project_code/Home/uploads/Backer.jpg', 'active', NULL, NULL, NULL, NULL, NULL, 'e73a8812c61f9bb69d4dc5183afb37d069a71c9bfb33820cdc40e6fed5557bd9'),
(40, 'Miheret', 'Girma', 'Baye', 'Female', '1998-06-16', 'Miheret', '$2y$10$qvfoM2.dj63BTc/duXa6ZOh3LIJl5WOsSa6IwaCO7sb3bDrCgfVhi', 'theimpalervlad910@gmail.com', 942423607, 'Entrepreneur', '/Final_project_code/Home/uploads/Avatar-Profile.png', 'active', 'Creative Arts', 'Miheret Girma Baye', 'ee8d0efb-eea1-42d3-9b6f-518f932f3e7a', NULL, NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `entrepreneur`
--
ALTER TABLE `entrepreneur`
  ADD CONSTRAINT `entrepreneur_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
