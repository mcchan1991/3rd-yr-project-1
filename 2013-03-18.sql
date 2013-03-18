CREATE ALGORITHM = UNDEFINED VIEW  `matchResultsView` AS SELECT (
SELECT SUM( goal ) 
FROM matchResults
INNER JOIN players ON matchResults.playerId = players.playerId
WHERE players.nwaId = matchDetails.team1Id
) AS team1Goals, (
SELECT SUM( goal ) 
FROM matchResults
INNER JOIN players ON matchResults.playerId = players.playerId

ALTER ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `matchResultsView` AS select (select sum(`matchResults`.`goal`) from (`matchResults` join `players` on((`matchResults`.`playerId` = `players`.`playerId`))) where (`players`.`nwaId` = `matchDetails`.`team1Id`)) AS `team1Goals`,(select sum(`matchResults`.`goal`) from (`matchResults` join `players` on((`matchResults`.`playerId` = `players`.`playerId`))) where (`players`.`nwaId` = `matchDetails`.`team2Id`)) AS `team2Goals`,`matchDetails`.`matchId` AS `matchId`,matchDetails.team1Id, matchDetails.team2Id from ((`matchDetails` join `teams` `team1`) join `teams` `team2` on(((`matchDetails`.`team1Id` = `team1`.`nwaId`) and (`matchDetails`.`team2Id` = `team2`.`nwaId`))))