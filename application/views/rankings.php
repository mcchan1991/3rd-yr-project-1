<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Home</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/tournaments">Tournaments</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/tournaments/view/<?php echo $tournament['tournamentId'] ?>"><?php echo $tournament['name'] ?></a> <span class="divider">/</span></li>
  <li class="active">Event: <?php echo $event['name']; ?></li>
</ul>
<h3>Rankings</h3>
<table class="table">
<thead>
	<th>No.</th>
	<th>Team</th>
	<th style="text-align:center;">Matches</th>
	<th style="text-align:center;">Won</th>
	<th style="text-align:center;">Draw</th>
	<th style="text-align:center;">Lost</th>
	<th style="text-align:center;">Goals</th>
	<th style="text-align:center;">Points</th>
</thead>
<tbody>
	<?php
		$i = 0;
		foreach ($teamResults as $currentTeam)
		{
			$i++;
			$tr = "<tr";
			if ($i == 1)
			{
				$tr .= " class=\"warning\"";
			}
			else if ($i == 2)
			{
				$tr .= " style=\"background-color:#EBEBEB;\"";
			}
			else if ($i == 3)
			{
				$tr .= " class=\"error\"";
			}
			$tr .= ">";
			echo $tr;
			
			echo "<td>{$i}</td>";
			$curTeam = $teams[$currentTeam['teamId']];
			echo "<td>" . $curTeam['name'] . "</td>";
			echo "<td style=\"text-align:center;\">" . $currentTeam['matches'] . "</td>";
			echo "<td style=\"text-align:center;\">" . $currentTeam['won'] . "</td>";
			echo "<td style=\"text-align:center;\">" . $currentTeam['draw'] . "</td>";
			echo "<td style=\"text-align:center;\">" . $currentTeam['lost'] . "</td>";
			echo "<td style=\"text-align:center;\">" . $currentTeam['goalsScored'] . " - " . $currentTeam['goalsAgainst'] . "</td>";
			echo "<td style=\"text-align:center;\">" . $currentTeam['points'] . "</td>";
			
			echo "</tr>";
		}
		if (count($teamResults) == 0)
		{
			echo "<tr><td colpsan=\"7\">No teams has registered for this event yet...</td></tr>";
		}
	?>
</tbody>
</table>

<h3>Topscores</h3>
<table class="table">
	<tbody>
		<?php
			//print_r($topScores);
			$i = 1;
			foreach ($topScores as $currentPlayer)
			{
				if ($currentPlayer['goals'] != NULL)
				{
					echo "<tr>";
					echo "<td>{$i}</td>";
					echo "<td><strong>{$currentPlayer['shirtNo']}. {$currentPlayer['firstName']} {$currentPlayer['surName']}</strong>, {$currentPlayer['teamName']} </td>";
					echo "<td><strong>{$currentPlayer['goals']}</strong></td>";
					echo "</tr>";
					$i++;
				}
			}
			if ($i == 1)
			{
				echo "<tr><td colpsan=\"3\">No goals have been scored yet...</td></tr>";
			}
			
		?>
	</tbody>
</table>
<h3>Assists</h3>
<table class="table">
	<tbody>
		<?php
			//print_r($topScores);
			$i = 1;
			foreach ($mostAssists as $currentPlayer)
			{
				if ($currentPlayer['assists'] != NULL)
				{
					echo "<tr>";
					echo "<td>{$i}</td>";
					echo "<td><strong>{$currentPlayer['shirtNo']}. {$currentPlayer['firstName']} {$currentPlayer['surName']}</strong>, {$currentPlayer['teamName']} </td>";
					echo "<td><strong>{$currentPlayer['assists']}</strong></td>";
					echo "</tr>";
					$i++;
				}
			}
			if ($i == 1)
			{
				echo "<tr><td colpsan=\"3\">No assists has ben made yet...</td></tr>";
			}
		?>
	</tbody>
</table>