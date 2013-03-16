ALTER TABLE `matchDetails`
  DROP `team1Goals`,
  DROP `team2Goals`;

--
-- Table structure for table `matchResults`
--

CREATE TABLE `matchResults` (
  `resultId` int(11) NOT NULL AUTO_INCREMENT,
  `matchId` int(11) NOT NULL,
  `nwaId` varchar(11) NOT NULL,
  `shirtNo` int(11) NOT NULL,
  `minute` int(3) NOT NULL,
  `goal` tinyint(1),
  `assist` int(11),
  `yellowCard` tinyint(1),
  `redCard` tinyint(1),
  PRIMARY KEY (`resultId`),
  KEY `matchId` (`matchId`),
  KEY `nwaId` (`nwaId`),
  KEY `shirtNo` (`shirtNo`),
  KEY `assist` (`assist`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `matchResults`
--
ALTER TABLE `matchResults`
  ADD CONSTRAINT `matchResults_ibfk_3` FOREIGN KEY (`nwaId`) REFERENCES `teams` (`nwaId`),
  ADD CONSTRAINT `matchResults_ibfk_1` FOREIGN KEY (`matchId`) REFERENCES `matchDetails` (`matchId`),
  ADD CONSTRAINT `matchResults_ibfk_2` FOREIGN KEY (`shirtNo`) REFERENCES `players` (`shirtNo`),
  ADD CONSTRAINT `matchResults_ibfk_4` FOREIGN KEY (`assist`) REFERENCES `matchResults` (`resultId`);

DROP TABLE playerResults;
