CREATE ALGORITHM = UNDEFINED VIEW  `matchResultsView` AS SELECT (
SELECT SUM( goal ) 
FROM matchResults
INNER JOIN players ON matchResults.playerId = players.playerId
WHERE players.nwaId = matchDetails.team1Id
) AS team1Goals, (
SELECT SUM( goal ) 
FROM matchResults
INNER JOIN players ON matchResults.playerId = players.playerId
