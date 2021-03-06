-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 17, 2013 at 09:34 PM
-- Server version: 5.5.25
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `groupproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `athleteInRace`
--

CREATE TABLE `athleteInRace` (
  `raceId` int(5) NOT NULL,
  `athleteId` int(5) NOT NULL,
  `lane` int(5) NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`raceId`,`athleteId`),
  KEY `athleteId` (`athleteId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `athletes`
--

CREATE TABLE `athletes` (
  `athleteId` int(5) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(6) NOT NULL,
  `fastest` time DEFAULT NULL,
  PRIMARY KEY (`athleteId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customerId` int(5) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `addr1` varchar(100) NOT NULL,
  `addr2` varchar(100) DEFAULT NULL,
  `postcode` varchar(8) NOT NULL,
  `city` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`customerId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `eventRegs`
--

CREATE TABLE `eventRegs` (
  `eventRegsId` int(5) NOT NULL AUTO_INCREMENT,
  `eventId` int(5) NOT NULL,
  `nwaId` varchar(10) DEFAULT NULL,
  `athleteId` int(5) DEFAULT NULL,
  PRIMARY KEY (`eventRegsId`),
  KEY `eventId` (`eventId`,`nwaId`,`athleteId`),
  KEY `nwaId` (`nwaId`),
  KEY `athleteId` (`athleteId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `eventId` int(5) NOT NULL AUTO_INCREMENT,
  `tournamentId` int(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `sportId` int(5) NOT NULL,
  `type` int(5) NOT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `regStart` date NOT NULL,
  `regEnd` date NOT NULL,
  `maxEntries` int(5) NOT NULL,
  `minEntries` int(5) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `scheduleAproved` tinyint(1) NOT NULL,
  `duration` time NOT NULL,
  PRIMARY KEY (`eventId`),
  KEY `tournamentId` (`tournamentId`),
  KEY `sportId` (`sportId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `eventTimes`
--

CREATE TABLE `eventTimes` (
  `eventId` int(10) NOT NULL,
  `start` time NOT NULL,
  PRIMARY KEY (`eventId`,`start`),
  KEY `eventId` (`eventId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `locationId` int(5) NOT NULL AUTO_INCREMENT,
  `capacity` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `lights` tinyint(1) NOT NULL,
  PRIMARY KEY (`locationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `matchDetails`
--

CREATE TABLE `matchDetails` (
  `matchId` int(5) NOT NULL AUTO_INCREMENT,
  `eventId` int(5) NOT NULL,
  `locationId` int(5) NOT NULL,
  `umpireId` int(5) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `team1Id` varchar(10) NOT NULL,
  `team2Id` varchar(10) NOT NULL,
  `status` varchar(20) NOT NULL,
  `round` int(3) DEFAULT NULL,
  PRIMARY KEY (`matchId`),
  KEY `eventId` (`eventId`,`locationId`,`umpireId`,`team1Id`,`team2Id`),
  KEY `locationId` (`locationId`),
  KEY `umpireId` (`umpireId`),
  KEY `team1Id` (`team1Id`),
  KEY `team2Id` (`team2Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

-- --------------------------------------------------------

--
-- Table structure for table `matchResults`
--

CREATE TABLE `matchResults` (
  `resultId` int(11) NOT NULL AUTO_INCREMENT,
  `matchId` int(11) NOT NULL,
  `playerId` int(11) NOT NULL,
  `minute` int(3) NOT NULL,
  `goal` tinyint(1) DEFAULT NULL,
  `assist` int(11) DEFAULT NULL,
  `yellowCard` tinyint(1) DEFAULT NULL,
  `redCard` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`resultId`),
  KEY `matchId` (`matchId`),
  KEY `assist` (`assist`),
  KEY `matchId_2` (`matchId`),
  KEY `playerId` (`playerId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `playerId` int(11) NOT NULL AUTO_INCREMENT,
  `shirtNo` int(2) NOT NULL,
  `nwaId` varchar(10) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  PRIMARY KEY (`playerId`),
  KEY `index` (`shirtNo`),
  KEY `nwaId` (`nwaId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `raceDetails`
--

CREATE TABLE `raceDetails` (
  `raceId` int(5) NOT NULL AUTO_INCREMENT,
  `eventId` int(5) NOT NULL,
  `locationId` int(5) NOT NULL,
  `time` datetime NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`raceId`),
  KEY `eventId` (`eventId`,`locationId`),
  KEY `locationId` (`locationId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sportAtLocations`
--

CREATE TABLE `sportAtLocations` (
  `sportId` int(5) NOT NULL,
  `locationId` int(5) NOT NULL,
  PRIMARY KEY (`sportId`,`locationId`),
  KEY `locationId` (`locationId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sports`
--

CREATE TABLE `sports` (
  `sportId` int(5) NOT NULL AUTO_INCREMENT,
  `sportName` varchar(50) NOT NULL,
  PRIMARY KEY (`sportId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffId` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `manager` tinyint(1) NOT NULL,
  PRIMARY KEY (`staffId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `nwaId` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contactFirstName` varchar(100) NOT NULL,
  `contactSurname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`nwaId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticketId` int(5) NOT NULL AUTO_INCREMENT,
  `tournamentId` int(5) NOT NULL,
  `ticketType` varchar(10) NOT NULL,
  `noTickets` int(5) NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`ticketId`),
  KEY `tournamentId` (`tournamentId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `ticketSales`
--

CREATE TABLE `ticketSales` (
  `transactionId` int(5) NOT NULL AUTO_INCREMENT,
  `customerId` int(5) NOT NULL,
  `ticketId` int(5) NOT NULL,
  `quantity` int(5) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`transactionId`),
  KEY `customerId` (`customerId`,`ticketId`),
  KEY `ticketId` (`ticketId`),
  KEY `customerId_2` (`customerId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tournaments`
--

CREATE TABLE `tournaments` (
  `tournamentId` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `noTickets` int(7) NOT NULL,
  PRIMARY KEY (`tournamentId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `umpireAvailability`
--

CREATE TABLE `umpireAvailability` (
  `umpireId` int(9) NOT NULL,
  `tournamentId` int(9) NOT NULL,
  `date` date NOT NULL,
  `availableFrom` time NOT NULL,
  `availableTo` time NOT NULL,
  PRIMARY KEY (`umpireId`,`tournamentId`,`date`),
  KEY `tournamentId` (`tournamentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `umpireCount`
--
CREATE TABLE `umpireCount` (
`count` bigint(21)
,`umpireId` int(5)
,`tournamentId` int(5)
);
-- --------------------------------------------------------

--
-- Table structure for table `umpires`
--

CREATE TABLE `umpires` (
  `umpireId` int(5) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `DOB` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `sport` int(5) NOT NULL,
  PRIMARY KEY (`umpireId`),
  KEY `sport` (`sport`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure for view `umpireCount`
--
DROP TABLE IF EXISTS `umpireCount`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `umpireCount` AS select count(`matchDetails`.`umpireId`) AS `count`,`matchDetails`.`umpireId` AS `umpireId`,`events`.`tournamentId` AS `tournamentId` from (`matchDetails` join `events`) where (`matchDetails`.`eventId` = `events`.`eventId`) group by `matchDetails`.`umpireId`,`events`.`tournamentId`;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `athleteInRace`
--
ALTER TABLE `athleteInRace`
  ADD CONSTRAINT `athleteInRace_ibfk_1` FOREIGN KEY (`raceId`) REFERENCES `raceDetails` (`raceId`),
  ADD CONSTRAINT `athleteInRace_ibfk_2` FOREIGN KEY (`athleteId`) REFERENCES `athletes` (`athleteId`);

--
-- Constraints for table `eventRegs`
--
ALTER TABLE `eventRegs`
  ADD CONSTRAINT `eventRegs_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `events` (`eventId`),
  ADD CONSTRAINT `eventRegs_ibfk_2` FOREIGN KEY (`nwaId`) REFERENCES `teams` (`nwaId`),
  ADD CONSTRAINT `eventRegs_ibfk_3` FOREIGN KEY (`athleteId`) REFERENCES `athletes` (`athleteId`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`tournamentId`) REFERENCES `tournaments` (`tournamentId`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`sportId`) REFERENCES `sports` (`sportId`);

--
-- Constraints for table `eventTimes`
--
ALTER TABLE `eventTimes`
  ADD CONSTRAINT `eventTimes_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `events` (`eventId`);

--
-- Constraints for table `matchDetails`
--
ALTER TABLE `matchDetails`
  ADD CONSTRAINT `matchDetails_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `events` (`eventId`),
  ADD CONSTRAINT `matchDetails_ibfk_2` FOREIGN KEY (`locationId`) REFERENCES `locations` (`locationId`),
  ADD CONSTRAINT `matchDetails_ibfk_3` FOREIGN KEY (`umpireId`) REFERENCES `umpires` (`umpireId`),
  ADD CONSTRAINT `matchDetails_ibfk_4` FOREIGN KEY (`team1Id`) REFERENCES `teams` (`nwaId`),
  ADD CONSTRAINT `matchDetails_ibfk_5` FOREIGN KEY (`team2Id`) REFERENCES `teams` (`nwaId`);

--
-- Constraints for table `matchResults`
--
ALTER TABLE `matchResults`
  ADD CONSTRAINT `matchResults_ibfk_5` FOREIGN KEY (`playerId`) REFERENCES `players` (`playerId`),
  ADD CONSTRAINT `matchResults_ibfk_1` FOREIGN KEY (`matchId`) REFERENCES `matchDetails` (`matchId`),
  ADD CONSTRAINT `matchResults_ibfk_4` FOREIGN KEY (`assist`) REFERENCES `matchResults` (`resultId`);

--
-- Constraints for table `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `players_ibfk_1` FOREIGN KEY (`nwaId`) REFERENCES `teams` (`nwaId`);

--
-- Constraints for table `raceDetails`
--
ALTER TABLE `raceDetails`
  ADD CONSTRAINT `raceDetails_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `events` (`eventId`),
  ADD CONSTRAINT `raceDetails_ibfk_2` FOREIGN KEY (`locationId`) REFERENCES `locations` (`locationId`);

--
-- Constraints for table `sportAtLocations`
--
ALTER TABLE `sportAtLocations`
  ADD CONSTRAINT `sportAtLocations_ibfk_1` FOREIGN KEY (`sportId`) REFERENCES `sports` (`sportId`),
  ADD CONSTRAINT `sportAtLocations_ibfk_2` FOREIGN KEY (`locationId`) REFERENCES `locations` (`locationId`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`tournamentId`) REFERENCES `tournaments` (`tournamentId`);

--
-- Constraints for table `ticketSales`
--
ALTER TABLE `ticketSales`
  ADD CONSTRAINT `ticketSales_ibfk_1` FOREIGN KEY (`customerId`) REFERENCES `customers` (`customerId`),
  ADD CONSTRAINT `ticketSales_ibfk_2` FOREIGN KEY (`ticketId`) REFERENCES `tickets` (`ticketId`);

--
-- Constraints for table `umpireAvailability`
--
ALTER TABLE `umpireAvailability`
  ADD CONSTRAINT `umpireAvailability_ibfk_1` FOREIGN KEY (`umpireId`) REFERENCES `umpires` (`umpireId`),
  ADD CONSTRAINT `umpireAvailability_ibfk_2` FOREIGN KEY (`tournamentId`) REFERENCES `tournaments` (`tournamentId`);

--
-- Constraints for table `umpires`
--
ALTER TABLE `umpires`
  ADD CONSTRAINT `umpires_ibfk_1` FOREIGN KEY (`sport`) REFERENCES `sports` (`sportId`);