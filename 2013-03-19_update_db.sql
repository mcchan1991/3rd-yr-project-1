CREATE ALGORITHM = UNDEFINED VIEW  `playerResults` AS SELECT players . * , SUM( matchResults.goal ) AS goals, SUM( matchResults.assist ) AS assists, SUM( matchResults.redCard ) AS redCards, SUM( matchResults.yellowCard ) AS yewllowCards
FROM  `players` 
LEFT JOIN matchResults ON players.playerId = matchResults.playerId
GROUP BY players.playerId
