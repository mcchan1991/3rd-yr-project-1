<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/">Home</a> <span class="divider">/</span></li>
  <li class="active">Ticket</li>
</ul>
<h3>Tournaments</h3>
<table class="table" >
	<thead>
		<tr>
			<th>Name</th>
			<th style="text-align:center;">Sport</th>
			<th style="text-align:center;">Start date</th>
			<th style="text-align:center;">End date</th>
		</tr> 
	</thead>
	<tbody>
	<?php
		foreach ($tournaments as $tournament)
		{
			$url = base_url() . "index.php/ticket/tournamentTicket/{$tournament['tournamentId']}/";
			$currentEvents = $events[$tournament['tournamentId']];
			echo "<tr class=\"info\"   data-provides=\"rowlink\">";
			echo "	<td colspan=\"1\"><strong><a href=\"{$url}\" style=\"color:#333333;\">".$tournament['name']."</a></strong></td>";
			echo "	<td colspan=\"5\"></td>";
			echo "</tr>";
			foreach ($currentEvents as $event)
			{
				echo "	<td>{$event['name']}</td>";
				$sport = $sports[$event['sportId']-1]['sportName'];
				echo "	<td style=\"text-align:center;\">{$sport}</td>";
				echo "	<td style=\"text-align:center;\">{$event['start']}</td>";
				echo "	<td style=\"text-align:center;\">{$event['end']}</td>";
				echo "</tr>";
			}
			if ($totalEventCount[$tournament['tournamentId']] > count($currentEvents))
			{
				echo "<tr class=\"warning\">";
				echo "<td colspan=\"6\" style=\"color:#333333;\" ><a href=\"#\">Total events: {$totalEventCount[$tournament['tournamentId']]} view all</a></td>";
				echo "</tr>";
			}
		}
	?>
	</tbody>
</table>
<?php echo $links; ?>

<p>This screen will probably be redone where this is the archieve view, and the actual view have more details on it, for better accessibility especially when there are few planned tournaments, though this view will probably be planend if there are >2 active tournaments.</p>
