-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2024 at 08:03 AM
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
-- Database: `adminexam`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `email` varchar(100) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`email`, `username`, `password`) VALUES
('admin@admin.com', 'admin', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `ansIndex` int(11) NOT NULL,
  `eid` varchar(255) NOT NULL,
  `ansid` int(11) NOT NULL,
  `userId` varchar(150) NOT NULL,
  `correct` int(11) NOT NULL,
  `wrong` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`ansIndex`, `eid`, `ansid`, `userId`, `correct`, `wrong`, `date`) VALUES
(1, '298cac114f255f66fdfe5f23dcee2d7164ca4577', 1, '08bddcaf697462ac53e5', 9, 1, '2024-11-08'),
(2, '298cac114f255f66fdfe5f23dcee2d7164ca4577', 1, '0f79b9609ec4cee0c6e5', 10, 0, '2024-11-08'),
(4, '298cac114f255f66fdfe5f23dcee2d7164ca4577', 1, '24e4e7cd6856797251a7', 9, 1, '2024-11-08');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedId` int(11) NOT NULL,
  `userId` varchar(150) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `feedback` varchar(500) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `time` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedId`, `userId`, `name`, `email`, `subject`, `feedback`, `date`, `time`) VALUES
(1, '08bddcaf697462ac53e5', 'Student Student', 'student1@gmail.com', 'dummySubject', 'dummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagedummyMessagev', '2024-11-08', '01:49:32 PM'),
(2, '0f79b9609ec4cee0c6e5', 'Student2 Student2', 'student2@gmail.com', 'dummySubject2', 'dummyMessage2\r\ndummyMessage2\r\ndummyMessage2\r\ndummyMessage2\r\ndummyMessage2\r\ndummyMessage2\r\ndummyMessage2', '2024-11-08', '01:50:14 PM'),
(3, '24e4e7cd6856797251a7', 'Student3 Student3', 'studen3@gmail.com', 'Student3', 'Student3\r\nStudent3\r\nStudent3\r\nStudent3\r\nStudent3\r\nStudent3\r\nStudent3', '2024-11-08', '02:13:49 PM');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `eid` varchar(255) NOT NULL,
  `qid` varchar(255) NOT NULL,
  `qns` varchar(255) NOT NULL,
  `ch1` varchar(1000) NOT NULL,
  `ch2` varchar(1000) NOT NULL,
  `ch3` varchar(1000) NOT NULL,
  `ch4` varchar(1000) NOT NULL,
  `sn` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`eid`, `qid`, `qns`, `ch1`, `ch2`, `ch3`, `ch4`, `sn`) VALUES
('6d407771cb12cd55969ae764337691166895e73d', '015b706c5b1bd181', 'What is acrophobia a fear of?', 'Land', 'Water', 'Acre', 'Heights', 'd'),
('6d407771cb12cd55969ae764337691166895e73d', '0401f0cbc6e4062a', 'What is the process by which a liquid changes into a gas?', 'Condensation', 'Evaporation', 'Evolution', 'Liquid-motion', 'b'),
('298cac114f255f66fdfe5f23dcee2d7164ca4577', '063ce461064fc260', 'Where did Scotch whisky originate?', 'Ireland', 'Wales', 'The United States', 'Scotland', 'd'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', '111fc26e1c8a13b5', 'When did Dr. Jose Rizal die?', 'December 30, 1986', 'December 30, 1886', 'December 30, 1869', 'December 30, 1896', 'd'),
('6d407771cb12cd55969ae764337691166895e73d', '171a5fdf99822463', 'What art form is described as \"decorative handwriting or handwritten lettering\"?', 'Graffiti', 'Calligraphy', 'Print', 'Cursive', 'b'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', '266ae43fb85d462a', 'How many dots appear on a pair of dice?', '50', '60', '42', '32', 'c'),
('6d407771cb12cd55969ae764337691166895e73d', '28ae2fa552750f43', 'How many bones do we have in an ear? ', '5', '3', '2', 'None', 'b'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', '2dafb3224e9fbc62', 'Who led the longest revolt in the Philippines during the Spanish times', 'Francisco Baltazar', 'Francisco Ayala', 'Francisco Dagohoy', 'Francisco Del Pilar', 'c'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', '31d16fff80df6e66', '68   36   __   12   8   6', '18', '19', '20', '21', 'c'),
('6d407771cb12cd55969ae764337691166895e73d', '3464b83d030171c4', '  In which province is the Mayon Volcano located?', 'Cagayan', 'Albay', 'Zambales', 'Batanes', 'b'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', '3813ed8b55635cad', 'How many islands and islets do the Philippines consist of?', '7,641', '7,777', '7,052', '7,136', 'a'),
('298cac114f255f66fdfe5f23dcee2d7164ca4577', '3e0fd6cc1213c523', 'If someone asked to see your ID, what might you show them?', 'Your tongue', 'Your teeth', 'Your passport', 'The door', 'c'),
('6d407771cb12cd55969ae764337691166895e73d', '466de0479fa64596', 'What animal has the longest tongue?', 'Lion', 'Zebra', 'Dog', 'Giraffe', 'd'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', '47e2707b6003cd0f', '13   -21   34   __  89   -144', '-55 ', '-50', '-45', '-60', 'a'),
('298cac114f255f66fdfe5f23dcee2d7164ca4577', '484efcdc72fa440e', 'According to the old saying, \"love of\" what \"is the root of all evil\"?', 'Food', 'Money', 'Clothing', 'TV', 'b'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', '4eff5bce8449c567', 'During the Japanese occupation of the Philippines, who was the puppet president that is appointed by the Japanese?', 'Jose P. Laurel Jr.', 'Jose P. Laurelio Jr.', 'Jose P. Lawrell Sr.', 'Jose P. Laurel Sr.', 'd'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', '553505ad7dd56f98', 'Mt. Pinatubo is located in the province of Luzon at the intersection of the borders of the provinces of Zambales, Tarlac, and which other province?', 'Pampanga', 'Lapaz', 'Nueva Ecija', 'Isabela', 'a'),
('298cac114f255f66fdfe5f23dcee2d7164ca4577', '586e982b950c7154', 'What two primary colors can be mixed to make purple?', 'Red and blue', 'Yellow and orange', 'Green and red', 'Blue and yellow', 'a'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', '593fdab901c19485', 'Which number is equivalent to 3^(4)÷3^(2)', '8', '9', '5', '10', 'b'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', '60af1c64453c4e22', '230   __   46   92   9.2   18.4', '460', '461', '462', '463', 'a'),
('6d407771cb12cd55969ae764337691166895e73d', '61099dc5be68edd1', 'What fruit is Guimaras known for?', 'Strawberry', 'Guava', 'Papaya', 'Mango', 'd'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', '6667e684a67db5e2', 'Which planet has the most moons?', 'Saturn', 'Venus', 'Mars', 'Jupiter', 'a'),
('6d407771cb12cd55969ae764337691166895e73d', '6892de04bcc68e24', 'What is the process by which plants convert sunlight to energy?', 'Photogenic', 'Photosynthetic', 'Photosynthesis', 'Photoscopic', 'c'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', '6a9587a980302d98', 'There are 49 dogs signed up for a dog show. There are 36 more small dogs than large dogs. How many small dogs have signed up to compete? ', '42.2', '42.3', '42.6', '42.5', 'd'),
('6d407771cb12cd55969ae764337691166895e73d', '6c33879e2fb7bed1', 'Sally is 54 years old and her mother is 80, how many years ago was Sally’s mother times her age?', '40 years ago', '41 years ago', '42 years ago', '43 years ago', 'b'),
('6d407771cb12cd55969ae764337691166895e73d', '6d6e23acc19e4ea1', 'How many faces does a Dodecahedron have?', '8', '5', '12', '15', 'c'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', '786cc996646938a6', '3   8   23   __   203   608', '66', '65', '67', '68', 'd'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', '7c2c9ef851377c58', 'In which year did the Bataan Death March take place?', '1890', '1942', '1950', '1560', 'b'),
('298cac114f255f66fdfe5f23dcee2d7164ca4577', '7e7cdfa1c4d9674f', 'When a tree is cut down, the part that remains in the ground is called what?', 'Hump', 'Dump', 'Stump', 'Pump', 'c'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', '8088b72ac16ea144', 'I am an odd number. Take away one letter and I become even. What number am I?', 'Three', 'Five', 'Seven', 'Eleven', 'c'),
('6d407771cb12cd55969ae764337691166895e73d', '80fc602abc674b9f', 'What is the original name of Luneta park?', 'LunetaPark', 'Bagumbayan', 'Pook Pasyalan', 'Rizal Park', 'b'),
('298cac114f255f66fdfe5f23dcee2d7164ca4577', '8330a522a62321bf', 'Who painted Mona Lisa?', 'Leonardo diCarpio', 'Leonardo Sandri', 'Leonardo da Vinci', 'Leonardo Fibonacci', 'c'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', '84f1f40dbfb4d9f9', 'What pen name did Marcelo H del Pilar use in his writings?', 'Plaridel', 'Parker', 'Mongol', 'Ancora', 'a'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', '861ec3aa618ac885', 'What is the meaning of the acronym NAMFREL?', 'National Movement Free Relocations', ' National Citizens Movement for Free Elections', 'National Forum for Research in Arbitration Law', 'None of the above', 'b'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', '86d77048e75b17cf', 'What is 1.92÷3?', '0.46', '0.66', '0.64', '0.44', 'c'),
('6d407771cb12cd55969ae764337691166895e73d', '86f78f85e936c2f7', 'How many minutes are in a full week?', '10,080', '10,000', '12,000', '9,050', 'a'),
('6d407771cb12cd55969ae764337691166895e73d', '8be31779312ceb45', 'Where is the strongest human muscle located?', 'Hands', 'Jaw', 'Legs', 'Abdominal', 'b'),
('6d407771cb12cd55969ae764337691166895e73d', '9ae2d70d50284d0e', 'What is a word, phrase, number, or other sequence of characters that reads the same backward as forward?', 'Palworld', 'Pal Asia', 'Paldrone', 'Palindrome', 'd'),
('6d407771cb12cd55969ae764337691166895e73d', '9bbec895b857a97c', 'In what year did the Portuguese explorer Ferdinand Magellan arrive on the shores of the Philippines?', '1420', '1621', '1823', '1521', 'd'),
('6d407771cb12cd55969ae764337691166895e73d', '9d4bdf627119092c', 'What is a group of crows called?', 'Crowbear', 'A murder', 'Serial Killers', 'Birds', 'b'),
('6d407771cb12cd55969ae764337691166895e73d', '9e45f39490c0ffc2', 'AZ BY __ DW EV', 'CD', 'BD', 'CX', 'BY', 'c'),
('298cac114f255f66fdfe5f23dcee2d7164ca4577', '9e8c4fba6ec62810', 'A person who is not a banker and lends money at an extremely high interest rate is known as what?', 'Green snake', 'Paperman', 'Loan shark', 'Brother-in-law', 'c'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', 'a253c7e6d52d308d', 'Which city is known as the “Walled City?”', 'Malolos', 'Intramuros', 'Makati', 'Cebu', 'b'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', 'a30246e6e6f9a1a2', 'Which country occupied the Philippines during World War II?', 'German', 'America', 'Japan', 'India', 'c'),
('298cac114f255f66fdfe5f23dcee2d7164ca4577', 'afb5ed69b0d64dc3', 'A lullaby is a song sung to babies to help them do what?', 'Fall asleep', 'Wake up', 'Rock', 'Eat', 'a'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', 'b10c77eac9bdef16', 'How to get a number 100 by using four sevens (7’s) and a one (1)?', '100', '110', '101', '111', 'a'),
('6d407771cb12cd55969ae764337691166895e73d', 'ba31fd7a66cbbf6d', 'What is the smallest unit of matter?', 'Molecule', 'Atom', 'Photon', 'Iron', 'b'),
('6d407771cb12cd55969ae764337691166895e73d', 'c67e35ae5094cdaa', 'Who was known as the \"Hero of Tirad Pass?\"', 'Gregorio Del Pilar', 'Andres Bonifacio', 'Dr. Jose Rizal', 'Marcelo Del Pilar', 'a'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', 'c8b8fd35c6c53077', ' How many feet are in a mile? ', '5281', '5820', '5280', '5028', 'c'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', 'c8f1c6844988d665', 'Solve  - 15+ (-5x) =0', '-3', '3', '-2', '2', 'a'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', 'ca9578d20de48c25', 'What was the first book published in the Philippines?', 'Doctrina Christiana', 'Doctrina Christiano', 'Doctrina Christianismo', 'Doctrina Christo', 'a'),
('298cac114f255f66fdfe5f23dcee2d7164ca4577', 'd1b8ebbe77a50642', 'A magnet would most likely attract which of the following?', 'Metal', 'Plastic', 'Wood', 'Copper', 'a'),
('6d407771cb12cd55969ae764337691166895e73d', 'd26bd8578ccae83a', 'What is the name of the Chinese philosophical system that emphasizes harmony with nature? ', 'Buddhism', 'Taoism', 'Stoism', 'Christianism', 'b'),
('298cac114f255f66fdfe5f23dcee2d7164ca4577', 'de92968e90fd5543', 'Something in an obvious location is said to be \"right under your\" what?', 'Nose', 'Mattress', 'Chair', 'Skirt', 'a'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', 'ecf2bec804edb290', '52   56   48   64   32   __', '99', '95', '96', '94', 'c'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', 'f2fdfaa1edf32874', 'There is a three-digit number. The second digit is four times as big as the third digit, while the first digit is three less than the second digit. What is the number?', '414', '141', '411', '114', 'b'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', 'f5034e3062f92d70', 'For how many years did Spanish rule last in the Philippines?', '300', '333', '343', '313', 'b'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', 'f9fb2c00e25ca3ff', 'One of the last Filipino generals who fought the Americans and established the so-called Tagalog Republic?', 'Macario Sakay', 'Macario Saclolo', 'Macario Silvester', 'Macario Amorsolo', 'a'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', 'fdc336dd62897bea', 'J10 K11 M13 Q17 __', 'W22', 'W23', 'W25', 'W21', 'b'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', 'ff31b5f67f0c6091', 'The Hispanic Period had started in the Philippines in 1500s. Who was the first Governor of the Philippines?', 'Miguel Sotto de Legazpi', 'Miguel Garcia de Legazpi', 'Miguel Zobel de Legazpi', 'Miguel Lopez de Legazpi', 'd');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `eid` varchar(255) NOT NULL,
  `title` varchar(100) NOT NULL,
  `sahi` int(11) NOT NULL,
  `wrong` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `time` bigint(20) NOT NULL,
  `intro` text NOT NULL,
  `tag` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`eid`, `title`, `sahi`, `wrong`, `total`, `time`, `intro`, `tag`, `date`) VALUES
('298cac114f255f66fdfe5f23dcee2d7164ca4577', '10 Easy Questions', 9, 5, 10, 3, 'Here is the 10 easy questions for you to move to the next level.', 'Easy', '2024-11-07 22:25:50'),
('6d407771cb12cd55969ae764337691166895e73d', '20 Medium Questions', 18, 10, 20, 2, '20 Medium questions, for you to unlock the next level.', 'Medium', '2024-11-07 12:56:44'),
('8f18de75bd574bbee9324a4a513c6f8ad07a8969', '30 Hard Questions', 28, 14, 30, 1, '30 Hard Questions, congratulations for making it this far.', 'Hard', '2024-11-07 05:58:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`ansIndex`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedId`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`qid`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`eid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `ansIndex` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
