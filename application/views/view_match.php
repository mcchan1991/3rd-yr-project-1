<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Home</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/tournaments">Tournaments</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/tournaments/view/<?php echo $tournament['tournamentId'] ?>"><?php echo $tournament['name'] ?></a> <span class="divider">/</span></li>
  <li class="active">Event: <?php echo $event['name']; ?></li>
</ul>

<table class="table">
	<thead>
		<tr>
			<th></th>
			<th>
				<img  src="<?php if ($team1['logo'] == 1) {echo base_url() . "uploads/" . md5($team1['nwaId']) . ".png";} ?>" style="width:150px; height:150px; margin-left: auto; margin-right: auto; display:block;" class="img-rounded" />
				<div style="text-align:center; padding-top:5px;"> <?php echo $team1['name']; ?> </div>
			</th>
			<th style="text-align:center; vertical-align: middle"><h1><?php echo $result['team1Goals'] . " - ". $result['team2Goals']; ?></h1></th>
			<th style="padding-right:30px">
				<img  src="<?php  if ($team2['logo'] == 1) { echo base_url() . "uploads/" . md5($team2['nwaId']) . ".png";} ?>" style="width:150px; height:150px; margin-left: auto; margin-right: auto; display:block;" class="img-rounded" />
				<div style="text-align:center; padding-top:5px;"> <?php echo $team2['name']; ?> </div>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$team1Goals = 0;
		$team2Goals = 0;
		$yellowCards = array();
		foreach($resultEvents as $currentEvent)
		{
			//$curPlayer = $this->Team_model->getPlayer($currentEvent['playerId']);
			echo "<tr class=\"success\">";
			echo "<td style=\"text-align:center;\"><strong>" . $currentEvent['minute'] . "'</strong></td>";
			echo "<td style=\"text-align:center;\">";
			if ($currentEvent['nwaId'] == $team1['nwaId'])
			{
				if ($currentEvent['goal'] == 1 && $currentEvent['assist'] != NULL)
				{
					echo $currentEvent['assistShirtNo'] . ". " . $currentEvent['assistSurname'];
					echo " <i class=\"icon-chevron-right\"></i> ";
				}
				echo "<strong>" . $currentEvent['shirtNo'] . ". " . $currentEvent['surname'] . "</strong>";
			}
			echo "</td>";
			echo "<td style=\"text-align:center;\">";
			if ($currentEvent['goal'] == 1)
			{
				if ($currentEvent['nwaId'] == $team1['nwaId'])
				{
					$team1Goals++;
				}
				else
				{
					$team2Goals++;
				}
				echo "<img  src=\"".base_url() . "assets/img/goal.png" . "\" style=\"width:20px; height:20px; float:left;\" class=\"img-rounded\" />";
				echo " <strong>Goal ({$team1Goals}-{$team2Goals})</strong>";
			}
			else if ($currentEvent['yellowCard'] == 1)
			{
				if (in_array($currentEvent['playerId'], $yellowCards))
				{
					echo "<img  src=\"".base_url() . "assets/img/doubleyellow.png" . "\" style=\"width:20px; height:20px; float:left;\" class=\"img-rounded\" />";
				}
				else
				{
					echo "<img  src=\"".base_url() . "assets/img/Yellow_card.png" . "\" style=\"width:20px; height:20px; float:left;\" class=\"img-rounded\" />";
				}
				echo " <strong>Yellow Card</strong>";
				array_push($yellowCards, $currentEvent['playerId']);
			}
			else if ($currentEvent['redCard'] == 1)
			{
				echo "<img  src=\"".base_url() . "assets/img/Red_card.png" . "\" style=\"width:20px; height:20px; float:left;\" class=\"img-rounded\" />";
				echo " <strong>Red Card</strong>";
			}
			echo "</td>";
			echo "<td style=\"text-align:center;\">";
			if ($currentEvent['nwaId'] == $team2['nwaId'])
			{
				if ($currentEvent['goal'] == 1 && $currentEvent['assist'] != NULL)
				{
					echo $currentEvent['assistShirtNo'] . ". " . $currentEvent['assistSurname'];
					echo " <i class=\"icon-chevron-right\"></i> ";
				}
				echo "<strong>" . $currentEvent['shirtNo'] . ". " . $currentEvent['surname'] . "</strong>";
			}
			echo "</td>";
			echo "</tr>";
		}
	
	
	
	
	?>
	</tbody>
	<tfoot>
		<td colspan="2">Location: <?php echo $location; ?></td>
		<td colspan="2" style="text-align:right;">Umpire: <?php echo $umpire; ?></td>
	</tfoot>
</table>