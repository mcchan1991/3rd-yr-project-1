-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 17, 2012 at 04:30 PM
-- Server version: 5.5.25
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `groupproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `athleteInRace`
--
-- Creation: Nov 17, 2012 at 03:24 PM
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
-- Creation: Nov 17, 2012 at 02:54 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--
-- Creation: Nov 17, 2012 at 03:29 PM
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
-- Creation: Nov 17, 2012 at 02:58 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--
-- Creation: Nov 17, 2012 at 03:03 PM
--

CREATE TABLE `events` (
  `eventId` int(5) NOT NULL AUTO_INCREMENT,
  `tournamentId` int(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `sportId` int(5) NOT NULL,
  `type` int(5) NOT NULL,
  `regStart` date NOT NULL,
  `regEnd` date NOT NULL,
  `maxEntries` int(5) NOT NULL,
  `minEntries` int(5) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  PRIMARY KEY (`eventId`),
  KEY `tournamentId` (`tournamentId`),
  KEY `sportId` (`sportId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--
-- Creation: Nov 13, 2012 at 05:18 PM
--

CREATE TABLE `locations` (
  `locationId` int(5) NOT NULL AUTO_INCREMENT,
  `capacity` int(10) NOT NULL,
  `lights` tinyint(1) NOT NULL,
  PRIMARY KEY (`locationId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `matchDetails`
--
-- Creation: Nov 17, 2012 at 03:16 PM
--

CREATE TABLE `matchDetails` (
  `matchId` int(5) NOT NULL AUTO_INCREMENT,
  `eventId` int(5) NOT NULL,
  `locationId` int(5) NOT NULL,
  `umpireId` int(5) NOT NULL,
  `team1Id` varchar(10) NOT NULL,
  `team2Id` varchar(10) NOT NULL,
  `team1Goals` int(5) NOT NULL,
  `team2Goals` int(5) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`matchId`),
  KEY `eventId` (`eventId`,`locationId`,`umpireId`,`team1Id`,`team2Id`,`team1Goals`),
  KEY `locationId` (`locationId`),
  KEY `umpireId` (`umpireId`),
  KEY `team1Id` (`team1Id`),
  KEY `team2Id` (`team2Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `playerResults`
--
-- Creation: Nov 17, 2012 at 03:20 PM
--

CREATE TABLE `playerResults` (
  `matchId` int(5) NOT NULL,
  `nwaId` varchar(10) NOT NULL,
  `shirtNo` int(2) NOT NULL,
  `goals` int(5) DEFAULT NULL,
  `assists` int(5) DEFAULT NULL,
  PRIMARY KEY (`matchId`,`nwaId`,`shirtNo`),
  KEY `shirtNo` (`shirtNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `players`
--
-- Creation: Nov 13, 2012 at 05:18 PM
--

CREATE TABLE `players` (
  `shirtNo` int(2) NOT NULL,
  `nwaId` varchar(10) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  PRIMARY KEY (`shirtNo`,`nwaId`),
  KEY `nwaId` (`nwaId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `raceDetails`
--
-- Creation: Nov 17, 2012 at 03:23 PM
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
-- Creation: Nov 17, 2012 at 03:04 PM
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
-- Creation: Nov 17, 2012 at 03:03 PM
--

CREATE TABLE `sports` (
  `sportId` int(5) NOT NULL AUTO_INCREMENT,
  `sportName` varchar(50) NOT NULL,
  PRIMARY KEY (`sportId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Dumping data for table `sports`
--

INSERT INTO `sports` (`sportId`, `sportName`) VALUES
(1, 'Wattball'),
(2, 'Hurdling');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--
-- Creation: Nov 13, 2012 at 05:18 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--
-- Creation: Nov 13, 2012 at 05:18 PM
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
-- Creation: Nov 17, 2012 at 03:25 PM
--

CREATE TABLE `tickets` (
  `ticketId` int(5) NOT NULL AUTO_INCREMENT,
  `tournamentId` int(5) NOT NULL,
  `ticketType` varchar(10) NOT NULL,
  `noTickets` int(5) NOT NULL,
  PRIMARY KEY (`ticketId`),
  KEY `tournamentId` (`tournamentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ticketSales`
--
-- Creation: Nov 17, 2012 at 03:29 PM
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
-- Creation: Nov 13, 2012 at 05:18 PM
--

CREATE TABLE `tournaments` (
  `tournamentId` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `noTickets` int(7) NOT NULL,
  PRIMARY KEY (`tournamentId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `umpires`
--
-- Creation: Nov 17, 2012 at 03:13 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `umpireAvailability`
--

CREATE TABLE `umpireAvailability` (
  `umpireId` int(9) NOT NULL,
  `tournamentId` int(9) NOT NULL,
  `date` date NOT NULL,
  `availableFrom` datetime NOT NULL,
  `availableTo` datetime NOT NULL,
  PRIMARY KEY (`umpireId`,`tournamentId`,`date`),
  KEY `tournamentId` (`tournamentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for table `umpireAvailability`
--
ALTER TABLE `umpireAvailability`
  ADD CONSTRAINT `umpireAvailability_ibfk_2` FOREIGN KEY (`tournamentId`) REFERENCES `tournaments` (`tournamentId`),
  ADD CONSTRAINT `umpireAvailability_ibfk_1` FOREIGN KEY (`umpireId`) REFERENCES `umpires` (`umpireId`);

--
-- Constraints for table `athleteInRace`
--
ALTER TABLE `athleteInRace`
  ADD CONSTRAINT `athleteInRace_ibfk_2` FOREIGN KEY (`athleteId`) REFERENCES `athletes` (`athleteId`),
  ADD CONSTRAINT `athleteInRace_ibfk_1` FOREIGN KEY (`raceId`) REFERENCES `raceDetails` (`raceId`);

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
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`sportId`) REFERENCES `sports` (`sportId`),
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`tournamentId`) REFERENCES `tournaments` (`tournamentId`);

--
-- Constraints for table `matchDetails`
--
ALTER TABLE `matchDetails`
  ADD CONSTRAINT `matchDetails_ibfk_5` FOREIGN KEY (`team2Id`) REFERENCES `teams` (`nwaId`),
  ADD CONSTRAINT `matchDetails_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `events` (`eventId`),
  ADD CONSTRAINT `matchDetails_ibfk_2` FOREIGN KEY (`locationId`) REFERENCES `locations` (`locationId`),
  ADD CONSTRAINT `matchDetails_ibfk_3` FOREIGN KEY (`umpireId`) REFERENCES `umpires` (`umpireId`),
  ADD CONSTRAINT `matchDetails_ibfk_4` FOREIGN KEY (`team1Id`) REFERENCES `teams` (`nwaId`);

--
-- Constraints for table `playerResults`
--
ALTER TABLE `playerResults`
  ADD CONSTRAINT `playerResults_ibfk_1` FOREIGN KEY (`matchId`) REFERENCES `matchDetails` (`matchId`),
  ADD CONSTRAINT `playerResults_ibfk_2` FOREIGN KEY (`shirtNo`) REFERENCES `players` (`shirtNo`);

--
-- Constraints for table `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `players_ibfk_1` FOREIGN KEY (`nwaId`) REFERENCES `teams` (`nwaId`);

--
-- Constraints for table `raceDetails`
--
ALTER TABLE `raceDetails`
  ADD CONSTRAINT `raceDetails_ibfk_2` FOREIGN KEY (`locationId`) REFERENCES `locations` (`locationId`),
  ADD CONSTRAINT `raceDetails_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `events` (`eventId`);

--
-- Constraints for table `sportAtLocations`
--
ALTER TABLE `sportAtLocations`
  ADD CONSTRAINT `sportAtLocations_ibfk_2` FOREIGN KEY (`locationId`) REFERENCES `locations` (`locationId`),
  ADD CONSTRAINT `sportAtLocations_ibfk_1` FOREIGN KEY (`sportId`) REFERENCES `sports` (`sportId`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`tournamentId`) REFERENCES `tournaments` (`tournamentId`);

--
-- Constraints for table `ticketSales`
--
ALTER TABLE `ticketSales`
  ADD CONSTRAINT `ticketSales_ibfk_2` FOREIGN KEY (`ticketId`) REFERENCES `tickets` (`ticketId`),
  ADD CONSTRAINT `ticketSales_ibfk_1` FOREIGN KEY (`customerId`) REFERENCES `customers` (`customerId`);

--
-- Constraints for table `umpires`
--
ALTER TABLE `umpires`
  ADD CONSTRAINT `umpires_ibfk_1` FOREIGN KEY (`sport`) REFERENCES `sports` (`sportId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
